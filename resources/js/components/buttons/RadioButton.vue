<template>
  <label
    class="btn"
    :class="{active: isActive}"
  >
    <input
      type="radio"
      autocomplete="off"
      @click="activate"
    >
    <slot />
  </label>
</template>

<script>

import { getCurrentInstance, inject, watch, ref } from 'vue'

export default {
  name: 'RadioButton',
  emits: ['click'],
  setup (props, { emit }) {
    const index = getCurrentInstance().vnode.key
    const state = inject('radioProvider')
    const isActive = ref()
    const activate = () => {
      state.selectedIndex = index
      emit('click')
    }

    watch(
      () => state.selectedIndex,
      () => {
        isActive.value = index === state.selectedIndex
      })

    return {
      activate,
      isActive
    }
  }
}
</script>

<style scoped>

</style>
