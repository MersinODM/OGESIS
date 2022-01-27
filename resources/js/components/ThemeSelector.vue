<template>
  <div
    class="form-group"
  >
    <label>Tema Seçimi</label>
    <multiselect
      v-model="selectedTheme"
      :name="name"
      :groups="true"
      placeholder="Etkinlik teması seçebilirsiniz"
      no-options-text="Bu liste boş!"
      no-result-text="Burada bişey bulamadık!"
      :close-on-select="true"
      track-by="name"
      label="name"
      :min-chars="2"
      value-prop="id"
      :searchable="true"
      :options="themeList"
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
import Multiselect from '@vueform/multiselect'
import ValidationError from './ValidationError'
import { useModelWrapper } from '../compositions/useModelWrapper'
import { useComponentValidationWrapper } from '../compositions/useComponentValidationWrapper'
import useThemeApi from '../services/useThemeApi'
import { ref } from 'vue'

export default {
  name: 'ThemeSelector',
  components: { Multiselect, ValidationError },
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
    const themeList = ref([])
    const { getThemes } = useThemeApi()
    getThemes().then(value => {
      themeList.value = value.filter(value => !value.parent_id)
        .map((p) => {
          return {
            label: p.name,
            id: p.id,
            options: value.filter(value => value.parent_id === p.id)
          }
        })
    })
    return {
      selectedTheme: useModelWrapper(props, emit),
      ...useComponentValidationWrapper(props), // Buradan validasyon parametreleri geliyor
      themeList
    }
  }
}
</script>

<style scoped>

</style>
