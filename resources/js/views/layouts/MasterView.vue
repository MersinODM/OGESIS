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
    <n-header />
    <n-sidebar />
    <div
      class="content-wrapper"
      style="min-height: 225.546px;"
    >
      <router-view />
    </div>
    <n-footer />
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
// import { lessonStore } from '../../store/lessonStore'
// import useCurriculumShower from '../../compositions/useCurriculumShower'
import constants from '../../utils/constants'
import Modal from '../../components/Modal'

export default {
  name: 'DashBoard',
  components: { NFooter, NHeader, NSidebar, Modal },
  setup () {
    SkinHelper.MainSkin()
    // lessonStore.actions.setLessons()
    const { MODAL_CURRICULUM, MODAL_QUESTION } = constants()
    // const { curriculums } = useCurriculumShower()
    return {
      // curriculums,
      curriculumModal: MODAL_CURRICULUM,
      questionModal: MODAL_QUESTION
    }
  }
}
</script>
<style lang="sass">
  // @import "../../../../../node_modules/animate.css/animate.min.css"
</style>
