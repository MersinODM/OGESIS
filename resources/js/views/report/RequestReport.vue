<template>
  <page>
    <template #header>
      <h4><span class="text-blue">Yeni</span> Rapor Talebi</h4>
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
                        class="col-md-12"
                        :add-all-choice="true"
                        :validation-required="true"
                        :validation-message="errors.district_id"
                      />
                    </div>
                    <div class="row justify-content-md-center">
                      <institution-selector
                        v-model="institutionId"
                        name="institution_id"
                        class="col-md-12"
                        :institutions="institutions"
                        :validation-required="true"
                        :validation-message="errors.institution_id"
                      />
                    </div>
                    <div class="row justify-content-md-center">
                      <text-area
                        v-model="description"
                        :validation-required="true"
                        :validation-message="errors.description"
                        class="col-md-12"
                        label="Açıklama"
                        name="description"
                      />
                    </div>
                    <div class="row justify-content-md-center">
                      <div class="col-md-6">
                        <button
                          type="submit"
                          class="btn btn-primary btn-block"
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
import InstitutionSelector from '../../components/InstitutionSelector'
import DistrictSelector from '../../components/DistrictSelector'
import Page from '../../components/Page'
import { object, string } from 'yup'
import { useRuleDistrict, useRuleInstitution } from '../../compositions/useRules'
import { useField, useForm } from 'vee-validate'
import Messenger from '../../utils/messenger'
import { ResponseCodes } from '../../utils/constants'
import router from '../../router'
import useNotifier from '../../utils/useNotifier'
import { ref, watch } from 'vue'
import TextArea from '../../components/TextArea'
import useInstitutionApi from '../../services/useInstitutionApi'

export default {
  name: 'RequestReport',
  components: { TextArea, InstitutionSelector, DistrictSelector, Page },
  setup () {
    const notifier = useNotifier()
    const { getInstitution } = useInstitutionApi()

    const schema = object({
      description: string().typeError(() => 'Kısa açıklama giderilmelidir!')
        .min(8, () => 'Açıklama yeterince uzun değil!')
        .required(() => 'Açıklama gereklidir!'),
      // Eğer ilçe yetkisi varsa kurum doğrulaması yapacağız
      ...useRuleInstitution(),
      // Eğer il yetkisi varsa ilçe kurum doğrulması yapacağız
      ...useRuleDistrict()
    })

    // Bu fonksiyonu çağırma sırası önemli
    const { handleSubmit, errors } = useForm({ validationSchema: schema })

    const { value: description } = useField('description')
    const { value: institutionId } = useField('institution_id')
    const { value: districtId } = useField('district_id')

    const institutions = ref([])

    // İl kullanıcıları için ilçe seçimi değişikliğini takip ediyoruz
    watch(districtId, async () => {
      institutionId.value = null
      if (districtId.value) {
        institutions.value = await getInstitution(districtId.value)
      } else {
        institutions.value = []
      }
    })

    const save = handleSubmit(async values => {
      const result = await Messenger.showPrompt('Takım oluşturulacaktır. Onaylıyor musunuz?')
      if (result.isConfirmed) {
        const response = null // await createTeam(values)
        if (response?.code === ResponseCodes.SUCCESS) {
          await notifier.success({ message: 'Takım kaydı başarıyla oluşturuldu.', duration: 3200 })
          await router.replace({ name: 'listTeams' })
        } else {
          await notifier.error({ message: 'Takım kaydı oluşturalamadı!.', duration: 3200 })
        }
      }
    })

    return {
      save,
      districtId,
      institutionId,
      description,
      institutions,
      errors
    }
  }
}
</script>

<style scoped>

</style>
