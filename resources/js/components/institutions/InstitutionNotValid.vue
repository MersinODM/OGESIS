<template>
  <div
    v-if="hasInstitutionNotSelected"
    class="row"
  >
    <div class="col-md-12">
      <p>
        Lütfen önce <a
          href="javascript:void(0)"
          class="text-bold text-maroon"
        >kurum</a> seçimi yapınız
      </p>
    </div>
  </div>
</template>

<script>

import { useInstitutionCheck } from '../../compositions/useRules'

export default {
  name: 'InstitutionNotValid',
  setup () {
    const { hasInstitutionNotSelected } = useInstitutionCheck()
    return {
      hasInstitutionNotSelected
    }
  }
}
</script>

<style scoped>

</style>
