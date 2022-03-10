<template>
  <page>
    <template #header>
      <h4>Giriş</h4> <button
        class="btn btn-danger"
        @click="openM1"
      >
        AÇ
      </button>
      <button
        class="btn btn-danger"
        @click="openM2"
      >
        AÇ
      </button>
    </template>
    <template #content>
      <div class="row justify-content-md-center">
        <div class="col-md-8">
          <institution-not-valid />
        </div>
      </div>
    </template>
  </page>
</template>

<script>
import Page from '../../components/Page'
import { ref } from 'vue'
import InstitutionNotValid from '../../components/institutions/InstitutionNotValid'
import useModal from '../../compositions/useModal'

export default {
  name: 'Start',
  components: { InstitutionNotValid, Page },
  setup (props) {
    const { openModal } = useModal()
    const openM1 = () => {
      openModal({ title: 'Yeni Etkinlik', component: 'AddActivity' })
    }

    const openM2 = () => {
      openModal({ title: 'Kurum seçimi', component: 'InstitutionSelectorModal' })
    }
    return {
      selectedVal: ref(),
      openM1,
      openM2
    }
  }
}
</script>

<style >

</style>
