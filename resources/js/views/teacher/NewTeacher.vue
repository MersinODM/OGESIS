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
                          v-model="branchId"
                          name="branch_id"
                          placeholder="Branş seçimi yapabilirsiniz"
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
                          :options="searchInstitution"
                        />
                      </div>
                    </div>
                    <div class="row justify-content-md-center">
                      <div class="form-group col-md-12">
                        <label>Branş Seçimi</label>
                        <multiselect
                          v-model="selectedDistrict"
                          :options="districts"
                          label="name"
                          value-prop="id"
                        />
                      </div>
                    </div>
                    <div class="row justify-content-md-center">
                      <div class="form-group col-md-6">
                        <label>Ad</label>
                        <input
                          v-model="title"
                          name="title"
                          type="text"
                          class="form-control"
                          :class="{'is-invalid': titleEM != null}"
                        >
                        <div
                          v-if="titleEM"
                          role="alert"
                          class="invalid-feedback order-last"
                          style="display: inline-block;"
                        >
                          {{ titleEM }}
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Soyad</label>
                        <input
                          v-model="title"
                          name="title"
                          type="text"
                          class="form-control"
                          :class="{'is-invalid': titleEM != null}"
                        >
                        <div
                          v-if="titleEM"
                          role="alert"
                          class="invalid-feedback order-last"
                          style="display: inline-block;"
                        >
                          {{ titleEM }}
                        </div>
                      </div>
                    </div>
                    <div class="row justify-content-md-center">
                      <div class="form-group col-md-6">
                        <label>Telefon</label>
                        <input
                          v-model="title"
                          name="title"
                          type="text"
                          class="form-control"
                          :class="{'is-invalid': titleEM != null}"
                        >
                        <div
                          v-if="titleEM"
                          role="alert"
                          class="invalid-feedback order-last"
                          style="display: inline-block;"
                        >
                          {{ titleEM }}
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <label>E-Posta</label>
                        <input
                          v-model="title"
                          name="title"
                          type="text"
                          class="form-control"
                          :class="{'is-invalid': titleEM != null}"
                        >
                        <div
                          v-if="titleEM"
                          role="alert"
                          class="invalid-feedback order-last"
                          style="display: inline-block;"
                        >
                          {{ titleEM }}
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

export default {
  name: 'NewTeacher',
  components: { Page, Multiselect },
  setup () {
    const { createTeacher } = useTeacherApi()
    const { searchInstitution } = useInstitutionApi()

    const schema = object({
      firstName: string().typeError(() => 'Ad yazı tipinde olmalıdır!')
        .required(() => 'Ad bilgisi gereklidir!'),
      lastName: string().typeError(() => 'Soyad yazı tipinde olmalıdır!')
        .required(() => 'Soyad bilgisi gereklidir!'),
      phone: string().typeError(() => 'Telefon yazı tipinde olmalıdır!')
        .required(() => 'Telefon bilgisi gereklidir!'),
      branch_id: number().typeError(() => 'Branş sayı tipinde olmalıdır!')
        .required(() => 'Branş bilgisi seçilmelidir!'),
      institution_id: number().typeError(() => 'Branş sayı tipinde olmalıdır!')
        .required(() => 'Branş bilgisi seçilmelidir!')
    })

    const { handleSubmit } = useForm({ validationSchema: schema })

    const { value: firstName, errorMessage: firstNameEM } = useField('first_name')
    const { value: lastName, errorMessage: lastNameEM } = useField('last_name')
    const { value: phone, errorMessage: phoneEM } = useField('phone')
    const { value: branchId, errorMessage: branchEM } = useField('branch_id')
    const { value: institutionId, errorMessage: institutionEM } = useField('institution_id')

    const save = handleSubmit(async values => {
      const result = await Messenger.showPrompt('Yeni öğretmen kaydınız yapılcaktır. Onaylıyor musunuz?')
      if (result.isConfirmed) {
        await createTeacher(values)
      }
    })

    return {
      branchId,
      branchEM,
      firstName,
      firstNameEM,
      institutionId,
      institutionEM,
      lastName,
      lastNameEM,
      phone,
      phoneEM,
      searchInstitution
    }
  }
}
</script>

<style scoped>

</style>
