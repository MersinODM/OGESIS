<template>
  <div class="form-group">
    <label>Paydaş/Partner Seçimi</label>
    <multiselect
      v-model="selectedPartners"
      :options="partnerList"
      label="name"
      name="partners"
      mode="tags"
      :searchable="true"
      track-by="name"
      value-prop="id"
      placeholder="Paydaş seçimi yapabilirsiniz."
      no-options-text="Bu liste boş!"
      no-result-text="Burada bişey bulamadık!"
      class="form-control h-auto"
      :class="{'is-invalid': isValidated && errorMessage != null}"
    >
    </multiselect>
    <validation-error
      v-if="isValidated"
      v-model="errorMessage"
    />
  </div>
</template>

<script>
import { useModelWrapper } from '../compositions/useModelWrapper'
import { useComponentValidationWrapper } from '../compositions/useComponentValidationWrapper'
import ValidationError from './ValidationError'
import Multiselect from '@vueform/multiselect'

export default {
  name: 'PartnerSelector',
  components: { ValidationError, Multiselect },
  props: {
    modelValue: {
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
    partners: {
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
      selectedPartners: useModelWrapper(props, emit),
      partnerList: useModelWrapper(props, emit, 'partners'),
      ...useComponentValidationWrapper(props) // Buradan validasyon parametreleri geliyor
    }
  }
}
</script>

<style scoped>

</style>
