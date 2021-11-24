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
                      @deselect="clearInstitutions"
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
                      placeholder="Branş araması/seçimi yapabilirsiniz."
                      no-options-text="Bu liste boş!"
                      no-result-text="Burada bişey bulamadık!"
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
                          <th>İLÇE</th>
                          <th>OKUL</th>
                          <th>BRANŞ</th>
                          <th>AD SOYAD</th>
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
import { useDistrictConstants, useInstitutionConstants } from '../../utils/constants'

let table = null

export default {
  name: 'TeacherList',
  components: { Page, Multiselect },
  setup () {
    const store = useStore()
    const { A_SET_CURRENT_DISTRICT, A_SET_DISTRICTS } = useDistrictConstants()
    const { A_SEARCH_INSTITUTIONS, A_SET_CURRENT_INSTITUTION, M_INSTITUTIONS, M_CURRENT_INSTITUTION } = useInstitutionConstants()

    store.dispatch(`district/${A_SET_DISTRICTS}`)

    const districts = computed(() => store.state.district.districts)
    const selectedDistrict = ref(store.state.district.currentDistrict)

    const institutions = computed(() => store.state.institution.institutions)
    const selectedInstitution = ref(store.state.institution.currentInstitution)

    watch(selectedDistrict, () => {
      store.dispatch(`district/${A_SET_CURRENT_DISTRICT}`, selectedDistrict.value)
    })

    watch(selectedInstitution, () => {
      store.dispatch(`institution/${A_SET_CURRENT_INSTITUTION}`, selectedInstitution.value)
    })

    const searchInstitution = (param) => {
      if (param.length < 3) return
      store.dispatch(`institution/${A_SEARCH_INSTITUTIONS}`, { district_id: selectedDistrict.value, content: param })
    }

    // TODO Buraya bir daha bakılacak
    const clearInstitutions = () => {
      store.commit(`institution/${M_INSTITUTIONS}`, [])
      store.commit(`institution/${M_CURRENT_INSTITUTION}`, '')
    }

    onMounted(() => {
      table = $('#teachersTable')
        .on('preXhr.dt', (e, settings, data) => {
          // Bu event sunucuya datatable üzerinden veri gitmeden önce
          // yeni parametre eklemek için ateşleniyor
          data.district_id = selectedDistrict.value
          data.institution_id = selectedDistrict.value
          data.branc_id = selectedDistrict.value
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
            }, {
              data: 'district_id',
              name: 'district_id',
              searchable: false,
              visible: false
            },
            {
              data: 'district.name',
              name: 'district.name',
              searchable: true
            },
            {
              data: 'name',
              name: 'name',
              searchable: true
            },
            {
              data: 'phone',
              name: 'phone',
              searchable: true
            },
            {
              data: 'address',
              name: 'address',
              searchable: false
            },
            {
              data: 'e_mail',
              name: 'e_mail',
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
      clearInstitutions
    }
  }
}
</script>

<style scoped>

</style>
