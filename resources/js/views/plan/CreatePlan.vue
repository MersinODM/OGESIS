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
                        <div class="form-group col-md-12">
                          <label>Plan Adı</label>
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
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label>Plan Başlangıç Tarihi</label>
                          <date-picker
                            v-model="startDate"
                            mode="date"
                            name="startDate"
                            locale="tr"
                            input-format="dd.MM.yyyy"
                            style="background-color: white"
                          >
                            <template #default="{ inputValue, inputEvents }">
                              <input
                                class="form-control text-center"
                                :class="{'is-invalid': startDateEM != null}"
                                :value="inputValue"
                                v-on="inputEvents"
                              >
                            </template>
                          </date-picker>
                          <div
                            v-if="startDateEM"
                            role="alert"
                            class="invalid-feedback order-last"
                            style="display: inline-block;"
                          >
                            {{ startDateEM }}
                          </div>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Plan Bitiş Tarihi</label>
                          <date-picker
                            v-model="endDate"
                            mode="date"
                            name="endDate"
                            locale="tr"
                            input-format="dd.MM.yyyy"
                            style="background-color: white"
                          >
                            <template #default="{ inputValue, inputEvents }">
                              <input
                                class="form-control text-center"
                                :class="{'is-invalid': endDateEM != null}"
                                :value="inputValue"
                                v-on="inputEvents"
                              >
                            </template>
                          </date-picker>
                          <div
                            v-if="endDateEM"
                            role="alert"
                            class="invalid-feedback order-last"
                            style="display: inline-block;"
                          >
                            {{ endDateEM }}
                          </div>
                        </div>
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
import { DatePicker } from 'v-calendar'
import { string, date, object, ref as yupRef } from 'yup'
import { useField, useForm } from 'vee-validate'
import Messenger from '../../utils/messenger'
import PlanService from '../../services/PlanService'

export default {
  name: 'CreatePlan',
  components: { Page, DatePicker },
  setup () {
    const schema = object({
      title: string().typeError(() => 'Plan adı/başlığı yazı tipinde olmalıdır!')
        .required(() => 'Plan adı/başlığı gereklidir!'),
      startDate: date().typeError(() => 'Plan başlangıç tarihi seçilmelidir')
        .required(() => 'Plan başlangıç tarihi seçilmelidir!'),
      endDate: date().typeError(() => 'Plan bitiş tarihi seçilmelidir!')
        .required(() => 'Plan bitiş tarihi seçilmelidir!')
        .min(yupRef('startDate'), () => 'Plan tarihi başlangıç tarihinden sonra olmalıdır')
    })

    const { handleSubmit, errors } = useForm({ validationSchema: schema })

    const { value: title, errorMessage: titleEM } = useField('title')
    const { value: startDate, errorMessage: startDateEM } = useField('startDate')
    const { value: endDate, errorMessage: endDateEM } = useField('endDate')

    const save = handleSubmit(async values => {
      const result = await Messenger.showPrompt('Ayarladağınız tarih aralığında başka plan yoksa planlarınız oluşturulacaktır. Onaylıyor musunuz?')
      if (result.isConfirmed) {
        await PlanService.save({
          start_date: values.startDate,
          end_date: values.endDate,
          description: values.title
        })
      }
    })

    return {
      title,
      titleEM,
      startDate,
      startDateEM,
      endDate,
      endDateEM,
      handleSubmit,
      errors,
      save
    }
  }
}
</script>

<style scoped>

</style>
