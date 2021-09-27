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

import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/auth/Login'
import MasterView from '../views/layouts/MasterView'
import Start from '../views/home/Start'
import UnderConstruction from '../views/utils/UnderConstruction'
import NotFound from '../views/utils/NotFound'
import planRoutes from './planRoutes'
import institutionRoutes from './institutionRoutes'
import teacherRoute from "./teacherRoutes";

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: Login
    },
    {
      path: '/',
      component: MasterView,
      children: [
        {
          path: '',
          name: 'start',
          component: Start
        },
        {
          path: 'under-construction',
          name: 'underConstruction',
          component: UnderConstruction
        },
        ...planRoutes,
        ...institutionRoutes,
        ...teacherRoute
      ]
    },
    { path: '/:pathMatch(.*)*', name: 'not-found', component: NotFound }
  ]
})

const checkAuth = (to, next) => {
  if (to.name === 'login' || to.name === 'forgotMyPassword') {
    next()
  } else {
    // TODO burada login kontrlolü yapılsın
    next()
  }
}

// TODO Burada role denetimi yapılacak
router.beforeEach((to, from, next) => checkAuth(to, next))

export default router
