<template>
  <router-view />
</template>

<script>

// import { statusStore } from '../store/statusStore'
// import { lessonStore } from '../store/lessonStore'
// import examStore from '../store/examStore'
// import previewQuestionStore from '../store/previewQuestionStore'
// import previewCurriculumStore from '../store/previewCurriculumStore'

import mitt from 'mitt'

// eslint-disable-next-line new-cap
const eventBus = new mitt()

export default {
  name: 'App',
  provide: {
    eventBus
  },
  setup () {
  }
}
</script>

<style scoped>

</style>
