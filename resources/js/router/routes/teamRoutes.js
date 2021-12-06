import NewTeam from '../../views/team/NewTeam'
import TeamList from '../../views/team/TeamList'

const teamRoutes = [
  {
    path: 'teams/new',
    name: 'newTeam',
    component: NewTeam
  },
  {
    path: 'teams/table',
    name: 'listTeams',
    component: TeamList
  }
]

export default teamRoutes
