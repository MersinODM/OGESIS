import { useDistrictConstants } from '../../utils/constants'
import useDistrictApi from '../../services/useDistrictApi'

const {
  M_DISTRICTS,
  M_CURRENT_DISTRICT,
  A_SET_CURRENT_DISTRICT,
  A_SET_DISTRICTS
} = useDistrictConstants()

const { getDistricts } = useDistrictApi()

export default {
  namespaced: true,
  state: () => ({
    currentDistrict: null,
    districts: []
  }),
  getters: {
    currentDistrict: (state) => state.currentDistrict,
    districts: (state) => state.districts
  },
  mutations: {
    [M_DISTRICTS] (state, districts) { state.districts = districts },
    [M_CURRENT_DISTRICT] (state, district) { state.currentDistrict = district }
  },
  actions: {
    [A_SET_CURRENT_DISTRICT] ({ commit }, district) {
      commit(M_CURRENT_DISTRICT, district)
    },
    async [A_SET_DISTRICTS] ({ commit }) {
      try {
        const districts = await getDistricts()
        commit(M_DISTRICTS, districts)
      } catch (e) {}
    }
  }
}
