import { ResponseCodes, useAuthActionTypes, useAuthMutationTypes } from '../../utils/constants'
import useAuthApi from '../../services/useAuthApi'
import router from '../../router'
import Messenger from '../../utils/messenger'
import { Ability } from '@casl/ability'

const { REMOVE_USER, SET_USER } = useAuthMutationTypes()
const { LOGIN, LOGOUT, GET_ME } = useAuthActionTypes()
const { login, logout, me } = useAuthApi()
// Burada oluşturulmalı ability örneği değilse getter her çağrıldığığında yeni
// örnek çağrılıyor bu yüzden casl doğru çalışmıyor
const ability = new Ability()

export default {
  namespaced: true,
  state: () => ({
    user: null,
    roles: [],
    permissions: []
  }),
  getters: {
    user: (state) => state.user,
    ability: () => ability
  },
  mutations: {
    [SET_USER] (state, user) { state.user = user },
    [REMOVE_USER] (state) { state.user = null }
  },
  actions: {
    async [LOGIN] ({ commit }, credentials) {
      try {
        const response = await login(credentials)
        if (response?.status === 200 && response?.data.code === ResponseCodes.SUCCESS) {
          const user = await me()
          commit(SET_USER, user)
          await router.push({ name: 'start' })
        } else {
          await Messenger.showWarning('Oturumunuz açılamadı, e-posta ve şifreyi kontrol ediniz')
        }
      } catch (e) {
        await Messenger.showWarning('Oturumunuz açılamadı, e-posta ve şifreyi kontrol ediniz.\n' +
          'Hatasız giriş yatığınızı düşünüyosanız sistem yöneticinize başvurunuz.')
      }
    },
    async [LOGOUT] ({ commit }) {
      try {
        const response = logout()
        commit(REMOVE_USER)
        await router.push({ name: 'login' })
      } catch (e) {}
    },
    async [GET_ME] ({ commit, state }) {
      if (!state.user) {
        const user = await me()
        commit(SET_USER, user)
      }
    }
  }
}
