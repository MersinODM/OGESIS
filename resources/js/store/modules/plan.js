import {
  usePlanConstants
} from '../../utils/constants'
import usePlanApi from '../../services/usePlanApi'

const { getLatestPlans } = usePlanApi()
const { SET_SELECTED, SET_PLAN_LIST, INIT, CLEAR_SELECTED } = usePlanConstants()

export default {
  namespaced: true,
  state: () => ({
    selectedPlan: null,
    plans: []
  }),
  getters: {
    selectedPlan: (state) => state.selectedPlan
  },
  mutations: {
    [SET_SELECTED] (state, plan) { state.selectedPlan = plan },
    [SET_PLAN_LIST] (state, planList) { state.plans = planList }
  },
  actions: {
    async [INIT] ({ commit }) {
      const data = await getLatestPlans()
      commit(SET_PLAN_LIST, data)
    },
    [SET_SELECTED] ({ commit }, plan) {
      commit(SET_SELECTED, plan)
    },
    [CLEAR_SELECTED] ({ commit }) {
      commit(SET_SELECTED, null)
    }
  }
}
