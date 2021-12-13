import http from '../utils/http'
import Messenger from '../utils/messenger'

export default function () {
  const login = async (credentials) => {
    try {
      return await http.post('auth/login', credentials)
    } catch (e) {
      await Messenger.showWarning('Oturumunuz açılamadı, e-posta ve şifreyi kontrol ediniz.\n' +
        'Hatasız giriş yatığınızı düşünüyosanız sistem yöneticinize başvurunuz.')
    }
  }

  const logout = async () => {
    try {
      const response = await http.post('auth/logout')
      return await response?.data
    } catch (e) {}
  }

  const me = async () => {
    try {
      const response = await http.get('api/v1/me')
      return response.data
    } catch (e) {
    }
  }

  return {
    login,
    logout,
    me
  }
}
