<template />

<script>
import { useRoute, useRouter } from 'vue-router'

export default {
  name: 'ShowPlan',
  setup () {
    // const router = useRouter()
    const route = useRoute()
    console.log(route.params.planId)
  }
}
</script>

<style scoped>

</style>
