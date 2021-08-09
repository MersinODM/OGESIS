<template>
  <div class="error-page">
    <h2 class="headline text-yellow">
      404
    </h2>

    <div class="error-content">
      <h3><i class="fa fa-warning text-yellow" /> Üzgünüz aradığınız sayfa bulunamadı!</h3>

      <p>
        Aradığınız sayfayı bulamadık :-(
        Belki <router-link :to="{name:''}">
          anasayfaya
        </router-link> dönmek isteyebilirsiniz.
      </p>
    </div>
    <!-- /.error-content -->
  </div>
</template>

<script>
export default {
  name: 'NotFound'
}
</script>

<style>

</style>
