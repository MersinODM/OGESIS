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
                      <plan-selector
                        v-model="planId"
                        name="plan_id"
                        class="col-md-12"
                        :validation-required="true"
                        :validation-message="errors.plan_id"
                      />
                    </div>
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
                        mode="tags"
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
import { object, string, number } from 'yup'
import { useRuleDistrict, useRuleInstitution } from '../../compositions/useRules'
import { useField, useForm } from 'vee-validate'
import Messenger from '../../utils/messenger'
import { ResponseCodes } from '../../utils/constants'
import router from '../../router'
import useNotifier from '../../utils/useNotifier'
import { ref, watch } from 'vue'
import TextArea from '../../components/TextArea'
import useInstitutionApi from '../../services/useInstitutionApi'
import useReportApi from '../../services/useReportApi'
import PlanSelector from '../../components/PlanSelector'
import usePlanApi from '../../services/usePlanApi'

export default {
  name: 'RequestReport',
  components: { PlanSelector, TextArea, InstitutionSelector, DistrictSelector, Page },
  setup () {
    const notifier = useNotifier()
    const { getInstitution } = useInstitutionApi()
    const { createReportRequest } = useReportApi()
    const { getLatestPlans } = usePlanApi()

    const schema = object({
      description: string().typeError(() => 'Kısa açıklama giderilmelidir!')
        .min(8, () => 'Açıklama yeterince uzun değil!')
        .required(() => 'Açıklama gereklidir!'),
      plan_id: number().typeError(() => 'Plan seçilmelidir')
        .required(() => 'Plan seçilmelidir!'),
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
    const { value: planId } = useField('plan_id')

    const institutions = ref([])
    // İl kullanıcıları için ilçe seçimi değişikliğini takip ediyoruz
    watch(districtId, async () => {
      institutionId.value = null
      if (districtId.value) {
        institutions.value = await getInstitution(districtId.value)
        institutions.value.insert(0, { id: -1, name: 'Hepsi' })
      } else {
        institutions.value = []
      }
    })

    const save = handleSubmit(async values => {
      const result = await Messenger.showPrompt('Takım oluşturulacaktır. Onaylıyor musunuz?')
      if (result.isConfirmed) {
        const response = await createReportRequest(values)
        if (response?.code === ResponseCodes.SUCCESS) {
          await notifier.success({ message: 'Takım kaydı başarıyla oluşturuldu.', duration: 3200 })
          await router.replace({ name: 'listReports' })
        } else {
          await notifier.error({ message: 'Takım kaydı oluşturalamadı!.', duration: 3200 })
        }
      }
    })

    return {
      save,
      planId,
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
