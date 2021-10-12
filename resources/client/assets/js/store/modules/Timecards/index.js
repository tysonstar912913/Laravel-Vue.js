// this store is for one project

function initialState() {
  return {
    data: [],
    weekData: [],
    checkinsData: [],
  }
}

const getters = {
  data: (state) => state.data,
  weekData: (state) => state.weekData,
  checkinsData: (state) => state.checkinsData,
}

const actions = {
  // fetchData({ commit, state }, param) {
  //   axios
  //     .get(`/api/v1/timecards/${param.projectId}/${param.startDate}/${param.endDate}`)
  //     .then((response) => {
  //       commit('setAll', response.data)
  //     })
  //     .catch((error) => {
  //       message = error.response.data.message || error.message
  //       commit('setError', message)
  //       console.log(message)
  //     })
  //     .finally(() => {
  //     })
  // },
  // fetchUserList({ commit, state }, param) {
  //   axios
  //     .get(`/api/v1/timecards/userlist/${param.projectId}`)
  //     .then((response) => {
  //       commit('setUserList', response.data)
  //     })
  //     .catch((error) => {
  //       message = error.response.data.message || error.message
  //       commit('setError', message)
  //       console.log(message)
  //     })
  //     .finally(() => {
  //     })
  // },
  fetchData({ commit, state }, param) {
    axios
      .get(`/api/v1/timecards/get-all/${param.projectId}/${param.startDate}/${param.endDate}`)
      .then((response) => {
        commit('setData', response.data)
      })
      .catch((error) => {
        message = error.response.data.message || error.message
        commit('setError', message)
        console.log(message)
      })
      .finally(() => {
      })
  },
  fetchWeekData({commit, state}, param) {
    axios
    .get(`/api/v1/timecards/get-week-data/${param.projectId}/${param.userId}/${param.startDate}/${param.endDate}`)
    .then((response) => {
      commit('setWeekData', response.data)
    })
    .catch((error) => {
      message = error.response.data.message || error.message
        commit('setError', message)
        console.log(message)
    })
    .finally(() => {
    })
  },
  fetchCheckinsData({commit, state}, param) {
    axios
    .post(`/api/v1/timecards/get-checkins-data`, {
      userId: param.userId,
      projectId: param.projectId,
      entryDate: param.entryDate,
    })
    .then((response) => {
      commit('setCheckinsData', response.data)
    })
    .catch((error) => {
      message = error.response.data.message || error.message
        commit('setError', message)
        console.log(message)
    })
    .finally(() => {
    })
  },
  addEntry({commit, dispatch}, param) {
    axios
      .post('/api/v1/timecards/add-entry', {
        isUpdate: param.isUpdate,
        isCompleteCheckin: param.isCompleteCheckin,
        id: param.id,
        userId: param.userId,
        projectId: param.projectId,
        checkin: param.checkin,
        checkout: param.checkout,
        entryCostCode: param.entryCostCode,
        entryTimeType: param.entryTimeType,
        entryDuration: param.entryDuration,
        entryTool: param.entryTool,
        entryClassification: param.entryClassification,
        entryNotes: param.entryNotes,
        entryDate: param.entryDate,
      })
      .then((response) => {
        if(param.isCompleteCheckin)
          dispatch('fetchCheckinsData', {
            userId: param.userId,
            projectId: param.projectId,
            entryDate: param.entryDate,
          })
        else
          dispatch('fetchWeekData', {
            userId: param.userId,
            projectId: param.projectId,
            startDate: param.startDate,
            endDate: param.endDate,
          })
      })
      .catch((error) => {
        message = error.response.data.message || error.message
          commit('setError', message)
          console.log(message)
      })
      .finally(() => {
      })
  },
  deleteEntryItem({commit, dispatch}, param) {
    axios.get(`/api/v1/timecards/delete-entry/${param.id}/`)
      .then((response) => {
        dispatch('fetchWeekData', {
          userId: response.data.user_id,
          projectId: response.data.project_id,
          startDate: param.startDate,
          endDate: param.endDate,
        })
      })
      .catch((error) => {
        message = error.response.data.message || error.message
          commit('setError', message)
          console.log(message)
      })
      .finally(() => {
      })
  },
  addCheckinTime({commit, dispatch}, param) {
    axios
      .post('/api/v1/timecards/add-checkin', {
        title: param.title,
        id: param.id,
        userId: param.userId,
        projectId: param.projectId,
        checkIn: param.checkIn,
        entryDate: param.entryDate,
      })
      .then((response) => {
        dispatch('fetchCheckinsData', {
          userId: param.userId,
          projectId: param.projectId,
          entryDate: param.entryDate,
        })
      })
      .catch((error) => {
        message = error.response.data.message || error.message
          commit('setError', message)
          console.log(message)
      })
      .finally(() => {
      })
  },
  removeCheckinData({commit, dispatch}, param) {
    axios.get(`/api/v1/timecards/delete-checkin/${param.id}/`)
      .then((response) => {
        dispatch('fetchCheckinsData', {
          userId: response.data.user_id,
          projectId: response.data.project_id,
          entryDate: response.data.entry_date,
        })
      })
      .catch((error) => {
        message = error.response.data.message || error.message
          commit('setError', message)
          console.log(message)
      })
      .finally(() => {
      })
  },
}

const mutations = {
  setUserList(state, items) {
    state.userList = items

  },
  setData(state, items) {
    items.forEach(timecard => {
      const today = moment().format('YYYY-MM-DD')
      let weekTime = 0
      let todayTime = 0
      if(timecard.staticData != null){
        timecard.staticData.forEach(el => {
          // if(el.duration == null) return
          if (el.entry_date == today) todayTime += el.duration
          weekTime += el.duration
        })

        timecard.staticDuration = (todayTime > 0) ? Math.floor(todayTime / 60) + ':' + Math.floor(todayTime % 60) : '0:00'
        timecard.weekTime = (weekTime > 0) ? Math.floor(weekTime / 60) + ':' + Math.floor(weekTime % 60) : '0:00'
      }
      else {
        timecard.staticDuration = "0:00"
      }
    })
    state.data = items
  },
  setUserData(state, value) {
    const index = state.data.findIndex(userData => userData.userId == value.userId)
    if (index > -1) {
      const clone = [...state.data]
      clone[index] = value
      state.data = clone
    }
  },
  setWeekData(state, items) {
    const tempData = []
    const daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
    let weekTime = 0
    daysOfWeek.forEach((day, index, arr) => {
      const tempDay = moment(items.startDate).add(index, 'day').format('YYYY-MM-DD')
      const today = moment().format('YYYY-MM-DD')
      let dayTime = 0
      tempData[index] = items.weekData.filter((el, index) => {
        return el.entry_date == tempDay
      })
      
      tempData[index].forEach(el => {
        dayTime += el.duration
        el.hours = Math.floor(el.duration / 60)
        el.minutes = Math.floor(el.duration % 60)

        let hours = ''
        let minutes = ''
        if(el.duration != null) {
          hours = Math.floor(el.duration / 60)
          minutes = Math.floor(el.duration % 60)
          el.format_duration = (hours < 10 ? '0' + hours: hours) + ":" + (minutes < 10 ? '0' + minutes: minutes)
        }
          
        if(el.time_type != null) el.entry_time_type = el.time_type.split('-')[1]
        else el.entry_time_type = null
      })
      weekTime += dayTime
      tempData[index].day = moment(items.startDate).add(index, 'day').format('dddd D')
      tempData[index].today = (tempDay == today) ? true: false
      tempData[index].total = (dayTime > 0) ? Math.floor(dayTime / 60) + ':' + Math.floor(dayTime % 60) : '0:00'
      tempData[index].date = tempDay
    })
    
    state.weekData = tempData
    state.weekData.weekTime = (weekTime > 0) ? Math.floor(weekTime / 60) + ':' + Math.floor(weekTime % 60) : '0:00'
  },
  setCheckinsData(state, items) {
    items.forEach(item => {
      let hours = ''
      let minutes = ''
      if(item.check_in != null) {
        hours = Math.floor(item.check_in / 60)
        minutes = Math.floor(item.check_in % 60)
        item.check_in = (hours < 10 ? '0' + hours: hours) + ":" + (minutes < 10 ? '0' + minutes: minutes)
      }
        
      if(item.check_out != null) {
        hours = Math.floor(item.check_out / 60)
        minutes = Math.floor(item.check_out % 60)
        item.check_out = (hours < 10 ? '0' + hours: hours) + ":" + (minutes < 10 ? '0' + minutes: minutes)
      }
    })
    state.checkinsData = items
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
