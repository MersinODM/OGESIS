import { useBranchConstants } from '../../utils/constants'
import useBranchApi from '../../services/useBranchApi'

const {
  M_BRANCHES,
  M_CURRENT_BRANCH,
  A_SET_CURRENT_BRANCH,
  A_SET_BRANCHES,
  A_SEARCH_BRANCH
} = useBranchConstants()

const { searchBranch } = useBranchApi()

export default {
  namespaced: true,
  state: () => ({
    currentBranch: null,
    branches: []
  }),
  getters: {
    currentBranch: (state) => state.currentBranch,
    branches: (state) => state.branches
  },
  mutations: {
    [M_BRANCHES] (state, branches) { state.branches = branches },
    [M_CURRENT_BRANCH] (state, branch) { state.currentBranch = branch }
  },
  actions: {
    [A_SET_CURRENT_BRANCH] ({ commit }, branch) {
      commit(M_CURRENT_BRANCH, branch)
    },
    async [A_SEARCH_BRANCH] ({ commit }, param) {
      try {
        if (!param?.content) return
        const institutions = await searchBranch(param)
        commit(M_BRANCHES, institutions)
      } catch (e) {}
    }
  }
}
