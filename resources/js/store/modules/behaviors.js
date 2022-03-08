import { useBehaviorConstants, useDistrictConstants, useInstitutionConstants } from '../../utils/constants'
const { INIT, SET_CRUD } = useBehaviorConstants()
const { DISTRICT } = useDistrictConstants()
const { INSTITUTION } = useInstitutionConstants()


export default {
  namespaced: true,
  state: () => ({
    isCRUD: false
  }),
  getters: {
    crudMode: (state) => state.isCRUD
  },
  mutations: {
    CRUD (state, value) {
      state.isCRUD = value
    }
  },
  actions: {
    [INIT] ({ dispatch }) {
      dispatch(DISTRICT.withSuffix(INIT), null, { root: true })
      dispatch(INSTITUTION.withSuffix(INIT), null, { root: true })
    },
    [SET_CRUD] ({ commit }, setCrud) {
      commit('CRUD', setCrud)
    }
  }
}
