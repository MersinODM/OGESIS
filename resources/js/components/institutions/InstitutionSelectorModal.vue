<template>
  <div class="row">
    <district-selector
      v-model="selectedDistrict"
      name="district_id"
      class="col-md-12 mt-1"
      :validation-required="false"
    />
  </div>
  <div class="row">
    <institution-selector
      v-model="selectedInstitution"
      :institutions="institutions"
      :validation-required="false"
      class="col-md-12 mt-1"
    />
  </div>
  <div class="row justify-content-md-center">
    <div class="col-md-4">
      <button class="btn btn-primary btn-block">SEÇ</button>
    </div>
  </div>
</template>

<script>
import DistrictSelector from '../selectors/DistrictSelector'
import InstitutionSelector from '../selectors/InstitutionSelector'
import { useDistrictAndInstitutionFilter } from '../../compositions/useDistrictAndInstitutionFilter'

export default {
  name: 'InstitutionSelectorModal',
  components: { DistrictSelector, InstitutionSelector },
  setup () {
    const { institutions, selectedInstitution, selectedDistrict } = useDistrictAndInstitutionFilter()

    return {
      institutions,
      selectedInstitution,
      selectedDistrict
    }
  }
}
</script>

<style scoped>

</style>
