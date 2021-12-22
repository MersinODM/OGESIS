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
                      <district-selector
                        v-model="districtId"
                        name="district_id"
                        :validation-required="true"
                        :validation-message="districtEM"
                      />
                    </div>
                    <div class="row justify-content-md-center">
                      <institution-selector
                        v-model="institutionId"
                        name="institution_id"
                        :institutions="institutions"
                        :validation-required="true"
                        :validation-message="institutionEM"
                      />
                    </div>
                    <div class="row justify-content-md-center">
                      <branch-selector
                        v-model="branchId"
                        name="branch_id"
                        :validation-required="true"
                        :validation-message="branchEM"
                      />
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
import { number, object, string } from 'yup'
import { useField, useForm } from 'vee-validate'
import Messenger from '../../utils/messenger'
import useTeacherApi from '../../services/useTeacherApi'
import useInstitutionApi from '../../services/useInstitutionApi'
import useNotifier from '../../utils/useNotifier'
import router from '../../router'
import { ResponseCodes, usePermissionConstants } from '../../utils/constants'
import { useAbility } from '@casl/vue'
import { computed, nextTick, ref, watch } from 'vue'
import { useStore } from 'vuex'
import DistrictSelector from '../../components/DistrictSelector'
import InstitutionSelector from '../../components/InstitutionSelector'
import BranchSelector from '../../components/BranchSelector'

export default {
  name: 'NewTeacher',
  components: { BranchSelector, InstitutionSelector, DistrictSelector, Page },
  setup () {
    const notifier = useNotifier()
    const { can, cannot } = useAbility()
    const { TEACHER_LIST_LEVEL_2, TEACHER_LIST_LEVEL_3 } = usePermissionConstants()
    const store = useStore()
    const { getInstitution } = useInstitutionApi()
    const { createTeacher } = useTeacherApi()
    const user = computed(() => store.state.auth.user)
    //
    // Validasyon bilgileri
    const branchValidationMessage = 'Branş bilgisi seçilmelidir!'
    const institutionValidationMessage = 'Kurum seçilmelidir!'
    const districtValidationMessage = 'İlçe seçimi yapılmalıdır!'

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
      branch_id: number().typeError(() => branchValidationMessage)
        .required(() => branchValidationMessage),
      // Eğer ilçe yetkisi varsa kurum doğrulaması yapacağız
      ...(can(TEACHER_LIST_LEVEL_2) && {
        institution_id: number().typeError(() => institutionValidationMessage)
          .required(() => institutionValidationMessage)
      }),
      // Eğer il yetkisi varsa ilçe kurum doğrulması yapacağız
      ...(can(TEACHER_LIST_LEVEL_3) && {
        district_id: number().typeError(() => districtValidationMessage)
          .required(() => districtValidationMessage)
      })
    })

    const { handleSubmit } = useForm({ validationSchema: schema })
    // Validasyon değişken tanımlamaları
    const { value: firstName, errorMessage: firstNameEM } = useField('first_name')
    const { value: lastName, errorMessage: lastNameEM } = useField('last_name')
    const { value: phone, errorMessage: phoneEM } = useField('phone')
    const { value: email, errorMessage: emailEM } = useField('email')
    const { value: branchId, errorMessage: branchEM } = useField('branch_id')
    const { value: institutionId, errorMessage: institutionEM } = useField('institution_id')
    const { value: districtId, errorMessage: districtEM } = useField('district_id')
    const branches = ref([])
    const institutions = ref([])

    // İl kullanıcıları için ilçe seçimi değişikliğini takip ediyoruz
    watch(districtId, async () => {
      institutions.value = await getInstitution(districtId.value)
    })

    // Sayfa ilk defa açıldığında çalıştırmamız gerekiyor değilse kurumları dolduramıyoruz
    nextTick(() => {
      if (can(TEACHER_LIST_LEVEL_2) && cannot(TEACHER_LIST_LEVEL_3)) {
        getInstitution(store.getters['auth/user']?.institution.district_id)
          .then(res => {
            institutions.value = res
          })
      }
    })

    // Kullanıcı değişimini izliyoruz eğer ilçe kullanıcısı ise
    // kullanıcının ilçesindeki okulları dolduruyoruz seçim için
    watch(user, () => {
      if (can(TEACHER_LIST_LEVEL_2) && cannot(TEACHER_LIST_LEVEL_3))  {
        getInstitution(store.getters['auth/user']?.institution.district_id)
          .then(res => {
            institutions.value = res
          })
      }
    })

    // Kayıt işlemini yapalım
    const save = handleSubmit(async values => {
      const result = await Messenger.showPrompt('Yeni öğretmen kaydınız yapılcaktır. Onaylıyor musunuz?')
      if (result.isConfirmed) {
        const response = await createTeacher(values)
        if (response?.code === ResponseCodes.SUCCESS) {
          await notifier.success({ message: 'Öğretmen kaydı başarıyla oluşturuldu.', duration: 3200 })
          await router.replace({ name: 'listTeachers' })
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
      can,
      save
    }
  }
}
</script>

<style scoped>

</style>
