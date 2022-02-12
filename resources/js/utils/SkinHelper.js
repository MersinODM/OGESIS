/*
 * ODM.Web  https://github.com/electropsycho/ODM.Web
 * Copyright 2019-2020 Hakan GÜLEN
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

const SkinHelper = {
  LoginSkin () {
    const appElement = document.body
    // document.body.classList.remove('sidebar-mini', 'layout-fixed', 'layout-navbar-fixed', 'layout-footer-fixed', 'register-page')
    appElement.classList.remove('sidebar-mini', 'layout-fixed', 'register-page')
    appElement.classList.add('login-page')
  },
  MainSkin () {
    const appElement = document.body
    appElement.classList.remove('login-page', 'register-page')
    appElement.classList.add('sidebar-mini', 'layout-fixed')
    // appElement.classList.add('sidebar-mini', 'layout-fixed', 'layout-footer-fixed', 'layout-navbar-fixed')
  },
  OpenModalSkin () {
    const appElement = document.body
    appElement.classList.add('modal-open')
    appElement.style.paddingRight = '15px'
    appElement.style.height = 'auto'
    const modalBackground = document.createElement('div')
    modalBackground.id = 'modalBackground'
    modalBackground.classList.add('modal-backdrop', 'fade', 'show')
    document.body.appendChild(modalBackground)
  },
  CloseModalSkin () {
    const appElement = document.body
    appElement.classList.remove('modal-open')
    appElement.style.removeProperty('padding-right')
    appElement.style.removeProperty('height')
    document.getElementById('modalBackground')?.remove()
  }
}

export default SkinHelper
