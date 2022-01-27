<template>
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
  </form>
</template>

<script>
import PlanSelector from '../PlanSelector'
import DistrictSelector from '../DistrictSelector'
import InstitutionSelector from '../InstitutionSelector'
import ThemeSelector from '../ThemeSelector'
import TextBox from '../TextBox'
import TextArea from '../TextArea'
import DatePicker from '../ODatePicker'

export default {
  name: 'AddActivity',
  components: { TextArea, TextBox, InstitutionSelector, DistrictSelector, PlanSelector, ThemeSelector, DatePicker },
  setup () {
    return {
      title: '',
      selectedPlan: '',
      selectedDistrict: '',
      selectedInstitution: '',
      selectedTheme: '',
      errors: []
    }
  }
}
</script>

<style scoped>

</style>
