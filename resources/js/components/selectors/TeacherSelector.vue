<template>
  <div class="form-group">
    <label>Öğretmen Seçimi</label>
    <multiselect
      v-model="selectedTeachers"
      :options="teacherList"
      label="full_name"
      :name="name"
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
import ValidationError from '../ValidationError'
import Multiselect from '@vueform/multiselect'
import { useModelWrapper } from '../../compositions/useModelWrapper'
import { useComponentValidationWrapper } from '../../compositions/useComponentValidationWrapper'
import { computed, watch } from 'vue'
import store from '../../store'

export default {
  name: 'TeacherSelector',
  components: { ValidationError, Multiselect },
  props: {
    modelValue: {
      default: null,
      required: false
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
    const selectedTeachers = useModelWrapper(props, emit)
    const teacherList = computed(() => store.getters['teacher/teachers'])

    watch(teacherList, () => {
      selectedTeachers.value = null
    })

    watch(selectedTeachers, (value) => {
      // if (store.getters['institution/selectedInstitution']?.id !== value.id) {
      store.dispatch('teacher/setSelectedTeacher', value)
      // }
    })

    return {
      selectedTeachers,
      teacherList,
      ...useComponentValidationWrapper(props) // Buradan validasyon parametreleri geliyor
    }
  }
}
</script>

<style scoped>

</style>
