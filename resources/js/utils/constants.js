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

const MessengerConstants = {
  errorMessage: 'Üzgünüz, bir hata ile karşılaştık lütfen sistem yöneticinize başvurunuz!'
}

const MessageKeys = {
  MESSAGE: 'message',
  CODE: 'code'
}

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
    M_CURRENT_DISTRICT: 'currentDistrict',
    M_DISTRICTS: 'allDistricts',
    A_SET_CURRENT_DISTRICT: 'setCurrentDistrict',
    A_SET_DISTRICTS: 'setDistricts'
  }
}

export const useInstitutionConstants = () => {
  return {
    M_CURRENT_INSTITUTION: 'currentInstitution',
    M_INSTITUTIONS: 'allInstitutions',
    A_SET_CURRENT_INSTITUTION: 'setCurrentInstitution',
    A_SET_INSTITUTIONS: 'setInstitutions',
    A_SEARCH_INSTITUTIONS: 'searchInstitutions'
  }
}

export const useBranchConstants = () => {
  return {
    M_CURRENT_BRANCH: 'currentBranch',
    M_BRANCHES: 'allBranches',
    A_SET_CURRENT_BRANCH: 'setCurrentBranch',
    A_SET_BRANCHES: 'setBranches',
    A_SEARCH_BRANCH: 'searchBranch'
  }
}

export {
  MessengerConstants,
  ResponseCodes,
  MessageKeys,
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
