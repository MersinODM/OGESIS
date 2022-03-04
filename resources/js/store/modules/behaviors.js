import { useBehaviorConstants, useDistrictConstants, useInstitutionConstants } from '../../utils/constants'

const { INIT, SET_CRUD } = useBehaviorConstants()
const { DISTRICT } = useDistrictConstants()
const { INSTITUTION } = useInstitutionConstants()

export default {
  namespaced: true,
  actions: {
    [INIT] ({ dispatch }) {
      dispatch(DISTRICT.withSuffix(INIT), null, { root: true })
      dispatch(INSTITUTION.withSuffix(INIT), null, { root: true })
    },
    [SET_CRUD] ({ commit }, setCrud) {
      commit(DISTRICT.withSuffix(SET_CRUD), setCrud, { root: true })
      commit(INSTITUTION.withSuffix(SET_CRUD), setCrud, { root: true })
    }
  }
}
