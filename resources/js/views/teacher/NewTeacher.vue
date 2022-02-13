<template>
  <page>
    <template #header>
      <h4><span class="text-blue">Yeni</span> Öğretmen Kaydı</h4>
    </template>
    <template #content>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row justify-content-md-center">
                <div class="col-md-6">
                  <form @submit.prevent>
                    <div class="row justify-content-md-center">
                      <district-selector
                        v-model="districtId"
                        name="district_id"
                        class="col-md-12"
                        :validation-required="true"
                        :validation-message="errors.district_id"
                      />
                    </div>
                    <div class="row justify-content-md-center">
                      <institution-selector
                        v-model="institutionId"
                        name="institution_id"
                        class="col-md-12"
                        :institutions="institutions"
                        :validation-required="true"
                        :validation-message="errors.institution_id"
                      />
                    </div>
                    <div class="row justify-content-md-center">
                      <branch-selector
                        v-model="branchId"
                        name="branch_id"
                        class="col-md-12"
                        :validation-required="true"
                        :validation-message="errors.branch_id"
                      />
                    </div>
                    <div class="row justify-content-md-center">
                      <text-box
                        v-model="firstName"
                        :validation-required="true"
                        :validation-message="errors.first_name"
                        class="col-md-6"
                        label="Ad"
                        name="first_name"
                      />
                      <text-box
                        v-model="lastName"
                        :validation-required="true"
                        :validation-message="errors.last_name"
                        :uppercase="true"
                        class="col-md-6"
                        label="Soyad"
                        name="last_name"
                      />
                    </div>
                    <div class="row justify-content-md-center">
                      <text-box
                        v-model="phone"
                        :validation-required="true"
                        :validation-message="errors.phone"
                        :mask="'### ### ## ##'"
                        class="col-md-6"
                        label="Telefon"
                        name="phone"
                      />
                      <text-box
                        v-model="email"
                        :validation-required="true"
                        :validation-message="errors.email"
                        class="col-md-6"
                        name="email"
                        label="E-Posta"
                      />
                    </div>
                    <div class="row justify-content-md-center">
                      <div class="col-md-6">
                        <button
                          type="submit"
                          class="btn btn-primary btn-block"
                          @click="save"
                        >
                          Kaydet
                        </button>
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
import { object, string } from 'yup'
import { useField, useForm } from 'vee-validate'
import Messenger from '../../utils/messenger'
import useTeacherApi from '../../services/useTeacherApi'
import useInstitutionApi from '../../services/useInstitutionApi'
import useNotifier from '../../utils/useNotifier'
import router from '../../router'
import { ResponseCodes, usePermissionConstants } from '../../utils/constants'
import { useAbility } from '@casl/vue'
import { ref, watch } from 'vue'
import { useStore } from 'vuex'
import DistrictSelector from '../../components/selectors/DistrictSelector'
import InstitutionSelector from '../../components/selectors/InstitutionSelector'
import BranchSelector from '../../components/selectors/BranchSelector'
import TextBox from '../../components/TextBox'
import { useRuleBranch, useRuleDistrict, useRuleInstitution } from '../../compositions/useRules'

export default {
  name: 'NewTeacher',
  components: { TextBox, BranchSelector, InstitutionSelector, DistrictSelector, Page },
  setup () {
    const notifier = useNotifier()
    const { can, cannot } = useAbility()
    const { TEACHER_LIST_LEVEL_2, TEACHER_LIST_LEVEL_3 } = usePermissionConstants()
    const store = useStore()
    const { getInstitution } = useInstitutionApi()
    const { createTeacher } = useTeacherApi()

    // Validasyon bilgileri
    const schema = object({
      first_name: string().typeError(() => 'Ad yazı tipinde olmalıdır!')
        .required(() => 'Ad bilgisi gereklidir!'),
      last_name: string().typeError(() => 'Soyad yazı tipinde olmalıdır!')
        .required(() => 'Soyad bilgisi gereklidir!'),
      phone: string().typeError(() => 'Telefon yazı tipinde olmalıdır!')
        .required(() => 'Telefon bilgisi gereklidir!'),
      email: string().typeError(() => 'E-Posta yazı tipinde olmalıdır!')
        .email(() => 'E-Posta geçerli olmalıdır!')
        .required(() => 'E-Posta bilgisi gereklidir!'),
      ...useRuleBranch(),
      // Eğer ilçe yetkisi varsa kurum doğrulaması yapacağız
      ...useRuleInstitution(),
      // Eğer il yetkisi varsa ilçe kurum doğrulması yapacağız
      ...useRuleDistrict()
    })

    const { handleSubmit, errors } = useForm({ validationSchema: schema })
    // Validasyon değişken tanımlamaları
    const { value: firstName } = useField('first_name')
    const { value: lastName } = useField('last_name')
    const { value: phone } = useField('phone')
    const { value: email } = useField('email')
    const { value: branchId } = useField('branch_id')
    const { value: institutionId } = useField('institution_id')
    const { value: districtId } = useField('district_id')
    const branches = ref([])
    const institutions = ref([])

    // İl kullanıcıları için ilçe seçimi değişikliğini takip ediyoruz
    watch(districtId, async () => {
      if (districtId.value) {
        institutions.value = await getInstitution(districtId.value)
      } else {
        institutions.value = []
      }
    })

    // Kullanıcı değişimini izliyoruz eğer ilçe kullanıcısı ise
    // kullanıcının ilçesindeki okulları dolduruyoruz seçim için
    if (can(TEACHER_LIST_LEVEL_2) && cannot(TEACHER_LIST_LEVEL_3)) {
      getInstitution(store.getters['auth/user']?.institution.district_id)
        .then(res => {
          institutions.value = res
        })
    }

    // Kayıt işlemini yapalım
    const save = handleSubmit(async values => {
      const result = await Messenger.showPrompt('Yeni öğretmen kaydınız yapılcaktır. Onaylıyor musunuz?')
      if (result.isConfirmed) {
        const response = await createTeacher(values)
        if (response?.code === ResponseCodes.SUCCESS) {
          await notifier.success({ message: 'Öğretmen kaydı başarıyla oluşturuldu.', duration: 3200 })
          await router.replace({ name: 'listTeachers' })
        } else {
          await notifier.error({ message: 'Öğretmen kaydı oluşturalamadı!.', duration: 3200 })
        }
      }
    })

    return {
      errors,
      districtId,
      branchId,
      email,
      firstName,
      institutionId,
      lastName,
      phone,
      branches,
      institutions,
      can,
      save
    }
  }
}
</script>

<style scoped>

</style>
