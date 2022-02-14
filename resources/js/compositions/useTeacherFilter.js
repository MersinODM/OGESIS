import { ref, watch } from 'vue'
import { useAbility } from '@casl/vue'
import { usePermissionConstants } from '../utils/constants'
import store from '../store'
import useTeacherApi from '../services/useTeacherApi'

export function useTeacherFilter (selectedDistrict = null, selectedInstitution = null, selectedTeachers = []) {
  const teachers = ref([])
  if (selectedDistrict == null || selectedInstitution == null) {
    selectedDistrict = ref()
    selectedInstitution = ref()
  }
  const { can, cannot } = useAbility()
  const { getTeachers } = useTeacherApi()
  const { TEACHER_LIST_LEVEL_1, TEACHER_LIST_LEVEL_2, TEACHER_LIST_LEVEL_3 } = usePermissionConstants()

  // Kullanıcı değişimini izliyoruz eğer okul kullanıcısı ise
  // kullanıcının okulundaki öğretmenleri dolduruyoruz seçim için
  if (can(TEACHER_LIST_LEVEL_1) && cannot(TEACHER_LIST_LEVEL_3, TEACHER_LIST_LEVEL_2)) {
    getTeachers(store.getters['auth/user']?.institution.district_id, store.getters['auth/user']?.institution_id)
      .then(res => {
        teachers.value = res
      })
  }

  // // İl kullanıcıları için ilçe seçimi değişikliğini takip ediyoruz
  // watch(selectedDistrict, async () => {
  //   selectedInstitution.value = null
  //   if (selectedDistrict.value) {
  //     institutions.value = await getInstitution(selectedDistrict.value)
  //   } else {
  //     institutions.value = []
  //   }
  // })

  // Kurum id değştiyse öğretmenleri tekrar yüklüyoruz
  watch(selectedInstitution, () => {
    selectedTeachers.value = []
    if (selectedInstitution.value) {
      if (can(TEACHER_LIST_LEVEL_2) && cannot(TEACHER_LIST_LEVEL_3)) {
        getTeachers(store.getters['auth/user']?.institution.district_id, selectedInstitution.value)
          .then(res => {
            teachers.value = res
          })
      }
      if (can(TEACHER_LIST_LEVEL_3)) {
        getTeachers(selectedDistrict.value, selectedInstitution.value)
          .then(res => {
            teachers.value = res
          })
      }
    } else {
      teachers.value = []
    }
  })

  return {
    teachers
  }
}
