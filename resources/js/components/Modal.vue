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
  <div
    v-if="isShow"
    id="modal-default"
    class="modal fade show"
    aria-modal="true"
    role="dialog"
    style="display: block;"
  >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4>{{ title }}</h4>
          <button
            type="button"
            class="close"
            aria-label="Close"
            @click="close"
          >
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <component :is="current" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { computed } from 'vue'

import { useModalActionTypes } from '../utils/constants'
import { useStore } from 'vuex'

export default {
  name: 'Modal',
  setup (props, { emit }) {
    const store = useStore()
    const { MODAL, CLOSE } = useModalActionTypes()

    const close = () => {
      store.dispatch(MODAL.withSuffix(CLOSE))
    }

    return {
      current: computed(() => store.state.modal.currentComponent),
      isShow: computed(() => store.state.modal.isShow),
      title: computed(() => store.state.modal.title),
      close
    }
  }
}
</script>

<style scoped>

</style>
