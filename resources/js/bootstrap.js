import axios from 'axios';
import url from 'url';
import queryString from 'query-string';
window.axios = axios;
window.url = url;
window.queryString = queryString;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
