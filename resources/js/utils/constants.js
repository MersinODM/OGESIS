/*
 *     Copyright 2021 Mersin İl Milli Eğitim Müdürlüğü Ölçme Değerlendirme Merkezi
 *
 *     Licensed under the Apache License, Version 2.0 (the "License");
 *     you may not use this file except in compliance with the License.
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
    SCREEN_SIZE: 'screenSize'
  }
}

export const useDistrictConstants = () => {
  return {
    DISTRICT_PREFIX: 'district/',
    M_CURRENT_DISTRICT: 'currentDistrict',
    M_DISTRICTS: 'allDistricts',
    A_SET_CURRENT_DISTRICT: 'setCurrentDistrict',
    A_SET_DISTRICTS: 'setDistricts'
  }
}

export const useInstitutionConstants = () => {
  return {
    INSTITUTION_PREFIX: 'institution/',
    M_CURRENT_INSTITUTION: 'currentInstitution',
    M_INSTITUTIONS: 'allInstitutions',
    A_SET_CURRENT_INSTITUTION: 'setCurrentInstitution',
    A_SET_INSTITUTIONS: 'setInstitutions',
    A_SEARCH_INSTITUTIONS: 'searchInstitutions'
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

export const usePermissionConstants = () => {
  return {
    // Öğretmen işlemleri ile ilgili yetkiler
    TEACHER_CREATE_LEVEL_3: 'teacher.create.level3',
    TEACHER_CREATE_LEVEL_2: 'teacher.create.level2',
    TEACHER_CREATE_LEVEL_1: 'teacher.create.level1',
    TEACHER_UPDATE_LEVEL_3: 'teacher.update.level3',
    TEACHER_UPDATE_LEVEL_2: 'teacher.update.level2',
    TEACHER_UPDATE_LEVEL_1: 'teacher.update.level1',
    TEACHER_DELETE_LEVEL_3: 'teacher.delete.level3',
    TEACHER_DELETE_LEVEL_2: 'teacher.delete.level2',
    TEACHER_DELETE_LEVEL_1: 'teacher.delete.level1',
    TEACHER_LIST_LEVEL_3: 'teacher.list.level3',
    TEACHER_LIST_LEVEL_2: 'teacher.list.level2',
    TEACHER_LIST_LEVEL_1: 'teacher.list.level1',
    // Takım işlmeleri ile ilgili yetkiler
    TEAM_CREATE_LEVEL_3: 'team.create.level3',
    TEAM_CREATE_LEVEL_2: 'team.create.level2',
    TEAM_CREATE_LEVEL_1: 'team.create.level1',
    TEAM_UPDATE_LEVEL_3: 'team.update.level3',
    TEAM_UPDATE_LEVEL_2: 'team.update.level2',
    TEAM_UPDATE_LEVEL_1: 'team.update.level1',
    TEAM_DELETE_LEVEL_3: 'team.delete.level3',
    TEAM_DELETE_LEVEL_2: 'team.delete.level2',
    TEAM_DELETE_LEVEL_1: 'team.delete.level1',
    TEAM_LIST_LEVEL_3: 'team.list.level3',
    TEAM_LIST_LEVEL_2: 'team.list.level2',
    TEAM_LIST_LEVEL_1: 'team.list.level1',
    TEAM_ADD_MEMBER_LEVEL_3: 'team.add-member.level3',
    TEAM_ADD_MEMBER_LEVEL_2: 'team.add-member.level2',
    TEAM_ADD_MEMBER_LEVEL_1: 'team.add-member.level1',
    TEAM_REMOVE_MEMBER_LEVEL_3: 'team.remove-member.level3',
    TEAM_REMOVE_MEMBER_LEVEL_2: 'team.remove-member.level2',
    TEAM_REMOVE_MEMBER_LEVEL_1: 'team.remove-member.level1',
    // Kurum izinleri
    INSTITUTION_CREATE_LEVEL_3: 'institution.create.level3',
    INSTITUTION_CREATE_LEVEL_2: 'institution.create.level2',
    INSTITUTION_UPDATE_LEVEL_3: 'institution.update.level3',
    INSTITUTION_UPDATE_LEVEL_2: 'institution.update.level2',
    INSTITUTION_DELETE_LEVEL_3: 'institution.delete.level3',
    INSTITUTION_DELETE_LEVEL_2: 'institution.delete.level2',
    INSTITUTION_IMPORT_LIST: 'institution.import-list',
    INSTITUTION_LIST_LEVEL_3: 'institution.list.level3',
    INSTITUTION_LIST_LEVEL_2: 'institution.list.level2',
    // Plan izinleri
    PLAN_CREATE_LEVEL_3: 'plan.create.level3',
    PLAN_UPDATE_LEVEL_3: 'plan.update.level3',
    PLAN_DELETE_LEVEL_3: 'plan.delete.level3',
    // Aktivite izinleri
    ACTIVITY_CREATE_LEVEL_3: 'activity.create.level3',
    ACTIVITY_CREATE_LEVEL_2: 'activity.create.level2',
    ACTIVITY_CREATE_LEVEL_1: 'activity.create.level1',
    ACTIVITY_UPDATE_LEVEL_3: 'activity.update.level3',
    ACTIVITY_UPDATE_LEVEL_2: 'activity.update.level2',
    ACTIVITY_UPDATE_LEVEL_1: 'activity.update.level1',
    ACTIVITY_DELETE_LEVEL_3: 'activity.delete.level3',
    ACTIVITY_DELETE_LEVEL_2: 'activity.delete.level2',
    ACTIVITY_DELETE_LEVEL_1: 'activity.delete.level1',
    ACTIVITY_LIST_LEVEL_3: 'activity.list.level3',
    ACTIVITY_LIST_LEVEL_2: 'activity.list.level2',
    ACTIVITY_LIST_LEVEL_1: 'activity.list.level1',
    // Rapor yetkileri
    REPORT_UPLOAD: 'report.upload',
    REPORT_DELETE_LEVEL_3: 'report.delete.level3',
    REPORT_DELETE_LEVEL_2: 'report.delete.level2',
    REPORT_DELETE_LEVEL_1: 'report.delete.level1',
    REPORT_LIST_LEVEL_3: 'report.list.level3',
    REPORT_LIST_LEVEL_2: 'report.list.level2',
    REPORT_LIST_LEVEL_1: 'report.list.level1'
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
