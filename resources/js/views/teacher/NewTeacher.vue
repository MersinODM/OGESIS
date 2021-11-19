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
                      <div class="form-group col-md-12">
                        <label>Kurum Seçimi</label>
                        <multiselect
                          v-model="institutionId"
                          name="institution_id"
                          placeholder="Kurum aramak için yazınız."
                          no-options-text="Bu liste boş!"
                          no-result-text="Burada bişey bulamadık!"
                          :close-on-select="true"
                          :filterResults="false"
                          :min-chars="2"
                          :resolve-on-load="false"
                          value-prop="id"
                          :delay="300"
                          :searchable="true"
                          label="name"
                          :options="searchInstitution"
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
                          placeholder="Branş aramak için yazınız."
                          no-options-text="Bu liste boş!"
                          no-result-text="Burada bişey bulamadık!"
                          :close-on-select="true"
                          :filterResults="false"
                          :min-chars="2"
                          :resolve-on-load="false"
                          value-prop="id"
                          :delay="300"
                          :searchable="true"
                          label="name"
                          track-by="id"
                          :options="searchBranch"
                          class="form-control"
                          :class="{'is-invalid': branchEM != null}"
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
import useNotifier from "../../utils/useNotifier";
import router from "../../router";
import {ResponseCodes} from "../../utils/constants";

export default {
  name: 'NewTeacher',
  components: { Page, Multiselect },
  setup () {
    const { createTeacher } = useTeacherApi()
    const { searchInstitution } = useInstitutionApi()
    const { searchBranch } = useBranchApi()
    const notifier = useNotifier()

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
      branch_id: number().typeError(() => 'Branş sayı tipinde olmalıdır!')
        .required(() => 'Branş bilgisi seçilmelidir!'),
      institution_id: number().typeError(() => 'Branş sayı tipinde olmalıdır!')
        .required(() => 'Branş bilgisi seçilmelidir!')
    })

    const { handleSubmit } = useForm({ validationSchema: schema })

    const { value: firstName, errorMessage: firstNameEM } = useField('first_name')
    const { value: lastName, errorMessage: lastNameEM } = useField('last_name')
    const { value: phone, errorMessage: phoneEM } = useField('phone')
    const { value: email, errorMessage: emailEM } = useField('email')
    const { value: branchId, errorMessage: branchEM } = useField('branch_id')
    const { value: institutionId, errorMessage: institutionEM } = useField('institution_id')

    const save = handleSubmit(async values => {
      const result = await Messenger.showPrompt('Yeni öğretmen kaydınız yapılcaktır. Onaylıyor musunuz?')
      if (result.isConfirmed) {
        const response = await createTeacher(values)
        if (response?.code === ResponseCodes.SUCCESS) {
          await notifier.success({ message: 'Öğretmen kaydı başarıyla oluşturuldu.', duration: 3000 })
          await router.push({ name: 'listTeachers' })
        } else {
          await notifier.error({ message: 'Öğretmen kaydı oluşturalamadı!.', duration: 3000 })
        }
      }
    })

    return {
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
      searchInstitution,
      searchBranch,
      save
    }
  }
}
</script>

<style scoped>

</style>
