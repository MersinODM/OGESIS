import http from '../utils/http'

export default function () {
  const createReportRequest = async (data) => {
    try {
      const response = await http.post('api/v1/report-requests', data)
      return response.data
    } catch (e) {}
  }

  const updateReportRequest = async (id, data) => {

  }

  const deleteReportRequest = async (id) => {

  }

  const searchReportRequest = async (params) => {
    try {
      const response = await http.get('api/v1/report-requests/search_by', { params: params })
      return response.data
    } catch (e) {}
  }

  const getReportRequest = async (districtId, institutionId) => {
    try {
      const response = await http.get(`api/v1/districts/${districtId}/institutions/${institutionId}/reports-requests`)
      return response.data
    } catch (e) {}
  }

  return {
    createReportRequest,
    updateReportRequest,
    deleteReportRequest,
    searchReportRequest,
    getReportRequest
  }
}
