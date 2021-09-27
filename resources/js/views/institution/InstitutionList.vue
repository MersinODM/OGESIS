<template>
  <page>
    <template #header>
      <h4>
        <span class="text-bold text-blue"> Okul/Kurum</span> Listesi, Seçilen İlçe:
        <span class="text-bold">{{ selectedDistrict!=null ? selectedDistrict : 'Hepsi' }}</span>
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
                    />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="dataTables_wrapper dt-bootstrap4 table-responsive">
                    <table
                      id="institutionsTable"
                      class="table table-bordered table-hover dataTable dtr-inline"
                      role="grid"
                      style="width:100%"
                    >
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>DISTRICT_ID</th>
                          <th>İLÇE</th>
                          <th>AD</th>
                          <th>TELEFON</th>
                          <th>ADRES</th>
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
import { useRouter } from 'vue-router'
import useDistrictFilter from '../../compositions/useDistrictFilter'
import useDistrictStore from '../../store/useDistrictStore'
import { onMounted, onUnmounted, watch } from 'vue'
import tr from '../../utils/dataTablesTurkish'

let table = null

export default {
  name: 'InstitutionList',
  components: { Page, Multiselect },
  setup () {
    const router = useRouter()
    const districtStore = useDistrictStore()
    districtStore.actions.setDistricts()
    const { selectedDistrict, districts } = useDistrictFilter()

    watch(selectedDistrict, () => {
      table?.ajax.reload(null, false)
      // eventBus.emit(EVENT_OPEN_MODAL)
    })

    onMounted(() => {
      table = $('#institutionsTable')
        .on('preXhr.dt', (e, settings, data) => {
          // Bu event sunucuya datatable üzerinden veri gitmeden önce
          // yeni parametre eklemek için ateşleniyor
          data.district_id = selectedDistrict.value
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
            url: '/api/v1/institutions/table',
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

    onUnmounted(() => {
      table?.destroy()
    })

    return {
      selectedDistrict,
      districts
    }
  }
}
</script>

<style scoped>

</style>
