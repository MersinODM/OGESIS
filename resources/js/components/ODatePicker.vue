<template>
  <div class="form-group">
    <label>{{ label }}</label>
    <date-picker
      v-model="selectedDate"
      mode="date"
      :name="name"
      :update-on-input="false"
      locale="tr"
      input-format="dd.MM.yyyy"
      :model-config="{
        type: 'string',
        mask: ['YYYY-MM-DD HH:mm'],
      }"
      style="background-color: white"
    >
      <template #default="{ inputValue, inputEvents }">
        <input
          class="form-control text-center"
          :class="{'is-invalid': isValidated && errorMessage != null}"
          :value="inputValue"
          v-on="inputEvents"
        >
      </template>
    </date-picker>
    <validation-error
      v-if="isValidated"
      v-model="errorMessage"
    />
  </div>
</template>

<script>
import ValidationError from './ValidationError'
import { DatePicker } from 'v-calendar'
import { useModelWrapper } from '../compositions/useModelWrapper'
import { useComponentValidationWrapper } from '../compositions/useComponentValidationWrapper'

export default {
  name: 'ODatePicker',
  components: { ValidationError, DatePicker },
  props: {
    modelValue: {
      default: null
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
    name: {
      type: String,
      default: ''
    },
    label: {
      type: String,
      default: ''
    }
  },
  setup (props, { emit }) {
    return {
      selectedDate: useModelWrapper(props, emit),
      ...useComponentValidationWrapper(props) // Buradan validasyon parametreleri geliyor
    }
  }
}
</script>

<style scoped lang="sass">
@import 'v-calendar/dist/style.css'
</style>
