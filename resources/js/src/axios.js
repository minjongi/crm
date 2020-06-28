// axios
import axios from 'axios'

const baseURL = ''

// export default axios.create({
const axs = axios.create({
  baseURL,
  headers: {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
  }
})

axios.interceptors.response.use(function (response) {
  return response;
}, function (error) {
  if (error.response.status === 403) {
    location.replace('/pages/login')
  }
  return Promise.reject(error);
})

export default axs
