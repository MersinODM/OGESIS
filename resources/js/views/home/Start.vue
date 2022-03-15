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
      <div class="row justify-content">
        <div class="col-md-6">
          <draggable
            :list="myArr"
            item-key="name"
            group="people"
          >
            <template #item="{element}">
              <div class="card">
                <div class="card-body">
                  {{ element.name }}
                </div>
              </div>
            </template>
          </draggable>
        </div>
        <div class="col-md-6">
          <draggable
            :list="myArr1"
            item-key="name"
            group="people"
          >
            <template #item="{element}">
              <div class="card">
                <div class="card-body">
                  {{ element.name }}
                </div>
              </div>
            </template>
          </draggable>
        </div>
      </div>
    </template>
  </page>
</template>

<script>
import Page from '../../components/Page'
import { ref } from 'vue'
import Draggable from 'vuedraggable'
import InstitutionNotValid from '../../components/institutions/InstitutionNotValid'
import useModal from '../../compositions/useModal'

export default {
  name: 'Start',
  components: { InstitutionNotValid, Page, Draggable },
  order: 1,
  setup (props) {
    const { openModal } = useModal()
    const openM1 = () => {
      openModal({ title: 'Yeni Etkinlik', component: 'AddActivity' })
    }

    const openM2 = () => {
      openModal({ title: 'Kurum seçimi', component: 'InstitutionSelectorModal' })
    }
    const myArr = ref([{ id: 1, name: 'tets' }, { id: 3, name: 'gdfdf' }, { id: 4, name: 'gfdgdf' }])
    const myArr1 = ref([{ id: 5, name: 'KİMO' }, { id: 8, name: 'DENEME' }, { id: 14, name: 'FSFD' }])
    return {
      selectedVal: ref(),
      myArr, myArr1,
      openM1,
      openM2
    }
  }
}
</script>

<style >

</style>
