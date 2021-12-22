import { ref } from 'vue'


export function useDistrictFilter () {
  const districts = ref([])
  const selectedDistrict = ref()

  return {
    selectedDistrict,
    districts
  }
}
