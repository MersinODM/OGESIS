
import { usePermissionConstants } from '../../utils/constants'
import useTeamApi from '../../services/useTeamApi'

// const { INIT, SET_CRUD } = useBehaviorConstants()
// const {
//   INSTITUTIONS,
//   SELECTED_INSTITUTION,
//   SET_SELECTED_INSTITUTION,
//   SET_INSTITUTIONS
// } = useInstitutionConstants()

const { LEVEL_1, LEVEL_2, LEVEL_3 } = usePermissionConstants()
// const { can, cannot } = useAbility()
const { getTeams } = useTeamApi()

export default {
  namespaced: true,
  state: () => ({
    selectedTeam: null,
    teams: []
  }),
  getters: {
    selectedTeam: (state) => state.selectedTeam,
    teams: (state) => state.teams
  },
  mutations: {
    TEAMS (state, teams) {
      state.teams = teams
    },
    SELECTED_TEAM (state, team) { state.selectedTeam = team }
  },
  actions: {
    async init ({ dispatch }) {
      // const { can, cannot } = rootGetters['auth/ability']
      // const user = rootGetters['auth/user']
      // // Kullanıcı değişimini izliyoruz eğer ilçe kullanıcısı ise
      // // kullanıcının ilçesindeki okulları dolduruyoruz seçim için
      // if (can(LEVEL_1) && cannot(LEVEL_3, LEVEL_3)) {
      //   const data = await getTeams(user?.institution_id)
      //   commit('TEACHERS', data)
      // }
      dispatch('setTeams')
    },
    async setTeams ({ commit, rootGetters }, institution) {
      const { can, cannot } = rootGetters['auth/ability']
      const user = rootGetters['auth/user']
      // Kullanıcı değişimini izliyoruz eğer ilçe kullanıcısı ise
      // kullanıcının ilçesindeki okulları dolduruyoruz seçim için

      if (can(LEVEL_1) && cannot(LEVEL_3, LEVEL_2)) {
        const data = await getTeams(user?.institution.district_id, user?.institution_id)
        commit('TEAMS', data)
      }

      if (institution && can(LEVEL_3)) {
        const data = await getTeams(rootGetters['district/selectedDistrict'].id, institution.id)
        commit('TEAMS', data)
      } else if (institution && can(LEVEL_2) && cannot(LEVEL_3)) {
        const data = await getTeams(user?.institution.district_id, institution.id)
        commit('TEAMS', data)
      }
    },
    setSelectedTeam ({ commit }, team) {
      commit('SELECTED_TEAM', team)
    }
  }
}
