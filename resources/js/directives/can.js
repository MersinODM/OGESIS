import { useStore } from 'vuex'

const can = {
  mounted (el, binding, vnode) {
    const store = useStore()
    const permissions = store.getters.auth.user.permissions
    if (!permissions?.includes(binding.expression
      ?.replace(/'/g, '')
      ?.replace(/"/g, ''))) {
      el.parentNode.removeChild(el)
    } else {
      console.error('Yetki hatası meydana geldi!')
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
