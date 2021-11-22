import { createStore, createLogger } from 'vuex'
// import districts from './modules/districts'
import ui from './modules/ui'

const debug = process.env.NODE_ENV !== 'production'

export default createStore({
  modules: {
    ui
    // districts
  },
  strict: debug,
  plugins: debug ? [createLogger()] : []
})
