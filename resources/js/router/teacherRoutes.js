import NewTeacher from '../views/teacher/NewTeacher'
import UnderConstruction from '../views/utils/UnderConstruction'

const teacherRoute = [
  {
    path: 'teachers/new',
    name: 'newTeacher',
    component: NewTeacher
  },
  {
    path: 'teachers/table',
    name: 'listTeachers',
    component: UnderConstruction
  }
]

export default teacherRoute
