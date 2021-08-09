<template>
  <section class="content">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-1">
          <div class="col-md-12">
            <slot name="header" />
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <div class="container-fluid">
      <slot name="content" />
    </div>
  </section>
</template>

<script>
export default {
  name: 'Page'
}
</script>

<style scoped>

</style>
