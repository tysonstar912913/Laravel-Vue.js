<template>
  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
      <h1>Project</h1>
    </section>

    <section class="content">
      <div class="row">
        <div class="w-100">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">View</h3>
            </div>

            <div class="box-body">
              <back-buttton></back-buttton>
            </div>

            <div class="box-body">
              <div class="row">
                <div class="col-xs-6">
                  <table class="table table-bordered table-striped">
                    <tbody>
                      <tr>
                        <th>#</th>
                        <td>{{ item.id }}</td>
                      </tr>
                      <tr>
                        <th>Project</th>
                        <td>{{ item.project }}</td>
                      </tr>
                      <tr>
                        <th>Project number</th>
                        <td>{{ item.project_number }}</td>
                      </tr>
                      <tr>
                        <th>Status</th>
                        <td>{{ item.status }}</td>
                      </tr>
                      <tr>
                        <th>Start date</th>
                        <td>{{ item.start_date }}</td>
                      </tr>
                      <tr>
                        <th>End date</th>
                        <td>{{ item.end_date }}</td>
                      </tr>
                      <tr>
                        <th>Country</th>
                        <td>{{ item.country }}</td>
                      </tr>
                      <tr>
                        <th>Address</th>
                        <td>{{ item.address }}</td>
                      </tr>
                      <tr>
                        <th>City</th>
                        <td>{{ item.city }}</td>
                      </tr>
                      <tr>
                        <th>Region</th>
                        <td>{{ item.region }}</td>
                      </tr>
                      <tr>
                        <th>Postal Code</th>
                        <td>{{ item.postal_code }}</td>
                      </tr>
                      <tr>
                        <th>Map Scale1</th>
                        <td>{{ item.longitude }}</td>
                      </tr>
                      <tr>
                        <th>Map Scale2</th>
                        <td>{{ item.latitude }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </section>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  data() {
    return {
      // Code...
    }
  },
  created() {
    this.fetchData(this.$route.params.id)
  },
  destroyed() {
    this.resetState()
  },
  computed: {
    ...mapGetters('ProjectsSingle', ['item']),
  },
  watch: {
    '$route.params.id': function() {
      this.resetState()
      this.fetchData(this.$route.params.id)
    },
  },
  methods: {
    ...mapActions('ProjectsSingle', ['fetchData', 'resetState']),
  },
}
</script>

<style scoped></style>
