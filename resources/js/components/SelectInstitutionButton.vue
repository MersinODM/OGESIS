<template>
  <a
    href="javascript:void(0)"
    class="btn btn-warning"
    @click="openModal({ title: 'Kurum seçimi', component: 'InstitutionSelectorModal' })"
  >Kurum Seç</a>
</template>

<script>
import useModal from '../compositions/useModal'

export default {
  name: 'SelectInstitutionButton',
  setup () {
    const { openModal } = useModal()
    return {
      openModal
    }
  }
}
</script>

<style scoped>

</style>
