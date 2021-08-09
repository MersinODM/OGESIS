<template>
  <div class="card text-justify">
    <div class="card-body">
      <a
        rel="license"
        href="https://www.apache.org/licenses/LICENSE-2.0"
      >
        <img
          alt="Apache Software License"
          style="border-width:0; height:1.5em"
          :src="feather"
        >
      </a> Bu eser özgür ve açık kaynak kod yazılım lisanslarıdan olan <a
        rel="license"
        href="https://www.apache.org/licenses/LICENSE-2.0"
      >
        Apache Lisansı v2.0</a> ile lisanslanmıştır.
      <a
        class="btn btn-block btn-secondary"
        href="https://github.com/MersinODM/LimonODS"
      >
        <i class="mdi mdi-github" /> GitHub
      </a>
    </div>
  </div>
</template>

<script>

import feather from '../../images/svg/feather.svg'

export default {
  name: 'LicenceInfo',
  setup () {
    return {
      feather
    }
  }
}
</script>

<style scoped>

</style>
