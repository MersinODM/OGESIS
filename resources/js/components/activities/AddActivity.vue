<template>
  <div class="form">
    <div class="form-row">
      <plan-selector
        v-model="selectedPlan"
        :validation-required="true"
        :validation-message="errors.plan"
      />
    </div>
    <div class="form-row">
      <district-selector
        v-model="selectedDistrict"
        :validation-required="true"
        :validation-message="errors.district_id"
      />
    </div>
    <div class="form-row">
      <institution-selector
        v-model="selectedInstitution"
        :validation-required="true"
        :validation-message="errors.institution_id"
      />
    </div>
    <div class="form-row">
      <theme-selector
        v-model="selectedTheme"
        :validation-required="true"
        :validation-message="errors.theme_id"
      />
    </div>
  </div>
</template>

<script>
import PlanSelector from '../PlanSelector'
import DistrictSelector from '../DistrictSelector'
import InstitutionSelector from '../InstitutionSelector'

export default {
  name: 'AddActivity',
  components: { InstitutionSelector, DistrictSelector, PlanSelector }

}
</script>

<style scoped>

</style>
