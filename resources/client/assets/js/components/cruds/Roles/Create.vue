<template>
  <section class="content-wrapper" style="min-height: 960px;">
    <section class="content-header">
      <h1>Roles</h1>
    </section>

    <section class="content">
      <div class="row">
        <div class="w-100">
          <form @submit.prevent="submitForm" autocomplete="off">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Create</h3>
              </div>

              <div class="box-body">
                <back-buttton></back-buttton>
              </div>

              <bootstrap-alert />

              <div class="box-body">
                <div class="form-group">
                  <label for="title">Title</label>
                  <input
                    type="text"
                    class="form-control"
                    name="title"
                    placeholder="Enter Title"
                    :value="item.title"
                    @input="updateTitle"
                  />
                </div>
              </div>
              <div class="d-flex flex-wrap">
                <div
                  class="toggle-wrapper w-25 text-center"
                  v-for="permission in permissionsAll"
                  v-bind:key="permission.id"
                >
                  <toggle-button
                    :sync="true"
                    :value="
                      item.permissions.findIndex(
                        (userPermission) =>
                          userPermission.permission == 1 &&
                          userPermission.permission_id ==
                            permission.id,
                      ) > -1
                    "
                    :color="{
                      checked: '#00cc88',
                      unchecked: '#aaa',
                      disabled: '#CCCCCC',
                    }"
                    :labels="{
                      checked: permission.title,
                      unchecked: permission.title,
                    }"
                    :font-size="16"
                    :width="250"
                    :height="42"
                    @change="
                      (value) =>
                        updatePermissions(permission.id, value)
                    "
                  />
                </div>
              </div>
              <div class="box-footer">
                <vue-button-spinner
                  class="btn btn-primary btn-sm"
                  :isLoading="loading"
                  :disabled="loading"
                >
                  Save
                </vue-button-spinner>
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
      // Code...
    }
  },
  computed: {
    ...mapGetters('RolesSingle', ['item', 'loading', 'permissionsAll']),
  },
  created() {
    this.fetchPermissionsAll()
  },
  destroyed() {
    this.resetState()
  },
  methods: {
    ...mapActions('RolesSingle', ['storeData', 'resetState', 'setTitle', 'fetchPermissionsAll', 'setPermissions']),
    updateTitle(e) {
      this.setTitle(e.target.value)
    },
    updatePermissions(permission_id, value) {
      this.setPermissions({ permission_id, value: value.value })
    },
    submitForm() {
      this.storeData()
        .then(() => {
          this.$router.push({ name: 'roles.index' })
          this.$eventHub.$emit('create-success')
        })
        .catch((error) => {
          console.error(error)
        })
    },
  },
}
</script>

<style scoped></style>
