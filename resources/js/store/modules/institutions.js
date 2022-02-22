
import { useInstitutionConstants, usePermissionConstants } from '../../utils/constants'
import useInstitutionApi from '../../services/useInstitutionApi'
import { useAbility } from '@casl/vue'

const {
  INSTITUTIONS,
  SELECTED_INSTITUTION,
  SET_SELECTED_INSTITUTION,
  SET_INSTITUTIONS,
  INIT
} = useInstitutionConstants()

const { LEVEL_2, LEVEL_3 } = usePermissionConstants()
const { can, cannot } = useAbility()
const { getInstitution } = useInstitutionApi()

export default {
  namespaced: true,
  state: () => ({
    selectedInstitution: null,
    institutions: []
  }),
  getters: {
    selectedInstitution: (state) => state.selectedInstitution,
    institutions: (state) => state.institutions
  },
  mutations: {
    [INSTITUTIONS] (state, institutions) { state.institutions = institutions },
    [SELECTED_INSTITUTION] (state, institution) { state.selectedInstitution = institution },
    [SET_CRUD] (state, setCrud) {
      if (setCrud) {
        state.institutions.splice(state.institutions.findIndex((d) => d.id === -1), 1)
      } else {
        state.institutions.insert(0, { id: -1, district_id: -1, name: 'Hepsi' })
      }
    }
  },
  actions: {
    async [INIT] ({ commit, rootGetters }) {
      // Kullanıcı değişimini izliyoruz eğer ilçe kullanıcısı ise
      // kullanıcının ilçesindeki okulları dolduruyoruz seçim için
      if (can(LEVEL_2) && cannot(LEVEL_3)) {
        const data = await getInstitution(rootGetters['auth/user']?.institution.district_id)
        commit(INSTITUTIONS, data)
      }
    },
    [SET_INSTITUTIONS] ({ commit }, institutions) {
      commit(INSTITUTIONS, institutions)
    },
    [SET_SELECTED_INSTITUTION] ({ commit }, institution) {
      commit(SELECTED_INSTITUTION, institution)
    }
  }
}
