<template>
  <div>
    <button
      type="submit"
      :class="['btn', $attrs['btn-class']]"
      @click="click"
    >
      <slot />
    </button>
  </div>
</template>

<script>
export default {
  // eslint-disable-next-line vue/multi-word-component-names
  name: 'Buttonow', // Buton soyundan demek
  // inheritAttrs: false,
  setup (props, { emit }) {
    const click = (event) => {
      emit('click', event)
    }
    return {
      click
    }
  }
}
</script>

<style scoped>

</style>
