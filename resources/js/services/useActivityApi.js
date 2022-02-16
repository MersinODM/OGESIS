import http from '../utils/http'

export default function () {
  const createActivity = async (data) => {
    try {
      const response = await http.post('api/v1/activities', data)
      return response.data
    } catch (e) {}
  }

  const updateActivity = async (id, data) => {
    try {
      const response = await http.put(`api/v1/activities/${id}`, data)
      return response.data
    } catch (e) {}
  }

  const removeActivity = async (id) => {
    try {
      const response = await http.delete(`api/v1/activities/${id}`)
      return response.data
    } catch (e) {}
  }

  const getActivities = async (districtId, institutionId) => {
    // try {
    //     const response = await http.get(`api/v1/districts/${districtId}/institutions/${institutionId}/activities`)
    //     return response.data
    // } catch (e) {}
  }

  return {
    createActivity,
    updateActivity,
    removeActivity,
    getActivities
  }
}
