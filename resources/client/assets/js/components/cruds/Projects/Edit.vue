<template>
  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
      <h1>Projects</h1>
    </section>

    <section class="content">
      <div class="row">
        <div class="w-100">
          <form @submit.prevent="submitForm" autocomplete="off">
            <div class="box">
              <div class="box-header with-border">
                <h3 v-if="isCreate" class="box-title">Create</h3>
                <h3 v-else class="box-title">Edit</h3>
              </div>

              <div class="box-body d-flex justify-content-between">
                <back-buttton></back-buttton>
                <button
                  type="submit"
                  class="btn btn-primary btn-sm ml-auto"
                  :isLoading="loading"
                  :disabled="loading"
                  @click="handleShowMap"
                >
                  <span v-if="isCreate">Create Project</span>
                  <span v-else>Save</span>
                </button>
              </div>

              <bootstrap-alert />

              <div class="box-body row">
                <div class="col-md-6 col-sm-12">
                  <div class="form-group">
                    <input
                      type="text"
                      class="form-control"
                      name="project"
                      placeholder="Project"
                      :value="item.project"
                      @input="updateProject"
                    />
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <input
                          type="text"
                          class="form-control"
                          name="project_number"
                          placeholder="Project Number"
                          :value="item.project_number"
                          @input="updateProjectNumber"
                        />
                      </div>
                      <div class="col-md-6">
                        <v-select
                          name="status"
                          label="status"
                          @input="updateStatus"
                          :value="item.status"
                          :options="statusOptions"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <datepicker
                          input-class="form-control"
                          name="start_date"
                          placeholder="Start date"
                          :value="item.start_date"
                          @input="updateStartDate"
                          :config="options"
                        />
                      </div>
                      <div class="col-md-6">
                        <datepicker
                          input-class="form-control"
                          name="end_date"
                          placeholder="End date"
                          :value="item.end_date"
                          @input="updateEndDate"
                          :config="options"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <input
                      type="text"
                      class="form-control"
                      name="country"
                      placeholder="Country"
                      :value="item.country"
                      @input="updateCountry"
                    />
                  </div>
                  <div class="form-group">
                    <input
                      type="text"
                      class="form-control"
                      name="country"
                      placeholder="Address"
                      :value="item.address"
                      @input="updateAddress"
                    />
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <input
                          type="text"
                          class="form-control"
                          name="city"
                          placeholder="City"
                          :value="item.city"
                          @input="updateCity"
                        />
                      </div>
                      <div class="col-md-6">
                        <input
                          type="text"
                          class="form-control"
                          name="region"
                          placeholder="Region"
                          :value="item.region"
                          @input="updateRegion"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <input
                      type="text"
                      class="form-control"
                      name="country"
                      placeholder="Postal Code"
                      :value="item.postal_code"
                      @input="updatePostalCode"
                    />
                  </div>
                  <div class="form-group row">
                    <div class="col-md-4">
                      <button
                        type="button"
                        class="btn btn-secondary btn-sm"
                        @click="handleShowMap"
                      >
                        Show on a map
                      </button>
                    </div>
                    <div class="col-md-4">
                      <input
                        type="text"
                        class="form-control"
                        name="longitude"
                        placeholder="Longitude"
                        :value="item.longitude"
                        @input="updateLongitude"
                        @keypress="isNumber($event)"
                      />
                    </div>
                    <div class="col-md-4">
                      <input
                        type="text"
                        class="form-control"
                        name="latitude"
                        placeholder="Latitude"
                        :value="item.latitude"
                        @input="updateLatitude"
                        @keypress="isNumber($event)"
                      />
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-sm-12 d-flex flex-direction-column">
                  <div class="map-wrapper w-100">
                    <iframe class="w-100"></iframe>
                  </div>
                </div>
              </div>
            </div>
          </form>
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
      statusOptions: ['Active', 'In Deck'],
      options: {
        format: 'YYYY-MM-DD',
        useCurrent: false,
      }
    }
  },
  computed: {
    ...mapGetters('ProjectsSingle', ['item', 'loading']),
    isCreate: function() {
      return !(this.$route.params && this.$route.params.id)
    },
  },
  created() {
    if (this.$route.params.id) {
      // edit
      this.fetchData(this.$route.params.id)
    } else {
      // create
    }
  },
  destroyed() {
    this.resetState()
  },
  watch: {
    '$route.params.id': function() {
      this.resetState()
      this.fetchData(this.$route.params.id)
    },
  },
  methods: {
    ...mapActions('ProjectsSingle', [
      'storeData',
      'updateData',
      'resetState',
      'setProject',
      'setProjectNumber',
      'setStatus',
      'setStartDate',
      'setEndDate',
      'setCountry',
      'setAddress',
      'setCity',
      'setRegion',
      'setPostalCode',
      'setLongitude',
      'setLatitude',
      'fetchData',
    ]),
    updateProject(e) {
      this.setProject(e.target.value)
    },
    updateProjectNumber(e) {
      this.setProjectNumber(e.target.value)
    },
    updateStatus(e) {
      this.setStatus(e)
    },
    updateStartDate(e) {
      this.setStartDate(e)
    },
    updateEndDate(e) {
      this.setEndDate(e)
    },
    updateCountry(e) {
      this.setCountry(e.target.value)
    },
    updateAddress(e) {
      this.setAddress(e.target.value)
    },
    updateCity(e) {
      this.setCity(e.target.value)
    },
    updateRegion(e) {
      this.setRegion(e.target.value)
    },
    updatePostalCode(e) {
      this.setPostalCode(e.target.value)
    },
    updateLongitude(e) {
      this.setLongitude(e.target.value)
    },
    updateLatitude(e) {
      this.setLatitude(e.target.value)
    },
    submitForm() {
      if (this.$route.params.id) {
        // edit
        this.updateData()
          .then(() => {
            this.$router.push({ name: 'projects.index' })
            this.$eventHub.$emit('update-success')
          })
          .catch((error) => {
            console.error(error)
          })
      } else {
        this.storeData()
          .then(() => {
            this.$router.push({ name: 'projects.index' })
            this.$eventHub.$emit('create-success')
          })
          .catch((error) => {
            console.error(error)
          })
      }
    },
    handleShowMap(e) {},
    isNumber: function(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
        evt.preventDefault();;
      } else {
        return true;
      }
    }
  },
}
</script>

<style scoped></style>
