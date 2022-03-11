import { useModalActionTypes, useModalMutationTypes } from '../../utils/constants'
import SkinHelper from '../../utils/SkinHelper'

const { SHOW, CLOSE } = useModalActionTypes()
const { TITLE, CURRENT_COMPONENT, IS_SHOW } = useModalMutationTypes()

export default {
  namespaced: true,
  state: () => ({
    currentComponent: null,
    isShow: false,
    title: ''
  }),
  getters: {
    title: (state) => state.title,
    currentComponent: (state) => state.currentComponent,
    isShow: (state) => state.isShow
  },
  mutations: {
    [TITLE] (state, title) { state.title = title },
    [CURRENT_COMPONENT] (state, currentComponent) { state.currentComponent = currentComponent },
    [IS_SHOW] (state, isShow) { state.isShow = isShow }
  },
  actions: {
    [SHOW] ({ commit }, modal) {
      commit(TITLE, modal.title)
      commit(CURRENT_COMPONENT, modal.component)
      commit(IS_SHOW, true)

      SkinHelper.CloseModalSkin()
      SkinHelper.OpenModalSkin()
    },
    [CLOSE] ({ commit }) {
      commit(TITLE, '')
      commit(CURRENT_COMPONENT, null)
      commit(IS_SHOW, false)
      SkinHelper.CloseModalSkin()
    }
  }
}
