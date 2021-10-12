function initialState() {
  return {
    auth: {},
    loading: false,
  }
}

const getters = {
  auth: (state) => state.auth,
  loading: (state) => state.loading,
}

const actions = {
  fetchAuth({ commit, dispatch }) {
    axios.get('/api/v1/get-auth').then((response) => {
      commit('setAuth', response.data)
    })
  },

  setAuth({ commit }, value) {
    commit('setAuth', value)
  },
  resetState({ commit }) {
    commit('resetState')
  },
}

const mutations = {
  setAuth(state, item) {
    state.auth = item
  },
  setLoading(state, loading) {
    state.loading = loading
  },
  resetState(state) {
    state = Object.assign(state, initialState())
  },
}

export default {
  namespaced: true,
  state: initialState,
  getters,
  actions,
  mutations,
}
