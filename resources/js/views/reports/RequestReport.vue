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
                      <branch-selector
                        v-model="branchId"
                        name="branch_id"
                        class="col-md-12"
                        :validation-required="true"
                        :validation-message="errors.branch_id"
                      />
                    </div>
                    <div class="row justify-content-md-center">
                      <text-box
                        v-model="firstName"
                        :validation-required="true"
                        :validation-message="errors.first_name"
                        class="col-md-6"
                        label="Ad"
                        name="first_name"
                      />
                      <text-box
                        v-model="lastName"
                        :validation-required="true"
                        :validation-message="errors.last_name"
                        :uppercase="true"
                        class="col-md-6"
                        label="Soyad"
                        name="last_name"
                      />
                    </div>
                    <div class="row justify-content-md-center">
                      <text-box
                        v-model="phone"
                        :validation-required="true"
                        :validation-message="errors.phone"
                        :mask="'### ### ## ##'"
                        class="col-md-6"
                        label="Telefon"
                        name="phone"
                      />
                      <text-box
                        v-model="email"
                        :validation-required="true"
                        :validation-message="errors.email"
                        class="col-md-6"
                        name="email"
                        label="E-Posta"
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
import TextBox from '../../components/TextBox'
import BranchSelector from '../../components/BranchSelector'
import InstitutionSelector from '../../components/InstitutionSelector'
import DistrictSelector from '../../components/DistrictSelector'
import Page from '../../components/Page'

export default {
  name: 'RequestReport',
  components: { TextBox, BranchSelector, InstitutionSelector, DistrictSelector, Page },
  setup () {

  }
}
</script>

<style scoped>

</style>
