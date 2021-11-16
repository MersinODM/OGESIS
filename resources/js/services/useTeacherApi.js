import http from '../utils/http'

export default function () {
  const createTeacher = async (data) => {
    try {
      const response = await http.post('api/v1/teachers', data)
      return response.data
    } catch (e) {}
  }

  const updateTeacher = async (id, data) => {
    try {
      const response = await http.put(`api/v1/teachers/${id}`, data)
      return response.data
    } catch (e) {}
  }

  const removeTeacher = async (id) => {
    try {
      const response = await http.delete(`api/v1/teachers/${id}`)
      return response.data
    } catch (e) {}
  }

  return {
    createTeacher,
    updateTeacher,
    removeTeacher
  }
}
