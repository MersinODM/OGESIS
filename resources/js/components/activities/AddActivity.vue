<template>
  <div>
    <form @submit.prevent>
      <div class="form-row">
        <plan-selector
          v-model="selectedPlan"
          class="col-md-12"
          :validation-required="true"
          :validation-message="errors.plan"
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
        <theme-selector
          v-model="selectedTheme"
          class="col-md-12"
          label="Açıklama"
          :validation-required="true"
          :validation-message="errors.theme_id"
        />
      </div>
      <div class="form-row">
        <partner-selector
          v-model="selectedPartners"
          class="col-md-12"
          :validation-required="false"
        />
      </div>
      <div class="form-row">
        <text-box
          v-model="title"
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
            label="Planlanan Başlangıç Tarihi"
            :validation-required="true"
            :validation-message="errors.planned_start_date"
          />
        </div>
        <div class="col-md-6">
          <date-picker
            v-model="plannedEndDate"
            label="Planlanan Bitiş Tarihi"
            :validation-required="true"
            :validation-message="errors.planned_end_date"
          />
        </div>
      </div>
      <div class="form-row justify-content-md-center">
        <div class="col-md-12">
          <radio-group label="Ekip veya sorumlu seçimi">
            <radio-button
              :key="0"
              class="bg-gradient-fuchsia col-md-6"
              @click="isTeamSelected = false"
            >
              Öğretmenlerden Seç
            </radio-button>
            <radio-button
              :key="1"
              v-model="isTeamSelected"
              class="bg-gradient-fuchsia col-md-6"
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
        <team-selector class="col-md-12" />
      </div>
      <div
        v-if="!isTeamSelected"
        class="form-row"
      >
        <teacher-selector class="col-md-12" />
      </div>
    </form>
  </div>
</template>
<script>

import { ref, inject } from 'vue'
import PlanSelector from '../PlanSelector'
import DistrictSelector from '../DistrictSelector'
import InstitutionSelector from '../InstitutionSelector'
import ThemeSelector from '../ThemeSelector'
import TextBox from '../TextBox'
import TextArea from '../TextArea'
import DatePicker from '../ODatePicker'
import PartnerSelector from '../PartnerSelector'
import RadioGroup from '../buttons/RadioGroup'
import RadioButton from '../buttons/RadioButton'
import TeamSelector from '../TeamSelector'
import TeacherSelector from '../TeacherSelector'
import constants from '../../utils/constants'

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
    const selection = ref(false)
    const isTeamSelected = ref(false)
    const { EVENT_OPEN_MODAL } = constants()
    const eventBus = inject('eventBus')
    const showModal = ref(false)

    const button1 = () => {
      showModal.value = !showModal.value
      isTeamSelected.value = false
      eventBus.publish(EVENT_OPEN_MODAL)
    }

    const button2 = () => {
      isTeamSelected.value = false
    }
    return {
      title: '',
      selectedPlan: '',
      selectedDistrict: '',
      selectedInstitution: '',
      selectedTheme: '',
      errors: [],
      selection,
      isTeamSelected,
      button1,
      button2,
      showModal
    }
  }
}
</script>

<style scoped>

</style>
