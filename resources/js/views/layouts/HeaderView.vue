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
  <nav
    id="main-header"
    class="main-header navbar navbar-expand navbar-white navbar-light elevation-1"
  >
    <!-- Left navbar links -->
    <!--    <ul class="navbar-nav">-->
    <!--      <li class="nav-item">-->
    <!--        <a-->
    <!--          class="nav-link"-->
    <!--          href="javascript:void(0)"-->
    <!--          role="button"-->
    <!--          @click="$emit('toggleMenuSideBar')"-->
    <!--        ><img alt="">-->
    <!--          <svg-->
    <!--            style="width:24px;height:24px"-->
    <!--            viewBox="0 0 24 24"-->
    <!--          >-->
    <!--            <path-->
    <!--              fill="currentColor"-->
    <!--              d="M3,6H21V8H3V6M3,11H21V13H3V11M3,16H21V18H3V16Z"-->
    <!--            />-->
    <!--          </svg>-->
    <!--          <img>-->
    <!--        </a>-->
    <!--      </li>-->
    <!--    </ul>-->
    <ul class="navbar-nav">
      <li class="nav-item">
        <button
          class="nav-link"
          role="button"
          @click="$emit('toggleMenuSideBar')"
        >
          <i class="fas fa-bars" />
        </button>
      </li>
      <li class="nav-item d-none d-sm-inline-block ml-2">
        <select-institution-button
          class="btn-block mb-2 text-dark"
        />
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a
          class="nav-link"
          role="button"
          @click="logout"
        >
          <i class="mdi mdi-logout" /></a>
      </li>
    </ul>
  </nav>
</template>

<script>

import Messenger from '../../utils/messenger'
import { useStore } from 'vuex'
import { useAuthActionTypes } from '../../utils/constants'
import useModal from '../../compositions/useModal'
import SelectInstitutionButton from "../../components/SelectInstitutionButton";

export default {
  name: 'NHeader',
  components: { SelectInstitutionButton },
  emits: ['toggleMenuSideBar'],
  setup () {
    const store = useStore()
    const { AUTH, LOGOUT } = useAuthActionTypes()
    const { openModal } = useModal()

    const selectInstitution = () => {
      openModal({ title: 'Kurum seçimi', component: 'InstitutionSelectorModal' })
    }

    const logout = async () => {
      const result = await Messenger.showPrompt('Oturumu kapatmak istediğinize emin misiniz?')
      if (result.isConfirmed) {
        await store.dispatch(LOGOUT.withPrefix(AUTH))
      }
    }
    return {
      logout,
      selectInstitution
    }
  }
}
</script>

<style lang="sass">

</style>
