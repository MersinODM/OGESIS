<template>
  <div class="form-group">
    <label>{{ label }}</label><br>
    <div class="btn-group btn-group-toggle col-md-12">
      <slot />
    </div>
  </div>
</template>

<script>
import { provide, reactive, ref, onBeforeMount, onBeforeUpdate } from 'vue'
const isButton = (node) => node.type.name === 'RadioButton'

export default {
  name: 'RadioGroup',
  props: {
    label: {
      type: String,
      default: ''
    }
  },
  setup (_, { slots }) {
    const state = reactive({
      selectedIndex: null,
      buttons: []
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
