import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import '../../vendor/wire-elements/pro/resources/js/overlay-component.js'
