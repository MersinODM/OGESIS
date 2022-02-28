import { ref, watch } from 'vue'
import { useAbility } from '@casl/vue'
import { usePermissionConstants } from '../utils/constants'
import store from '../store'
import useTeamApi from '../services/useTeamApi'

export function useTeamFilter (selectedDistrict = null, selectedInstitution = null, selectedTeachers = []) {
  const teams = ref([])
  if (selectedDistrict == null || selectedInstitution == null) {
    selectedDistrict = ref()
    selectedInstitution = ref()
  }
  const { can, cannot } = useAbility()
  const { getTeams } = useTeamApi()
  const { LEVEL_1, LEVEL_2, LEVEL_3 } = usePermissionConstants()

  // Kullanıcı değişimini izliyoruz eğer okul kullanıcısı ise
  // kullanıcının okulundaki öğretmenleri dolduruyoruz seçim için
  if (can(LEVEL_1) && cannot(LEVEL_3, LEVEL_2)) {
    getTeams(store.getters['auth/user']?.institution.district_id, store.getters['auth/user']?.institution_id)
      .then(res => {
        teams.value = res
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
      if (can(LEVEL_2) && cannot(LEVEL_3)) {
        getTeams(store.getters['auth/user']?.institution.district_id, selectedInstitution.value)
          .then(res => {
            teams.value = res
          })
      }
      if (can(LEVEL_3)) {
        getTeams(selectedDistrict.value, selectedInstitution.value)
          .then(res => {
            teams.value = res
          })
      }
    } else {
      teams.value = []
    }
  })

  return {
    teams
  }
}
