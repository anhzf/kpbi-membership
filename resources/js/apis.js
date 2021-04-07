import axios from './util/axios';

export const userApi = {
  getById(id) {
    return axios.get(`/api/user/${id}`);
  },
  sendPasswordResetEmail: axios.post.bind(null, '/api/forgot-password'),
}

export const kpbiApi = {
  getById(id) {
    return axios.get(`/api/kpbi/profile/${id}`);
  },
  getAccountByProfileId(id) {
    return axios.get(`/api/kpbi/profile-account/${id}`);
  },
};
