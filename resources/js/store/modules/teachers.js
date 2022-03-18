
import { usePermissionConstants } from '../../utils/constants'
import useTeacherApi from '../../services/useTeacherApi'

// const { INIT, SET_CRUD } = useBehaviorConstants()
// const {
//   INSTITUTIONS,
//   SELECTED_INSTITUTION,
//   SET_SELECTED_INSTITUTION,
//   SET_INSTITUTIONS
// } = useInstitutionConstants()

const { LEVEL_1, LEVEL_2, LEVEL_3 } = usePermissionConstants()
// const { can, cannot } = useAbility()
const { getTeachers } = useTeacherApi()

export default {
  namespaced: true,
  state: () => ({
    selectedTeacher: null,
    teachers: []
  }),
  getters: {
    selectedTeacher: (state) => state.selectedTeacher,
    teachers: (state) => state.teachers
  },
  mutations: {
    TEACHERS (state, teachers) {
      state.teachers = teachers
    },
    SELECTED_TEACHER (state, teacher) { state.selectedTeacher = teacher }
  },
  actions: {
    async init ({ commit, rootGetters }) {
      const { can, cannot } = rootGetters['auth/ability']
      const user = rootGetters['auth/user']
      // Kullanıcı değişimini izliyoruz eğer ilçe kullanıcısı ise
      // kullanıcının ilçesindeki okulları dolduruyoruz seçim için
      if (can(LEVEL_1) && cannot(LEVEL_3, LEVEL_3)) {
        const data = await getTeachers(user?.institution_id)
        commit('TEACHERS', data)
      }
    },
    async setTeachers ({ commit, rootGetters }, institution) {
      const { can, cannot } = rootGetters['auth/ability']
      const user = rootGetters['auth/user']
      // Kullanıcı değişimini izliyoruz eğer ilçe kullanıcısı ise
      // kullanıcının ilçesindeki okulları dolduruyoruz seçim için

      if (can(LEVEL_1) && cannot(LEVEL_3, LEVEL_2)) {
        const data = await getTeachers(user?.institution.district_id, user?.institution_id)
        commit('TEACHERS', data)
      }

      if (institution && can(LEVEL_3)) {
        const data = await getTeachers(rootGetters['district/selectedDistrict'].id, institution.id)
        commit('TEACHERS', data)
      } else if (institution && can(LEVEL_2) && cannot(LEVEL_3)) {
        const data = await getTeachers(user?.institution.district_id, institution.id)
        commit('TEACHERS', data)
      }
    },
    setSelectedTeacher ({ commit }, teacher) {
      commit('SELECTED_TEACHER', teacher)
    }
  }
}
