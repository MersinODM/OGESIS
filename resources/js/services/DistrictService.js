import http from '../utils/http'

const DistrictService = {
  getDistricts: async () => {
    try {
      const response = await http.get('/api/v1/districts')
      return response.data
    } catch (e) { }
  }
}

export default DistrictService
