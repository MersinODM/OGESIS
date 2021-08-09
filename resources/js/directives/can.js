const can = {
  mounted (el, binding, vnode) {
    if (!JSON.parse(sessionStorage.getItem('permissions'))
      ?.includes(binding.expression
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
