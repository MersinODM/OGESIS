<template>
  <li
    class="nav-item"
    :class="{'menu-open': isMenuExtended && hasChildren}"
  >
    <a
      class="nav-link"
      :class="{'active': isMainActive || isOneOfChildrenActive}"
      @click="handleMainMenuAction"
    >
      <i class="nav-icon fas fa-tachometer-alt" />
      <p>{{ menuItem.name }}</p>
      <i
        v-if="isExpandable"
        class="right fas fa-angle-left"
      />
    </a>
    <ul
      v-if="hasChildren"
      class="nav nav-treeview"
    >
      <template v-for="item in menuItem.children">
        <menu-item
          :menu-item="item"
        />
      </template>
    </ul>
  </li>
</template>

<script>

import { computed, onMounted, ref } from 'vue'
import router from '../router'

export default {
  name: 'MenuItem',
  props: {
    menuItem: {
      type: Object,
      required: false,
      default: null
    },
    icon: String,
    type: String,
    placeholder: String,
    autocomplete: String
  },
  setup: function (props) {
    const menuItem = props.menuItem
    const isMenuExtended = ref(false)
    const isExpandable = ref(false)
    const isMainActive = ref(false)
    const isOneOfChildrenActive = ref(false)

    onMounted(() => {
      isExpandable.value =
          menuItem &&
          menuItem.children &&
          menuItem.children.length > 0
      calculateIsActive(router.currentRoute.value.name)
      router.afterEach((to) => {
        calculateIsActive(to.name)
      })
    })

    const handleMainMenuAction = () => {
      if (isExpandable.value) {
        toggleMenu()
        return
      }
      router.replace({ name: menuItem.routeName })
    }

    const toggleMenu = () => {
      isMenuExtended.value = !isMenuExtended.value
    }

    const calculateIsActive = (name) => {
      isMainActive.value = false
      isOneOfChildrenActive.value = false
      if (isExpandable.value) {
        menuItem.children.forEach((item) => {
          if (item.routeName === name) {
            isOneOfChildrenActive.value = true
            isMenuExtended.value = true
          }
        })
      } else if (menuItem.routeName === name) {
        isMainActive.value = true
      }
      if (!isMainActive.value && !isOneOfChildrenActive.value) {
        isMenuExtended.value = false
      }
    }

    const hasChildren = computed(() => {
      const { children } = menuItem
      return children && children.length > 0
    })

    return {
      toggleMenu,
      handleMainMenuAction,
      isExpandable,
      isMenuExtended,
      isMainActive,
      isOneOfChildrenActive,
      hasChildren
    }
  }
}
</script>

<style scoped>
.nav-item {
  cursor: pointer;
}
</style>
