<template>
  <div class="form-group">
    <label>Öğretmen Seçimi</label>
    <multiselect
      v-model="selectedTeachers"
      :options="teacherList"
      label="full_name"
      name="teachers"
      mode="tags"
      :searchable="true"
      :create-option="false"
      track-by="full_name"
      value-prop="id"
      placeholder="Öğretmen seçimi yapabilirsiniz."
      no-options-text="Bu liste boş!"
      no-result-text="Burada bişey bulamadık!"
      class="form-control h-auto"
      :class="{'is-invalid': isValidated && errorMessage != null}"
    >
      <template #option="{ option }">
        {{ option.full_name }} - {{ option.branch.name }}
      </template>
      <template #tag="{ option, handleTagRemove, disabled }">
        <span class="multiselect-tag text-wrap">
          {{ option.full_name }} - {{ option.branch.name }}
          <span
            v-if="!disabled"
            class="multiselect-tag-remove"
            @mousedown.prevent="handleTagRemove(option, $event)"
          >
            <span class="multiselect-tag-remove-icon" />
          </span>
        </span>
      </template>
    </multiselect>
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
  name: 'TeacherSelector',
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
    teachers: {
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
      selectedTeachers: useModelWrapper(props, emit),
      teacherList: useModelWrapper(props, emit, 'teachers'),
      ...useComponentValidationWrapper(props) // Buradan validasyon parametreleri geliyor
    }
  }
}
</script>

<style scoped>

</style>
