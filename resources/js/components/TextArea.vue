<template>
  <div class="form-group">
    <label>{{ label }}</label>
    <textarea
      v-model="text"
      v-uppercase="isUppercase"
      :class="{'is-invalid': isValidated && errorMessage != null}"
      :name="name"
      :placeholder="placeholder"
      class="form-control"
      type="text"
      style="width: 100%; min-height: 3.5em; max-height: 15em"
    />
    <validation-error
      v-if="isValidated"
      v-model="errorMessage"
    />
  </div>
</template>

<script>
import ValidationError from './ValidationError'
import { useModelWrapper } from '../compositions/useModelWrapper'
import { useComponentValidationWrapper } from '../compositions/useComponentValidationWrapper'

export default {
  name: 'TextArea',
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
    }
  },
  setup (props, { emit }) {
    return {
      text: useModelWrapper(props, emit),
      isUppercase: useModelWrapper(props, emit, 'uppercase'),
      ...useComponentValidationWrapper(props)
    }
  }
}
</script>

<style scoped>

</style>
