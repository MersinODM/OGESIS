<template>
  <page>
    <template #header>
      <h4>Giriş</h4>
    </template>
    <template #content>
      <div class="row">
        <div class="col-md-3">
          <theme-selector v-model="selectedVal" />
        </div>
      </div>
    </template>
  </page>
</template>

<script>
import Page from '../../components/Page'
import { inject, ref } from 'vue'
import ThemeSelector from '../../components/ThemeSelector'

export default {
  name: 'Start',
  components: { ThemeSelector, Page },
  setup (props) {
    return {
      selectedVal: ref()
    }
  }
}
</script>

<style >

</style>
