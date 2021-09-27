import { reactive, computed, readonly } from 'vue'
// import now from '../helpers/dayjs'

import constants from '../utils/constants'
import DistrictService from '../services/DistrictService'
const { DISTRICT, DISTRICTS } = constants()

const state = reactive({
  district: null,
  districts: []
})

const setCurrentDistrict = (lesson) => {
  sessionStorage.setItem(DISTRICT, JSON.stringify(lesson))
  state.lesson = lesson
}

const setDistricts = async (districts = null) => {
  // if (districts) {
  districts = await DistrictService.getDistricts()
  // }
  state.districts.splice(0, state.districts.length)
  await districts.every((district) => state.districts.push(district))
  await sessionStorage.setItem(DISTRICTS, JSON.stringify(state.districts))
}

const lesson = computed(() => {
  if (!state.lesson) { state.lesson = JSON.parse(sessionStorage.getItem(DISTRICT)) }
  return state.lesson
})

const store = readonly({
  state: state,
  actions: {
    setCurrentDistrict,
    setDistricts
  },
  getters: {
    lesson,
    lessons: state.districts
  }
})

export default function () {
  return store
}
