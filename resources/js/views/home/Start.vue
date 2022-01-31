<template>
  <page>
    <template #header>
      <h4>Giriş</h4>
    </template>
    <template #content>
      <div class="row justify-content-md-center">
        <div class="col-md-8">
          <add-activity />
        </div>
      </div>
    </template>
  </page>
</template>

<script>
import Page from '../../components/Page'
import { ref } from 'vue'
import AddActivity from '../../components/activities/AddActivity'

export default {
  name: 'Start',
  components: { AddActivity, Page },
  setup (props) {
    return {
      selectedVal: ref()
    }
  }
}
</script>

<style >

</style>
