import { useBehaviorConstants, useDistrictConstants, usePermissionConstants } from '../../utils/constants'
import useDistrictApi from '../../services/useDistrictApi'
import { useAbility } from '@casl/vue'

const { INIT, SET_CRUD } = useBehaviorConstants()
const {
  SET_DISTRICTS,
  SELECT_DISTRICT,
  SET_SELECTED_DISTRICT,
  DISTRICTS
} = useDistrictConstants()

const { getDistricts } = useDistrictApi()
const { can } = useAbility()
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
    [SET_DISTRICTS] (state, districts) { state.district = districts },
    [SELECT_DISTRICT] (state, selectedDistrict) { state.selectedDistrict = selectedDistrict },
    [SET_CRUD] (state, setCrud) {
      if (setCrud) {
        state.districts.splice(state.districts.findIndex((d) => d.id === -1), 1)
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
    [SET_DISTRICTS] ({ commit }, districts) {
      commit(DISTRICTS, districts)
    },
    [SET_SELECTED_DISTRICT] ({ commit, dispatch }, selectedDistrict) {
      commit(SET_SELECTED_DISTRICT, selectedDistrict)
    }
  }
}
