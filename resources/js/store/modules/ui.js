import { calculateScreenSize } from '../../utils/calculateScreenSize'

import { useUIMutationConstants } from '../../utils/constants'

const { IS_SIDE_BAR_MENU_COLLAPSED, DARK_MODE, SCREEN_SIZE } = useUIMutationConstants()

export default {
  namespaced: true,
  state: () => ({
    darkMode: false,
    screenSize: calculateScreenSize(window.innerWidth),
    isSidebarMenuCollapsed: false
  }),
  getters: {
    themMode: (state) => state.darkMode,
    screenSize: (state) => state.screenSize,
    isSidebarMenuCollapsed: (state) => state.isSidebarMenuCollapsed
  },
  mutations: {
    [DARK_MODE] (state, themMode) { state.darkMode = themMode },
    [SCREEN_SIZE] (state, screenSize) { state.screenSize = screenSize },
    [IS_SIDE_BAR_MENU_COLLAPSED] (state, isCollapsed) { state.isSidebarMenuCollapsed = isCollapsed }
  },
  actions: {
    setToggleSideBar ({ commit, state }) {
      commit(IS_SIDE_BAR_MENU_COLLAPSED, !state.isSidebarMenuCollapsed)
    },
    setDarkMode ({ commit }, mode) {
      commit(DARK_MODE, mode)
    },
    setScreenSize ({ commit }, screenSize) {
      commit(SCREEN_SIZE, screenSize)
    }
  }
}
