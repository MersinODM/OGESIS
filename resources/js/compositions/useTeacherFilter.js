import { computed, watch } from 'vue'
import { useAbility } from '@casl/vue'
import { usePermissionConstants } from '../utils/constants'
import store from '../store'
import useTeacherApi from '../services/useTeacherApi'

export function useTeacherFilter () {
  const teachers = computed(() => store.getters['teacher/teachers'])

  return {
    teachers
  }
}
