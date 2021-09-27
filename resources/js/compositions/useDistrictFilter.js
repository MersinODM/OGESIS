import { watch, ref } from 'vue'
import useDistrictStore from '../store/useDistrictStore'

export default function () {
  const store = useDistrictStore()
  const selectedDistrict = ref(store.getters.lesson)

  watch(selectedDistrict, () => {
    store.actions.setCurrentDistrict(selectedDistrict)
  })

  return {
    selectedDistrict,
    districts: store.getters.lessons
  }
}
