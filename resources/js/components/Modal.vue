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
    v-if="isShowModal"
    id="modal-default"
    class="modal fade show"
    aria-modal="true"
    role="dialog"
    style="padding-right: 15px; display: block;"
  >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4><slot name="modal-title" /></h4>
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
          <slot name="modal-body" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { inject, ref, watch } from 'vue'
import SkinHelper from '../utils/SkinHelper'
import constants from '../utils/constants'
import { useModelWrapper } from '../compositions/useModelWrapper'

export default {
  name: 'Modal',
  props: {
    name: {
      type: String,
      default: ''
    },
    isShow: {
      type: Boolean,
      default: true
    }
  },
  setup (props, { emit }) {
    const eventBus = inject('eventBus')
    const { EVENT_CLOSE_MODAL, EVENT_MODAL_CLOSED, EVENT_OPEN_MODAL, EVENT_MODAL_OPENED } = constants()
    const isShowModal = useModelWrapper(props, emit, 'isShowModal')

    watch(isShowModal, () => {
      if (isShowModal) {
        SkinHelper.OpenModalSkin()
      } else {
        SkinHelper.CloseModalSkin()
      }
    })

    eventBus.on(EVENT_CLOSE_MODAL, () => close())

    const close = () => {
      isShowModal.value = false
      SkinHelper.CloseModalSkin()
      eventBus.emit(EVENT_MODAL_CLOSED)
    }

    eventBus.on(EVENT_OPEN_MODAL, (event) => {
      if (props.name !== event.name) return
      isShowModal.value = true
      SkinHelper.OpenModalSkin()
    })

    eventBus.emit(EVENT_MODAL_OPENED, { name: props.name })

    return {
      isShowModal,
      close
    }
  }
}
</script>

<style scoped>

</style>
