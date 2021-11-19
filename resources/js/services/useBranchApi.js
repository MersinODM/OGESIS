import http from '../utils/http'

export default function () {
  const createBranch = async (data) => {

  }

  const updateBranch = async (id, data) => {

  }

  const deleteBranch = async (id) => {

  }

  const searchBranch = async (param) => {
    try {
      const response = await http.get('api/v1/branches/search_by', { params: { param: param } })
      return response.data
    } catch (e) {}
  }

  return {
    createBranch,
    updateBranch,
    deleteBranch,
    searchBranch
  }
}
