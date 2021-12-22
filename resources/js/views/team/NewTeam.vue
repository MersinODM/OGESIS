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
                        <div
                          v-if="can(TEACHER_CREATE_LEVEL_3)"
                          class="form-group col-md-12"
                        >
                          <label>İlçe Seçimi</label>
                          <multiselect
                            v-model="districtId"
                            name="district_id"
                            placeholder="İlçe seçebilirsiniz"
                            no-options-text="Bu liste boş!"
                            no-result-text="Burada bişey bulamadık!"
                            :close-on-select="true"
                            :min-chars="2"
                            value-prop="id"
                            :searchable="true"
                            label="name"
                            :options="getDistricts"
                            class="form-control"
                            :class="{'is-invalid': districtEM != null}"
                          />
                          <div
                            v-if="districtEM"
                            role="alert"
                            class="invalid-feedback order-last"
                            style="display: inline-block;"
                          >
                            {{ districtEM }}
                          </div>
                        </div>
                      </div>
                      <div class="form-row justify-content-md-center">
                        <div
                          v-if="can(TEACHER_CREATE_LEVEL_3) || can(TEACHER_CREATE_LEVEL_2)"
                          class="form-group col-md-12"
                        >
                          <label>Kurum Seçimi</label>
                          <multiselect
                            v-model="institutionId"
                            name="institution_id"
                            placeholder="Kurum seçebilirsiniz."
                            no-options-text="Bu liste boş!"
                            no-result-text="Burada bişey bulamadık!"
                            label="name"
                            value-prop="id"
                            :searchable="true"
                            :close-on-select="true"
                            :loading="false"
                            :options="institutions"
                            class="form-control"
                            :class="{'is-invalid': institutionEM != null}"
                          />
                          <div
                            v-if="institutionEM"
                            role="alert"
                            class="invalid-feedback order-last"
                            style="display: inline-block;"
                          >
                            {{ institutionEM }}
                          </div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label>Takım Adı</label>
                          <input
                            v-model="title"
                            name="title"
                            type="text"
                            class="form-control"
                            :class="{'is-invalid': titleEM != null}"
                          >
                          <div
                            v-if="titleEM"
                            role="alert"
                            class="invalid-feedback order-last"
                            style="display: inline-block;"
                          >
                            {{ titleEM }}
                          </div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label>Takım Seçimi</label>
                          <multiselect
                            v-model="selectedTeachers"
                            :options="teachers"
                            label="full_name"
                            name="teachers"
                            mode="tags"
                            track-by="id"
                            value-prop="id"
                            placeholder="Öğretmen seçimi yapabilirsiniz."
                            no-options-text="Bu liste boş!"
                            no-result-text="Burada bişey bulamadık!"
                            class="form-control h-auto"
                            :class="{'is-invalid': teachersEM != null}"
                          >
                            <template #option="{ option }">
                              {{ option.full_name }} - {{ option.branch.name }}
                            </template>
                            <template #tag="{ option, handleTagRemove, disabled }">
                              <span class="multiselect-tag">
                                {{ option.full_name }} - {{ option.branch.name }}
                                <span
                                  v-if="!disabled"
                                  class="multiselect-tag-remove"
                                  @mousedown.prevent="handleTagRemove(option, $event)"
                                >
                                  <span class="multiselect-tag-remove-icon" />
                                </span>
                              </span>
                            </template>
                          </multiselect>
                          <div
                            v-if="teachersEM"
                            role="alert"
                            class="invalid-feedback order-last"
                            style="display: inline-block;"
                          >
                            {{ teachersEM }}
                          </div>
                        </div>
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
import { nextTick, ref, watch } from 'vue'
import useTeamApi from '../../services/useTeamApi'
import useNotifier from '../../utils/useNotifier'
import { useAbility } from '@casl/vue'
import { usePermissionConstants } from '../../utils/constants'
import { useStore } from 'vuex'
import useInstitutionApi from '../../services/useInstitutionApi'
import useDistrictApi from '../../services/useDistrictApi'

export default {
  name: 'NewTeam',
  components: { Page, Multiselect },
  setup () {
    const notifier = useNotifier()
    const { can } = useAbility()
    const { TEACHER_LIST_LEVEL_2, TEACHER_LIST_LEVEL_3 } = usePermissionConstants()
    const store = useStore()
    const { getInstitution } = useInstitutionApi()
    const { getDistricts } = useDistrictApi()
    const TEAM_VALIDATION_EM = 'Öğretmen seçimi yapılmalıdır!'
    const { getTeachers } = useTeacherApi()
    const { createTeam } = useTeamApi()
    const institutions = ref([])

    const schema = object({
      title: string().typeError(() => 'Takım adı yazı tipinde olmalıdır!')
        .min(2, () => 'En az 2 karakter uzunluğunda olmalıdır!')
        .required(() => 'Takım adı gereklidir!'),
      teachers: array().typeError(() => TEAM_VALIDATION_EM)
        .min(2, () => 'En az iki öğretmen seçilmelidir')
        .required(() => TEAM_VALIDATION_EM)
    })

    const { handleSubmit } = useForm({ validationSchema: schema })

    const { value: title, errorMessage: titleEM } = useField('title')
    const { value: selectedTeachers, errorMessage: teachersEM } = useField('teachers')
    const teachers = ref()
    // getTeachers().then(values => { teachers.value = values })

    // İl kullanıcıları için ilçe seçimi değişikliğini takip ediyoruz
    watch(districtId, async () => {
      institutions.value = await getInstitution(districtId.value)
    })

    // Sayfa ilk defa açıldığında çalıştırmamız gerekiyor değilse kurumları dolduramıyoruz
    nextTick(() => {
      if (can(TEACHER_LIST_LEVEL_3)) {
        getInstitution(store.getters['auth/user']?.institution.district_id)
          .then(res => {
            institutions.value = res
          })
      }
    })

    // Kullanıcı değişimini izliyoruz eğer ilçe kullanıcısı ise
    // kullanıcının ilçesindeki okulları dolduruyoruz seçim için
    watch(user, () => {
      if (can(TEACHER_LIST_LEVEL_2)) {
        getInstitution(store.getters['auth/user']?.institution.district_id)
          .then(res => {
            institutions.value = res
          })
      }
    })

    const save = handleSubmit(async values => {
      const result = await Messenger.showPrompt('Takım oluşturulacaktır. Onaylıyor musunuz?')
      if (result.isConfirmed) {
        await createTeam(values)
      }
    })

    return {
      save,
      title,
      titleEM,
      selectedTeachers,
      teachersEM,
      teachers,
      getDistricts,
      can
    }
  }
}
</script>

<style scoped>

</style>
