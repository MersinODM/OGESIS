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

import Swal from 'admin-lte/plugins/sweetalert2/sweetalert2.all.min'
import router from '../router'
import pace from 'pace-progressbar'
// import OverlayHelper from './OverlayHelper'
import axios from 'axios/dist/axios.min'

const isHandlerEnabled = (config = {}) => {
  return !(!config?.errorHandler)
}

// // eslint-disable-next-line no-unused-vars
// const handleError = (error) => {
//   if (isHandlerEnabled(error.config)) {
//     // VanillaToasts.create({
//     //   title: `Request failed: ${error.response.status}`,
//     //   text: `Unfortunately error happened during request: ${error.config.url}`,
//     //   type: 'warning',
//     //   timeout: TIMEOUT
//     // })
//   }
//   // eslint-disable-next-line prefer-promise-reject-errors
//   return Promise.reject({ ...error })
// }

const domain = document.querySelector('meta[name="base-url"]').getAttribute('content')
const http = axios.create({
  baseURL: `${domain}`,
  withCredentials: true
})


http.interceptors.response.use((response) => {
  // pace.stop()
  return response
}, (error) => {
  if (error.config?.errorHandle === false) {
    return Promise.reject(error)
  }
  if (error.response.status === 419) {
    // location.reload()
    console.error(error)
  }
  if (error.response.status === 401) {
    Swal.fire({
      title: 'Oturum süreniz dolmuştur',
      text: 'Kullanıcı giriş sayfasına yönlendirileceksiniz',
      icon: 'warning',
      confirmButtonText: 'Tamam'
    }).then(async (value) => {
      pace.stop()
      await router.push({ name: 'login' })
    })
  } else {
    pace.stop()
    return Promise.reject(error)
  }
})

http.interceptors.response.use((response) => {
  // pace.stop()
  return response
}, async (error) => {
  if (error.response.status === 422) {
    const validationMessages = Object.entries(error.response.data)
      .map(entry => entry[1])
      .join('<br>')
    // eslint-disable-next-line no-unused-expressions
    // OverlayHelper.close()
    const msg = `Aşağıdaki veri doğrulama hataları giderilmelidir.<br><b>${validationMessages}</b>`
    await Swal.fire({
      title: 'Veri doğrulama hatası!',
      html: msg,
      icon: 'warning',
      confirmButtonText: 'Tamam'
      // timer: 3000
    })
    pace.stop()
  } else if (error.response.status === 500) {
    const msg = 'Maalesef sunucu taraflı bir hata meydana geldi. Lütfen sistem yöneticinize başvurunuz.'
    await Swal.fire({
      title: 'Sistem hatası!',
      html: msg,
      icon: 'error',
      confirmButtonText: 'Tamam'
    })
    pace.stop()
  }
  return Promise.reject(error)
})

export default http
