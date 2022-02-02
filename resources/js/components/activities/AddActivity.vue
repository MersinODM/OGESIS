<template>
  <form @submit.prevent>
    <div class="form-row">
      <plan-selector
        v-model="selectedPlan"
        class="col-md-12"
        :validation-required="true"
        :validation-message="errors.plan"
      />
    </div>
    <div class="form-row">
      <district-selector
        v-model="selectedDistrict"
        class="col-md-12"
        :validation-required="true"
        :validation-message="errors.district_id"
      />
    </div>
    <div class="form-row">
      <institution-selector
        v-model="selectedInstitution"
        class="col-md-12"
        :validation-required="true"
        :validation-message="errors.institution_id"
      />
    </div>
    <div class="form-row">
      <theme-selector
        v-model="selectedTheme"
        class="col-md-12"
        label="Açıklama"
        :validation-required="true"
        :validation-message="errors.theme_id"
      />
    </div>
    <div class="form-row">
      <partner-selector
        v-model="selectedPartners"
        class="col-md-12"
        :validation-required="false"
      />
    </div>
    <div class="form-row">
      <text-box
        v-model="title"
        class="col-md-12"
        label="Etkinlik Başlığı"
        :validation-required="true"
        :validation-message="errors.title"
      />
    </div>
    <div class="form-row">
      <text-area
        v-model="description"
        label="Açıklama"
        class="col-md-12"
        :validation-required="true"
        :validation-message="errors.description"
      />
    </div>
    <div class="form-row">
      <div class="col-md-12">
        <radio-group>
          <radio-button>Aktif</radio-button>
          <radio-button>Aktif</radio-button>
          <radio-button>Aktif</radio-button>
        </radio-group>
      </div>
<!--      <div class="col-md-6">-->
<!--        <button class="btn btn-primary btn-block">Öğretmen Seç</button>-->
<!--      </div>-->
<!--      <div class="col-md-6">-->
<!--        <button class="btn btn-primary btn-block">Takım Seç</button>-->
<!--      </div>-->
    </div>
    <div class="form-row">
      <div class="col-md-6">
        <date-picker
          v-model="plannedStartDate"
          label="Planlanan Başlangıç Tarihi"
          :validation-required="true"
          :validation-message="errors.planned_start_date"
        />
      </div>
      <div class="col-md-6">
        <date-picker
          v-model="plannedEndDate"
          label="Planlanan Bitiş Tarihi"
          :validation-required="true"
          :validation-message="errors.planned_end_date"
        />
      </div>
    </div>
  </form>
</template>
<script>

import PlanSelector from '../PlanSelector'
import DistrictSelector from '../DistrictSelector'
import InstitutionSelector from '../InstitutionSelector'
import ThemeSelector from '../ThemeSelector'
import TextBox from '../TextBox'
import TextArea from '../TextArea'
import DatePicker from '../ODatePicker'
import PartnerSelector from '../PartnerSelector'
import Toggle from '@vueform/toggle'
import { ref } from 'vue'
import RadioGroup from "../buttons/RadioGroup";
import RadioButton from "../buttons/RadioButton";

export default {
  name: 'AddActivity',
  components: {
    RadioButton,
    RadioGroup,
    PartnerSelector,
    TextArea,
    TextBox,
    InstitutionSelector,
    DistrictSelector,
    PlanSelector,
    ThemeSelector,
    DatePicker,
    Toggle
  },
  setup () {
    const selection = ref(false)
    return {
      title: '',
      selectedPlan: '',
      selectedDistrict: '',
      selectedInstitution: '',
      selectedTheme: '',
      errors: [],
      selection
    }
  }
}
</script>

<style scoped>

</style>
