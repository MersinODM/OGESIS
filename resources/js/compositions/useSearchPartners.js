import usePartnerApi from '../services/usePartnerApi'
import { ref } from 'vue'

export function useSearchPartners (selectedPartners) {
  const { searchPartner } = usePartnerApi()
  const partners = ref([])
  const isSearching = ref(false)

  const findPartner = async (param) => {
    if (param && param.length > 1) {
      isSearching.value = true
      // branchSubject.next(param)
      const res = await searchPartner({ content: param })
      isSearching.value = false
      return res
    }
  }

  return {
    findPartner,
    partners,
    isSearching
  }
}
