import NewTeacher from '../../views/teacher/NewTeacher'
import TeacherList from '../../views/teacher/TeacherList'

const teacherRoute = [
  {
    path: 'teachers/new',
    name: 'newTeacher',
    component: NewTeacher
  },
  {
    path: 'teachers/table',
    name: 'listTeachers',
    component: TeacherList
  }
]

export default teacherRoute
