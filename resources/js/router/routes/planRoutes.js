import CreatePlan from '../../views/plan/CreatePlan'
import PlanList from '../../views/plan/PlanList'

const planRoutes = [
  {
    path: 'plans/new',
    name: 'newPlan',
    component: CreatePlan
  },
  {
    path: 'plans/table',
    name: 'planList',
    component: PlanList
  }
]

export default planRoutes
