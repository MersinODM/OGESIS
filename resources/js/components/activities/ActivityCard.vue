<template>
  <div class="card">
    <div class="card-header">
      <h5 class="card-title">
        {{ activity.title }}
      </h5>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <p class="card-text">
            {{ activity.description }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ActivityCard',
  setup () {

  }
}
</script>

<style scoped>

</style>
