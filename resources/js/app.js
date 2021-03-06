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

import './bootstrap'

import App from './views/App.vue'
import { createApp } from 'vue'
import router from './router'
import uppercase from './directives/uppercase'
import dateFormat from './directives/dateFormat'
import store from './store'
import { abilitiesPlugin } from '@casl/vue'
import { constantMixin } from './mixins/constantMixin'
import { maska } from 'maska'

const app = createApp(App)
app.use(router)
app.use(store)
app.use(abilitiesPlugin, store.getters['auth/ability'], {
  useGlobalProperties: true
})
app.mixin(constantMixin)
app.directive('mask', maska)
app.directive('uppercase', uppercase)
app.directive('date-format', dateFormat)
router.isReady().then(() => app.mount('#app'))
