import axios from 'axios';

let base = window.location.origin + '/api';
console.log(base);
export const getActivityList = params => { return axios.get(`${base}/activitylist`, { params: params }); };
