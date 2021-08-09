
<!--
  -     Copyright 2021 Mersin İl Milli Eğitim Müdürlüğü Ölçme Değerlendirme Merkezi
  -
  -     Licensed under the Apache License, Version 2.0 (the "License");
  -     you may not use this file except in compliance with the License.
  -     You may obtain a copy of the License at
  -
  -       http://www.apache.org/licenses/LICENSE-2.0
  -
  -     Unless required by applicable law or agreed to in writing, software
  -     distributed under the License is distributed on an "AS IS" BASIS,
  -     WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  -     See the License for the specific language governing permissions and
  -     limitations under the License.
  -
  -->

<template>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a
      href="#"
      class="brand-link"
    >
      <img
        alt="Logo"
        class="brand-image img-circle elevation-3"
        style="opacity: .8; width:1.5em"
        :src="logo"
      >
      <span class="brand-text font-weight-light">OGESIS</span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-center">
        <div class="info">
          <a
            href="#"
            class="d-block"
            @click.prevent
          >Test User</a>
        </div>
      </div>
      <nav class="mt-2">
        <ul
          class="nav nav-pills nav-sidebar nav-child-indent flex-column"
          data-widget="treeview"
          role="menu"
          data-accordion="true"
        >
          <!-- Optionally, you can add icons to the links -->
          <li class="nav-item has-treeview">
            <router-link
                :to="{name: 'start' }"
                class="nav-link"
            >
              <i class="mdi mdi-account-question" />
              <p>Ana Sayfa
                <i class="right mdi mdi-angle-left" />
              </p>
            </router-link>
          </li>
          <li class="nav-item has-treeview">
            <a
              href="#"
              class="nav-link"
            >
              <i class="mdi mdi-account-question" />
              <p>Planlama Modülü
                <i class="right fas fa-angle-left" />
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link
                    :to="{name: '' }"
                    class="nav-link"
                >
                  <i class="mdi mdi-book-multiple" />
                  <p>Güncel Gelişim Planı</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link
                  :to="{name: '' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-book-multiple" />
                  <p>Gelişim Planlarımız</p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a
              href="#"
              class="nav-link"
            >
              <i class="mdi mdi-account-question" />
              <p>Ekip Modülü
                <i class="right fas fa-angle-left" />
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link
                  :to="{name: 'underConstruction' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-book-multiple" />
                  <p>Ekibi Listele</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link
                  :to="{name: '' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-book-plus" />
                  <p>Üye Ekle</p>
                </router-link>
              </li>
            </ul>
          </li>

        </ul>
      </nav>
    </div>
  </aside>
</template>

<script>

// import img from '../../../images/Logo.png'
// import { mapGetters } from 'vuex'
import logo from '../../../images/svg/logo.svg'
import { onMounted } from 'vue'

export default {
  name: 'NMainSidebar',
  setup () {
    onMounted(() => {
      $('body').Layout('fixLayoutHeight')
      $('ul').Treeview('init')
    })
    return {
      logo
    }
  }
}
</script>

<style>

</style>
