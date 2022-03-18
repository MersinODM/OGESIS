import { createStore, createLogger } from 'vuex'
import district from './modules/districts'
import institution from './modules/institutions'
import branch from './modules/branches'
import ui from './modules/ui'
import auth from './modules/auth'
import ability from './plugins/ability'
import modal from './modules/modal'
import behavior from './modules/behaviors'
import teacher from './modules/teachers'
import init from './plugins/init'

const debug = process.env.NODE_ENV !== 'production'

export default createStore({
  modules: {
    auth,
    ui,
    branch,
    modal,
    district,
    institution,
    behavior,
    teacher
  },
  strict: debug,
  plugins: debug ? [createLogger(), ability, init] : [ability, init]
})
