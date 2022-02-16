import CreatePlan from '../../views/plan/CreatePlan'
import PlanList from '../../views/plan/PlanList'
import ShowPlan from '../../views/plan/ShowPlan'

const planRoutes = [
  {
    path: 'plans/new',
    name: 'newPlan',
    component: CreatePlan
  },
  {
    path: 'plans/:planId',
    name: 'newPlan',
    component: ShowPlan
  },
  {
    path: 'plans/table',
    name: 'planList',
    component: PlanList
  }
]

export default planRoutes
