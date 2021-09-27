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
                          v-model="selectedDistrict"
                          :options="districts"
                          label="name"
                          value-prop="id"
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

export default {
  name: 'NewTeacher',
  components: { Page, Multiselect },
  setup () {

  }
}
</script>

<style scoped>

</style>
