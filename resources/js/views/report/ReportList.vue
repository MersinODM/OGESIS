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
                <plan-selector
                  v-model="selectedPlan"
                  :validation-required="false"
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
                          <th>PLAN</th>
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
import { onMounted, ref, watch, computed } from 'vue'
import tr from '../../utils/dataTablesTurkish'
import router from '../../router'
import { useDistrictAndInstitutionFilter } from '../../compositions/useDistrictAndInstitutionFilter'
import PlanSelector from '../../components/selectors/PlanSelector'
import { useStore } from 'vuex'
let table = null

export default {
  name: 'ReportList',
  components: { PlanSelector, Page },
  setup () {
    // const { institutions, selectedInstitution, selectedDistrict } = useDistrictAndInstitutionFilter(() => table?.ajax.reload(null, false))

    const store = useStore()
    const selectedDistrict = computed(() => store.getters['district/selectedDistrict'])
    const selectedInstitution = computed(() => store.getters['institution/selectedInstitution'])
    const selectedPlan = ref()

    watch(selectedPlan, () => {
      table?.ajax.reload(null, false)
    })

    // İl kullanıcıları için ilçe seçimi değişikliğini takip ediyoruz
    watch(selectedDistrict, async () => {
      table?.ajax.reload(null, false)
    })

    // Kurum id değştiyse öğretmenleri tekrar yüklüyoruz
    watch(selectedInstitution, () => {
      table?.ajax.reload(null, false)
    })

    onMounted(() => {
      table = $('#reportTable')
        .on('preXhr.dt', (e, settings, data) => {
          // Bu event sunucuya datatable üzerinden veri gitmeden önce
          // yeni parametre eklemek için ateşleniyor
          data.district_id = selectedDistrict.value
          data.institution_id = selectedInstitution.value
          data.plan_id = selectedPlan.value
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

    return {
      selectedPlan
    }
  }
}
</script>

<style scoped>

</style>
