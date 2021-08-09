/*
 *     Copyright 2021 Mersin İl Milli Eğitim Müdürlüğü Ölçme Değerlendirme Merkezi
 *
 *     Licensed under the Apache License, Version 2.0 (the "License");
 *     you may not use this file except in compliance with the License.
 *     You may obtain a copy of the License at
 *
 *       http://www.apache.org/licenses/LICENSE-2.0
 *
 *     Unless required by applicable law or agreed to in writing, software
 *     distributed under the License is distributed on an "AS IS" BASIS,
 *     WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *     See the License for the specific language governing permissions and
 *     limitations under the License.
 *
 */

import http from '../utils/http'
import router from '../router'
import Messenger from '../utils/messenger'
import { ResponseCodes } from '../utils/constants'

const AuthService = {
  async login (credentials) {
    try {
      const response = await http.post('app/auth/login', credentials)
      if (response?.status === 200 && response?.data.code === ResponseCodes.CODE_SUCCESS) {
        await router.push({ name: 'start' })
      }
    } catch (e) {
      await Messenger.showWarning('Oturumunuz açılamadı, e-posta ve şifreyi kontrol ediniz.\n' +
          'Hatasız giriş yatığınızı düşünüyosanız sistem yöneticinize başvurunuz.')
    }
  },
  async logout () {
    try {
      const response = await http.post('app/auth/logout')
      return await response?.data
    } catch (e) {}
  }
}

export default AuthService
