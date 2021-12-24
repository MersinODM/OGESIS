<template>
  <div class="form-group">
    <label>{{ label }}</label>
    <input
      v-model="text"
      v-mask="mask"
      v-uppercase="isUppercase"
      :class="{'is-invalid': isValidated && errorMessage != null}"
      class="form-control"
      :name="name"
      type="text"
      :placeholder="placeholder"
    >
    <validation-error
      v-if="isValidated"
      v-model="errorMessage"
    />
  </div>
</template>

<script>
import { useComponentValidationWrapper } from '../compositions/useComponentValidationWrapper'
import ValidationError from './ValidationError'
import { useModelWrapper } from '../compositions/useModelWrapper'
import { computed } from 'vue'

export default {
  name: 'TextBox',
  components: { ValidationError },
  props: {
    modelValue: {
      type: String,
      default: () => ('')
    },
    validationMessage: {
      type: String,
      default: null,
      required: false
    },
    validationRequired: {
      type: Boolean,
      default: false
    },
    uppercase: {
      type: Boolean,
      default: false
    },
    name: {
      type: String,
      default: ''
    },
    label: {
      type: String,
      default: ''
    },
    placeholder: {
      type: String,
      default: ''
    },
    mask: {
      type: String,
      default: () => ('')
    }
  },
  setup (props, { emit }) {
    return {
      text: useModelWrapper(props, emit),
      isUppercase: useModelWrapper(props, emit, 'uppercase'),
      textMask: computed(() => props.mask),
      ...useComponentValidationWrapper(props)
    }
  }
}
</script>

<style scoped>

</style>
