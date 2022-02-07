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
import { useModelWrapper } from '../../compositions/useModelWrapper'

export default {
  name: 'RadioButton',
  props: {
    modelValue: {
      default: false,
      type: Boolean
    }
  },
  emits: ['click'],
  setup (props, { emit }) {
    const index = getCurrentInstance().vnode.key
    const isShow = useModelWrapper(props, emit)
    const state = inject('radioProvider')
    const isActive = ref(false)
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
      isShow,
      isActive
    }
  }
}
</script>

<style scoped>

</style>
