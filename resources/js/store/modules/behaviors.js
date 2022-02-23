import { useDistrictConstants, useInstitutionConstants } from '../../utils/constants'

const {
  INIT,
  SET_CRUD,
  DISTRICT
} = useDistrictConstants()

const {
  INSTITUTION
} = useInstitutionConstants()

export default {
  namespaced: true,
  actions: {
    [INIT] ({ dispatch }) {
      dispatch(DISTRICT.withSuffix(INIT), { root: true })
      dispatch(INSTITUTION.withSuffix(INIT), { root: true })
    },
    [SET_CRUD] ({ dispatch }, setCrud) {
      dispatch(DISTRICT.withSuffix(SET_CRUD), setCrud, { root: true })
      dispatch(INSTITUTION.withSuffix(SET_CRUD), setCrud, { root: true })
    }
  }
}
