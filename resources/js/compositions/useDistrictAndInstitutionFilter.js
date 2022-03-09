import { ref, watch, computed } from 'vue'
// import useInstitutionApi from '../services/useInstitutionApi'
// import { useAbility } from '@casl/vue'
// import { usePermissionConstants } from '../utils/constants'
import { useStore } from 'vuex'
import {useDistrictConstants} from '../utils/constants'
const {
  DISTRICT,
  SET_SELECTED_DISTRICT
} = useDistrictConstants()

export function useDistrictAndInstitutionFilter (reload = null, selectedDistrict = null, selectedInstitution = null) {
  const store = useStore()
  if (selectedDistrict == null || selectedInstitution == null) {
    selectedDistrict = ref()
    selectedInstitution = ref()
  }
  // const { can, cannot } = useAbility()
  // const { getInstitution } = useInstitutionApi()
  // const { LEVEL_2, LEVEL_3 } = usePermissionConstants()

  // // Kullanıcı değişimini izliyoruz eğer ilçe kullanıcısı ise
  // // kullanıcının ilçesindeki okulları dolduruyoruz seçim için
  // if (can(LEVEL_2) && cannot(LEVEL_3)) {
  //   getInstitution(store.getters['auth/user']?.institution.district_id)
  //     .then(res => {
  //       institutions.value = res
  //     })
  // }

  // İl kullanıcıları için ilçe seçimi değişikliğini takip ediyoruz
  // watch(selectedDistrict, () => {
  //   selectedInstitution.value = null
  //   store.dispatch(DISTRICT.withSuffix(SET_SELECTED_DISTRICT), selectedDistrict.value.id)
  // })

  // Kurum id değştiyse öğretmenleri tekrar yüklüyoruz
  watch(selectedInstitution, () => {
    if (reload) {
      reload()
    }
  })

  // // Kullanıcı değişimini izliyoruz eğer ilçe kullanıcısı ise
  // // kullanıcının ilçesindeki okulları dolduruyoruz seçim için
  // if (can(LEVEL_2) && cannot(LEVEL_3)) {
  //   getInstitution(store.getters['auth/user']?.institution.district_id)
  //     .then(res => {
  //       institutions.value = res
  //     })
  // }

  return {
    selectedDistrict,
    selectedInstitution,
    institutions: computed(() => store.getters['institution/institutions'])
  }
}
