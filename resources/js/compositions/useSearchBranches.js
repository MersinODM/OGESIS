import { debounce, interval, Subject } from 'rxjs'
import useBranchApi from '../services/useBranchApi'
import { ref } from 'vue'

export function useSearchBranches () {
  const { searchBranch } = useBranchApi()
  const branches = ref([])
  const isSearching = ref(false)

  // Burada debouncing ile alan/branş araması yaptırıyoruz
  const branchSubject = new Subject()
  branchSubject.pipe(debounce(() => interval(1000)))
    .subscribe(async param => {
      branches.value = await searchBranch({ content: param })
      isSearching.value = false
    })

  // Bu fonksiyon ui dan aldığı aranacak parametreyi subjeye geçirir
  // Subje reaktif operatörlere göre değerleri işler subscribe'a aktarır
  const findBranch = (param) => {
    if (param) {
      isSearching.value = true
      branchSubject.next(param)
    }
  }

  return {
    findBranch,
    branches,
    isSearching
  }
}
