import http from '../utils/http'

const PlanService = {
  findById: async (id) => {
    try {
      const response = await http.get(`api/v1/plans/${id}`)
      return response.data
    } catch (e) {}
  },
  save: async (data) => {
    try {
      const response = await http.post('api/v1/plans', data)
      return response.data
    } catch (e) {}
  }
}

export default PlanService
