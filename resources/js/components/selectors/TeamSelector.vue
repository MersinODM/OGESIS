<template>
  <div class="form-group">
    <label>Takım Seçimi</label>
    <multiselect
      v-model="selectedTeam"
      :name="name"
      placeholder="Takım seçebilirsiniz"
      no-options-text="Bu liste boş!"
      no-result-text="Burada bişey bulamadık!"
      option-selected="text-black"
      :close-on-select="true"
      track-by="name"
      :min-chars="2"
      value-prop="id"
      :searchable="false"
      label="name"
      :options="teamList"
      class="form-control h-auto"
      :class="{'is-invalid': isValidated && errorMessage != null}"
    >
      <template #option="{ option }">
        <div class="d-flex bg-transparent border-bottom mr-3 mt-1 mb-1 flex-grow-1">
          <div class="card-body">
            <span class="text-bold">{{ option.name }}</span><br>
            <span v-for="teacher in option.teachers">
              {{ teacher.full_name }} - {{ teacher.branch }}<br>
            </span>
          </div>
        </div>
      </template>
      <template #singlelabel="{ value }">
        <div class="card mr-3 mt-1 mb-1  flex-grow-1">
          <div class="card-body">
            <span class="text-bold">{{ value.name }}</span><br>
            <span v-for="teacher in value.teachers">
              {{ teacher.full_name }} - {{ teacher.branch }}<br>
            </span>
          </div>
        </div>
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

export default {
  name: 'TeamSelector',
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
    teams: {
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
      selectedTeam: useModelWrapper(props, emit),
      teamList: useModelWrapper(props, emit, 'teams'),
      ...useComponentValidationWrapper(props) // Buradan validasyon parametreleri geliyor
    }
  }
}
</script>

<style scoped>

</style>
