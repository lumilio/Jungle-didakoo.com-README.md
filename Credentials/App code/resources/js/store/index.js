import Vue from "vue";
import Vuex from "vuex";
Vue.use(Vuex);
const store = new Vuex.Store({
  state: {
    user: localStorage.getItem('user') ?? null,
    address: localStorage.getItem('address') ?? null,
    playerNumber: localStorage.getItem('playerNumber') ?? null,
    turn: "white",
    turnNumber: 1,
    squares: [],
    movesHistory: [
      {
        black: {},
        white: {},
      },
    ],
    svg: null,
    errors: [],
    userData: localStorage.getItem('userData')
      ? JSON.parse(localStorage.getItem('userData'))
      : {},
    connectWallet: false,
    lastActivityLogged: null,
    playersList: localStorage.getItem('playersList')
      ? JSON.parse(localStorage.getItem('playersList'))
      : [],
    playersListLastFetched: localStorage.getItem('playersListLastFetched')
      ? parseInt(localStorage.getItem('playersListLastFetched'))
      : null
  },

  getters: {
    errors: state => state.errors
  },

  mutations: {
    CHANGE_TURN(state, val) {
      state.turn = val;
    },
    PUSH_MOVES_HISTORY(state, val) {
      state.movesHistory.push(val);
    },
    RESET_MOVES_HISTORY(state) {
      state.movesHistory = [
        {
          black: {},
          white: {},
        },
      ];
    },
    LOG_IN_USER(state, val) {
        localStorage.setItem('user', val)
        state.user = val;
    },
    SET_USER_ADDRESS(state, val) {
      localStorage.setItem('address', val)
      state.address = val;
    },
    SET_PLAYER_NUMBER(state, val) {
        localStorage.setItem('playerNumber', val);
        state.playerNumber = val
    },
    SET_USER_DATA(state, UsersData) {
      localStorage.setItem('userData', JSON.stringify(UsersData))
      state.userData = UsersData;
    },
    LOG_OUT_USER (state){
        localStorage.removeItem('address')
        localStorage.removeItem('user')
        state.user = null;
        state.address = null;
    },
    TOGGLE_WALLET_MODAL(state) {
      state.connectWallet = !state.connectWallet;
  },
    ADD_MOVE_HISTORY(state, move) {
      let lastMove = state.movesHistory[state.movesHistory.length - 1];
      if (Object.keys(lastMove[move.color]).length) {
        lastMove = {
          black: {},
          white: {},
        };
        state.movesHistory.push(lastMove);
      }

      lastMove[move.color] = move;
    },
    setErrors(state, errors) {
      state.errors = errors;
    },
    SET_LAST_LOGGED_ACTIVITY(state, lastActivityLogged) {
      state.lastActivityLogged = lastActivityLogged
    },
    SET_PLAYERS_LIST(state, playersList) {
      localStorage.setItem('playersList', JSON.stringify(playersList));
      state.playersList = playersList
    },
    SET_PLAYERS_LIST_LAST_FETCHED(state, date) {
      localStorage.setItem('playersListLastFetched', date);
      state.playersListLastFetched = date
    }
  },
  actions: {
    makemove({commit}, data){
      return axios
        .post("/api/makemove", data)
        .then(response => {
          console.log("response", response.data);
        });
      },
    test({commint}, data)
    {
      return axios
        .post("/api/test", data)
        .then(response => {
          console.log("response", response.data);
        });

    }
  },
})
export default store;
