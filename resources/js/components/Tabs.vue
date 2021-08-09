<template>
  <div class="card card-primary card-outline card-outline-tabs">
    <div class="card-header p-0 border-bottom-0">
      <ul class="nav nav-tabs">
        <li
          v-for="tab in tabs"
          :key="tab.props.title"
          class="nav-item"
        >
          <a
            class="nav-link"
            :class="tab.props.title === selectedIndex && 'active'"
            href="#"
            @click.prevent="changeTab(tab.props.title, 0)"
          >
            {{ tab.props.title }}
          </a>
        </li>
      </ul>
      <div class="card-body">
        <div class="tab-content">
          <slot />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import {
  onBeforeMount,
  onMounted,
  onBeforeUpdate,
  provide,
  reactive,
  toRefs
} from 'vue'

const isTab = (node) => node.type.name === 'Tab'
const isFragment = (node) =>
  typeof node.type === 'symbol' && node.type.description === 'Fragment'
const hasTabs = (node) =>
  node.children && node.children.length && node.children.some(isTab)
const isTabParent = (node) => isFragment(node) && hasTabs(node)

export default {
  name: 'Tabs',
  setup (_, { slots }) {
    const state = reactive({
      selectedIndex: null,
      tabs: [],
      count: 0,
      selectedId: 0
    })

    provide('TabsProvider', state)

    // const state = inject('TabsProvider')
    const selectTab = (i) => {
      state.selectedIndex = i
    }

    const changeTab = (title, id) => {
      localStorage.setItem('tabIndex', id)
      state.selectedIndex = title
    }

    const update = () => {
      if (slots.default) {
        state.tabs = slots
          .default()
          .filter((node) => isTab(node) || isTabParent(node))
          .flatMap((node) => (isTabParent(node) ? node.children : node))
      }
    }

    onBeforeMount(() => update())
    onBeforeUpdate(() => update())

    onMounted(() => {
      selectTab(state.tabs[0].props.title)
      localStorage.setItem('tabIndex', '0')
    })
    return { ...toRefs(state), selectTab, changeTab }
  }
}
</script>

<style scoped>

</style>
