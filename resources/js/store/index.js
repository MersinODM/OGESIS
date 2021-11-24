import { createStore, createLogger } from 'vuex'
import district from './modules/districts'
import institution from './modules/institutions'
import branch from './modules/branches'
import ui from './modules/ui'

const debug = process.env.NODE_ENV !== 'production'

export default createStore({
  modules: {
    ui,
    district,
    institution,
    branch
  },
  strict: debug,
  plugins: debug ? [createLogger()] : []
})
