<template>
  <page>
    <template #header>
      <h4><span class="text-blue">Yeni</span> Öğretmen Kaydı</h4>
    </template>
    <template #content>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row justify-content-md-center">
                <div class="col-md-6">
                  <form @submit.prevent>
                    <div class="row justify-content-md-center">
                      <div
                        v-if="can(TEACHER_CREATE_LEVEL_3)"
                        class="form-group col-md-12"
                      >
                        <label>İlçe Seçimi</label>
                        <multiselect
                          v-model="districtId"
                          name="district_id"
                          placeholder="İlçe seçebilirsiniz"
                          no-options-text="Bu liste boş!"
                          no-result-text="Burada bişey bulamadık!"
                          :close-on-select="true"
                          :min-chars="2"
                          value-prop="id"
                          :searchable="true"
                          label="name"
                          :options="getDistricts"
                          class="form-control"
                          :class="{'is-invalid': districtEM != null}"
                        />
                        <div
                          v-if="districtEM"
                          role="alert"
                          class="invalid-feedback order-last"
                          style="display: inline-block;"
                        >
                          {{ districtEM }}
                        </div>
                      </div>
                    </div>
                    <div class="row justify-content-md-center">
                      <div
                        v-if="can(TEACHER_CREATE_LEVEL_3) || can(TEACHER_CREATE_LEVEL_2)"
                        class="form-group col-md-12"
                      >
                        <label>Kurum Seçimi</label>
                        <multiselect
                          v-model="institutionId"
                          name="institution_id"
                          placeholder="Önce ilçe seçiniz."
                          no-options-text="Bu liste boş!"
                          no-result-text="Burada bişey bulamadık!"
                          label="name"
                          value-prop="id"
                          :searchable="true"
                          :close-on-select="true"
                          :loading="false"
                          :options="institutions"
                          class="form-control"
                          :class="{'is-invalid': institutionEM != null}"
                        />
                        <div
                          v-if="institutionEM"
                          role="alert"
                          class="invalid-feedback order-last"
                          style="display: inline-block;"
                        >
                          {{ institutionEM }}
                        </div>
                      </div>
                    </div>
                    <div class="row justify-content-md-center">
                      <div class="form-group col-md-12">
                        <label>Branş Seçimi</label>
                        <multiselect
                          v-model="branchId"
                          name="branch_id"
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
                          class="form-control"
                          :class="{'is-invalid': branchEM != null}"
                          @search-change="findBranch"
                        />
                        <div
                          v-if="branchEM"
                          role="alert"
                          class="invalid-feedback order-last"
                          style="display: inline-block;"
                        >
                          {{ branchEM }}
                        </div>
                      </div>
                    </div>
                    <div class="row justify-content-md-center">
                      <div class="form-group col-md-6">
                        <label>Ad</label>
                        <input
                          v-model="firstName"
                          name="first_name"
                          type="text"
                          class="form-control"
                          :class="{'is-invalid': firstNameEM != null}"
                        >
                        <div
                          v-if="firstNameEM"
                          role="alert"
                          class="invalid-feedback order-last"
                          style="display: inline-block;"
                        >
                          {{ firstNameEM }}
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Soyad</label>
                        <input
                          v-model="lastName"
                          v-uppercase
                          name="last_name"
                          type="text"
                          class="form-control"
                          :class="{'is-invalid': lastNameEM != null}"
                        >
                        <div
                          v-if="lastNameEM"
                          role="alert"
                          class="invalid-feedback order-last"
                          style="display: inline-block;"
                        >
                          {{ lastNameEM }}
                        </div>
                      </div>
                    </div>
                    <div class="row justify-content-md-center">
                      <div class="form-group col-md-6">
                        <label>Telefon</label>
                        <input
                          v-model="phone"
                          v-maska="'(###) ###-##-##'"
                          name="phone"
                          type="text"
                          class="form-control"
                          placeholder="Başında 0 olmadan giriniz"
                          :class="{'is-invalid': phoneEM }"
                        >
                        <div
                          v-if="phoneEM"
                          role="alert"
                          class="invalid-feedback order-last"
                          style="display: inline-block;"
                        >
                          {{ phoneEM }}
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <label>E-Posta</label>
                        <input
                          v-model="email"
                          name="email"
                          type="text"
                          class="form-control"
                          :class="{'is-invalid': emailEM}"
                        >
                        <div
                          v-if="emailEM"
                          role="alert"
                          class="invalid-feedback order-last"
                          style="display: inline-block;"
                        >
                          {{ emailEM }}
                        </div>
                      </div>
                    </div>
                    <div class="row justify-content-md-center">
                      <div class="col-md-6">
                        <button
                          type="submit"
                          class="btn btn-primary btn-block btn-flat"
                          @click="save"
                        >
                          Kaydet
                        </button>
                      </div>
                    </div>
                  </form>
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
import { number, object, string } from 'yup'
import { useField, useForm } from 'vee-validate'
import Messenger from '../../utils/messenger'
import useTeacherApi from '../../services/useTeacherApi'
import useInstitutionApi from '../../services/useInstitutionApi'
import useBranchApi from '../../services/useBranchApi'
import useDistrictApi from '../../services/useDistrictApi'
import useNotifier from '../../utils/useNotifier'
import router from '../../router'
import { ResponseCodes, usePermissionConstants } from '../../utils/constants'
import { useAbility } from '@casl/vue'
import { debounce, interval, Subject } from 'rxjs'
import { ref, watch } from 'vue'

export default {
  name: 'NewTeacher',
  components: { Page, Multiselect },
  setup () {
    const { createTeacher } = useTeacherApi()
    const { getInstitution } = useInstitutionApi()
    const { searchBranch } = useBranchApi()
    const { getDistricts } = useDistrictApi()
    const notifier = useNotifier()
    const { can } = useAbility()

    const schema = object({
      first_name: string().typeError(() => 'Ad yazı tipinde olmalıdır!')
        .required(() => 'Ad bilgisi gereklidir!'),
      last_name: string().typeError(() => 'Soyad yazı tipinde olmalıdır!')
        .required(() => 'Soyad bilgisi gereklidir!'),
      phone: string().typeError(() => 'Telefon yazı tipinde olmalıdır!')
        .required(() => 'Telefon bilgisi gereklidir!'),
      email: string().typeError(() => 'E-Posta yazı tipinde olmalıdır!')
        .email(() => 'E-Posta geçerli olmalıdır!')
        .required(() => 'E-Posta bilgisi gereklidir!'),
      branch_id: number().required(() => 'Branş bilgisi seçilmelidir!'),
      institution_id: number().required(() => 'Kurum seçilmelidir!'),
      district_id: number().required(() => 'İlçe seçilmelidir!')
    })

    const { handleSubmit } = useForm({ validationSchema: schema })

    const { value: firstName, errorMessage: firstNameEM } = useField('first_name')
    const { value: lastName, errorMessage: lastNameEM } = useField('last_name')
    const { value: phone, errorMessage: phoneEM } = useField('phone')
    const { value: email, errorMessage: emailEM } = useField('email')
    const { value: branchId, errorMessage: branchEM } = useField('branch_id')
    const { value: institutionId, errorMessage: institutionEM } = useField('institution_id')
    const { value: districtId, errorMessage: districtEM } = useField('district_id')
    const branches = ref([])
    const institutions = ref([])

    const branchSubject = new Subject()
    branchSubject.pipe(debounce(() => interval(1000)))
      .subscribe(async param => {
        branches.value = await searchBranch({ content: param })
      })

    // Bu fonksiyon ui dan aldığı aranacak parametreyi subjeye geçirir
    // Subje reaktif operatörlere göre değerleri işler subscribe'a aktarır
    const findBranch = (param) => {
      if (param) {
        branchSubject.next(param)
      }
    }

    watch(districtId, async () => {
      institutions.value = await getInstitution(districtId.value)
    })

    const save = handleSubmit(async values => {
      const result = await Messenger.showPrompt('Yeni öğretmen kaydınız yapılcaktır. Onaylıyor musunuz?')
      if (result.isConfirmed) {
        const response = await createTeacher(values)
        if (response?.code === ResponseCodes.SUCCESS) {
          await notifier.success({ message: 'Öğretmen kaydı başarıyla oluşturuldu.', duration: 3200 })
          await router.push({ name: 'listTeachers' })
        } else {
          await notifier.error({ message: 'Öğretmen kaydı oluşturalamadı!.', duration: 3200 })
        }
      }
    })

    return {
      districtId,
      districtEM,
      branchId,
      branchEM,
      email,
      emailEM,
      firstName,
      firstNameEM,
      institutionId,
      institutionEM,
      lastName,
      lastNameEM,
      phone,
      phoneEM,
      branches,
      institutions,
      getDistricts,
      findBranch,
      can,
      save,
      ...usePermissionConstants()
    }
  }
}
</script>

<style scoped>

</style>
