<template>
  <div>
    <institution-not-valid />
    <form @submit.prevent>
      <div class="form-group has-feedback">
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
</template>

<script>
import { object, array, string } from 'yup'
import { useField, useForm } from 'vee-validate'
import Messenger from '../../utils/messenger'
import { ref } from 'vue'
import useTeamApi from '../../services/useTeamApi'
import useNotifier from '../../utils/useNotifier'
import { useAbility } from '@casl/vue'
import { ResponseCodes } from '../../utils/constants'
import useDistrictApi from '../../services/useDistrictApi'
import TextBox from '../../components/TextBox'
import router from '../../router'
import TeacherSelector from '../../components/selectors/TeacherSelector'
import InstitutionNotValid from '../../components/institutions/InstitutionNotValid'

export default {
  name: 'AddTeam',
  components: { TeacherSelector, TextBox, InstitutionNotValid },
  setup () {
    const notifier = useNotifier()
    const { can } = useAbility()
    const { getDistricts } = useDistrictApi()
    const TEAM_VALIDATION_EM = 'Öğretmen seçimi yapılmalıdır!'
    const { createTeam } = useTeamApi()
    const institutions = ref([])

    const schema = object({
      name: string().typeError(() => 'Takım adı yazı tipinde olmalıdır!')
        .min(2, () => 'En az 2 karakter uzunluğunda olmalıdır!')
        .required(() => 'Takım adı gereklidir!'),
      teachers: array().typeError(() => TEAM_VALIDATION_EM)
        .min(2, () => 'En az iki öğretmen seçilmelidir')
        .required(() => TEAM_VALIDATION_EM)
    })

    const { handleSubmit, errors } = useForm({ validationSchema: schema })

    const { value: name } = useField('name')
    const { value: selectedTeachers } = useField('teachers')
    const { value: institutionId } = useField('institution_id')
    const { value: districtId } = useField('district_id')

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
      getDistricts,
      can
    }
  }
}
</script>

<style scoped>

</style>
