import { useAbility } from '@casl/vue'
import { usePermissionConstants } from '../utils/constants'
import store from '../store'
import useInstitutionApi from '../../services/useInstitutionApi'

const { SET, CLEAR } = usePlanActionTypes()
const { CURRENT_PLAN } = usePlanMutationTypes()

const { can, cannot } = useAbility()
const { getInstitution } = useInstitutionApi()
const { TEACHER_LIST_LEVEL_2, TEACHER_LIST_LEVEL_3 } = usePermissionConstants()

export default {
  namespaced: true,
  state: () => ({
    districts: [],
    selectedDistrict: null,
    institutions: [],
    selectedInstitution: null
  }),
  getters: {
    districts: (state) => state.districts,
    selectedDistrict: (state) => state.selectedDistrict,
    institutions: (state) => state.institutions,
    selectedInstitution: (state) => state.selectedInstitution
  },
  mutations: {
    [DISTRICTS] (state, districts) { state.district = districts },
    [SELECTED_DISTRICT] (state, selectedDistrict) { state.selectedDistrict = selectedDistrict },
    [INSTITUTIONS] (state, institutions) { state.institutions = institutions },
    [SELECTED_INSTITUTION] (state, selectedInstitution) { state.selectedInstitution = selectedInstitution }
  },
  actions: {
    [INIT] ({ commit }) {
      // Kullanıcı değişimini izliyoruz eğer ilçe kullanıcısı ise
      // kullanıcının ilçesindeki okulları dolduruyoruz seçim için
      if (can(TEACHER_LIST_LEVEL_2) && cannot(TEACHER_LIST_LEVEL_3)) {
        getInstitution(store.getters['auth/user']?.institution.district_id)
          .then(res => {
            institutions.value = res
          })
      }
    },
    [SET_DISTRICTS] ({ commit }, districts) {
      commit(DISTRICTS, districts)
    },
    [SET_SELECTED_DISTRICT] ({ commit }, selectedDistrict) {
      commit(SET_SELECTED_DISTRICT, selectedDistrict)
    },
    [SET_INSTITUTIONS] ({ commit }, institution) {
      commit(CURRENT_PLAN, null)
    }
  }
}
