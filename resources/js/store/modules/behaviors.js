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
    init ({ dispatch }) {
      dispatch('district/init', null, { root: true })
      dispatch('institution/init', null, { root: true })
    },
    setCrud ({ commit }, mode) {
      commit('CRUD', mode)
    }
  }
}
