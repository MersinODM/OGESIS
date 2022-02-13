import { ref, watch } from 'vue'
import useInstitutionApi from '../services/useInstitutionApi'
import { useAbility } from '@casl/vue'
import { usePermissionConstants } from '../utils/constants'
import store from '../store'

export function useDistrictAndInstitutionFilter (reload = null, selectedDistrict = null, selectedInstitution = null) {
  const institutions = ref([])
  if (selectedDistrict == null || selectedInstitution == null) {
    selectedDistrict = ref()
    selectedInstitution = ref()
  }
  const { can, cannot } = useAbility()
  const { getInstitution } = useInstitutionApi()
  const { TEACHER_LIST_LEVEL_2, TEACHER_LIST_LEVEL_3 } = usePermissionConstants()

  // Kullanıcı değişimini izliyoruz eğer ilçe kullanıcısı ise
  // kullanıcının ilçesindeki okulları dolduruyoruz seçim için
  if (can(TEACHER_LIST_LEVEL_2) && cannot(TEACHER_LIST_LEVEL_3)) {
    getInstitution(store.getters['auth/user']?.institution.district_id)
      .then(res => {
        institutions.value = res
      })
  }

  // İl kullanıcıları için ilçe seçimi değişikliğini takip ediyoruz
  watch(selectedDistrict, async () => {
    selectedInstitution.value = null
    if (selectedDistrict.value) {
      institutions.value = await getInstitution(selectedDistrict.value)
    } else {
      institutions.value = []
    }
  })

  // Kurum id değştiyse öğretmenleri tekrar yüklüyoruz
  watch(selectedInstitution, () => {
    if (reload) {
      reload()
    }
  })

  // Kullanıcı değişimini izliyoruz eğer ilçe kullanıcısı ise
  // kullanıcının ilçesindeki okulları dolduruyoruz seçim için
  if (can(TEACHER_LIST_LEVEL_2) && cannot(TEACHER_LIST_LEVEL_3)) {
    getInstitution(store.getters['auth/user']?.institution.district_id)
      .then(res => {
        institutions.value = res
      })
  }

  return {
    selectedDistrict,
    selectedInstitution,
    institutions
  }
}
