
import { usePermissionConstants } from '../../utils/constants'
import useInstitutionApi from '../../services/useInstitutionApi'

// const { INIT, SET_CRUD } = useBehaviorConstants()
// const {
//   INSTITUTIONS,
//   SELECTED_INSTITUTION,
//   SET_SELECTED_INSTITUTION,
//   SET_INSTITUTIONS
// } = useInstitutionConstants()

const { LEVEL_2, LEVEL_3 } = usePermissionConstants()
// const { can, cannot } = useAbility()
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
    INSTITUTIONS (state, institutions) {
      state.institutions = state.institutions.filter(i => i.id === -1)
      state.institutions.push(...institutions)
    },
    SELECTED_INSTITUTION (state, institution) { state.selectedInstitution = institution },
    // Burasi init altına çekilebilir merkezileştirme adına altında
    SET_CRUD (state, setCrud) {
      if (setCrud) {
        const index = state.institutions.findIndex((d) => d.id === -1)
        if (index >= 0) { state.institutions.splice(index, 1) }
      } else {
        if (state.institutions.some(i => i.id === -1)) return // Zaten ekli ise tekrar eklenmesin
        state.institutions.insert(0, { id: -1, district_id: -1, name: 'Hepsi' })
      }
    }
  },
  actions: {
    async init ({ commit, rootGetters }) {
      const { can, cannot } = rootGetters['auth/ability']
      // Kullanıcı değişimini izliyoruz eğer ilçe kullanıcısı ise
      // kullanıcının ilçesindeki okulları dolduruyoruz seçim için
      if (can(LEVEL_2) && cannot(LEVEL_3)) {
        const data = await getInstitution(rootGetters['auth/user']?.institution.district_id)
        commit('INSTITUTIONS', data)
      }
    },
    async setInstitutions ({ commit, rootGetters }, district) {
      const { can, cannot } = rootGetters['auth/ability']
      // Kullanıcı değişimini izliyoruz eğer ilçe kullanıcısı ise
      // kullanıcının ilçesindeki okulları dolduruyoruz seçim için

      if (can(LEVEL_2) && cannot(LEVEL_3)) {
        const data = await getInstitution(rootGetters['auth/user']?.institution.district_id)
        commit('INSTITUTIONS', data)
      }

      // 3. seviye yetkilerde ilçe nul geçilirse kurumalrın işini boşaltıyoruz
      if (district && can(LEVEL_3)) {
        const data = await getInstitution(district.id)
        commit('INSTITUTIONS', data)
      } else {
        commit('INSTITUTIONS', [])
      }
    },
    setSelectedInstitution ({ commit }, institution) {
      commit('SELECTED_INSTITUTION', institution)
    }
  }
}
