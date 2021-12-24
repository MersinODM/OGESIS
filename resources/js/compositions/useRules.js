import { number } from 'yup'
import { useAbility } from '@casl/vue'
import { usePermissionConstants } from '../utils/constants'

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
  const { TEACHER_LIST_LEVEL_3 } = usePermissionConstants()
  return {
    ...(can(TEACHER_LIST_LEVEL_3) && {
      district_id: number().typeError(() => districtValidationMessage)
        .required(() => districtValidationMessage)
    })
  }
}

export function useRuleInstitution () {
  const { can } = useAbility()
  const { TEACHER_LIST_LEVEL_2 } = usePermissionConstants()
  return {
    ...(can(TEACHER_LIST_LEVEL_2) && {
      institution_id: number().typeError(() => institutionValidationMessage)
        .required(() => institutionValidationMessage)
    })
  }
}
