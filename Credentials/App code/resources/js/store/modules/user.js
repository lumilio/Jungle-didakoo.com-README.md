import axios from "axios";
export default {
  namespaced: true,
  state: {
    userData: null
  },
  getters: {
    user: state => state.userData
  },
  mutations: {
    setUserData(state, user) {
      state.userData = user;
    }
  },
  actions: {
    getUserData({ commit }) {
      axios
        .get("user")
        .then(response => {
          commit("setUserData", response.data);
        })
        .catch(() => {
          localStorage.removeItem("authToken");
        });
    },
    sendLoginRequest({ commit }, data) {
      commit("setErrors", {}, { root: true });
      return axios
        .post("/api/login", data)
        .then(response => {
          commit("setUserData", response.data.data.user);
          localStorage.setItem("authToken", response.data.data.token);
        });
    },
    sendMetamaskLoginRequest({ commit }, data) {
      commit("setErrors", {}, { root: true });
      return axios
        .post("/api/login-web3", data)
        .then(response => {
          commit("setUserData", response.data.data.address);
          localStorage.setItem("authToken", response.data.data.token);
        });
    },
    sendRegisterRequest({ commit }, data) {
      commit("setErrors", {}, { root: true });
      return axios
        .post("/api/register", data)
        .then(response => {
          commit("setUserData", response.data.data.user);
          localStorage.setItem("authToken", response.data.data.token);
        });
    },
    sendLogoutRequest({ commit }) {
      axios.post("logout").then(() => {
        commit("setUserData", null);
        localStorage.removeItem("authToken");
      });
    },
    sendVerifyResendRequest() {
      return axios.get("email/resend");
    },
    sendVerifyRequest({ dispatch }, hash) {
      return axios
        .get("email/verify/" + hash)
        .then(() => {
          dispatch("getUserData");
        });
    }
  }
};
