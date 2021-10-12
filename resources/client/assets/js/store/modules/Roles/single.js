function initialState() {
  return {
    item: {
      id: null,
      title: null,
      permissions: []
    },

    loading: false,
    permissionsAll: [],
  }
}

const getters = {
  item: (state) => state.item,
  loading: (state) => state.loading,
  permissionsAll: (state) => state.permissionsAll,
}

const actions = {
  storeData({ commit, state, dispatch }) {
    commit('setLoading', true)
    dispatch('Alert/resetState', null, { root: true })

    return new Promise((resolve, reject) => {
      let params = _.cloneDeep(state.item)

      axios
        .post('/api/v1/roles', params)
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

      axios
        .put('/api/v1/roles/' + params.id, params)
        .then((response) => {
          commit('setItem', response.data.data)
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
    axios.get('/api/v1/roles/' + id).then((response) => {
      commit('setItem', response.data.data)
    })
  },
  fetchPermissionsAll({ commit }) {
    axios.get('/api/v1/permission-lists').then((response) => {
      commit('setPermissionsAll', response.data.data)
    })
  },
  setTitle({ commit }, value) {
    commit('setTitle', value)
  },
  resetState({ commit }) {
    commit('resetState')
  },
  setPermissions({ commit }, param) {
    commit('setPermissions', param)
  }
}

const mutations = {
  setItem(state, item) {
    state.item = item
  },
  setTitle(state, value) {
    state.item.title = value
  },

  setLoading(state, loading) {
    state.loading = loading
  },
  setPermissionsAll(state, value) {
    state.permissionsAll = value
  },
  setPermissions(state, param) {
    const {permission_id, value} = param
    let item = {...state.item}
    let index = item.permissions.findIndex(title => title.permission_id === permission_id)
    if (value) {
      if (index === -1) {
        item.permissions.push({
          permission_id: permission_id,
          permission: 1
        })
      }
    } else {
      item.permissions.splice(index, 1)
    }
    state.item = item
    console.log(state.item)
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
