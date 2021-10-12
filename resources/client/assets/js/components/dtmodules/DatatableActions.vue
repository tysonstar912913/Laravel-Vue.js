<template>
    <div class="btn-group btn-group-xs">
        <router-link :to="{ name: xprops.route + '.show', params: { id: row.id } }" class="btn btn-primary btn-xs">
            View
        </router-link>
        <router-link :to="{ name: xprops.route + '.edit', params: { id: row.id } }" class="btn btn-warning btn-xs">
            Edit
        </router-link>
        <button @click="destroyData(row.id)" type="button" class="btn btn-danger btn-xs">
            Delete
        </button>
   </div>
</template>


<script>
export default {
    props: ['row', 'xprops'],
    data() {
        return {
            // Code...
        }
    },
    created() {
        // Code...
    },
    methods: {
        destroyData(id) {
            this.$swal({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                confirmButtonColor: '#dd4b39',
                focusCancel: true,
                reverseButtons: true
            }).then(result => {
                if (result.value) {
                    this.$store.dispatch(
                        this.xprops.module + '/destroyData',
                        id
                    ).then(result => {
                        this.$eventHub.$emit('delete-success')
                    })
                }
            })
        }
    }
}
</script>


<style scoped>

</style>
