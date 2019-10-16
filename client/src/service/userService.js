import axios from 'axios'
const API_URL = 'http://api.local/index.php'
axios.defaults.headers.patch['Content-Type'] = 'application/x-www-form-urlencoded';
const qs = require('qs');

export default {
  register (data) {
    return axios.post(`${API_URL}/register`, data)
      .then(response => {
        return response.data
      })
  },
  login (data) {
    return axios.post(`${API_URL}/login`, data)
      .then(response => {
        return response.data
      })
  },
  getTopics (token) {
    const formData = new FormData();
    formData.append('token', formData);
    return axios.get(`${API_URL}/topic?token=${token}`)
      .then(response => {
        return response.data
      })
  },
  addTopic (data) {
    return axios.post(`${API_URL}/topic`, data)
      .then(response => {
        return response.data
      })
  },
  updateTopic (id, data) {

    return axios.post(`${API_URL}/topic/${id}`, data)
      .then(response => {
        return response.data
      })
  },
  deleteTopic(id, data) {
    return axios.post(`${API_URL}/topic/${id}/delete`, data)
      .then(response => {
        return response.data
      })
  }
}
