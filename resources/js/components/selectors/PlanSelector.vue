<template>
  <div
    class="form-group"
  >
    <label v-if="isShowLabel">Gelişim Planı Seçimi</label>
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
import ValidationError from '../ValidationError'
import Multiselect from '@vueform/multiselect'
import { useModelWrapper } from '../../compositions/useModelWrapper'
import { useComponentValidationWrapper } from '../../compositions/useComponentValidationWrapper'
import usePlanApi from '../../services/usePlanApi'
import { ref } from 'vue'

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
    },
    isShowLabel: {
      type: Boolean,
      default: true
    }
  },
  setup (props, { emit }) {
    if (props.plans && props.plans.length <= 0) {
      const { getLatestPlans } = usePlanApi()
      const planList = ref([])
      getLatestPlans().then(value => {
        planList.value = value
      })
      return {
        selectedPLan: useModelWrapper(props, emit),
        planList,
        ...useComponentValidationWrapper(props) // Buradan validasyon parametreleri geliyor
      }
    }

    return {
      showLabel: useModelWrapper(props, emit, 'isShowLabel'),
      selectedPLan: useModelWrapper(props, emit),
      planList: useModelWrapper(props, emit, 'plans'),
      ...useComponentValidationWrapper(props) // Buradan validasyon parametreleri geliyor
    }
  }
}
</script>

<style scoped>

</style>
