<template>
  <page>
    <template #header>
      <h4>
        <span class="text-bold text-blue">Rapor</span> Taleplerini Listele
      </h4>
    </template>
    <template #content>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="row justify-content-md-center">
                <district-selector
                  v-model="selectedDistrict"
                  name="district_id"
                  class="col-md-3 mt-1"
                  :validation-required="false"
                />
                <institution-selector
                  v-model="selectedInstitution"
                  :institutions="institutions"
                  :validation-required="true"
                  class="col-md-3 mt-1"
                />
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="dataTables_wrapper dt-bootstrap4 table-responsive">
                    <table
                      id="reportTable"
                      class="table table-bordered table-hover dataTable dtr-inline"
                      role="grid"
                      style="width:100%"
                    >
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>DISTRICT_ID</th>
                          <th>PLAN_ID</th>
                          <th>CREATOR_ID</th>
                          <th>KOD</th>
                          <th>KURUM</th>
                          <th>AÇIKLAMA</th>
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
  </page>
</template>

<script>
import Page from '../../components/Page'
import DistrictSelector from '../../components/DistrictSelector'
import InstitutionSelector from '../../components/InstitutionSelector'
import { onMounted } from 'vue'
import tr from '../../utils/dataTablesTurkish'
import router from '../../router'
import { useDistrictAndInstitutionFilter } from '../../compositions/useDistrictAndInstitutionFilter'
let table = null

export default {
  name: 'ReportList',
  components: { Page, DistrictSelector, InstitutionSelector },
  setup () {
    const { institutions, selectedInstitution, selectedDistrict } = useDistrictAndInstitutionFilter(() => table?.ajax.reload(null, false))

    onMounted(() => {
      table = $('#reportTable')
        .on('preXhr.dt', (e, settings, data) => {
          // Bu event sunucuya datatable üzerinden veri gitmeden önce
          // yeni parametre eklemek için ateşleniyor
          data.district_id = selectedDistrict.value
          data.institution_id = selectedInstitution.value
          // data.institution_id = selectedInstitution.value
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
            url: '/api/v1/report-requests/table',
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
              data: 'description',
              name: 'description',
              searchable: true
            },

            {
              data: 'file_name',
              name: 'file_name',
              searchable: false,
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
                      '<button class="btn btn-xs btn-primary">İndir</button>' +
                      '<button class="btn btn-xs btn-warning">Düzenle</button>' +
                      // '<button class="btn btn-xs btn-danger">Düşür</button>' +
                      '</div>'
                }
                return '<div class="btn-group">' +
                    '<button class="btn btn-xs btn-danger">Yükle</button>' +
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
      institutions,
      selectedDistrict,
      selectedInstitution
    }
  }
}
</script>

<style scoped>

</style>
