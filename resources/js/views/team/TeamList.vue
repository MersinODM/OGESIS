<template>
  <page>
    <template #header>
      <h4>
        <span class="text-bold text-blue">Takım</span> Listesi
      </h4>
    </template>
    <template #content>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="dataTables_wrapper dt-bootstrap4 table-responsive">
                    <table
                      id="teamsTable"
                      class="table table-bordered table-hover dataTable dtr-inline"
                      role="grid"
                      style="width:100%"
                    >
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>DISTRICT_ID</th>
                          <th>INSTITUTION_ID</th>
                          <th>İLÇE</th>
                          <th>KURUM</th>
                          <th>AD</th>
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
import { onMounted, onUnmounted, watch, computed } from 'vue'
import tr from '../../utils/dataTablesTurkish'
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'
let table = null

export default {
  name: 'TeamList',
  components: { Page },
  setup () {
    const router = useRouter()

    const store = useStore()
    const selectedDistrict = computed(() => store.getters['district/selectedDistrict'])
    const selectedInstitution = computed(() => store.getters['institution/selectedInstitution'])

    // İl kullanıcıları için ilçe seçimi değişikliğini takip ediyoruz
    watch(selectedDistrict, async () => {
      table?.ajax.reload(null, false)
    })

    // Kurum id değştiyse öğretmenleri tekrar yüklüyoruz
    watch(selectedInstitution, () => {
      table?.ajax.reload(null, false)
    })

    onMounted(() => {
      table = $('#teamsTable')
        .on('preXhr.dt', (e, settings, data) => {
          // Bu event sunucuya datatable üzerinden veri gitmeden önce
          // yeni parametre eklemek için ateşleniyor
          data.district_id = selectedDistrict.value
          data.institution_id = selectedInstitution.value
        })
        .DataTable({
          fixedHeader: true,
          processing: true,
          serverSide: true,
          responsive: false,
          retrieve: true,
          searching: true,
          paging: true,
          ajax: {
            url: '/api/v1/teams/table',
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
              data: 'institution_id',
              name: 'institution_id',
              searchable: false,
              visible: false
            },
            {
              data: 'institution.district.name',
              name: 'institution.district.name',
              searchable: true
            },
            {
              data: 'institution.name',
              name: 'institution.name',
              searchable: true
            },
            {
              data: 'name',
              name: 'name',
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
  }
}
</script>

<style scoped>

</style>
