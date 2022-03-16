<template>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="row justify-content-md-center">
            <div class="col-md-3 mt-1" />
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="dataTables_wrapper dt-bootstrap4 table-responsive">
                <table
                  id="activitiesTable"
                  class="table table-bordered table-hover dataTable dtr-inline"
                  role="grid"
                  style="width:100%"
                >
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>PLAN_ID</th>
                      <th>INSTITUTION_ID</th>
                      <th>TEMA</th>
                      <th>AKTİVİTE TÜRÜ</th>
                      <th>AKTİVİTE</th>
                      <th>PAYDAŞ</th>
                      <th>DURUM</th>
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

<script>
import { onMounted, computed, watch } from 'vue'
import tr from '../../utils/dataTablesTurkish'
import router from '../../router'
import { useStore } from 'vuex'
let table = null

export default {
  name: 'ActivityList',
  setup () {
    const store = useStore()

    const selectedInstitution = computed(() => store.getters['institution/selectedInstitution'])
    watch(selectedInstitution, () => {
      table?.ajax.reload(null, false)
    })

    onMounted(() => {
      table = $('#activitiesTable')
        .on('preXhr.dt', (e, settings, data) => {
          // Bu event sunucuya datatable üzerinden veri gitmeden önce
          // yeni parametre eklemek için ateşleniyor
          data.institution_id = selectedInstitution.value.id
          // data.branch_id = selectedBranch.value
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
            url: '/api/v1/activities/table',
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
              data: 'plan_id',
              name: 'plan_id',
              searchable: false,
              visible: false
            },
            {
              data: 'creator_id',
              name: 'creator_id',
              searchable: false,
              visible: false
            },
            {
              data: 'code',
              name: 'code',
              searchable: true
            },
            {
              data: 'institution.name',
              name: 'institution.name',
              searchable: true
            },
            {
              data: 'plan.name',
              name: 'plan.name',
              searchable: true
            },
            {
              data: 'description',
              name: 'description',
              searchable: true
            },

            {
              data: 'file_name',
              name: 'file_name',
              searchable: false,
              className: 'text-center',
              render (data, type, row, meta) {
                if (row?.file_name) {
                  return '<span class="badge badge-success">Yüklenmiş</span>'
                }
                return '<span class="badge badge-danger">Yüklenmemiş</span>'
              }
            },
            {
              data: '',
              width: '10%',
              render (data, type, row, meta) {
                if (row?.file_name) {
                  return '<div class="btn-group">' +
                        '<button class="btn btn-xs btn-success">Göster</button>' +
                        '<button class="btn btn-xs btn-danger">Sil</button>' +
                        '</div>'
                }
                return '<div class="btn-group">' +
                      '<button class="btn btn-xs btn-primary">Yükle</button>' +
                      '</div>'
              },
              searchable: false,
              orderable: false,
              className: 'text-center'
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
  }
}
</script>

<style scoped>

</style>
