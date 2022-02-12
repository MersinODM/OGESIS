<template>
  <page>
    <template #header>
      <h4>Giriş</h4> <button
        class="btn btn-danger"
        @click="openModal"
      >
        AÇ
      </button>
      <button
        class="btn btn-danger"
        @click="openModal2"
      >
        AÇ
      </button>
    </template>
    <template #content>
      <div class="row justify-content-md-center">
        <div class="col-md-8">
          <add-activity />
        </div>
      </div>
    </template>
  </page>
</template>

<script>
import Page from '../../components/Page'
import { ref } from 'vue'
import AddActivity from '../../components/activities/AddActivity'
import { useStore } from 'vuex'
import { useModalActionTypes } from '../../utils/constants'
import BranchSelector from '../../components/BranchSelector'

export default {
  name: 'Start',
  components: { AddActivity, Page },
  setup (props) {
    const store = useStore()
    const { MODAL, SHOW } = useModalActionTypes()
    const openModal = () => {
      store.dispatch(MODAL.withSuffix(SHOW), { title: 'deneme', component: AddActivity })
    }

    const openModal2 = () => {
      store.dispatch(MODAL.withSuffix(SHOW), { title: 'Branş seçimi', component: BranchSelector })
    }
    return {
      selectedVal: ref(),
      openModal,
      openModal2
    }
  }
}
</script>

<style >

</style>
