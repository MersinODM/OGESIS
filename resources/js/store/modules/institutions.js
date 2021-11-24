
import { useInstitutionConstants } from '../../utils/constants'
import useInstitutionApi from '../../services/useInstitutionApi'

const {
  A_SEARCH_INSTITUTIONS,
  A_SET_CURRENT_INSTITUTION,
  M_CURRENT_INSTITUTION,
  M_INSTITUTIONS
} = useInstitutionConstants()

const { searchInstitution } = useInstitutionApi()

export default {
  namespaced: true,
  state: () => ({
    currentInstitution: null,
    institutions: []
  }),
  getters: {
    currentInstitution: (state) => state.currentInstitution,
    institutions: (state) => state.institutions
  },
  mutations: {
    [M_INSTITUTIONS] (state, institutions) { state.institutions = institutions },
    [M_CURRENT_INSTITUTION] (state, district) { state.currentInstitution = district }
  },
  actions: {
    [A_SET_CURRENT_INSTITUTION] ({ commit }, district) {
      commit(M_CURRENT_INSTITUTION, district)
    },
    async [A_SEARCH_INSTITUTIONS] ({ commit }, param) {
      try {
        if (!param?.content) return
        const institutions = await searchInstitution(param)
        commit(M_INSTITUTIONS, institutions)
      } catch (e) {}
    }
  }
}
