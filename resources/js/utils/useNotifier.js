import { Notyf } from 'notyf'

export default function (config = null) {
  return new Notyf(config || null)
}
