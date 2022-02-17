import { useDistrictConstants, usePermissionConstants } from '../../utils/constants'
import useDistrictApi from '../../services/useDistrictApi'
import { useAbility } from '@casl/vue'
import useInstitutionApi from '../../services/useInstitutionApi'

const {
  M_DISTRICTS,
  M_CURRENT_DISTRICT,
  A_SET_CURRENT_DISTRICT,
  A_SET_DISTRICTS
} = useDistrictConstants()

const { getDistricts } = useDistrictApi()
const { can, cannot } = useAbility()
const { getInstitution } = useInstitutionApi()
const { LEVEL_3 } = usePermissionConstants()

export default {
  namespaced: true,
  state: () => ({
    districts: [],
    selectedDistrict: null
  }),
  getters: {
    districts: (state) => state.districts,
    selectedDistrict: (state) => state.selectedDistrict
  },
  mutations: {
    [DISTRICTS] (state, districts) { state.district = districts },
    [SELECTED_DISTRICT] (state, selectedDistrict) { state.selectedDistrict = selectedDistrict },
    [SET_CRUD] (state, setCrud) {
      if (setCrud) {
        state.districts.splice(0, 1)
      } else {
        state.districts.insert(0, { id: -1, province_id: -1, name: 'Hepsi' })
      }
    }
  },
  actions: {
    async [INIT] ({ commit }) {
      // Kullanıcı değişimini izliyoruz eğer ilçe kullanıcısı ise
      // kullanıcının ilçesindeki okulları dolduruyoruz seçim için
      if (can(LEVEL_3)) {
        const data = await getDistricts()
        commit(DISTRICTS, data)
      }
    },
    [CRUD_MODE] ({ commit }, setCrud) {
      commit(SET_CRUD, setCrud)
    },
    [SET_DISTRICTS] ({ commit }, districts) {
      commit(DISTRICTS, districts)
    },
    [SET_SELECTED_DISTRICT] ({ commit, dispatch }, selectedDistrict) {
      commit(SET_SELECTED_DISTRICT, selectedDistrict)
    }
  }
}
