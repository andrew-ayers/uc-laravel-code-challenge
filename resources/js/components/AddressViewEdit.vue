<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <form id="viewedit-form">
                        <h3 class="card-header text-center">Address</h3>
                        <div class="card-body">
                            <addresses-view-edit-component is-from="address" :is-editing="false"></addresses-view-edit-component>
                            <owner-view-edit-component is-from="address" :is-editing="isEditing" @submittedOwner="doOwnerSubmitted"></owner-view-edit-component>
                            <cars-view-edit-component is-from="address" :is-editing="isEditing" @submittedCars="doCarsSubmitted"></cars-view-edit-component>
                        </div>
                        <div class="card-footer text-center">                        
                            <cancel-save-buttons-component :is-editing="isEditing"></cancel-save-buttons-component>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
/**
 * I had to do some research on how to make forms using Vue and
 * Bootstrap - these are the resources I studied (along with Vue
 * and Bootstrap documentation):
 * 
 * Ref: https://vegibit.com/vuejs-form-example/
 * Ref: https://medium.com/@mscherrenberg/laravel-5-6-vue-js-simple-form-submission-using-components-92b6d5fd4434
 */
export default {
    data() {
        return {
            isFrom: 'address',
            ownerSubmitted: false,
            carsSubmitted: false,
            fields: []
        }
    },

    methods: {
        doOwnerSubmitted: function () {
            this.ownerSubmitted = true;

            if (this.ownerSubmitted && this.carsSubmitted) {
                this.$router.go(-1);
            }
        },

        doCarsSubmitted: function () {
            this.carsSubmitted = true;

            if (this.carsSubmitted && this.ownerSubmitted) {
                this.$router.go(-1);
            }
        }
    },

    computed: {
        isEditing: function() {
            return (this.$route.query.action == "edit");
        }
    }
}
</script>