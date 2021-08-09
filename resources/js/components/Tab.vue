<template>
  <div
    v-show="isActive"
    class="tab-pane fade"
    :class="{active: isActive, show: isActive}"
  >
    <slot />
  </div>
</template>
<script>
import { onBeforeMount, ref, inject, watch } from 'vue'

export default {
  name: 'Tab',
  props: {
    title: {
      required: true,
      type: String,
      default: ''
    },
    id: {
      required: false,
      type: Number,
      default: 0
    }
  },
  emits: ['click'],
  setup (props, { emit }) {
    const isActive = ref(false)
    const tabs = inject('TabsProvider')

    watch(
      () => tabs.selectedIndex,
      (newVal) => {
        console.log(newVal)
        isActive.value = props.title === tabs.selectedIndex
        // if (isActive.value) {
        //   emit('click', { id: props.id, title: newVal })
        // }
      }
    )
    onBeforeMount(() => {
      isActive.value = props.title === tabs.selectedIndex
    })
    return { isActive }
  }
}
</script>

<style scoped>

</style>
