import dayjs from '../utils/dayjs'
const dateFormat = {
  beforeMount (el, binding, vnode, prevVnode) {
    const value = dayjs(vnode.el.innerText)
    if (value.isValid()) {
      vnode.el.innerText = value.format('L')
    }
  }
}

export default dateFormat
