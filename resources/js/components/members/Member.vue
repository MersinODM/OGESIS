<template>
  <div>
    <member-avatar />
  </div>
</template>

<script>
import MemberAvatar from './MemberAvatar'

export default {
  // eslint-disable-next-line vue/multi-word-component-names
  name: 'Member',
  components: { MemberAvatar }

}
</script>

<style scoped>
div {
  background-color: #11eff6;
  border-radius: 25em;
  color: #000;
  cursor: pointer;
  display: block;
  float: left;
  height: 32px;
  margin: 0 4px 4px 0;
  overflow: visible;
  position: relative;
  text-decoration: none;
  -webkit-user-select: none;
  user-select: none;
  width: 32px;
  z-index: 0;
}
</style>
