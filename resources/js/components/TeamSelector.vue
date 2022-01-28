<template />

<script>
import ValidationError from './ValidationError'
import Multiselect from '@vueform/multiselect'

export default {
  name: 'TeamSelector',
  components: { ValidationError, Multiselect },
  props: {
    modelValue: {
      type: Number,
      default: null
    },
    validationMessage: {
      type: String,
      default: null,
      required: false
    },
    validationRequired: {
      type: Boolean,
      default: false
    },
    teachers: {
      type: Array,
      default: () => ([])
    },
    name: {
      type: String,
      default: ''
    }
  }
}
</script>

<style scoped>

</style>
