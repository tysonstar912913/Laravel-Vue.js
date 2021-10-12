<template>
  <section class="content-wrapper" style="min-height: 960px;">
    <div class="dashboard-page">
      <!-- <div class="search-box">
        <datepicker
          input-class="form-control"
          name="search_date"
          placeholder="search_date"
          :value="searchDate"
        />
        <v-select
          name="status"
          label="status"
          :value="searchOrder"
          :options="searchOrderAll"
        />
        <v-select
          name="status"
          label="status"
          @input="updateStatus"
          :value="searchStatus"
          :options="searchStatusAll"
        />
      </div> -->
      <div class="cards-container">
        <div
          class="card-wrapper"
          v-for="project in projectsAll"
          v-bind:key="project.id"
        >
          <DashboardCard :project="project" />
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import DashboardCard from './DashboardCard.vue'

export default {
  data() {
    return {
      searchDate: new Date(),
      searchOrder: '',
      searchStatus: '',
      searchOrderAll: [],
      searchStatusAll: ['Active', 'In Deck'],
    }
  },
  computed: {
    ...mapGetters('Alert', ['message', 'errors', 'color']),
    ...mapGetters('ProjectsIndex', { projectsAll: 'allAssigns' }),
  },
  created() {
    this.fetchProjectsAll()
  },
  destroyed() {
    this.resetState()
  },
  watch: {
    '$route.params.id': function() {
      this.resetState()
    },
  },
  methods: {
    ...mapActions('Alert', ['resetState']),
    ...mapActions('ProjectsIndex', { fetchProjectsAll: 'fetchDataWithAssign' }),
  },
  components: {
    DashboardCard: DashboardCard,
  },
}
</script>

<style lang="scss" scoped>
.cards-container {
  padding: 20px;
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}

.search-box {
  display: flex;
  align-items: center;
  justify-content: flex-end;
}
</style>
