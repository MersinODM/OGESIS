import { ref, watch, computed } from 'vue'
import { useStore } from 'vuex'

export function useDistrictAndInstitutionFilter (reload = null) {
  const store = useStore()
  const selectedDistrict = ref(store.getters['district/selectedDistrict'])
  const selectedInstitution = ref(store.getters['institution/selectedInstitution'])

  // Kurum id değştiyse öğretmenleri tekrar yüklüyoruz
  watch(selectedInstitution, () => {
    if (reload) {
      reload()
    }
  })


  return {
    selectedDistrict,
    selectedInstitution,
    institutions: computed(() => store.getters['institution/institutions'])
  }
}
