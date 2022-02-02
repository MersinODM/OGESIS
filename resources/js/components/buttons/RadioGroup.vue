<template>
  <div class="btn-group btn-group-toggle">
    <slot />
  </div>
</template>

<script>
import { provide, reactive, ref, onBeforeMount, onBeforeUpdate } from 'vue'
const isButton = (node) => node.type.name === 'button'

export default {
  name: 'RadioGroup',
  setup (_, { slots }) {
    const state = reactive({
      selectedIndex: null,
      buttons: [],
      count: 0,
      selectedId: 0
    })
    provide('radioProvider', state)

    const update = () => {
      if (slots.default) {
        state.buttons = slots
          .default()
          .filter((node) => isButton(node))
      }
    }

    onBeforeMount(() => update())
    onBeforeUpdate(() => update())
  }
}
</script>

<style scoped>

</style>
