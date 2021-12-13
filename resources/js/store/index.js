import { createStore, createLogger } from 'vuex'
import district from './modules/districts'
import institution from './modules/institutions'
import branch from './modules/branches'
import ui from './modules/ui'
import auth from './modules/auth'

const debug = process.env.NODE_ENV !== 'production'

export default createStore({
  modules: {
    auth,
    ui,
    district,
    institution,
    branch
  },
  strict: debug,
  plugins: debug ? [createLogger()] : []
})
