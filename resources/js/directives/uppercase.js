const uppercase = {
  updated (el, binding, vnode) {
    if (binding.value) {
      const sourceValue = el.value
      const newValue = sourceValue.toLocaleUpperCase('TR')

      if (sourceValue !== newValue) {
        el.value = newValue
        el.dispatchEvent(new Event('input', { bubbles: true }))
      }
    }
  }
}

export default uppercase
