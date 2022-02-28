/*
 *     Copyright 2021 Mersin İl Milli Eğitim Müdürlüğü Ölçme Değerlendirme Merkezi
 *
 *     Licensed under the Apache License, Version 2.0 (the "License");
 *     you may not use subjects file except in compliance with the License.
 *     You may obtain a copy of the License at
 *
 *       http://www.apache.org/licenses/LICENSE-2.0
 *
 *     Unless required by applicable law or agreed to in writing, software
 *     distributed under the License is distributed on an "AS IS" BASIS,
 *     WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *     See the License for the specific language governing permissions and
 *     limitations under the License.
 *
 */
const Constants = {
  CURRENT_USER: 'current_user',
  ACCESS_TOKEN: 'access_token',
  PERMISSIONS: 'permissions',
  ROLES: 'roles',
  EXPIRES_IN: 'expires_in',
  GENERAL_INFO: 'general_info'
}

const ResponseCodes = {
  SUCCESS: 1000,
  UNAUTHORIZED: 1001,
  NOT_FOUND: 1002,
  INFO: 1003,
  WARNING: 1004,
  ERROR: 1005
}

// const MessengerConstants = {
//   errorMessage: 'Üzgünüz, bir hata ile karşılaştık lütfen sistem yöneticinize başvurunuz!'
// }
//
// const MessageKeys = {
//   MESSAGE: 'message',
//   CODE: 'code'
// }

// A prefix i vuex'te actionları M prefix i vuex'te Mutationları ifade eder

export const useUIMutationConstants = () => {
  return {
    DARK_MODE: 'darkMode',
    IS_SIDE_BAR_MENU_COLLAPSED: 'isSidebarMenuCollapsed',
    SCREEN_SIZE: 'screenSize',
    SET_CRUD: 'setCrud'
  }
}

export const useBehaviorConstants = () => {
  return {
    INIT: 'init',
    SET_CRUD: 'setCrud'
  }
}

export const useDistrictConstants = () => {
  return {
    DISTRICT: 'district/',
    DISTRICTS: 'districts',
    SELECT_DISTRICT: 'selectDistrict',
    SET_SELECTED_DISTRICT: 'setSelectedDistrict',
    SET_DISTRICTS: 'setDistricts'
  }
}

export const useInstitutionConstants = () => {
  return {
    INIT: 'init',
    INSTITUTION: 'institution/',
    INSTITUTIONS: 'institutions',
    SELECTED_INSTITUTION: 'selectedInstitution',
    SET_INSTITUTIONS: 'setInstitutions',
    SET_SELECTED_INSTITUTION: 'setSelectedInstitution'
  }
}

export const useBranchConstants = () => {
  return {
    BRANCH_PREFIX: 'branch/',
    M_CURRENT_BRANCH: 'currentBranch',
    M_BRANCHES: 'allBranches',
    A_SET_CURRENT_BRANCH: 'setCurrentBranch',
    A_SET_BRANCHES: 'setBranches',
    A_SEARCH_BRANCH: 'searchBranch'
  }
}

export const useAuthMutationTypes = () => {
  return {
    AUTH: 'auth/',
    SET_USER: 'setUser',
    REMOVE_USER: 'removeUser'
  }
}

export const useAuthActionTypes = () => {
  return {
    AUTH: 'auth/',
    LOGIN: 'login',
    LOGOUT: 'logout',
    GET_ME: 'getMe'
  }
}

export const useModalMutationTypes = () => {
  return {
    MODAL: 'modal/',
    CURRENT_COMPONENT: 'currentComponent',
    IS_SHOW: 'isShow',
    TITLE: 'title'
  }
}

export const useModalActionTypes = () => {
  return {
    MODAL: 'modal/',
    SHOW: 'show',
    CLOSE: 'close'
  }
}

export const usePlanConstants = () => {
  return {
    PLAN: 'plan/',
    INIT: 'init',
    SET_SELECTED: 'setSelected',
    SET_PLAN_LIST: 'setPlanList',
    CLEAR_SELECTED: 'clearSelected'
  }
}

export const usePlanActionTypes = () => {
  return {
    PLAN: 'plan/',
    SET: 'set',
    CLEAR: 'clear'
  }
}

// TODO Object.freeze() implemantasyonu yapılabilir
export const usePermissionConstants = () => {
  const subjects = {
    CREATE: 'create',
    DELETE: 'delete',
    UPDATE: 'update',
    LIST: 'list',
    SHOW: 'show',
    UPLOAD: 'upload',

    TEACHER: 'teacher',
    BRANCH: 'branch',
    TEAM: 'team',
    INSTITUTION: 'institution',
    PLAN: 'plan',
    ACTIVITY: 'activity',
    REPORT: 'report',
    THEME: 'theme',
    DISTRICT: 'district',
    PARTNER: 'partner',
    PERSONAL: 'personal'
  }
  return {
    ALL: '*',
    LEVEL_3: 'level.3',
    LEVEL_2: 'level.2',
    LEVEL_1: 'level.1',

    ...subjects,

    TEACHER_CREATE: `${subjects.TEACHER}.${subjects.CREATE}`,
    TEACHER_UPDATE: subjects.TEACHER + '.' + subjects.UPDATE,
    TEACHER_DELETE: subjects.TEACHER + '.' + subjects.DELETE,
    TEACHER_LIST: subjects.TEACHER + '.' + subjects.LIST,
    TEACHER_SHOW: subjects.TEACHER + '.' + subjects.SHOW,
    TEACHER_UPLOAD: subjects.TEACHER + '.' + subjects.UPLOAD,

    BRANCH_CREATE: subjects.BRANCH + '.' + subjects.CREATE,
    BRANCH_UPDATE: subjects.BRANCH + '.' + subjects.UPDATE,
    BRANCH_DELETE: subjects.BRANCH + '.' + subjects.DELETE,
    BRANCH_LIST: subjects.BRANCH + '.' + subjects.LIST,

    TEAM_CREATE: subjects.TEAM + '.' + subjects.CREATE,
    TEAM_UPDATE: subjects.TEAM + '.' + subjects.UPDATE,
    TEAM_DELETE: subjects.TEAM + '.' + subjects.DELETE,
    TEAM_LIST: subjects.TEAM + '.' + subjects.LIST,

    INSTITUTION_CREATE: subjects.INSTITUTION + '.' + subjects.CREATE,
    INSTITUTION_UPDATE: subjects.INSTITUTION + '.' + subjects.UPDATE,
    INSTITUTION_DELETE: subjects.INSTITUTION + '.' + subjects.DELETE,
    INSTITUTION_LIST: subjects.INSTITUTION + '.' + subjects.LIST,
    INSTITUTION_UPLOAD: subjects.INSTITUTION + '.' + subjects.UPLOAD,

    PLAN_CREATE: subjects.PLAN + '.' + subjects.CREATE,
    PLAN_UPDATE: subjects.PLAN + '.' + subjects.UPDATE,
    PLAN_DELETE: subjects.PLAN + '.' + subjects.DELETE,
    PLAN_LIST: subjects.PLAN + '.' + subjects.LIST,

    ACTIVITY_CREATE: subjects.ACTIVITY + '.' + subjects.CREATE,
    ACTIVITY_UPDATE: subjects.ACTIVITY + '.' + subjects.UPDATE,
    ACTIVITY_DELETE: subjects.ACTIVITY + '.' + subjects.DELETE,
    ACTIVITY_LIST: subjects.ACTIVITY + '.' + subjects.LIST,

    REPORT_CREATE: subjects.REPORT + '.' + subjects.CREATE,
    REPORT_UPDATE: subjects.REPORT + '.' + subjects.UPDATE,
    REPORT_DELETE: subjects.REPORT + '.' + subjects.DELETE,
    REPORT_LIST: subjects.REPORT + '.' + subjects.LIST,

    THEME_CREATE: subjects.THEME + '.' + subjects.CREATE,
    THEME_UPDATE: subjects.THEME + '.' + subjects.UPDATE,
    THEME_DELETE: subjects.THEME + '.' + subjects.DELETE,
    THEME_LIST: subjects.THEME + '.' + subjects.LIST,

    DISTRICT_CREATE: subjects.DISTRICT + '.' + subjects.CREATE,
    DISTRICT_UPDATE: subjects.DISTRICT + '.' + subjects.UPDATE,
    DISTRICT_DELETE: subjects.DISTRICT + '.' + subjects.DELETE, // Burada soft delete olabilir
    DISTRICT_LIST: subjects.DISTRICT + '.' + subjects.LIST,

    PARTNER_CREATE: subjects.PARTNER + '.' + subjects.CREATE,
    PARTNER_UPDATE: subjects.PARTNER + '.' + subjects.UPDATE,
    PARTNER_DELETE: subjects.PARTNER + '.' + subjects.DELETE,
    PARTNER_LIST: subjects.PARTNER + '.' + subjects.LIST,

    PERSONAL_PASSWORD_CHANGE: subjects.PERSONAL + '.password_change',
    PERSONAL_UPDATE: subjects.PERSONAL + '.' + subjects.UPDATE

  }
}

export {
  // MessengerConstants,
  ResponseCodes,
  // MessageKeys,
  // Permissions
  Constants
}

export default function () {
  const CONSTANTS = {
    DARK_MODE: 'ui/darkMode',
    SCREEN_SIZE: 'ui/screenSize',
    IS_SIDE_BAR_MENU_COLLAPSED: 'ui/isSidebarMenuCollapsed',
    STATUS: 'store/status',
    DISTRICT: 'store/district',
    DISTRICTS: 'store/districts',
    EXAM_TYPE: 'store/examType',
    EXAM_TITLE: 'store/examTitle',
    EXAM_START_DATE: 'store/examStartDate',
    EXAM_END_DATE: 'store/examEndDate',
    EXAM_LEVEL: 'store/examLevel',
    EXAM_DESCRIPTION: 'store/examDescription',
    EXAM_LESSONS: 'store/examLessons',
    EXAM_QUESTIONS: 'store/examQuestions',
    PREVIEW_QUESTION: 'store/previewQuestion',
    PREVIEW_CURRICULUMS: 'store/previewCurriculums',
    EVENT_CLOSE_MODAL: 'closeModal',
    EVENT_MODAL_CLOSED: 'modalClosed',
    EVENT_OPEN_MODAL: 'openModal',
    EVENT_LESSON_ADDED_TO_EXAM: 'lessonAddedToExam',
    EVENT_LEVEL_CHANGED: 'levelChanged',
    EVENT_MODAL_OPENED: 'modalOpened',
    EVENT_QUESTION_REMOVED_FROM_EXAM: 'questionRemovedFromExam',
    MODAL_CURRICULUM: 'curriculumModal',
    MODAL_QUESTION: 'questionModal'
  }

  return {
    ...CONSTANTS
  }
}
