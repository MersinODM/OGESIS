import http from '../utils/http'

export default function () {
  const findById = async (id) => {
    try {
      const response = await http.get(`api/v1/plans/${id}`)
      return response.data
    } catch (e) {}
  }
  const create = async (data) => {
    try {
      const response = await http.post('api/v1/plans', data)
      return response.data
    } catch (e) {}
  }

  const getLastPlans = async (count = 10) => {
    try {
      const response = await http.get(`api/v1/plans/latest/${count}`)
      return response.data
    } catch (e) { }
  }

  return {
    findById,
    create,
    getLastPlans
  }
}
