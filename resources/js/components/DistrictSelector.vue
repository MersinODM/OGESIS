<template>
  <div
    v-if="can(TEACHER_CREATE_LEVEL_3)"
    class="form-group"
  >
    <label>İlçe Seçimi</label>
    <multiselect
      v-model="district"
      :name="name"
      placeholder="İlçe seçebilirsiniz"
      no-options-text="Bu liste boş!"
      no-result-text="Burada bişey bulamadık!"
      :close-on-select="true"
      :min-chars="2"
      value-prop="id"
      :searchable="true"
      label="name"
      :options="getDistricts"
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
import useDistrictApi from '../services/useDistrictApi'
import ValidationError from './ValidationError'
import { useAbility } from '@casl/vue'
import Multiselect from '@vueform/multiselect'
import { computed } from 'vue'
import { useComponentValidationWrapper } from '../compositions/useComponentValidationWrapper'

export default {
  name: 'DistrictSelector',
  components: { ValidationError, Multiselect },
  props: {
    modelValue: {
      type: Object,
      default: () => ({})
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
    const { can } = useAbility()
    const { getDistricts } = useDistrictApi()

    const district = computed({
      get: () => props.modelValue,
      set: (value) => emit('update:modelValue', value)
    })

    return {
      can,
      getDistricts,
      district,
      ...useComponentValidationWrapper(props)
    }
  }
}
</script>

<style scoped>

</style>
