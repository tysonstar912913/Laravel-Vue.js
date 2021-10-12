function initialState() {
  return {
    item: {
      avatar: null,
      first_name: null,
      last_name: null,
      email: null,
      password: null,
      employee_number: null,
      remember_token: null,
      role_id: null,
      rate: null,
      phone_number: null,
      medical_notes: null,
      emergency_contact_name: null,
      emergency_contact_phone: null,
      titles: [],
      permissions: [],
      trade: null,
      pay_class: null,
      tags: null,
      classification: null,
      is_collaborator: null,
      send_invitation_email: null,
      company: null
    },
    rolesAll: [],
    titlesAll: [],
    permissionsAll: [],
    loading: false,
    companiesAll: [],
  }
}

const getters = {
  item: (state) => state.item,
  loading: (state) => state.loading,
  rolesAll: (state) => state.rolesAll,
  titlesAll: (state) => state.titlesAll,
  companiesAll: (state) => state.companiesAll,
  permissionsAll: (state) => state.permissionsAll
}

const actions = {
  storeData({ commit, state, dispatch }) {
    commit('setLoading', true)
    dispatch('Alert/resetState', null, { root: true })

    return new Promise((resolve, reject) => {
      let params = _.cloneDeep(state.item)
      if (! _.isEmpty(params.company)) {
        params.company_id = params.company.id
      }

      axios
        .post('/api/v1/users', params)
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
      if (! _.isEmpty(params.company)) {
        params.company_id = params.company.id
      }

      axios
        .put('/api/v1/users/' + params.id, params)
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
    axios.get('/api/v1/users/' + id).then((response) => {
      commit('setItem', response.data.data)
    })
    // dispatch('fetchRolesAll'
  },
  fetchCompaniesAll({ commit }) {
      axios.get('/api/v1/companies')
          .then(response => {
              commit('setCompaniesAll', response.data.data)
          })
  },
  fetchRolesAll({ commit }) {
    axios.get('/api/v1/roles').then((response) => {
      commit('setRolesAll', response.data.data)
    })
  },
  fetchTitlesAll({ commit }) {
    axios.get('/api/v1/titles').then((response) => {
      commit('setTitlesAll', response.data.data)
    })  
  },
  fetchPermissionsAll({ commit }) {
    axios.get('/api/v1/permission-lists').then((response) => {
      commit('setPermissionsAll', response.data.data)
    })
  },
  setName({ commit }, value) {
    commit('setName', value)
  },
  setEmail({ commit }, value) {
    commit('setEmail', value)
  },
  setPassword({ commit }, value) {
    commit('setPassword', value)
  },
  setRole({ commit }, value) {
    commit('setRole', value)
  },
  resetState({ commit }) {
    commit('resetState')
  },
  setInput({ commit }, param) {
    commit('setInput', param)
  },
  setTitles({ commit }, param) {
    commit('setTitles', param)
  },
  setPermissions({ commit }, param) {
    commit('setPermissions', param)
  }
}

const mutations = {
  setItem(state, item) {
    state.item = item
    console.log(state.item);
  },
  setName(state, value) {
    state.item.name = value
  },
  setEmail(state, value) {
    state.item.email = value
  },
  setPassword(state, value) {
    state.item.password = value
  },
  setRole(state, value) {
    state.item.role = value
  },
  setRolesAll(state, value) {
    state.rolesAll = value
  },
  setLoading(state, loading) {
    state.loading = loading
  },
  resetState(state) {
    state = Object.assign(state, initialState())
  },
  setInput(state, param) {
    console.log("mutation:", param)
    const {name, value} = param
    state.item[name] = value
  },
  setCompaniesAll(state, value) {
      state.companiesAll = value
  },
  setTitlesAll(state, value) {
    state.titlesAll = value
  },
  setPermissionsAll(state, value) {
    state.permissionsAll = value
  },
  setTitles(state, param) {
    const {title_id, value} = param
    let item = {...state.item}
    let index = item.titles.findIndex(title => title.title_id === title_id)
    if (value) {
      if (index === -1) {
        item.titles.push({
          title_id: title_id,
          is_include: 1
        })
      }
    } else {
      item.titles.splice(index, 1)
    }
    state.item = item
    console.log(state.item)
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
  }
}

export default {
  namespaced: true,
  state: initialState,
  getters,
  actions,
  mutations,
}
