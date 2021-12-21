<template>
  <page>
    <template #header>
      <h4>
        <span class="text-bold text-blue">Yeni</span> Takım
      </h4>
    </template>
    <template #content>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="row justify-content-md-center">
                <div class="col-md-6">
                  <form @submit.prevent>
                    <div class="form-group has-feedback">
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label>İlçe Seçimi</label>
                          <multiselect
                            v-model="selectedTeachers"
                            :options="teachers"
                            label="full_name"
                            name="teachers"
                            mode="tags"
                            track-by="id"
                            value-prop="id"
                            placeholder="Öğretmen seçimi yapabilirsiniz."
                            no-options-text="Bu liste boş!"
                            no-result-text="Burada bişey bulamadık!"
                            class="form-control h-auto"
                            :class="{'is-invalid': teachersEM != null}"
                          >
                            <template #option="{ option }">
                              {{ option.full_name }} - {{ option.branch.name }}
                            </template>
                            <template #tag="{ option, handleTagRemove, disabled }">
                              <span class="multiselect-tag">
                                {{ option.full_name }} - {{ option.branch.name }}
                                <span
                                  v-if="!disabled"
                                  class="multiselect-tag-remove"
                                  @mousedown.prevent="handleTagRemove(option, $event)"
                                >
                                  <span class="multiselect-tag-remove-icon" />
                                </span>
                              </span>
                            </template>
                          </multiselect>
                          <div
                            v-if="teachersEM"
                            role="alert"
                            class="invalid-feedback order-last"
                            style="display: inline-block;"
                          >
                            {{ teachersEM }}
                          </div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label>Takım Seçimi</label>
                          <multiselect
                            v-model="selectedTeachers"
                            :options="teachers"
                            label="full_name"
                            name="teachers"
                            mode="tags"
                            track-by="id"
                            value-prop="id"
                            placeholder="Öğretmen seçimi yapabilirsiniz."
                            no-options-text="Bu liste boş!"
                            no-result-text="Burada bişey bulamadık!"
                            class="form-control h-auto"
                            :class="{'is-invalid': teachersEM != null}"
                          >
                            <template #option="{ option }">
                              {{ option.full_name }} - {{ option.branch.name }}
                            </template>
                            <template #tag="{ option, handleTagRemove, disabled }">
                              <span class="multiselect-tag">
                                {{ option.full_name }} - {{ option.branch.name }}
                                <span
                                  v-if="!disabled"
                                  class="multiselect-tag-remove"
                                  @mousedown.prevent="handleTagRemove(option, $event)"
                                >
                                  <span class="multiselect-tag-remove-icon" />
                                </span>
                              </span>
                            </template>
                          </multiselect>
                          <div
                            v-if="teachersEM"
                            role="alert"
                            class="invalid-feedback order-last"
                            style="display: inline-block;"
                          >
                            {{ teachersEM }}
                          </div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label>Takım Adı</label>
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
                        <div class="form-group col-md-12">
                          <label>Takım Seçimi</label>
                          <multiselect
                            v-model="selectedTeachers"
                            :options="teachers"
                            label="full_name"
                            name="teachers"
                            mode="tags"
                            track-by="id"
                            value-prop="id"
                            placeholder="Öğretmen seçimi yapabilirsiniz."
                            no-options-text="Bu liste boş!"
                            no-result-text="Burada bişey bulamadık!"
                            class="form-control h-auto"
                            :class="{'is-invalid': teachersEM != null}"
                          >
                            <template #option="{ option }">
                              {{ option.full_name }} - {{ option.branch.name }}
                            </template>
                            <template #tag="{ option, handleTagRemove, disabled }">
                              <span class="multiselect-tag">
                                {{ option.full_name }} - {{ option.branch.name }}
                                <span
                                  v-if="!disabled"
                                  class="multiselect-tag-remove"
                                  @mousedown.prevent="handleTagRemove(option, $event)"
                                >
                                  <span class="multiselect-tag-remove-icon" />
                                </span>
                              </span>
                            </template>
                          </multiselect>
                          <div
                            v-if="teachersEM"
                            role="alert"
                            class="invalid-feedback order-last"
                            style="display: inline-block;"
                          >
                            {{ teachersEM }}
                          </div>
                        </div>
                      </div>
                      <div class="form-row justify-content-md-center mt-3">
                        <div class="form-group col-md-6">
                          <button
                            class="btn btn-primary btn-block"
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
import Multiselect from '@vueform/multiselect'
import { object, array, string } from 'yup'
import { useField, useForm } from 'vee-validate'
import Messenger from '../../utils/messenger'
import useTeacherApi from '../../services/useTeacherApi'
import { ref } from 'vue'
import useTeamApi from '../../services/useTeamApi'

export default {
  name: 'NewTeam',
  components: { Page, Multiselect },
  setup () {
    const TEAM_VALIDATION_EM = 'Öğretmen seçimi yapılmalıdır!'
    const { getTeachers } = useTeacherApi()
    const { createTeam } = useTeamApi()

    const schema = object({
      title: string().typeError(() => 'Takım adı yazı tipinde olmalıdır!')
        .min(2, () => 'En az 2 karakter uzunluğunda olmalıdır!')
        .required(() => 'Takım adı gereklidir!'),
      teachers: array().typeError(() => TEAM_VALIDATION_EM)
        .min(2, () => 'En az iki öğretmen seçilmelidir')
        .required(() => TEAM_VALIDATION_EM)
    })

    const { handleSubmit } = useForm({ validationSchema: schema })

    const { value: title, errorMessage: titleEM } = useField('title')
    const { value: selectedTeachers, errorMessage: teachersEM } = useField('teachers')
    const teachers = ref()
    // getTeachers().then(values => { teachers.value = values })

    const save = handleSubmit(async values => {
      const result = await Messenger.showPrompt('Takım oluşturulacaktır. Onaylıyor musunuz?')
      if (result.isConfirmed) {
        await createTeam(values)
      }
    })

    return {
      save,
      title,
      titleEM,
      selectedTeachers,
      teachersEM,
      teachers
    }
  }
}
</script>

<style scoped>

</style>
