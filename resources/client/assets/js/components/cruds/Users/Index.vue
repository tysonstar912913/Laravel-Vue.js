<template>
  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
      <h1>Users</h1>
    </section>

    <section class="content">
      <div class="row">
        <div class="w-100">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List</h3>
            </div>

            <div class="box-body"></div>

            <div class="box-body">
              <div class="row" v-if="loading">
                <div class="col-xs-4 col-xs-offset-4">
                  <div class="alert text-center">
                    <i class="fa fa-spin fa-refresh"></i> Loading
                  </div>
                </div>
              </div>

              <datatable
                v-if="!loading"
                :columns="columns"
                :data="data"
                :total="total"
                :query="query"
                :xprops="xprops"
                :selection="selectedUsers"
              >
                <div class="d-flex">
                  <div class="btn-group">
                    <router-link
                      :to="{ name: xprops.route + '.create' }"
                      class="btn btn-success btn-sm"
                    >
                      <i class="fa fa-plus"></i> Add new
                    </router-link>
                    <button
                      type="button"
                      class="btn btn-secondary btn-sm"
                      @click="fetchData"
                    >
                      <i
                        class="fa fa-refresh"
                        :class="{ 'fa-spin': loading }"
                      ></i>
                      Refresh
                    </button>
                  </div>
                  <div class="dropdown ml-auto mr-1">
                    <button
                      class="btn btn-secondary dropdown-toggle btn-sm"
                      type="button"
                      id="dropdownMenuButton"
                      data-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                      Actions
                    </button>
                    <div
                      class="dropdown-menu"
                      aria-labelledby="dropdownMenuButton"
                    >
                      <a
                        class="dropdown-item"
                        href="#"
                        @click="handleProjectAssign"
                        >Assign Project(s)</a
                      >
                    </div>
                  </div>
                </div>
              </datatable>
            </div>
          </div>
        </div>
      </div>
    </section>

    <Modal v-show="isModalVisible" @close="closeModal" showBtn="true" modalSize="modal-md">
      <div slot="header">Assign Project(s)</div>
      <div slot="body">
        <div class="tags-wrapper">
          <vue-tags-input
            v-model="tag"
            :tags="tags"
            :add-only-from-autocomplete="true"
            :autocomplete-items="filteredItems"
            placeholder="Input projects"
            :separators="[',']"
            @tags-changed="(newTags) => (tags = newTags)"
          />
        </div>
        <div class="table-wrapper mt-3">
          <table class="assign-users-table">
            <thead>
              <tr>
                <th style="width: 70px">Avatar</th>
                <th>Name</th>
                <th>Titles</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(user, index) in selectedUsers" v-bind:key="user.id">
                <td>
                  <img
                    :src="'/storage/' + user.avatar"
                    :alt="user.first_name"
                    @error="handleAvatarError"
                  />
                </td>
                <td>{{ user.first_name }}</td>
                <td>
                  <select
                    class="form-control"
                    aria-label="Default select example"
                    @change="e => handleAssignUserIitle(index, e)"
                  >
                    <option selected>Select Title</option>
                    <option
                      v-for="title in user.titles"
                      v-bind:key="title.id"
                      :value="
                        titlesAll.find(
                          (iTitle) => iTitle.id == title.title_id,
                        ) &&
                          titlesAll.find(
                            (iTitle) => iTitle.id == title.title_id,
                          ).title
                      "
                    >
                      {{
                        titlesAll.find(
                          (iTitle) => iTitle.id == title.title_id,
                        ) &&
                          titlesAll.find(
                            (iTitle) => iTitle.id == title.title_id,
                          ).title
                      }}
                    </option>
                  </select>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div slot="footer" class="w-100">
        <div class="w-100 d-flex">
          <button
            class="btn btn-success ml-auto"
            type="button"
            @click="handleSubmitAssign"
          >
            Assign
          </button>
        </div>
      </div>
    </Modal>
  </section>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import DatatableActions from '../../dtmodules/DatatableActions'
import DatatableSingle from '../../dtmodules/DatatableSingle'
import DataColumnTitle from '../../dtmodules/DataColumnTitle'
import DataColumnImage from '../../dtmodules/DataColumnImage'
// import DataColumnTitle from './DataColumnTitle'
import DatatableCheckbox from '../../dtmodules/DatatableCheckbox'

export default {
  data() {
    return {
      columns: [
        { title: '#', field: 'id', sortable: true, colStyle: 'width: 50px;' },
        { title: 'Avatar', field: 'avatar', tdComp: DataColumnImage },
        { title: 'FirstName', field: 'first_name', sortable: true },
        { title: 'LastName', field: 'last_name', sortable: true },
        { title: 'Email', field: 'email', sortable: true },
        { title: 'EmployeeNumber', field: 'employee_number', sortable: true },
        { title: 'Role', field: 'role', tdComp: DatatableSingle },
        { title: 'Title', field: 'titles', tdComp: DataColumnTitle },
        { title: 'Rate', field: 'rate', sortable: true },
        { title: 'PhoneNumber', field: 'phone_number', sortable: true },
        {
          title: 'Actions',
          tdComp: DatatableActions,
          visible: true,
          thClass: 'text-right',
          tdClass: 'text-right',
          colStyle: 'width: 130px;',
          tdStyle: 'vertical-align: middle',
        },
      ],
      query: { sort: 'id', order: 'asc' },
      xprops: {
        module: 'UsersIndex',
        route: 'users',
      },
      selectedUsers: [],

      // modal
      isModalVisible: false,

      // project assign tags
      tag: '',
      tags: [],
      projectNamesAll: ['A'],
      autocompleteItems: [
        {
          text: 'Spain',
        },
        {
          text: 'France',
        },
        {
          text: 'USA',
        },
        {
          text: 'Germany',
        },
        {
          text: 'China',
        },
      ],
    }
  },
  created() {
    this.$root.relationships = this.relationships
    this.fetchTitlesAll()
    this.fetchData()
    this.fetchProjectsAll()
  },
  destroyed() {
    this.resetState()
  },
  computed: {
    ...mapGetters('UsersIndex', ['data', 'total', 'loading', 'relationships']),
    ...mapGetters('UsersSingle', ['titlesAll']),
    ...mapGetters('ProjectsIndex', { projectsAll: 'all' }),
    filteredItems() {
      const items = this.projectsAll
        .filter((i) => {
          return i.project.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1
        })
        .map((i) => ({ id: i.id, text: i.project }))
      // console.log('this.projectsAll:', this.projectsAll)
      // console.log('items:', items)
      // console.log('tag:', this.tag)
      return items
    },
  },
  watch: {
    query: {
      handler(query) {
        this.setQuery(query)
      },
      deep: true,
    },
  },
  methods: {
    ...mapActions('UsersIndex', ['fetchData', 'setQuery', 'resetState', 'assignProject']),
    ...mapActions('UsersSingle', ['fetchTitlesAll']),
    ...mapActions('ProjectsIndex', { fetchProjectsAll: 'fetchData' }),
    handleProjectAssign: function(e) {
      e.preventDefault()
      this.showModal()
    },
    showModal() {
      this.isModalVisible = true
    },
    closeModal() {
      this.isModalVisible = false
    },
    handleAvatarError(e) {
      e.target.src = '/adminlte/img/default-user-avatar.png'
    },
    handleSubmitAssign(e) {
      console.log("tags:", this.tags)
      console.log("selectedUsers:", this.selectedUsers)

      const data = {
        users: this.selectedUsers.map(user => ({
          id: user.id,
          title: user.selectedTitle,
        })),
        projects: this.tags.map(project => ({
          id: project.id,
        })),
      }

      console.log("data:", data)

      this.assignProject(data)
      this.closeModal()
    },
    handleAssignUserIitle(index, e) {
      this.selectedUsers[index].selectedTitle = e.target.value
    }
  },
}
</script>

<style>
.vue-tags-input {
  max-width: unset !important;
  width: 100%;
}

.ti-input {
  height: 40px;
}

.assign-users-table {
  width: 100%;
  border-collapse: collapse;
}

.assign-users-table img {
  width: 45px;
  height: 45px;
  border-radius: 50%;
}

.assign-users-table th {
  border: 1px solid #ddd;
  vertical-align: middle;
  font-size: 14px;
  text-align: center;
  height: 40px;
  padding: 10px;
}

.assign-users-table td {
  border: 1px solid #ddd;
  vertical-align: middle;
  font-size: 14px;
  text-align: center;
  padding: 10px;
}
</style>
