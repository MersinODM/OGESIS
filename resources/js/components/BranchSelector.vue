<template>
  <div class="form-group">
    <label>Branş Seçimi</label>
    <multiselect
      v-model="branch"
      :name="name"
      :options="branches"
      label="name"
      value-prop="id"
      :searchable="true"
      :filterResults="false"
      :resolve-on-load="false"
      :close-on-select="true"
      :loading="isSearching"
      placeholder="Branş araması/seçimi yapabilirsiniz."
      no-options-text="Bu liste boş!"
      no-results-text="Burada bişey bulamadık!"
      class="form-control"
      :class="{'is-invalid': errorMessage != null}"
      @search-change="findBranch"
    />
    <validation-error
      v-if="isValidated"
      v-model="errorMessage"
    />
  </div>
</template>

<script>
import Multiselect from '@vueform/multiselect'
import ValidationError from './ValidationError'
import { useModelWrapper } from '../compositions/useModelWrapper'
import { useComponentValidationWrapper } from '../compositions/useComponentValidationWrapper'
import { useSearchBranches } from '../compositions/useSearchBranches'

export default {
  name: 'BranchSelector',
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
    name: {
      type: String,
      default: ''
    }
  },
  setup (props, { emit }) {
    const branch = useModelWrapper(props, emit) // Buradan model için gerekenler yapılıyor
    return {
      branch,
      ...useSearchBranches(branch), // Burada aramayla ilgili lojik var
      ...useComponentValidationWrapper(props) // Buradan validasyon parametreleri geliyor
    }
  }
}
</script>

<style scoped>

</style>
