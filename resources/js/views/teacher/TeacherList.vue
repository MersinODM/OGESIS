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
                  <district-selector
                    v-model="selectedDistrict"
                    :validation-required="false"
                  />
                </div>
                <div class="col-md-3 mt-1">
                  <institution-selector
                    v-model="selectedInstitution"
                    :validation-required="true"
                  />
                </div>
                <div class="col-md-3 mt-1">
                  <branch-selector
                    v-model="selectedBranch"
                    :validation-required="false"
                  />
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
import { onMounted, ref, watch, onUnmounted } from 'vue'
import tr from '../../utils/dataTablesTurkish'
import router from '../../router'

import InstitutionSelector from '../../components/selectors/InstitutionSelector'
import BranchSelector from '../../components/selectors/BranchSelector'
import DistrictSelector from '../../components/selectors/DistrictSelector'

import { useDistrictAndInstitutionFilter } from '../../compositions/useDistrictAndInstitutionFilter'

let table = null

export default {
  name: 'TeacherList',
  components: { BranchSelector, InstitutionSelector, Page, DistrictSelector },
  setup: function () {
    const { selectedInstitution, selectedDistrict } = useDistrictAndInstitutionFilter()
    const selectedBranch = ref()

    const unwatch = watch(([selectedDistrict, selectedInstitution, selectedBranch]), () => {
      table?.ajax?.reload(false, null)
    })

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

    onUnmounted(() => unwatch())

    return {
      selectedDistrict,
      selectedInstitution,
      selectedBranch
    }
  }
}
</script>

<style scoped>

</style>
