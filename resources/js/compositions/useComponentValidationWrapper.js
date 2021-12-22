import { computed } from 'vue'

export function useComponentValidationWrapper (props) {
  const errorMessage = computed(() => props.validationMessage)
  const isValidated = computed(() => props.validationRequired)
  return {
    errorMessage, isValidated
  }
}
