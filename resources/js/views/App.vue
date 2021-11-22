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
import { watch } from 'vue'
import useUIStore from '../store/useUIStore'
import { useWindowSize } from 'vue-window-size'
import { calculateScreenSize } from '../utils/calculateScreenSize'

// eslint-disable-next-line new-cap
const eventBus = new mitt()

export default {
  name: 'App',
  provide: {
    eventBus
  },
  setup () {
    const store = useUIStore()
    const { width: screenWidth } = useWindowSize()
    watch(screenWidth, () => {
      store.actions.setScreenSize(calculateScreenSize(screenWidth.value))
    })
  }
}
</script>

<style scoped>

</style>
