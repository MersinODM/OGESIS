import http from '../utils/http'

export default function () {
  const createTheme = async (data) => {
    try {
      const response = await http.post('api/v1/Themes', data)
      return response.data
    } catch (e) {}
  }

  const updateTheme = async (id, data) => {
    try {
      const response = await http.put(`api/v1/themes/${id}`, data)
      return response.data
    } catch (e) {}
  }

  const removeTheme = async (id) => {
    try {
      const response = await http.delete(`api/v1/themes/${id}`)
      return response.data
    } catch (e) {}
  }

  const getThemes = async () => {
    try {
      const response = await http.get('api/v1/themes')
      return response.data
    } catch (e) {}
  }

  return {
    createTheme,
    updateTheme,
    removeTheme,
    getThemes
  }
}
