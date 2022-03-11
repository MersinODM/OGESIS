import { object, number } from 'yup'
import { useAbility } from '@casl/vue'
import { usePermissionConstants } from '../utils/constants'
import { computed } from 'vue'
import { useStore } from 'vuex'

const branchValidationMessage = 'Branş bilgisi seçilmelidir!'
const districtValidationMessage = 'İlçe seçimi yapılmalıdır!'
const institutionValidationMessage = 'Kurum seçilmelidir!'

export function useRuleBranch () {
  return {
    branch_id: number().typeError(() => branchValidationMessage)
      .required(() => branchValidationMessage)
  }
}

export function useRuleDistrict () {
  const { can } = useAbility()
  const { LEVEL_3 } = usePermissionConstants()
  return {
    ...(can(LEVEL_3) && {
      district_id: object().typeError(() => districtValidationMessage)
        .required(() => districtValidationMessage)
    })
  }
}

export function useRuleInstitution () {
  const { can } = useAbility()
  const { LEVEL_2 } = usePermissionConstants()
  return {
    ...(can(LEVEL_2) && {
      institution_id: object().typeError(() => institutionValidationMessage)
        .required(() => institutionValidationMessage)
    })
  }
}

export function useInstitutionCheck () {
  const { LEVEL_3, LEVEL_2 } = usePermissionConstants()
  const { can } = useAbility()
  const store = useStore()
  const hasInstitutionNotSelected = computed(() => store.getters['institution/selectedInstitution'] === null && (can(LEVEL_3) || can(LEVEL_2)))
  const hasInstitutionSelected = computed(() => store.getters['institution/selectedInstitution'] !== null && (can(LEVEL_3) || can(LEVEL_2)))
  return {
    hasInstitutionNotSelected,
    hasInstitutionSelected
  }
}
