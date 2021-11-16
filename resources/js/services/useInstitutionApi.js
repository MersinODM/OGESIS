import http from '../utils/http'

export default function () {
  const createInstitution = async (data) => {

  }

  const updateInstitution = async (id, data) => {

  }

  const deleteInstitution = async (id) => {

  }

  const searchInstitution = async (param) => {
    try {
      const response = await http.get('api/v1/institutions/search_by', { params: { param: param } })
      return response.data
    } catch (e) {}
  }

  return {
    createInstitution,
    updateInstitution,
    deleteInstitution,
    searchInstitution
  }
}
