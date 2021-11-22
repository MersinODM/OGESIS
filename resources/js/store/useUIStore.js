import { reactive, computed, readonly } from 'vue'
// import now from '../helpers/dayjs'

import constants from '../utils/constants'
import { calculateScreenSize } from '../utils/calculateScreenSize'

const { SCREEN_SIZE, DARK_MODE, IS_SIDE_BAR_MENU_COLLAPSED } = constants()

const state = reactive({
  darkMode: false,
  screenSize: calculateScreenSize(window.innerWidth),
  isSidebarMenuCollapsed: false
})

const setScreenSize = (size) => {
  localStorage.setItem(SCREEN_SIZE, JSON.stringify(size))
  state.screenSize = size
}

const setDarkMode = (mode) => {
  localStorage.setItem(DARK_MODE, JSON.stringify(mode))
  state.darkMode = mode
}

const setToggleSideBar = () => {
  localStorage.setItem(IS_SIDE_BAR_MENU_COLLAPSED, JSON.stringify(!state.isSidebarMenuCollapsed))
  state.isSidebarMenuCollapsed = !state.isSidebarMenuCollapsed
}

const screenSize = computed(() => {
  if (!state.screenSize) {
    state.screenSize = JSON.parse(localStorage.getItem(SCREEN_SIZE))
  }
  return state.screenSize
})

const darkMode = computed(() => {
  if (!state.darkMode) {
    state.darkMode = JSON.parse(localStorage.getItem(DARK_MODE))
  }
  return state.darkMode
})

const isSidebarMenuCollapsed = computed(() => {
  // if (!state.isSidebarMenuCollapsed) {
  state.isSidebarMenuCollapsed = JSON.parse(localStorage.getItem(IS_SIDE_BAR_MENU_COLLAPSED))
  // }
  return state.isSidebarMenuCollapsed
})

const store = readonly({
  state: state,
  actions: {
    setScreenSize,
    setDarkMode,
    setToggleSideBar
  },
  getters: {
    darkMode,
    screenSize,
    isSidebarMenuCollapsed
  }
})

export default function () {
  return store
}
