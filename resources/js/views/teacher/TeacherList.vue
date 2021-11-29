<template>
  <page>
    <template #header>
      <h4>
        <span class="text-bold text-blue">Öğretmen</span> Listesi, Seçilen Branş:
        <span class="text-bold">{{ selectedBranch !=null ? selectedBranch : 'Hepsi' }}</span>
      </h4>
    </template>
    <template #content>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="row justify-content-md-center">
                <div class="col-md-3 mt-1">
                  <div class="form-group">
                    <label>İlçe Tercihi</label>
                    <multiselect
                      v-model="selectedDistrict"
                      :options="districts"
                      label="name"
                      value-prop="id"
                      placeholder="İlçe seçimi yapabilirsiniz."
                      no-options-text="Bu liste boş!"
                      no-result-text="Burada bişey bulamadık!"
                      @change="clearInstitutions"
                    />
                  </div>
                </div>
                <div class="col-md-3 mt-1">
                  <div class="form-group">
                    <label>Okul Tercihi</label>
                    <multiselect
                      ref="msInstitution"
                      v-model="selectedInstitution"
                      :options="institutions"
                      label="name"
                      value-prop="id"
                      :searchable="true"
                      :filterResults="false"
                      :resolve-on-load="true"
                      :close-on-select="true"
                      :loading="false"
                      track-by="name"
                      placeholder="Okul araması/seçimi yapabilirsiniz."
                      no-options-text="Bu liste boş!"
                      no-result-text="Burada bişey bulamadık!"
                      @search-change="searchInstitution"
                    />
                  </div>
                </div>
                <div class="col-md-3 mt-1">
                  <div class="form-group">
                    <label>Branş Tercihi</label>
                    <multiselect
                      v-model="selectedBranch"
                      :options="branches"
                      label="name"
                      value-prop="id"
                      :searchable="true"
                      :filterResults="false"
                      :resolve-on-load="true"
                      :close-on-select="true"
                      :loading="false"
                      track-by="name"
                      placeholder="Branş araması/seçimi yapabilirsiniz."
                      no-options-text="Bu liste boş!"
                      no-result-text="Burada bişey bulamadık!"
                      @search-change="searchBranch"
                    />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="dataTables_wrapper dt-bootstrap4 table-responsive">
                    <table
                      id="teachersTable"
                      class="table table-bordered table-hover dataTable dtr-inline"
                      role="grid"
                      style="width:100%"
                    >
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>DISTRICT_ID</th>
                          <th>BRANCH_ID</th>
<!--                          <th>İLÇE</th>-->
                          <th>OKUL</th>
                          <th>BRANŞ</th>
                          <th>AD</th>
                          <th>SOYAD</th>
                          <th>TELEFON</th>
                          <th>E-POSTA</th>
                          <th>AKSİYON</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </page>
</template>

<script>
import Page from '../../components/Page'
import Multiselect from '@vueform/multiselect'
import { computed, onMounted, ref, watch } from 'vue'
import tr from '../../utils/dataTablesTurkish'
import { useStore } from 'vuex'
import { useBranchConstants, useDistrictConstants, useInstitutionConstants } from '../../utils/constants'
import router from '../../router'
// import throttle from 'lodash/throttle'
import { Subject, interval, debounce } from 'rxjs'

let table = null

export default {
  name: 'TeacherList',
  components: { Page, Multiselect },
  setup: function () {
    const store = useStore()
    const { A_SET_CURRENT_DISTRICT, A_SET_DISTRICTS, DISTRICT_PREFIX } = useDistrictConstants()
    const {
      INSTITUTION_PREFIX,
      A_SEARCH_INSTITUTIONS,
      A_SET_CURRENT_INSTITUTION,
      M_INSTITUTIONS,
      M_CURRENT_INSTITUTION
    } = useInstitutionConstants()
    const { BRANCH_PREFIX, A_SEARCH_BRANCH, A_SET_CURRENT_BRANCH } = useBranchConstants()

    store.dispatch(A_SET_DISTRICTS.withPrefix(DISTRICT_PREFIX))

    const districts = computed(() => store.state.district.districts)
    const selectedDistrict = ref(store.state.district.currentDistrict)

    const institutions = computed(() => store.state.institution.institutions)
    const selectedInstitution = ref(store.state.institution.currentInstitution)

    const branches = computed(() => store.state.branch.branches)
    const selectedBranch = ref(store.state.branch.currentBranch)

    const msInstitution = ref()

    watch(selectedDistrict, () => {
      // district/setCurrentDistrict çağrılıyor aslında
      store.dispatch(A_SET_CURRENT_DISTRICT.withPrefix(DISTRICT_PREFIX), selectedDistrict.value)
      table?.ajax.reload(null, false)
      msInstitution.value.clear()
    })

    watch(selectedInstitution, () => {
      store.dispatch(A_SET_CURRENT_INSTITUTION.withPrefix(INSTITUTION_PREFIX), selectedInstitution.value)
      table?.ajax.reload(null, false)
    })

    watch(selectedBranch, () => {
      store.dispatch(A_SET_CURRENT_BRANCH.withPrefix(BRANCH_PREFIX), selectedBranch.value)
      table?.ajax.reload(null, false)
    })

    // Önce rxjs den bir subject oluşturalım
    const branchSubject = new Subject()
    // Sonra subjenini pipe fonksiyonu yardımıyla reactive operatörlerini verelim
    // Bu subjeye subscribe yaparak reaktif operatörlerin sonucunda fonksiyon çağrımızı yapalım
    // Biz burada debounce operatörünü kullandık çünkü her tuş basımında ya da
    // her bir karakter değişiminde sunucuya istek atılsın istemiyoruz(gereksiz yük bir sürü)
    // Yazılan karakterler 1000 milisaniye içinde istediği kadar değişebilir
    // Yazım işi bittikten sonra yani interval kadar geçen zaman sonunda
    // Subscribe ettiğimiz fonksiyon çağrılır
    branchSubject.pipe(debounce(() => interval(1000)))
      .subscribe(param => {
        store.dispatch(A_SEARCH_BRANCH.withPrefix(BRANCH_PREFIX), { content: param })
      })

    // Bu fonksiyon ui dan aldığı aranacak parametreyi subjeye geçirir
    // Subje reaktif operatörlere göre değerleri işler subscribe'a aktarır
    const searchBranch = (param) => {
      branchSubject.next(param)
    }

    const insSubject = new Subject()
    insSubject.pipe(debounce(() => interval(1000)))
      .subscribe(param => {
        store.dispatch(A_SEARCH_INSTITUTIONS.withPrefix(INSTITUTION_PREFIX), { district_id: selectedDistrict.value, content: param })
      })

    const searchInstitution = (param) => {
      insSubject.next(param)
    }

    // TODO Buraya bir daha bakılacak
    const clearInstitutions = () => {
      store.commit(M_INSTITUTIONS.withPrefix(INSTITUTION_PREFIX), [])
      store.commit(M_CURRENT_INSTITUTION.withPrefix(INSTITUTION_PREFIX), null)
    }

    onMounted(() => {
      table = $('#teachersTable')
        .on('preXhr.dt', (e, settings, data) => {
          // Bu event sunucuya datatable üzerinden veri gitmeden önce
          // yeni parametre eklemek için ateşleniyor
          data.district_id = selectedDistrict.value
          data.institution_id = selectedInstitution.value
          data.branch_id = selectedBranch.value
        })
        .DataTable({
          fixedHeader: true,
          processing: true,
          serverSide: true,
          responsive: false,
          stateSave: true,
          retrieve: true,
          searching: true,
          paging: true,
          stateDuration: -1,
          ajax: {
            url: '/api/v1/teachers/table',
            dataType: 'json',
            type: 'POST',
            xhrFields: {
              withCredentials: true
            }
          },
          language: tr,
          columns: [
            {
              data: 'id',
              name: 'id',
              searchable: false,
              visible: false
            },
            {
              data: 'district_id',
              name: 'district_id',
              searchable: false,
              visible: false
            },
            {
              data: 'branch_id',
              name: 'branch_id',
              searchable: false,
              visible: false
            },
            {
              data: 'institution.name',
              name: 'institution.name',
              searchable: true
            },
            {
              data: 'branch.name',
              name: 'branch.name',
              searchable: true
            },
            {
              data: 'first_name',
              name: 'first_name',
              searchable: true
            },
            {
              data: 'last_name',
              name: 'last_name',
              searchable: true
            },
            {
              data: 'phone',
              name: 'phone',
              searchable: true
            },
            {
              data: 'email',
              name: 'email',
              searchable: true
            },
            {
              data: '',
              width: '10%',
              render (data, type, row, meta) {
                return '<div class="btn-group">' +
                      '<button class="btn btn-xs btn-primary">Göster</button>' +
                      '<button class="btn btn-xs btn-warning">Düzenle</button>' +
                      // '<button class="btn btn-xs btn-danger">Düşür</button>' +
                      '</div>'
              },
              searchable: false,
              orderable: false
            }
          ]
        })

      table.on('click', '.btn-primary', async (e) => {
        const data = table.row($(e.target).parents('tr')[0]).data()
        // customerStore.actions.setCustomer({ id: data.customer_id, name: data.customer, identity: data.identity_no, phone: data.phone, address: data.address })
        await router.push({ name: 'underConstruction' })
      })

      table.on('click', '.btn-warning', async (e) => {
        const data = table.row($(e.target).parents('tr')[0]).data()
        // customerStore.actions.setCustomer({ id: data.customer_id, name: data.customer, identity: data.identity_no, phone: data.phone, address: data.address })
        await router.push({ name: 'underConstruction' })
      })
    })

    return {
      districts,
      selectedDistrict,
      selectedInstitution,
      institutions,
      searchInstitution,
      clearInstitutions,
      msInstitution,
      selectedBranch,
      branches,
      searchBranch
    }
  }
}
</script>

<style scoped>

</style>
