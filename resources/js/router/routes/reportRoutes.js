import RequestReport from '../../views/report/RequestReport'
import ReportList from '../../views/report/ReportList'

const reportRoutes = [
  {
    path: 'reports/request-report',
    name: 'requestNewReport',
    component: RequestReport
  },
  {
    path: 'reports/table',
    name: 'reportList',
    component: ReportList
  }
]

export default reportRoutes
