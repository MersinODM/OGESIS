import CreatePlan from '../../views/plan/CreatePlan'
import PlanList from '../../views/plan/PlanList'
import ActivityList from '../../views/activity/ActivityList'

const planRoutes = [
  {
    path: 'plans/new',
    name: 'newPlan',
    component: CreatePlan
  },
  {
    path: 'plans/:planId/activities',
    name: 'activityList',
    component: ActivityList
  },
  {
    path: 'plans/table',
    name: 'planList',
    component: PlanList
  }
]

export default planRoutes
