<template>
  <page>
    <template #header>
      <h4>
        <span class="text-bold text-blue">Yeni</span> Takım
      </h4>
    </template>
    <template #content>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="row justify-content-md-center">
                <div class="col-md-6">
                  <form @submit.prevent>
                    <div class="form-group has-feedback">
                      <div class="form-row justify-content-md-center">
                        <district-selector
                          v-model="districtId"
                          name="district_id"
                          class="col-md-12"
                          :validation-required="true"
                          :validation-message="errors.district_id"
                        />
                      </div>
                      <div class="form-row justify-content-md-center">
                        <institution-selector
                          v-model="institutionId"
                          name="institution_id"
                          class="col-md-12"
                          :institutions="institutions"
                          :validation-required="true"
                          :validation-message="errors.institution_id"
                        />
                      </div>
                      <div class="form-row">
                        <text-box
                          v-model="name"
                          name="name"
                          label="Takım Adı"
                          class="col-md-12"
                          :validation-required="true"
                          :validation-message="errors.name"
                        />
                      </div>
                      <div class="form-row">
                        <teacher-selector
                          v-model="selectedTeachers"
                          :teachers="teachers"
                          class="col-md-12"
                          name="teachers"
                          :validation-required="true"
                          :validation-message="errors.teachers"
                        />
                      </div>
                      <div class="form-row justify-content-md-center mt-3">
                        <div class="form-group col-md-6">
                          <button
                            class="btn btn-primary btn-block"
                            @click="save"
                          >
                            Kaydet
                          </button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </page>
</template>

<script>
import Page from '../../components/Page'
import Multiselect from '@vueform/multiselect'
import { object, array, string } from 'yup'
import { useField, useForm } from 'vee-validate'
import Messenger from '../../utils/messenger'
import useTeacherApi from '../../services/useTeacherApi'
import { ref, watch } from 'vue'
import useTeamApi from '../../services/useTeamApi'
import useNotifier from '../../utils/useNotifier'
import { useAbility } from '@casl/vue'
import { ResponseCodes, usePermissionConstants } from '../../utils/constants'
import { useStore } from 'vuex'
import useInstitutionApi from '../../services/useInstitutionApi'
import useDistrictApi from '../../services/useDistrictApi'
import DistrictSelector from '../../components/selectors/DistrictSelector'
import InstitutionSelector from '../../components/selectors/InstitutionSelector'
import TextBox from '../../components/TextBox'
import { useRuleDistrict, useRuleInstitution } from '../../compositions/useRules'
import router from '../../router'
import TeacherSelector from '../../components/selectors/TeacherSelector'

export default {
  name: 'NewTeam',
  components: { TeacherSelector, TextBox, Page, DistrictSelector, InstitutionSelector },
  setup () {
    const notifier = useNotifier()
    const { can, cannot } = useAbility()
    const { TEACHER_LIST_LEVEL_1, TEACHER_LIST_LEVEL_2, TEACHER_LIST_LEVEL_3 } = usePermissionConstants()
    const store = useStore()
    const { getInstitution } = useInstitutionApi()
    const { getDistricts } = useDistrictApi()
    const TEAM_VALIDATION_EM = 'Öğretmen seçimi yapılmalıdır!'
    const { getTeachers } = useTeacherApi()
    const { createTeam } = useTeamApi()
    const institutions = ref([])

    const schema = object({
      name: string().typeError(() => 'Takım adı yazı tipinde olmalıdır!')
        .min(2, () => 'En az 2 karakter uzunluğunda olmalıdır!')
        .required(() => 'Takım adı gereklidir!'),
      teachers: array().typeError(() => TEAM_VALIDATION_EM)
        .min(2, () => 'En az iki öğretmen seçilmelidir')
        .required(() => TEAM_VALIDATION_EM),
      // Eğer ilçe yetkisi varsa kurum doğrulaması yapacağız
      ...useRuleInstitution(),
      // Eğer il yetkisi varsa ilçe kurum doğrulması yapacağız
      ...useRuleDistrict()
    })

    const { handleSubmit, errors } = useForm({ validationSchema: schema })

    const { value: name } = useField('name')
    const { value: selectedTeachers } = useField('teachers')
    const { value: institutionId } = useField('institution_id')
    const { value: districtId } = useField('district_id')
    const teachers = ref([])
    // getTeachers().then(values => { teachers.value = values })

    // İl kullanıcıları için ilçe seçimi değişikliğini takip ediyoruz
    watch(districtId, async () => {
      institutionId.value = null
      if (districtId.value) {
        institutions.value = await getInstitution(districtId.value)
      } else {
        institutions.value = []
      }
    })

    watch(institutionId, async () => {
      teachers.value = await getTeachers(districtId.value, institutionId.value)
    })

    // Kullanıcı değişimini izliyoruz eğer ilçe kullanıcısı ise
    // kullanıcının ilçesindeki okulları dolduruyoruz seçim için
    if (can(TEACHER_LIST_LEVEL_2) && cannot(TEACHER_LIST_LEVEL_3)) {
      getInstitution(store.getters['auth/user']?.institution.district_id)
        .then(res => {
          institutions.value = res
        })
    }

    // Sadece 1.seviye öğretmen listeleme yetkisi varsa(Okul yetkilisi ise)
    if (cannot(TEACHER_LIST_LEVEL_3) && cannot(TEACHER_LIST_LEVEL_2) && can(TEACHER_LIST_LEVEL_1)) {
      const user = store.getters['auth/user']
      getTeachers(user?.institution.district_id, user.institution_id)
        .then(res => { teachers.value = res })
    }

    const save = handleSubmit(async values => {
      const result = await Messenger.showPrompt('Takım oluşturulacaktır. Onaylıyor musunuz?')
      if (result.isConfirmed) {
        const response = await createTeam(values)
        if (response?.code === ResponseCodes.SUCCESS) {
          await notifier.success({ message: 'Takım kaydı başarıyla oluşturuldu.', duration: 3200 })
          await router.replace({ name: 'listTeams' })
        } else {
          await notifier.error({ message: 'Takım kaydı oluşturalamadı!.', duration: 3200 })
        }
      }
    })

    return {
      errors,
      save,
      districtId,
      institutionId,
      institutions,
      name,
      selectedTeachers,
      teachers,
      getDistricts,
      can
    }
  }
}
</script>

<style scoped>

</style>
