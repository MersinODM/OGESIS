<template>
  <div
    v-if="hasInstitutionNotSelected"
    class="row"
  >
    <div class="col-md-12">
      <h4>
        Lütfen önce <a
          href="javascript:void(0)"
          class="text-bold text-maroon"
          @click="openInstitutionSelection"
        >kurum</a> seçimi yapınız!
      </h4>
    </div>
  </div>
</template>

<script>

import { useInstitutionCheck } from '../../compositions/useRules'
import useModal from '../../compositions/useModal'

export default {
  name: 'InstitutionNotValid',
  setup () {
    const { hasInstitutionNotSelected } = useInstitutionCheck()
    const { openModal } = useModal()
    const openInstitutionSelection = () => {
      openModal({ title: 'Kurum seçimi', component: 'InstitutionSelectorModal' })
    }
    return {
      openInstitutionSelection,
      hasInstitutionNotSelected
    }
  }
}
</script>

<style scoped>

</style>
