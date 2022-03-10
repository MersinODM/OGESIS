import { useModalActionTypes } from '../utils/constants'
import { useStore } from 'vuex'

const { MODAL, SHOW, CLOSE } = useModalActionTypes()
export default function () {
  const store = useStore()
  const openModal = async (modal) => {
    await store.dispatch(MODAL.withSuffix(SHOW), modal)
  }

  const closeModal = async () => {
    await store.dispatch(MODAL.withSuffix(CLOSE))
  }

  return {
    openModal,
    closeModal
  }
}
