<template>
  <div class="form-group">
    <label>Paydaş/Partner Seçimi</label>
    <multiselect
      v-model="selectedPartners"
      mode="tags"
      label="name"
      value-prop="id"
      :name="name"
      :options="findPartner"
      :close-on-select="false"
      :filter-results="false"
      :min-chars="1"
      :resolve-on-load="false"
      :delay="350"
      :searchable="true"
      :loading="isSearching"
      :class="{'is-invalid': isValidated && errorMessage != null}"
      placeholder="Paydaş seçimi için arama yapabilirsiniz."
      no-options-text="Bu liste boş!"
      no-results-text="Burada başka seçenek bulamadık!"
      class="form-control h-auto"
    />
    <validation-error
      v-if="isValidated"
      v-model="errorMessage"
    />
  </div>
</template>

<script>
import { useModelWrapper } from '../../compositions/useModelWrapper'
import { useComponentValidationWrapper } from '../../compositions/useComponentValidationWrapper'
import ValidationError from '../ValidationError'
import Multiselect from '@vueform/multiselect'
import { useSearchPartners } from '../../compositions/useSearchPartners'

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
    name: {
      type: String,
      default: ''
    }
  },
  setup (props, { emit }) {
    const selectedPartners = useModelWrapper(props, emit) // Buradan model için gerekenler yapılıyor
    return {
      selectedPartners,
      ...useSearchPartners(selectedPartners),
      ...useComponentValidationWrapper(props) // Buradan validasyon parametreleri geliyor
    }
  }
}
</script>

<style scoped>

</style>
