<template>
  <div
    v-if="$can(TEACHER_LIST_LEVEL_3) || $can(TEACHER_LIST_LEVEL_2)"
    class="form-group"
  >
    <label>Kurum Seçimi</label>
    <multiselect
      v-model="institution"
      :name="name"
      placeholder="Kurum seçebilirsiniz."
      no-options-text="Bu liste boş!"
      no-result-text="Burada bişey bulamadık!"
      label="name"
      value-prop="id"
      :searchable="true"
      track-by="name"
      :close-on-select="true"
      :loading="false"
      :options="institutionList"
      class="form-control"
      :class="{'is-invalid': isValidated && errorMessage != null}"
    />
    <validation-error
      v-if="isValidated"
      v-model="errorMessage"
    />
  </div>
</template>

<script>
import ValidationError from './ValidationError'
import { useComponentValidationWrapper } from '../compositions/useComponentValidationWrapper'
import { useModelWrapper } from '../compositions/useModelWrapper'
import Multiselect from '@vueform/multiselect'

export default {
  name: 'InstitutionSelector',
  components: { ValidationError, Multiselect },
  props: {
    modelValue: {
      default: null
    },
    institutions: {
      type: Array,
      default: () => ([])
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
    }
  },
  setup (props, { emit }) {
    return {
      institution: useModelWrapper(props, emit),
      institutionList: useModelWrapper(props, emit, 'institutions'),
      ...useComponentValidationWrapper(props)
    }
  }
}
</script>

<style scoped>

</style>
