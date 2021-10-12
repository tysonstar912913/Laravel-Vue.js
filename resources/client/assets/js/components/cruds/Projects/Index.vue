<template>
  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
      <h1>Projects</h1>
    </section>

    <section class="content">
      <div class="row">
        <div class="w-100">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List</h3>
            </div>

            <div class="box-body">
              <div class="btn-group">
                <router-link
                  :to="{ name: xprops.route + '.create', params: {} }"
                  class="btn btn-success btn-sm"
                  v-if="hasCreatePermission"
                >
                  <i class="fa fa-plus"></i> Add new
                </router-link>
                <button
                  type="button"
                  class="btn btn-secondary btn-sm"
                  @click="fetchData"
                >
                  <i class="fa fa-refresh" :class="{ 'fa-spin': loading }"></i>
                  Refresh
                </button>
              </div>
            </div>

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
              />
            </div>
          </div>
        </div>
      </div>
    </section>
  </section>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import axios from 'axios'
import DatatableActions from '../../dtmodules/DatatableActions'
import DatatableSingle from '../../dtmodules/DatatableSingle'
import DatatableList from '../../dtmodules/DatatableList'
import DatatableCheckbox from '../../dtmodules/DatatableCheckbox'

export default {
  data() {
    return {
      columns: [
        { title: '#', field: 'id', sortable: true, colStyle: 'width: 50px;' },
        { title: 'Project', field: 'project', sortable: true },
        { title: 'Number', field: 'project_number', sortable: true },
        { title: 'Status', field: 'status', sortable: true },
        { title: 'Start date', field: 'start_date', sortable: true },
        { title: 'Est. end date', field: 'end_date', sortable: true },
        { title: 'Country', field: 'country', sortable: true },
        { title: 'Address', field: 'address', sortable: true },
        { title: 'City', field: 'city', sortable: true },
        { title: 'Region', field: 'region', sortable: true },
        { title: 'Postal Code', field: 'postal_code', sortable: true },
        { title: 'Longitude', field: 'longitude', sortable: true },
        { title: 'Latitude', field: 'latitude', sortable: true },
        {
          title: 'Actions',
          tdComp: DatatableActions,
          visible: true,
          thClass: 'text-right',
          tdClass: 'text-right',
          colStyle: 'width: 130px;',
        },
      ],
      query: { sort: 'id', order: 'asc' },
      xprops: {
        module: 'ProjectsIndex',
        route: 'projects',
      },
    }
  },
  created() {
    this.$root.relationships = this.relationships
    this.fetchData()
    this.fetchAuth()
  },
  destroyed() {
    this.resetState()
  },
  computed: {
    ...mapGetters('ProjectsIndex', [
      'data',
      'total',
      'loading',
      'relationships',
    ]),
    ...mapGetters('Auth', [
      'auth'
    ]),
    hasCreatePermission: function() {
      // get the user's permision info

      return this.auth && this.auth.role && this.auth.role.title === "Admin"
    },
    hasEditPermission: function() {
      return this.auth && this.auth.role && this.auth.role.title === "Admin"
    }
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
    ...mapActions('ProjectsIndex', ['fetchData', 'setQuery', 'resetState']),
    ...mapActions('Auth', ['fetchAuth']),
  },
}
</script>

<style scoped></style>
