<template>
  <page>
    <template #header>
      <h4>
        <span class="text-bold text-blue">{{ plan.title }}</span> Aktiviteleri Tablosu
      </h4>
    </template>
    <template #content>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              Görünüm Seç
            </div>
            <div class="card-body">

            </div>
          </div>
        </div>
      </div>
    </template>
  </page>
</template>
<script>

import Page from '../../components/Page'

export default {
  // eslint-disable-next-line vue/multi-word-component-names
  name: 'Activities',
  components: { Page },
  setup () {

  }
}
</script>

<style scoped>

</style>
