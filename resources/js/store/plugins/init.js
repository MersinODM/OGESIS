
import {
  useAuthMutationTypes,
  useBehaviorConstants,
  useDistrictConstants,
  useInstitutionConstants
} from '../../utils/constants'
const {
  SELECT_DISTRICT,
  DISTRICT
} = useDistrictConstants()

const {
  INSTITUTION, SET_INSTITUTIONS
} = useInstitutionConstants()

export default (store) => {
  const { SET_USER, AUTH } = useAuthMutationTypes()
  const { BEHAVIOR, INIT, SET_CRUD } = useBehaviorConstants()

  return store.subscribe((mutation) => {
    if (mutation.type === AUTH.withSuffix(SET_USER)) {
      store.dispatch(BEHAVIOR.withSuffix(INIT))
      const init = () => {
        // Başlangıçta crud pasif hale getiriliyor
        store.dispatch(BEHAVIOR.withSuffix(SET_CRUD), false)
      }
      setTimeout(init, 500)
    } else if (mutation.type === DISTRICT.withSuffix(SELECT_DISTRICT)) {
      store.dispatch(INSTITUTION.withSuffix(SET_INSTITUTIONS), mutation.payload)
    } else if (mutation.type === 'institution/SELECTED_INSTITUTION') {
      store.dispatch('teacher/setTeachers', mutation.payload)
    }
  })
}
