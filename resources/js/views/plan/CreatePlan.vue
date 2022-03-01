<template>
  <page>
    <template #header>
      <h4><span class="text-blue">Yeni</span> Plan(Tüm Okullar İçin)</h4>
    </template>
    <template #content>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row justify-content-md-center">
                <div class="col-md-6">
                  <form @submit.prevent>
                    <div class="form-group has-feedback">
                      <div class="form-row">
                        <text-box
                          v-model="name"
                          label="Plan Başlığı"
                          name="name"
                          class="col-md-12"
                          :validation-message="errors.name"
                          :validation-required="true"
                        />
                      </div>
                      <div class="form-row">
                        <date-picker
                          v-model="startDate"
                          name="start_date"
                          label="Plan Başlangıç Tarihi"
                          class="col-md-6"
                          :validation-required="true"
                          :validation-message="errors.start_date"
                        />
                        <date-picker
                          v-model="endDate"
                          name="end_date"
                          label="Plan Bitiş Tarihi"
                          class="col-md-6"
                          :validation-required="true"
                          :validation-message="errors.end_date"
                        />
                      </div>
                      <div class="form-row">
                        <text-area
                          v-model="description"
                          name="description"
                          class="col-md-12"
                          label="Açıklamalar"
                          :validation-required="true"
                          :validation-message="errors.description"
                        />
                      </div>
                      <div class="form-row justify-content-md-center">
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
import DatePicker from '../../components/ODatePicker'
import { string, date, object, ref as yupRef } from 'yup'
import { useField, useForm } from 'vee-validate'
import Messenger from '../../utils/messenger'
import usePlanApi from '../../services/usePlanApi'
import TextBox from '../../components/TextBox'
import TextArea from '../../components/TextArea'

export default {
  name: 'CreatePlan',
  components: { TextArea, TextBox, Page, DatePicker },
  setup () {
    const { create } = usePlanApi()
    const schema = object({
      name: string().typeError(() => 'Plan adı/başlığı yazı tipinde olmalıdır!')
        .required(() => 'Plan adı/başlığı gereklidir!'),
      start_date: date().typeError(() => 'Plan başlangıç tarihi seçilmelidir')
        .required(() => 'Plan başlangıç tarihi seçilmelidir!'),
      end_date: date().typeError(() => 'Plan bitiş tarihi seçilmelidir!')
        .required(() => 'Plan bitiş tarihi seçilmelidir!')
        .min(yupRef('start_date'), () => 'Plan tarihi başlangıç tarihinden sonra olmalıdır'),
      description: string().required(() => 'Açıklama gereklidir!')
    })

    const { handleSubmit, errors } = useForm({ validationSchema: schema })

    const { value: name } = useField('name')
    const { value: startDate } = useField('start_date')
    const { value: endDate } = useField('end_date')
    const { value: description } = useField('description')

    const save = handleSubmit(async values => {
      const result = await Messenger.showPrompt('Ayarladağınız tarih aralığında başka plan yoksa planlarınız oluşturulacaktır. Onaylıyor musunuz?')
      if (result.isConfirmed) {
        await create(values)
      }
    })

    return {
      name,
      startDate,
      endDate,
      description,
      errors,
      save
    }
  }
}
</script>

<style scoped>

</style>
