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
    document.body.classList.remove('sidebar-mini', 'layout-fixed', 'layout-navbar-fixed', 'register-page')
    document.body.classList.add('login-page')
  },
  MainSkin () {
    document.body.classList.remove('login-page', 'register-page')
    document.body.classList.add('sidebar-mini', 'layout-fixed', 'layout-navbar-fixed')
  },
  OpenModalSkin () {
    document.body.classList.add('modal-open')
    document.body.style.paddingRight = '15px'
  },
  CloseModalSkin () {
    document.body.classList.remove('modal-open')
    document.body.style.removeProperty('padding-right')
  }
}

export default SkinHelper
