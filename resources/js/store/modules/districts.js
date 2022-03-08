import {
  useBehaviorConstants,
  useDistrictConstants,
  useInstitutionConstants,
  usePermissionConstants
} from '../../utils/constants'
import useDistrictApi from '../../services/useDistrictApi'
import { useAbility } from '@casl/vue'

const { INIT, SET_CRUD } = useBehaviorConstants()
const {
  SET_DISTRICTS,
  SELECT_DISTRICT,
  SET_SELECTED_DISTRICT,
  DISTRICTS
} = useDistrictConstants()

const {
  INSTITUTION, SET_SELECTED_INSTITUTION
} = useInstitutionConstants()

const { getDistricts } = useDistrictApi()
// const { can } = useAbility()
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
    [DISTRICTS] (state, districts) { state.districts = districts },
    [SELECT_DISTRICT] (state, selectedDistrict) { state.selectedDistrict = selectedDistrict },
    [SET_CRUD] (state, setCrud) {
      if (setCrud) {
        const index = state.districts.findIndex((d) => d.id === -1)
        if (index >= 0) { state.districts.splice(index, 1) }
      } else {
        if (state.districts.some(d => d.id === -1)) return // Zaten ekli ise tekrar eklenmesin
        state.districts.insert(0, { id: -1, province_id: -1, name: 'Hepsi' })
      }
    }
  },
  actions: {
    async [INIT] ({ commit, rootGetters }) {
      const { can } = rootGetters['auth/ability']
      // Kullanıcı değişimini izliyoruz eğer ilçe kullanıcısı ise
      // kullanıcının ilçesindeki okulları dolduruyoruz seçim için
      if (can(LEVEL_3)) {
        const data = await getDistricts()
        commit(DISTRICTS, data)
      } else {
        console.log('Yetki doğrulması geçilemedi')
      }
    },
    [SET_DISTRICTS] ({ commit }, districts) {
      commit(DISTRICTS, districts)
    },
    [SET_SELECTED_DISTRICT] ({ commit, dispatch }, selectedDistrict) {
      commit(SELECT_DISTRICT, selectedDistrict)
      dispatch(INSTITUTION.withSuffix(SET_SELECTED_INSTITUTION), null, { root: true })
    }
  }
}
