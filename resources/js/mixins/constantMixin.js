import { usePermissionConstants } from '../utils/constants'

export const constantMixin = {
  data () {
    return {
      ...usePermissionConstants()
    }
  }
}
