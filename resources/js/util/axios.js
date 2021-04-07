const { default: config } = require('../config');

const sessTokenConfigName = config.session.AUTH_TOKEN_NAME
const SESSION_TOKEN = window.localStorage.getItem(sessTokenConfigName)

const axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.baseURL = document.baseURI;
window.axios.defaults.headers.common['Authorization'] = SESSION_TOKEN;

export default axios;
