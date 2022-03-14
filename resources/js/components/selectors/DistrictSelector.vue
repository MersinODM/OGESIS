<template>
  <div
    v-if="$can(LEVEL_3)"
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
      track-by="name"
      :min-chars="2"
      value-prop="id"
      :searchable="true"
      :object="true"
      label="name"
      :options="districts"
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
import { computed, watch } from 'vue'
import { useComponentValidationWrapper } from '../../compositions/useComponentValidationWrapper'
import { useStore } from 'vuex'

export default {
  name: 'DistrictSelector',
  components: { ValidationError, Multiselect },
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
    addAllChoice: {
      type: Boolean,
      default: false
    },
    name: {
      type: String,
      default: ''
    }
  },
  setup (props, { emit }) {
    const store = useStore()

    const district = computed({
      get: () => props.modelValue,
      set: (value) => emit('update:modelValue', value)
    })

    const districts = computed(() => store.getters['district/districts'])

    watch(districts, () => {
      district.value = null
    }, { deep: true })

    watch(district, (value) => {
      store.dispatch('district/setSelectedDistrict', value)
    })

    // district.value = store.getters['district/selectedDistrict']

    return {
      districts,
      district,
      // useModelWrapper(props, emit, 'addAllChoice'),
      ...useComponentValidationWrapper(props)
    }
  }
}
</script>

<style scoped>

</style>
