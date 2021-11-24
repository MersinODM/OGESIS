import http from '../utils/http'

export default function () {
  const createDistrict = async (data) => {

  }

  const updateDistrict = async (id, data) => {

  }

  const deleteDistrict = async (id) => {

  }

  const getDistricts = async (param) => {
    try {
      const response = await http.get('/api/v1/districts')
      return response.data
    } catch (e) {}
  }

  return {
    createDistrict,
    updateDistrict,
    deleteDistrict,
    getDistricts
  }
}
