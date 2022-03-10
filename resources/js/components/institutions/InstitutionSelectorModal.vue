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
      :validation-required="false"
      class="col-md-12 mt-1"
    />
  </div>
  <div class="row justify-content-md-center">
    <div class="col-md-4">
      <button
        class="btn btn-danger btn-block"
        @click="close"
      >
        KAPAT
      </button>
    </div>
  </div>
</template>

<script>
import DistrictSelector from '../selectors/DistrictSelector'
import InstitutionSelector from '../selectors/InstitutionSelector'
import { useDistrictAndInstitutionFilter } from '../../compositions/useDistrictAndInstitutionFilter'
import { useStore } from 'vuex'
import { useModalActionTypes } from '../../utils/constants'

export default {
  name: 'InstitutionSelectorModal',
  components: { DistrictSelector, InstitutionSelector },
  setup () {
    const store = useStore()
    const { MODAL, CLOSE } = useModalActionTypes()
    const { selectedInstitution, selectedDistrict } = useDistrictAndInstitutionFilter()
    const close = async () => {
      await store.dispatch(MODAL.withSuffix(CLOSE))
    }
    return {
      close,
      selectedInstitution,
      selectedDistrict
    }
  }
}
</script>

<style scoped>

</style>
