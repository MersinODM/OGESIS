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
                  <district-selector
                    v-model="selectedDistrict"
                    :validation-required="false"
                  />
                </div>
                <div class="col-md-3 mt-1">
                  <institution-selector
                    v-model="selectedInstitution"
                    :institutions="institutions"
                    :validation-required="true"
                  />
                </div>
              </div>
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
import DistrictSelector from '../../components/DistrictSelector'
import InstitutionSelector from '../../components/InstitutionSelector'
import { onMounted, onUnmounted, ref, watch } from 'vue'
import tr from '../../utils/dataTablesTurkish'
import { useAbility } from '@casl/vue'
import { usePermissionConstants } from '../../utils/constants'
import useInstitutionApi from '../../services/useInstitutionApi'
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'
let table = null

export default {
  name: 'TeamList',
  components: { InstitutionSelector, DistrictSelector, Page },
  setup () {
    const { can, cannot } = useAbility()
    const router = useRouter()
    const { getInstitution } = useInstitutionApi()
    const { TEACHER_LIST_LEVEL_2, TEACHER_LIST_LEVEL_3 } = usePermissionConstants()
    const store = useStore()
    const selectedDistrict = ref()
    const selectedInstitution = ref()
    const institutions = ref([])

    // İl kullanıcıları için ilçe seçimi değişikliğini takip ediyoruz
    watch(selectedDistrict, async () => {
      selectedInstitution.value = null
      table?.ajax.reload(null, false)
      if (selectedDistrict.value) {
        institutions.value = await getInstitution(selectedDistrict.value)
      } else {
        institutions.value = []
      }
    })

    // Kurum id değştiyse öğretmenleri tekrar yüklüyoruz
    watch(selectedInstitution, () => {
      table?.ajax.reload(null, false)
    })

    // Kullanıcı değişimini izliyoruz eğer ilçe kullanıcısı ise
    // kullanıcının ilçesindeki okulları dolduruyoruz seçim için
    if (can(TEACHER_LIST_LEVEL_2) && cannot(TEACHER_LIST_LEVEL_3)) {
      getInstitution(store.getters['auth/user']?.institution.district_id)
        .then(res => {
          institutions.value = res
        })
    }

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

    return {
      selectedDistrict,
      selectedInstitution,
      institutions
    }
  }
}
</script>

<style scoped>

</style>
