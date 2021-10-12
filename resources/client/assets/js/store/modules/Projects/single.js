function initialState() {
  return {
    item: {
      id: null,
      project: null,
      project_number: null,
      start_date: null,
      end_date: null,
      country: null,
      address: null,
      city: null,
      region: null,
      postal_code: null,
      longitude: null,
      latitude: null,
    },
    loading: false,
    assignedUserList: [],
  }
}

const getters = {
  item: (state) => state.item,
  loading: (state) => state.loading,
  assignedUserList: (state) => state.assignedUserList,
}

const actions = {
  storeData({ commit, state, dispatch }) {
    commit('setLoading', true)
    dispatch('Alert/resetState', null, { root: true })

    return new Promise((resolve, reject) => {
      let params = _.cloneDeep(state.item)
      params.start_date = moment(params.start_date).format('YYYY-MM-DD')
      params.end_date = moment(params.end_date).format('YYYY-MM-DD')
      console.log('params:', params)

      axios
        .post('/api/v1/projects', params)
        .then((response) => {
          commit('resetState')
          resolve()
        })
        .catch((error) => {
          let message = error.response.data.message || error.message
          let errors = error.response.data.errors

          dispatch(
            'Alert/setAlert',
            { message: message, errors: errors, color: 'danger' },
            { root: true },
          )

          reject(error)
        })
        .finally(() => {
          commit('setLoading', false)
        })
    })
  },

  updateData({ commit, state, dispatch }) {
    commit('setLoading', true)
    dispatch('Alert/resetState', null, { root: true })

    return new Promise((resolve, reject) => {
      let params = _.cloneDeep(state.item)
      params.start_date = moment(params.start_date).format('YYYY-MM-DD')
      params.end_date = moment(params.end_date).format('YYYY-MM-DD')

      axios
        .put('/api/v1/projects/' + params.id, params)
        .then((response) => {
          commit('setItem', response.data.project)
          resolve()
        })
        .catch((error) => {
          let message = error.response.data.message || error.message
          let errors = error.response.data.errors

          dispatch(
            'Alert/setAlert',
            { message: message, errors: errors, color: 'danger' },
            { root: true },
          )

          reject(error)
        })
        .finally(() => {
          commit('setLoading', false)
        })
    })
  },

  fetchData({ commit, dispatch }, id) {
    axios.get('/api/v1/projects/' + id).then((response) => {
      response.data.start_date = moment(response.data.start_date).toDate()
      response.data.end_date = moment(response.data.end_date).toDate()
      commit('setItem', response.data)
    })
  },

  fetchAssignedUserList({ commit, dispatch }, id) {
    axios.get('/api/v1/projects/assigned-user-list/' + id).then((response) => {
      commit('setAssignedUserList', response.data)
    })
  },

  setProject({ commit }, value) {
    commit('setProject', value)
  },

  setProjectNumber({ commit }, value) {
    commit('setProjectNumber', value)
  },

  setStatus({ commit }, value) {
    commit('setStatus', value)
  },

  setStartDate({ commit }, value) {
    commit('setStartDate', value)
  },

  setEndDate({ commit }, value) {
    commit('setEndDate', value)
  },

  setCountry({ commit }, value) {
    commit('setCountry', value)
  },

  setAddress({ commit }, value) {
    commit('setAddress', value)
  },

  setCity({ commit }, value) {
    commit('setCity', value)
  },

  setRegion({ commit }, value) {
    commit('setRegion', value)
  },

  setPostalCode({ commit }, value) {
    commit('setPostalCode', value)
  },

  setLongitude({ commit }, value) {
    commit('setLongitude', value)
  },

  setLatitude({ commit }, value) {
    commit('setLatitude', value)
  },

  resetState({ commit }) {
    commit('resetState')
  },
}

const mutations = {
  setItem(state, item) {
    state.item = item
  },
  setProject(state, value) {
    state.item.project = value
  },
  setProjectNumber(state, value) {
    state.item.project_number = value
  },
  setStatus(state, value) {
    state.item.status = value
  },
  setStartDate(state, value) {
    state.item.start_date = value
  },
  setEndDate(state, value) {
    state.item.end_date = value
  },
  setCountry(state, value) {
    state.item.country = value
  },
  setAddress(state, value) {
    state.item.address = value
  },
  setCity(state, value) {
    state.item.city = value
  },
  setRegion(state, value) {
    state.item.region = value
  },
  setPostalCode(state, value) {
    state.item.postal_code = value
  },
  setLongitude(state, value) {
    state.item.longitude = value
  },
  setLatitude(state, value) {
    state.item.latitude = value
  },
  setLoading(state, loading) {
    state.loading = loading
  },
  resetState(state) {
    state = Object.assign(state, initialState())
  },
  setAssignedUserList(state, value) {
    state.assignedUserList = value
  },
}

export default {
  namespaced: true,
  state: initialState,
  getters,
  actions,
  mutations,
}
