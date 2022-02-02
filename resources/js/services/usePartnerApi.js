import http from '../utils/http'

export default function () {
  const createPartner = async (data) => {

  }

  const updatePartner = async (id, data) => {

  }

  const deletePartner = async (id) => {

  }

  const searchPartner = async (params) => {
    try {
      const response = await http.get('api/v1/partners/search_by', { params: params })
      return response.data
    } catch (e) {}
  }

  return {
    createPartner,
    updatePartner,
    deletePartner,
    searchPartner
  }
}
