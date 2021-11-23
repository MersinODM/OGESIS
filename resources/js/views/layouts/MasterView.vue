<!--
  - ODM.Web  https://github.com/electropsycho/ODM.Web
  - Copyright 2019-2020 Hakan GÜLEN
  -
  - Licensed under the Apache License, Version 2.0 (the "License");
  - you may not use this file except in compliance with the License.
  - You may obtain a copy of the License at
  -
  - http://www.apache.org/licenses/LICENSE-2.0
  -
  - Unless required by applicable law or agreed to in writing, software
  - distributed under the License is distributed on an "AS IS" BASIS,
  - WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  - See the License for the specific language governing permissions and
  - limitations under the License.
  -->

<template>
  <div class="wrapper">
    <n-header @toggleMenuSideBar="toggleMenuSidebar" />
    <n-sidebar />
    <div
      class="content-wrapper"
    >
      <router-view />
    </div>
    <n-footer />
    <div
      v-if="screenSize === 'xs' && isSidebarMenuCollapsed"
      id="sidebar-overlay"
      @click="toggleMenuSidebar"
    />
    <!--    <modal :name="curriculumModal">-->
    <!--      <template #modal-title>-->
    <!--        <h5>Kazanımlar</h5>-->
    <!--      </template>-->
    <!--      <template #modal-body>-->
    <!--        <preview-curriculums />-->
    <!--      </template>-->
    <!--    </modal>-->
    <!--    <modal :name="questionModal">-->
    <!--      <template #modal-title>-->
    <!--        <h5>Soru Önizleme</h5>-->
    <!--      </template>-->
    <!--      <template #modal-body>-->
    <!--        <preview-question />-->
    <!--      </template>-->
    <!--    </modal>-->
  </div>
</template>

<script>
import NHeader from './HeaderView'
import NSidebar from './MainSidebar'
import NFooter from './FooterView'
import SkinHelper from '../../utils/SkinHelper'
import constants from '../../utils/constants'
import Modal from '../../components/Modal'
import { computed, onMounted, onUnmounted, watch } from 'vue'
import { useStore } from 'vuex'

export default {
  name: 'MainView',
  components: { NFooter, NHeader, NSidebar, Modal },
  setup () {
    const store = useStore()
    // const { IS_SIDE_BAR_MENU_COLLAPSED } = useUIMutationConstants()
    SkinHelper.MainSkin()
    // lessonStore.actions.setLessons()
    const { MODAL_CURRICULUM, MODAL_QUESTION } = constants()
    // const { curriculums } = useCurriculumShower()
    let appElement = null

    const isSidebarMenuCollapsed = computed(() => store.state.ui.isSidebarMenuCollapsed)
    const screenSize = computed(() => store.state.ui.screenSize)
    const toggleMenuSidebar = () => {
      store.dispatch('ui/setToggleSideBar')
    }

    onMounted(() => {
      appElement = document.getElementById('app')
      appElement.classList.add('sidebar-mini')
      appElement.classList.add('layout-fixed')
    })

    onUnmounted(() => {
      appElement.classList.remove('sidebar-mini')
      appElement.classList.remove('layout-fixed')
    })

    watch([isSidebarMenuCollapsed, screenSize], () => {
      appElement.classList.remove('sidebar-closed')
      appElement.classList.remove('sidebar-collapse')
      appElement.classList.remove('sidebar-open')
      if (isSidebarMenuCollapsed.value && screenSize.value === 'lg') {
        appElement.classList.add('sidebar-collapse')
      } else if (isSidebarMenuCollapsed.value && screenSize.value === 'xs') {
        appElement.classList.add('sidebar-open')
      } else if (!isSidebarMenuCollapsed.value && screenSize.value !== 'lg') {
        appElement.classList.add('sidebar-closed')
        appElement.classList.add('sidebar-collapse')
      }
    })

    return {
      // curriculums,
      curriculumModal: MODAL_CURRICULUM,
      questionModal: MODAL_QUESTION,
      toggleMenuSidebar,
      isSidebarMenuCollapsed,
      screenSize
    }
  }
}
</script>
<style lang="sass">
  // @import "../../../../../node_modules/animate.css/animate.min.css"
</style>
