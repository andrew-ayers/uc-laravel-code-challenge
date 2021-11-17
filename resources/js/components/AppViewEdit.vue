<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <form id="viewedit-form">
                        <owner-view-edit 
                            :is-editing="isEditing" 
                            v-model="app_fields"
                            :app_fields="app_fields.owners"
                            @inputOwners="(fields) => {app_fields.owners = fields}"
                            @inputAddresses="(fields) => {app_fields.addresses = fields}"
                            @inputCars="(fields) => {app_fields.cars = fields}"
                            v-if="this.$route.params.model == 'owner'" 
                        />
                        <address-view-edit 
                            :is-editing="isEditing" 
                            v-model="app_fields"
                            :addresses="app_fields.addresses"
                            @inputOwners="(fields) => {app_fields.owners = fields}"
                            @inputAddresses="(fields) => {app_fields.addresses = fields}"
                            @inputCars="(fields) => {app_fields.cars = fields}"
                            v-if="this.$route.params.model == 'address'" 
                        />
                        <car-view-edit 
                            :is-editing="isEditing" 
                            v-model="app_fields"
                            :cars="app_fields.cars"
                            @inputOwners="(fields) => {app_fields.owners = fields}"
                            @inputAddresses="(fields) => {app_fields.addresses = fields}"
                            @inputCars="(fields) => {app_fields.cars = fields}"
                            v-if="this.$route.params.model == 'car'" 
                        />
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
 * 
 * Also I needed to implement using the v-model properly on components
 * to simplify how I updated records:
 *  
 * Ref: https://zaengle.com/blog/using-v-model-on-nested-vue-components
 */
import OwnerViewEdit from "./OwnerViewEdit.vue";
import AddressViewEdit from "./AddressViewEdit.vue";
import CarViewEdit from "./CarViewEdit.vue";

export default {
    components: {
        OwnerViewEdit,
        AddressViewEdit,
        CarViewEdit
    },

    data() {
        return {
            app_fields: {
                owners: [],
                addresses: [],
                cars: []
            }
        }
    },

    computed: {
        isEditing: function() {
            return (this.$route.params.action == "edit");
        }
    },

    mounted: function() {
        // Ref: https://stackoverflow.com/questions/38616167/communication-between-sibling-components-in-vue-js-2-0
        //
        // We capture the "doSubmit" event signal from the child
        // CancelSaveButtons component, and update our record(s)
        // as-needed...
        //
        this.$on("doSubmit", () => {
            // Only do the needful if in edit mode...
            //
            if (this.isEditing) {
                /**
                 * Here is how we could call a RESTful service to unlink
                 * record relationships, but that process is outside the 
                 * scope of the exercise.
                 * 
                 * However, code such as below (and the attendant routes to
                 * the service handler controllers/models) could be used
                 * to perform this process - ALA
                 */

                // Check if any records are selected for removal (unlinking)...
                let checks = [ this.app_fields.owners, this.app_fields.addresses, this.app_fields.cars ];

                checks.forEach((check) => {
                    let removeCheck = check.some(item => item.remove);

                    if (removeCheck) {
                        check.forEach((item) => {
                            // Only remove/unlink selected items
                            if (item.remove) {
                                // axios.put("/route/to/unlink/" + item.id, item).then(function (res) { 
                                //     // Do more stuff here...                                     
                                // }.bind(this));
                                //
                                // Just a debugging tool...
                                //console.log("REMOVE-ITEM", item);
                            }
                        });
                    }
                });

                let modelToUpdate = this.$route.params.model;
                let dataToUpdate = {
                    "owner": this.app_fields.owners,
                    "address": this.app_fields.addresses,
                    "car": this.app_fields.cars
                };
                
                // Call the RESTful service to update the data...
                dataToUpdate[modelToUpdate].forEach(item => {
                    axios.put("/" + modelToUpdate + "/" + item.id, item).then(function (res) {
                        // Do more stuff here...?
                    }.bind(this));
                    // Ideally, we'd have some error handling here... - ALA
                });

                // Then return back to the addresses table
                this.$router.go(-1);
            }
        });
    },

    watch: {
        app_fields: {
            handler(val, oldVal) {
                // Just a debugging tool...
                // console.log("APP-FIELDS", this.app_fields);
            },
            deep: true
        }
    }    
}
</script>