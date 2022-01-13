<template>
  <div
    v-if="$can(TEACHER_LIST_LEVEL_3)"
    class="form-group"
  >
    <label>Gelişim Planı Seçimi</label>
    <multiselect
      v-model="selectedPLan"
      :name="name"
      placeholder="Gelişim planı seçebilirsiniz"
      no-options-text="Bu liste boş!"
      no-result-text="Burada bişey bulamadık!"
      :close-on-select="true"
      track-by="name"
      :min-chars="2"
      value-prop="id"
      :searchable="true"
      label="name"
      :options="planList"
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
import Multiselect from '@vueform/multiselect'
import { useModelWrapper } from '../compositions/useModelWrapper'
import { useComponentValidationWrapper } from '../compositions/useComponentValidationWrapper'

export default {
  name: 'PlanSelector',
  components: { ValidationError, Multiselect },
  props: {
    modelValue: {
      type: Number,
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
    plans: {
      type: Array,
      default: () => ([])
    },
    name: {
      type: String,
      default: ''
    }
  },
  setup (props, { emit }) {
    return {
      selectedPLan: useModelWrapper(props, emit),
      planList: useModelWrapper(props, emit, 'plans'),
      ...useComponentValidationWrapper(props) // Buradan validasyon parametreleri geliyor
    }
  }
}
</script>

<style scoped>

</style>
