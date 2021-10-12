<template>
<section>
  <a href="#" @click="handleTimecard">
    <div class="timecard">
    <div class="userinfo">
      <img
        :src="'/static/' + data.userData.avatar"
        :alt="data.userData.first_name"
        @error="handleAvatarError"
      />
      <div class="name">
        {{ data.userData.first_name }} {{ data.userData.last_name }}
      </div>
    </div>
    <div class="curtime">
      {{ data.staticDuration === null ? "0:00" : data.staticDuration }}
    </div>
    <div class="totaltime">
      <span>
        Pay Period
        {{ data.weekTime === null ? "0:00" : data.weekTime }}
      </span>
    </div>
  </div>
  </a>
  <Modal v-show="isModalVisible" @close="closeModal" v-bind:showBtn="false" modalSize="modal-lg">
    <div slot="header">
      <div class="row">
        <div class="col-sm-4">
          <div class="align-items-center">
          <img :src="'/static/' + data.userData.avatar" :alt="data.userData.first_name"
        @error="handleAvatarError">
          <h5>{{ data.userData.first_name }} {{ data.userData.last_name }}</h5>
        </div>
        </div>
        <div class="col-sm-8">
          <div class="timecard-datepicker">
          </div>
        </div>
      </div>
    </div>
    <div slot="body">      
      <div class="space-between">
        <div class="curtime main">{{ weekData.weekTime }}</div>
        <button class="btn btn-default align-items-center"><span class="icon-check-box"></span>Submit</button>
      </div>
      <div class="table-wrapper mt-3">
        <table class="timecard-period-table">
          <thead>
            <tr>
              <th width="40">Day</th>
              <th width="40">In</th>
              <th width="40">Out</th>
              <th>Entries</th>
              <th width="60">Total</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in weekData" v-bind:key="item.id" v-bind:class="{today: item.today}">
              <td width="120">{{item.day}}</td>
              <td width="60">
                <div class="checkin align-items-center justify-content-center">
                  <div @click="showCheckinModal" class="plus-icon" v-show="item.length === 0">+</div>
                  <div class="checkin-value" v-show="item.length > 0">{{item.length}}</div>
                  <a href="#" @click="showCheckinModal(item.day, item.date)" class="checkin-edit" v-show="item.length > 0"><span class="fa fa-edit"></span></a>
                </div>
              </td>
              <td width="60">
                <div class="checkout align-items-center justify-content-center">
                  <div @click="showCheckinModal" class="plus-icon" v-show="item.length === 0">+</div>
                  <div class="checkout-value" v-show="item.length > 0">{{item.length}}</div>
                  <a href="#" @click="showCheckinModal(item.day, item.date)" class="checkin-edit" v-show="item.length > 0"><span class="fa fa-edit"></span></a>
                </div>
                
              </td>
              <td>
                <div class="entry align-items-center">
                  <div @click="showEntryModal(item.date)" class="plus-icon">+</div>
                  <div class="duration"  v-show="entry.entry_time_type" v-for="entry in item" v-bind:key="entry.id" @click="editEntry(entry, item.date)">NCC {{entry.format_duration}} {{entry.entry_time_type}}</div>
                </div>
                
              </td>
              <td width="60">
                <div class="total-time">{{item.total}}</div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div slot="footer" class="w-100">
      <div class="w-100 d-flex">
        <button
          class="btn btn-default ml-auto"
          type="button"
          @click="closeModal"
        >
          Close
        </button>
      </div>
    </div>
  </Modal>
  <Modal v-show="isCheckinModalVisible" @close="closeCheckinModal" v-bind:showBtn="true" modalSize="modal-sm">
    <div slot="header">
          <h5>Checkin Details - {{ checkinday }}</h5>
    </div>
    <div slot="body">
      <div class="mb-3" v-for="checkin in checkinsData" v-bind:key="checkin.id">
        <div v-show="checkin.check_in || checkin.check_out">
          <div class="botbar d-flex justify-content-between ">
            <div class="align-items-center" v-show="checkin.check_in">
              <div class="checkin-icon">
                <span class="fa fa-user-plus text-success"></span>
              </div>
              <div class="checked">
                <div class="checkedin text-success font-weight-bold">Checked in</div>
                <div class="time">{{checkin.check_in}}</div>
              </div>
            </div>
            <div class="align-items-center" v-show="!checkin.check_in">
              <a href="#" class="checkedout text-primary font-weight-bold" @click="showTimeModal('checkin', checkin.id)"><span class="fa fa-plus"></span>Add Checkin</a>
            </div>
            <div class="align-items-center" v-show="checkin.check_out">
              <div class="checkout-icon">
                <span span class="fa fa-user-plus text-primary"></span>
              </div>
              <div class="checked">
                <div class="checkedout text-primary font-weight-bold">Checked out</div>
                <div class="time">{{checkin.check_out}}</div>
              </div>
            </div>
            <div class="align-items-center" v-show="!checkin.check_out">
              <a href="#" class="checkedout text-primary font-weight-bold" @click="showTimeModal('check_out', checkin.id)"><span class="fa fa-plus"></span>Add Checkout</a>
            </div>
            <div class="align-items-center" v-show="checkin.check_in || checkin.check_out">
              <a href="#" @click="removeCheckin(checkin.id)"><span class="fa fa-times-circle"></span></a>
            </div>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-center align-items-center checkin-time mb-3" @click="showTimeModal('check_in', 0)">
        <span class="fa fa-plus"></span> <strong>Add Checkin</strong>
      </div>
      <div class="d-flex justify-content-center align-items-center checkin-time" @click="addComepleteCheckin">
          <span class="fa fa-plus"></span> <strong>Add Complete Checkin</strong>
      </div>
    </div>
    <div slot="footer" class="w-100">
      <div class="w-100 d-flex">
        <button
          class="btn btn-default ml-auto"
          type="button"
          @click="closeCheckinModal"
        >
          Close
        </button>
      </div>
    </div>
  </Modal>
  <Modal v-show="isEntryModalVisible" @close="closeEntryModal" v-bind:showBtn="true" modalSize="modal-md">
    <div slot="header">Add Entry</div>
    <div slot="body">
        <div class="container-fluid">
          <div class="complete-checkin" v-show="isCompleteCheckin">
            <div class="d-flex">
              <div class="title">Check-in</div>
              <div class="form-inline">
                <select class="form-control pt-2 px-3 mr-2" v-model="checkinHours">
                <option :value="hour" v-for="(hour, i) in 24" v-bind:key="hour.id">{{i}}</option>
                </select>
                <select class="form-control pt-2 px-3" v-model="checkinMinutes">
                  <option :value="minute" v-for="(minute, i) in 60" v-bind:key="minute.id">{{i}}</option>
                </select>
              </div>
            </div>
            <div class="d-flex">
              <div class="title">Check-out</div>
              <div class="form-inline">
                <select class="form-control pt-2 px-3 mr-2" v-model="checkoutHours">
                  <option :value="hour" v-for="(hour, i) in 24" v-bind:key="hour.id">{{i}}</option>
                </select>
                <select class="form-control pt-2 px-3" v-model="checkoutMinutes">
                  <option :value="minute" v-for="(minute, i) in 60" v-bind:key="minute.id">{{i}}</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row" v-show="!isAbsent">
            <div class="col-md-8">
              <div class="form-group" v-bind:class="{active: entryCostCode}">
                <label for="entry_cost_code">Cost Code</label>
                <input type="text" class="form-control" name="entry_cost_code" v-model="entryCostCode">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group" v-bind:class="{active: entryTimeType}">
                <label for="entry_time_type">Time Type</label>
                <select class="form-control" v-model="entryTimeType">
                  <option v-for="timeType in timeTypes" v-bind:key="timeType.id" :value="timeType">{{timeType}}</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row" v-show="!isAbsent">
            <div class="col-md-3" v-show="!isCompleteCheckin">
              <div class="form-group" v-bind:class="{active: entryHours}">
                <label for="entry_hours">Hours</label>
                <select class="form-control" name="entry_hours" v-model="entryHours">
                  <option v-for="(hour, i) in 24" v-bind:key="hour.id" :value="i">{{i}}</option>
                </select>
              </div>
            </div>
            <div class="col-md-3"  v-show="!isCompleteCheckin">
              <div class="form-group" v-bind:class="{active: entryMinutes}">
                <label for="entry_minutes">Minutes</label>
                <select class="form-control" name="entry_minutes" v-model="entryMinutes">
                  <option v-for="(minute, i) in 60" v-bind:key="minute.id" :value="i">{{i}}</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group" v-bind:class="{active: entryTool}">
                <label for="entry_tool">Equipment</label>
                <input type="text" class="form-control" name="entry_tool" v-model="entryTool">
              </div>
            </div>
          </div>
          <div class="row" v-show="!isAbsent">
            <div class="col-md-12">
              <div class="form-group" v-bind:class="{active: entryClassification}">
                <label for="entry_classification">Classification</label>
                <select class="form-control" name="entry_classification" v-model="entryClassification">
                  <option></option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group" v-bind:class="{active: entryNotes}">
                <label for="entry_notes">Description</label>
                <textarea name="entry_notes" class="form-control" rows="2" autoresize v-model="entryNotes"></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="checkbox">
                <label for="absent">
                  <input type="checkbox" id="absent" v-model="isAbsent">
                  Absent
                </label>
              </div>
            </div>
          </div>
        </div>
    </div>
    <div slot="footer" class="w-100">
      <div class="w-100 btn-actions">
        <div class="float-left" v-show="isUpdate">
          <button
            class="btn btn-danger mr-1"
            type="button"
            @click="deleteEntry"
          >
            Delete
          </button>
          <button
            class="btn btn-default"
            type="button" @click="closeEntryModal"
          >
            Move
          </button>
        </div>
        <div class="float-right">
          <button
            class="btn btn-default mr-1"
            type="button"
            @click="closeEntryModal"
          >
            Close
          </button>
          <button
            class="btn btn-success"
            type="button" @click="submitEntry" v-show="!isUpdate"
          >
            Add
          </button>
          <button
            class="btn btn-success"
            type="button" @click="submitEntry" v-show="isUpdate"
          >
            Update
          </button>
        </div>
      </div>
    </div>
  </Modal>
  <Modal v-show="isTimeModalVisible" @close="closeTimeModal" v-bind:showBtn="true" modalSize="modal-sm">
    <div slot="header">
          <h5 class="font-weight-bold" style="font-size: 15px">Time</h5>
    </div>
    <div slot="body">
      <div class="form-inline justify-content-center">
        <div class="form-group mr-3">
          <select class="form-control pt-1 px-3" v-model="hours">
            <option :value="item" v-for="(item, i) in 24" v-bind:key="item.id">{{i}}</option>
          </select>
        </div>
        <div class="form-group">
          <select class="form-control pt-1 px-3" v-model="minutes">
            <option :value="item" v-for="(item, i) in 60" v-bind:key="item.id">{{i}}</option>
          </select>
        </div>
      </div>
    </div>
    <div slot="footer" class="w-100">
      <div class="w-100 d-flex justify-content-end">
        <button
          class="btn btn-default ml-auto mr-1"
          type="button"
          @click="closeTimeModal"
        >
          Close
        </button>
        <button
          class="btn btn-success"
          type="button"
          @click="addCheckin"
        >
          Choose
        </button>
      </div>
    </div>
  </Modal>
</section>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  props: ["data", "checkins"],
  data() {
    return {
      // modal
      isModalVisible: false,
      isEntryModalVisible: false,
      isCheckinModalVisible: false,
      isTimeModalVisible: false,
      isCompleteCheckin: false,
      isAbsent: false,
      isActive: false,
      isUpdate: false,
      checkinId: '',
      checkinday: '',
      entryDate: '',
      entryCostCode: '',
      entryTimeType: '',
      entryHours: '',
      entryMinutes: '',
      entryTool: '',
      entryClassification: '',
      entryNotes: '',
      timeTypes: '',
      checkinHours: '',
      checkinMinutes: '',
      checkoutHours: '',
      checkoutMinutes: '',
      time: {
        in: {
          hours: ''
        },
        out: {
          hours: ''
        }
      },
      hours: '',
      minutes: '',
      entry: '',
      checkinDate: '',
      title: '',
    };
  },
  computed: {
    ...mapGetters("Alert", ["message", "errors", "color"]),
    ...mapGetters('TimecardsIndex', ['weekData', 'checkinsData']),
  },
  beforeCreate() {
    
  },
  created() {
    this.timeTypes = ['Double Time - DT', 'Drive Time - DRV', 'Drive Time Passanger - DRVP', 'Holiday- H', 'Overtime - OT', 'Regular Time - RT', 'Time and a Half - 1.5']
  },
  destroyed() {
    this.resetState();
  },
  watch: {
    "$route.params.id": function () {
      this.resetState();
    },
  },
  methods: {
    ...mapActions("Alert", ["resetState"]),
    ...mapActions('TimecardsIndex', ['fetchData', 'fetchWeekData', 'addEntry', 'deleteEntryItem', 'addCheckinTime' ,'fetchCheckinsData', 'removeCheckinData']),
    handleAvatarError(e) {
      e.target.src = "/adminlte/img/default-user-avatar.png";
    },
    handleTimecard: function (e) {
      e.preventDefault();
      
      this.showModal();
    },
    showModal() {
      this.fetchWeekData({
        userId: this.data.userId,
        projectId: this.data.projectId,
        startDate: this.getWeekDate()[0],
        endDate: this.getWeekDate()[1],
      })
      this.isModalVisible = true
    },
    getWeekDate() {
      const currentDate = moment();
      const weekStart = currentDate.clone().startOf('isoWeek');
      const weekEnd = currentDate.clone().endOf('isoWeek');

      return [moment(weekStart).format("YYYY-MM-DD"), moment(weekEnd).format("YYYY-MM-DD")]
    },
    closeModal() {
      this.fetchData({
        projectId: this.data.projectId,
        startDate: this.getWeekDate()[0],
        endDate: this.getWeekDate()[1],
      })
      this.isModalVisible = false
    },
    showEntryModal(date) {
      this.entryDate = date
      this.isEntryModalVisible = true
    },
    editEntry(entry, date) {
      this.entry = entry
      this.entryCostCode = entry.cost_code
      this.entryTimeType = entry.time_type
      this.entryHours = entry.hours
      this.entryMinutes = entry.minutes
      this.entryTool = entry.equipment
      this.entryClassification = entry.classification
      this.entryNotes = entry.description
      this.entryDate = date
      this.isUpdate = true
      this.isEntryModalVisible = true
    },
    deleteEntry() {
      this.deleteEntryItem({
        id: this.entry.id,
        startDate: this.getWeekDate()[0],
        endDate: this.getWeekDate()[1],
      })
      this.closeEntryModal()
    },
    submitEntry() {
      // if(this.entryHours == 0 && this.entryMinutes == 0) return
      this.addEntry({
        isUpdate: this.isUpdate,
        isCompleteCheckin: this.isCompleteCheckin,
        id: this.entry.id,
        userId: this.data.userId,
        projectId: this.data.projectId,
        checkin: this.checkinHours * 60 + this.checkinMinutes,
        checkout: this.checkoutHours * 60 + this.checkoutMinutes,
        entryCostCode: this.entryCostCode,
        entryTimeType: this.entryTimeType,
        entryDuration: (this.entryHours * 60) + this.entryMinutes,
        entryTool: this.entryTool,
        entryClassification: this.entryClassification,
        entryNotes: this.entryNotes,
        entryDate: this.entryDate || this.checkinDate,
        startDate: this.getWeekDate()[0],
        endDate: this.getWeekDate()[1],
      })
      this.closeEntryModal()
    },
    closeEntryModal() {
      this.entry = ''
      this.isEntryModalVisible = false
      this.isUpdate = false
      this.entryCostCode = ''
      this.entryTimeType = ''
      this.entryHours = ''
      this.entryMinutes = ''
      this.entryTool = ''
      this.entryClassification = ''
      this.entryNotes = ''
      this.isCompleteCheckin = false
    },
    showCheckinModal(day, date) {
      this.fetchCheckinsData({
        projectId: this.data.projectId,
        userId: this.data.userId,
        entryDate: date,
      })
      this.checkinday = day
      this.checkinDate = date
      this.isCheckinModalVisible = true
    },
    closeCheckinModal() {
      this.fetchWeekData({
        userId: this.data.userId,
        projectId: this.data.projectId,
        startDate: this.getWeekDate()[0],
        endDate: this.getWeekDate()[1],
      })
      this.isCheckinModalVisible = false
    },
    showTimeModal(title, id) {
      this.title = title
      this.checkinId = id
      this.isTimeModalVisible = true
    },
    addComepleteCheckin() {
      this.isEntryModalVisible = true
      this.isCompleteCheckin = true
    },
    addCheckin() {
      if(this.hours == 0 && this.minutes == 0) return
      this.addCheckinTime({
        title: this.title,
        id: this.checkinId,
        userId: this.data.userId,
        projectId: this.data.projectId,
        startDate: this.getWeekDate()[0],
        endDate: this.getWeekDate()[1],
        checkIn: (this.hours - 1) * 60 + (this.minutes - 1),
        entryDate: this.checkinDate,
      })
      this.isTimeModalVisible = false
    },
    tcAction(tcType) { // Submit, Approve

    },
    closeTimeModal() {
      this.isTimeModalVisible = false
    },
    removeCheckin(id) {
      this.removeCheckinData({
        id: id,
      })
    },
    updateValue(key, value) {
      this.$emit("input", { ...this.entry, [key]: value });
    }
  },
};
</script>

<style lang="scss" scoped>
.timecard {
  background: white;
  display: flex;
  flex-direction: column;
  padding: 10px;
  gap: 20px;
  border-radius: 8px;
  box-shadow: 3px 3px 7px 0px #d6d6d6, 2px 3px 1px 0px #d8d8d8;
  cursor: pointer;
}

.userinfo {
  display: flex;
  align-items: center;
  gap: 10px;
}

.userinfo img {
  width: 40px;
  height: 40px;
  display: block;
  border-radius: 50%;
}

.userinfo .name {
  color: #808080;
  font-size: 14px;
  font-weight: 600;
}

.curtime {
  font-size: 32px;
  color: #363636;
}

.totaltime span {
  background: #d0e1ff;
  color: #74b4f8;
  border-radius: 15px;
  padding: 2px 15px;
  font-size: 14px;
  font-weight: bold;
}

.modal-header img {
  width: 60px;
  height: 60px;
}

.modal-header h5 {
  font-size: 14px;
}

.modal-header .btn-close {
  display: none;
}

.align-items-center {
  display: flex;
  align-items: center;
  gap: 15px;
}

.justify-content-center {
  justify-content: center;
}

.space-between {
  display: flex;
  justify-content: space-between;
}

.btn {
  border-radius: 8px;
  font-size: 15px;
}

.btn.align-items-center {
  padding-left: 30px;
  position: relative;
}

.icon-check-box {
  position: absolute;
  top: 9px;
  left: 6px;
}

.icon-check-box::before {
  position: absolute;
  content: '';
  display: block;
  width:  15px;
  height: 15px;
  left: 5px;
  border: 1px solid #444;
}

.icon-check-box::after {
  position: absolute;
  content: '';
  display: block;
  width:  5px;
  height: 10px;
  left: 10px;
  border: 1px solid #444;
  border-left-style: none;
  border-top-style: none;
  transform: rotate(45deg);
}

.curtime.main {
  padding: 4px 16px;
  background-color: #111;
  color: #fff;
  border-radius: 25px;
  font-size: 16px;
  font-weight: 700;
  margin-right: 12px;
}

.timecard-period-table {
  width: 100%;
  border-collapse: collapse;
}

.timecard-period-table th {
  border: 1px solid #ddd;
  vertical-align: middle;
  font-size: 14px;
  text-align: center;
  height: 40px;
  padding: 10px;
}

.timecard-period-table tr.today td {
  background-color: #ffd149;
}

.timecard-period-table td {
  border: 1px solid #ddd;
  vertical-align: middle;
  font-size: 14px;
  padding: 10px;
}

.timecard-period-table td .checkin-value,
.timecard-period-table td .checkout-value {
  width: 25px;
  height: 25px;
  line-height: 25px;
  text-align: center;
  background-color: #7ed322;
  border-radius: 50%;
  color: #fff;
}

.timecard-period-table td .checkin-edit {
  position: relative;
}

.timecard-period-table td .checkout-value {
  background-color: #4a90e2;
  }

.timecard-period-table td .plus-icon {
  font-size: 18px;
  visibility: hidden;
}

.timecard-period-table td .plus-icon:hover {
  cursor: pointer;
}

.timecard-period-table td:hover .plus-icon {
  visibility: visible;
}

.timecard-period-table td .duration {
  border-radius: 30px;
  background-color: #cfdfff;
  box-shadow: 0 1px 2px 1px rgba(0, 0, 0, 0.25);
  padding: 3px 15px;
  cursor: pointer;
} 

.timecard-period-table td .duration:hover {
  background-color: #b5ceff;
}

.form-group {
  position: relative;
}

.form-group label {
    cursor: text;
    position: absolute;
    font-size: 15px;
    top: 14px;
    left: 13px;
    color: rgb(12, 7, 7);
    z-index: 10;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-align: left;
    transition: top .15s ease-in;
}

.form-group .form-control {
    color: #111;
    position: relative;
    padding: 22px 12px 6px;
    font-size: 16px;
    border-radius: 8px;
    border: 1px solid #ced0d4;
    transition: none;
}

.form-group.active label {
    color: #4a4a4a;
    top: 8px;
    font-size: 12px;
}
.form-group .form-control:not(.ui-select-multiple), .form-group .form-control:not(textarea) {
    height: 49px;
}

.form-group textarea.form-control {
  height: auto !important;
  overflow-wrap: break-word;
}

.modal-footer .btn-actions {
  gap: 20px;
  justify-content: flex-end;
}

.checkin-time {
  font-size: 14px;
}

.checkin-time:hover {
  cursor: pointer;
}

.complete-checkin {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-bottom: 10px;
}

.complete-checkin .d-flex {
  align-items: center;
}

.complete-checkin .title {
  width: 80px;
  font-size: 15px;
}

.complete-checkin .form-inline {
  gap: 10px;
}

.complete-checkin .form-control {
  border-radius: 5px;
  font-size: 15px;
}
</style>
