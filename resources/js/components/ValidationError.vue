<template>
  <div
    v-if="theModel"
    role="alert"
    class="invalid-feedback order-last"
    style="display: inline-block;"
  >
    {{ theModel }}
  </div>
</template>

<script>
import { computed, defineComponent } from 'vue'

export default defineComponent({
  name: 'ValidationError',
  props: {
    modelValue: {
      type: String,
      default: ''
    }
  },
  setup (props, { emit }) {
    const theModel = computed({ // Use computed to wrap the object
      get: () => props.modelValue,
      set: (value) => emit('update:modelValue', value)
    })

    // const theModel = toRef(props, 'modelValue')
    //
    // watch(props.modelValue, () => {
    //   theModel.value = props.modelValue
    // })

    return {
      theModel
    }
  }
})
</script>

<style scoped>

</style>
