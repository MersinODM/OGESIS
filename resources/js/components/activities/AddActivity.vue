<template>
  <div>
    <form @submit.prevent>
      <div class="form-row">
        <plan-selector
          v-model="selectedPlan"
          class="col-md-12"
          :validation-required="true"
          :validation-message="errors.plan_id"
        />
      </div>
      <div class="form-row">
        <theme-selector
          v-model="selectedTheme"
          name="theme_id"
          class="col-md-12"
          label="Açıklama"
          :validation-required="true"
          :validation-message="errors.theme_id"
        />
      </div>
      <div class="form-row">
        <district-selector
          v-model="selectedDistrict"
          class="col-md-12"
          :validation-required="true"
          :validation-message="errors.district_id"
        />
      </div>
      <div class="form-row">
        <institution-selector
          v-model="selectedInstitution"
          class="col-md-12"
          :validation-required="true"
          :validation-message="errors.institution_id"
        />
      </div>
      <div class="form-row">
        <partner-selector
          v-model="selectedPartners"
          name="partners"
          class="col-md-12"
          :validation-required="false"
        />
      </div>
      <div class="form-row justify-content-md-center">
        <div class="col-md-12">
          <radio-group label="Ekip veya sorumlu seçimi">
            <radio-button
              :key="0"
              class="bg-gradient-warning col-md-6"
              @click="isTeamSelected = false"
            >
              Öğretmenlerden Seç
            </radio-button>
            <radio-button
              :key="1"
              v-model="isTeamSelected"
              class="bg-gradient-warning col-md-6"
              @click="isTeamSelected = true"
            >
              Takımlardan Seç
            </radio-button>
          </radio-group>
        </div>
      </div>
      <div
        v-if="isTeamSelected"
        class="form-row"
      >
        <team-selector
          v-model="selectedTeam"
          class="col-md-12"
          name="team_id"
          :teams="teams"
          :validation-required="true"
          :validation-message="errors.team_id"
        />
      </div>
      <div
        v-if="!isTeamSelected"
        class="form-row"
      >
        <teacher-selector
          v-model="selectedTeachers"
          :teachers="teachers"
          name="teachers"
          class="col-md-12"
          :validation-required="true"
          :validation-message="errors.teachers"
        />
      </div>
      <div class="form-row">
        <text-box
          v-model="title"
          name="title"
          class="col-md-12"
          label="Etkinlik Başlığı"
          :validation-required="true"
          :validation-message="errors.title"
        />
      </div>
      <div class="form-row">
        <text-area
          v-model="description"
          label="Açıklama"
          class="col-md-12"
          :validation-required="true"
          :validation-message="errors.description"
        />
      </div>
      <div class="form-row">
        <div class="col-md-6">
          <date-picker
            v-model="plannedStartDate"
            name="planned_start_date"
            label="Planlanan Başlangıç Tarihi"
            :validation-required="true"
            :validation-message="errors.planned_start_date"
          />
        </div>
        <div class="col-md-6">
          <date-picker
            v-model="plannedEndDate"
            name="planned_end_date"
            label="Planlanan Bitiş Tarihi"
            :validation-required="true"
            :validation-message="errors.planned_end_date"
          />
        </div>
      </div>
      <div class="form-row justify-content-md-center">
        <div class="col-md-6">
          <button
            class="btn btn-primary btn-block"
            @click="save"
          >
            Kaydet
          </button>
        </div>
      </div>
    </form>
  </div>
</template>
<script>

import { ref } from 'vue'
import PlanSelector from '../selectors/PlanSelector'
import DistrictSelector from '../selectors/DistrictSelector'
import InstitutionSelector from '../selectors/InstitutionSelector'
import ThemeSelector from '../selectors/ThemeSelector'
import TextBox from '../TextBox'
import TextArea from '../TextArea'
import DatePicker from '../ODatePicker'
import PartnerSelector from '../selectors/PartnerSelector'
import RadioGroup from '../buttons/RadioGroup'
import RadioButton from '../buttons/RadioButton'
import TeamSelector from '../selectors/TeamSelector'
import TeacherSelector from '../selectors/TeacherSelector'
import { object, string, date, ref as yupRef, array, boolean, number } from 'yup'
import { useRuleDistrict, useRuleInstitution } from '../../compositions/useRules'
import { useField, useForm } from 'vee-validate'
import { useDistrictAndInstitutionFilter } from '../../compositions/useDistrictAndInstitutionFilter'
import { useTeacherFilter } from '../../compositions/useTeacherFilter'
import { useTeamFilter } from '../../compositions/useTeamFilter'
import Messenger from '../../utils/messenger'
import { ResponseCodes, useModalActionTypes } from '../../utils/constants'
import router from '../../router'
import useNotifier from '../../utils/useNotifier'
import useActivityApi from '../../services/useActivityApi'
import { useStore } from 'vuex'
import useModal from '../../compositions/useModal'

export default {
  name: 'AddActivity',
  components: {
    TeacherSelector,
    RadioButton,
    RadioGroup,
    PartnerSelector,
    TextArea,
    TextBox,
    InstitutionSelector,
    DistrictSelector,
    PlanSelector,
    ThemeSelector,
    DatePicker,
    TeamSelector
  },
  setup () {
    const PLAN_ERROR_MESSAGE = 'Plan seçimi yapılmaldır!'
    const THEME_ERROR_MESSAGE = 'Tema seçimi yapılmaldır!'
    const TITLE_ERROR_MESSAGE = 'Etkinlik başlığı girilmelidir!'
    const PLANNED_START_DATE_ERROR_MESSAGE = 'Planlanan başlangıç tarihi seçilmelidir!'
    const PLANNED_END_DATE_ERROR_MESSAGE = 'Planlanan bitiş tarihi seçilmelidir!'
    const TEAM_ERROR_MESSAGE = 'Takım seçimi yapılmaldır!'
    const notifier = useNotifier()
    const { createActivity } = useActivityApi()
    const { closeModal } = useModal()
    // Validasyon bilgileri
    const schema = object({
      isTeamSelected: boolean(),
      plan_id: string().typeError(() => PLAN_ERROR_MESSAGE)
        .required(() => PLAN_ERROR_MESSAGE),
      theme_id: string().typeError(() => THEME_ERROR_MESSAGE)
        .required(() => THEME_ERROR_MESSAGE),
      title: string().typeError(() => TITLE_ERROR_MESSAGE)
        .required(() => TITLE_ERROR_MESSAGE),
      planned_start_date: date().typeError(() => PLANNED_START_DATE_ERROR_MESSAGE)
        .required(() => PLANNED_START_DATE_ERROR_MESSAGE),
      planned_end_date: date().typeError(() => PLANNED_END_DATE_ERROR_MESSAGE)
        .required(() => PLANNED_END_DATE_ERROR_MESSAGE)
        .min(yupRef('planned_start_date'), () => 'Planlanan bitiş tarihi planlanan başlangıç tarihinden sonra olmalıdır'),
      partners: array().notRequired(),
      description: string().required(() => 'Anlaşılabilir bir açıklama gereklidir!')
        .max(5000, () => 'Açıklama azami 5000 karakter olabilir'),
      teachers: array().when('isTeamSelected', {
        is: false,
        then: (schema) => schema.required(() => 'Öğretmen seçimi yapılmaldır!')
          .min(1, () => 'En az 1 öğretmen seçilmelidir')
      }),
      team_id: number().when('isTeamSelected', {
        is: true,
        then: (schema) => schema.typeError(() => TEAM_ERROR_MESSAGE).required(() => TEAM_ERROR_MESSAGE)
      }),
      // // Eğer ilçe yetkisi varsa kurum doğrulaması yapacağız
      ...useRuleInstitution()
      // // Eğer il yetkisi vars    const notifier = useNotifier()a ilçe kurum doğrulması yapacağız
      // ...useRuleDistrict()
    })

    const { handleSubmit, errors } = useForm({ validationSchema: schema })
    // Validasyon değişken tanımlamaları
    const { value: title } = useField('title')
    const { value: selectedPlan } = useField('plan_id')
    const { value: selectedTheme } = useField('theme_id')
    const { value: plannedStartDate } = useField('planned_start_date')
    const { value: plannedEndDate } = useField('planned_end_date')
    const { value: selectedInstitution } = useField('institution_id')
    const { value: selectedDistrict } = useField('district_id')
    const { value: selectedPartners } = useField('partners')
    const { value: description } = useField('description')
    const { value: isTeamSelected } = useField('isTeamSelected')
    const { value: selectedTeachers } = useField('teachers')
    const { value: selectedTeam } = useField('team_id')
    isTeamSelected.value = false

    const { institutions } = useDistrictAndInstitutionFilter(null, selectedDistrict, selectedInstitution)
    const { teachers } = useTeacherFilter(selectedDistrict, selectedInstitution, selectedTeachers)
    const { teams } = useTeamFilter(selectedDistrict, selectedInstitution, selectedTeachers)
    const save = handleSubmit(async values => {
      const result = await Messenger.showPrompt('Etkinlik/Aktivite oluşturulacaktır. Onaylıyor musunuz?')
      if (result.isConfirmed) {
        const response = await createActivity(values)
        if (response?.code === ResponseCodes.SUCCESS) {
          await notifier.success({ message: 'Etkinlik/Aktivite başarıyla oluşturuldu.', duration: 3200 })
          await closeModal()
          await router.push({ name: 'activityList', params: { planId: values.plan_id } })
        } else {
          await notifier.error({ message: 'Etkinlik/Aktivite kaydı oluşturalamadı!.', duration: 3200 })
        }
      }
    })

    return {
      title,
      selectedPlan,
      selectedDistrict,
      selectedInstitution,
      selectedTheme,
      selectedPartners,
      plannedStartDate,
      plannedEndDate,
      isTeamSelected,
      selectedTeachers,
      selectedTeam,
      institutions,
      description,
      teachers,
      teams,
      errors,
      save
    }
  }
}
</script>

<style scoped>

</style>
