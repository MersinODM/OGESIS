
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
    <div
      class="sidebar"
      style="margin-top: 0"
    >
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img
            id="avatar"
            class="img-circle elevation-2"
            alt="User Image"
          >
        </div>
        <div class="info">
          <router-link
            :to="{ name: 'underConstruction' }"
            class="d-block"
          >
            DENEME KULLANICISI
          </router-link>
        </div>
      </div>
      <nav class="mt-2">
        <ul
          class="nav nav-pills nav-sidebar nav-child-indent flex-column"
          data-widget="treeview"
          role="menu"
          data-accordion="false"
        >
          <menu-item
            v-for="(item, index) in menu"
            :key="index"
            :menu-item="item"
          />
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
import MenuItem from '../../components/MenuItem'

export default {
  name: 'NMainSidebar',
  components: { MenuItem },
  setup () {
    const generateAvatar = (text, foregroundColor, backgroundColor) => {
      const canvas = document.createElement('canvas')
      const context = canvas.getContext('2d')

      canvas.width = 200
      canvas.height = 200

      // Draw background
      context.fillStyle = backgroundColor
      context.fillRect(0, 0, canvas.width, canvas.height)

      // Draw text
      context.font = 'bold 100px Arial'
      context.fillStyle = foregroundColor
      context.textAlign = 'center'
      context.textBaseline = 'middle'
      context.fillText(text, canvas.width / 2, canvas.height / 2)

      return canvas.toDataURL('image/png')
    }

    onMounted(() => {
      // TODO Burada kullanıcı adı verilecek fonksiyona
      const name = 'DENEME KULLANICISI'
      // Adımızın başharfini ve soyadımızın başharfini buluyoruz
      const initial = name.match(/(\b\S)?/g)
        .join('')
        .match(/(^\S|\S$)?/g)
        .join('')
        .toUpperCase()
      document.getElementById('avatar').src = generateAvatar(initial, 'black', '#40E0D0')
    })
    const menu = [
      {
        name: 'Ana Sayfa',
        path: '',
        routeName: 'start',
        icon: 'mdi mdi-home-circle'
      },
      {
        name: 'Planlama Modülü',
        icon: 'mdi mdi-notebook',
        children: [
          {
            name: 'Yeni Plan Oluştur',
            routeName: 'newPlan',
            icon: 'mdi mdi-book-plus'
          },
          {
            name: 'Güncel Gelişim Planı',
            routeName: 'underConstruction',
            icon: 'mdi mdi-book-settings-outline'
          },
          {
            name: 'Planlar',
            routeName: 'underConstruction',
            icon: 'mdi mdi-bookshelf'
          }
        ]
      },
      {
        name: 'Ekip Modülü',
        icon: 'mdi mdi-human-greeting-variant',
        children: [
          {
            name: 'Yeni Ekip Oluştur',
            routeName: 'underConstruction',
            icon: 'mdi mdi-human-capacity-increase'
          },
          {
            name: 'Ekipler',
            routeName: 'underConstruction',
            icon: 'mdi mdi-human-queue'
          }
        ]
      },
      {
        name: 'Öğretmen Modülü',
        icon: 'mdi mdi-account-group',
        children: [
          {
            name: 'Yeni Öğretmen Kaydı',
            routeName: 'newTeacher',
            icon: 'mdi mdi-account-plus'
          },
          {
            name: 'Öğretmenler',
            routeName: 'listTeachers',
            icon: 'mdi mdi-account-multiple'
          }
        ]
      },
      {
        name: 'Kurum Modülü',
        icon: 'mdi mdi-bank',
        children: [
          {
            name: 'Yeni Kurum',
            routeName: 'newInstitution',
            icon: 'mdi mdi-bank-plus'
          },
          {
            name: 'Toplu Kurum Ekle',
            routeName: 'importInstitutions',
            icon: 'mdi mdi-bank-transfer-out'
          },
          {
            name: 'Kurum Listsi',
            routeName: 'listInstitutions',
            icon: 'mdi mdi-garage'
          }
        ]
      }
    ]

    return {
      menu,
      logo
    }
  }
}
</script>

<style>

</style>
