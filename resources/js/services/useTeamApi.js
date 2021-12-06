import http from '../utils/http'

export default function () {
  const createTeam = async (data) => {
    try {
      const response = await http.post('api/v1/teams', data)
      return response.data
    } catch (e) {}
  }

  const updateTeam = async (id, data) => {
    try {
      const response = await http.put(`api/v1/teams/${id}`, data)
      return response.data
    } catch (e) {}
  }

  const removeTeam = async (id) => {
    try {
      const response = await http.delete(`api/v1/teams/${id}`)
      return response.data
    } catch (e) {}
  }

  const getTeams = async () => {
    try {
      const response = await http.get('api/v1/teams')
      return response.data
    } catch (e) {}
  }

  return {
    createTeam,
    updateTeam,
    removeTeam,
    getTeams
  }
}
