import { useStore } from 'vuex'

const can = {
  mounted (el, binding, vnode) {
    const store = useStore()
    const permissions = store.state.auth.user.permissions
    if (!permissions?.filter(permission => permission.name === binding.expression
      ?.replace(/'/g, '')
      ?.replace(/"/g, ''))) {
      el.parentNode.removeChild(el)
    }
  }
}

// TODO burada rol tanımları kontrol edilecek
const roles = {
  mounted (el, binding, vnode) {
    if (!JSON.parse(sessionStorage.getItem('roles'))
      ?.includes(binding.expression
        ?.replace(/'/g, '')
        ?.replace(/"/g, ''))) {
      el.parentNode.removeChild(el)
    }
  }
}

export default can
