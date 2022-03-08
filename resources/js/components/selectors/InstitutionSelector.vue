<template>
  <div
    v-if="$can(LEVEL_3) || $can(LEVEL_2)"
    class="form-group"
  >
    <label>Kurum Seçimi</label>
    <multiselect
      v-model="institution"
      :name="name"
      :mode="mode"
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
import ValidationError from '../ValidationError'
import { useComponentValidationWrapper } from '../../compositions/useComponentValidationWrapper'
import { useModelWrapper } from '../../compositions/useModelWrapper'
import Multiselect from '@vueform/multiselect'
import { watch } from 'vue'

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
    },
    mode: {
      type: String,
      default: 'single'
    }
  },
  setup (props, { emit }) {
    const institution = useModelWrapper(props, emit)
    const institutionList = useModelWrapper(props, emit, 'institutions')

    watch(institutionList, () => {
      institution.value = null
    }, { deep: true })

    return {
      institution,
      institutionList,
      ...useComponentValidationWrapper(props)
    }
  }
}
</script>

<style scoped>

</style>
