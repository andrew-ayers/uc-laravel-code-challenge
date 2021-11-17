<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center" v-if="isFrom != 'address'">
                    <span class="font-weight-bold py-3">Address<span v-if="isFrom != 'car'">es</span></span>
                    <link-button-component button-label="Address" v-if="canLink"></link-button-component>
                </div>                
                <div class="container p-2 alert alert-warning border border-warning" v-if="fields.length == 0">No assigned address<span v-if="isFrom != 'car'">es</span> found...</div>
                <div class="container p-0 m-0 border" v-if="fields.length > 0">
                    <div class="container border-bottom">
                        <div class="d-flex flex-row">
                            <div class="d-flex justify-content-left px-3 py-2 font-weight-bold" style="width:100%;">Address</div>
                            <div class="d-flex justify-content-left px-3 py-2 font-weight-bold" style="width:100%;">City</div>
                            <div class="d-flex justify-content-left px-3 py-2 font-weight-bold" style="width:100%;">Country</div>
                            <div class="d-flex justify-content-center px-3 py-2 font-weight-bold" style="width:100%;">Postal Code</div>
                            <div class="d-flex justify-content-center px-3 py-2 font-weight-bold" style="width:100%;" v-if="canUnlink">Remove?</div>
                        </div>
                    </div>
                    <div class="container">
                        <template v-for="(field, index) in fields">                        
                            <div class="d-flex align-items-center flex-row my-0 py-0 form-group" :key="index">
                                <div class="d-flex justify-content-left p-3" style="width:100%;">
                                    <input type="text" :name="'field-address-' + index" class="form-control" v-model="fields[index].address" placeholder="Enter the address" minlength=1 maxlength=255 :readonly="!isEditing" required>
                                </div>
                                <div class="d-flex justify-content-left p-3" style="width:100%;">
                                    <input type="text" :name="'field-city-' + index" class="form-control" v-model="fields[index].city" placeholder="Enter the city" minlength=1 maxlength=255 :readonly="!isEditing" required>
                                </div>
                                <div class="d-flex justify-content-left p-3" style="width:100%;">
                                    <input type="text" :name="'field-country-' + index" class="form-control" v-model="fields[index].country" placeholder="Enter the country" minlength=1 maxlength=255 :readonly="!isEditing" required>
                                </div>
                                <div class="d-flex justify-content-center p-3" style="width:100%;">
                                    <input type="text" :name="'field-postal_code-' + index" class="form-control" v-model="fields[index].postal_code" placeholder="Enter the postal code" minlength=1 maxlength=255 :readonly="!isEditing" required>
                                </div>
                                <div class="d-flex justify-content-center p-3" style="width:100%;" v-if="canUnlink">
                                    <input type="checkbox" :name="'field-remove-' + index" class="form-control form-control-sm" v-model="fields[index].remove">
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
/**
 * I had to do some research on how to make this grid form component
 * using Vue and Bootstrap - these are the resources I studied (along 
 * with Vue and Bootstrap documentation):
 * 
 * Ref: https://5balloons.info/dynamic-v-model-name-binding-in-v-for-loop-vuejs/
 */
export default {
    props: ["isFrom", "isEditing"],

    data() {
        return {
            fields: []
        }
    },

    methods: {
        showAddresses: function () {
            let resturl = "/address"
                + (this.isFrom == "address" ? "" : "/" + this.isFrom) 
                + "/" + this.$route.params.id;

            axios.get(resturl).then(function (res) {
                if (Array.isArray(res.data)) {
                    this.fields = res.data.map(o => ({...o}));
                }
                else {
                    this.fields = [res.data];
                }
            }.bind(this));
            // Ideally, we'd have some error handling here... - ALA
        }
    },

    computed: {
        canLink: function() {
            return (this.$route.params.action == "edit" && ((this.fields.length == 0 && this.isFrom == "car") || this.isFrom != "car"));
        },
 
        canUnlink: function() {
            return (this.$route.params.action == "edit" && this.fields.length > 0 && this.isFrom != "address");
        }
    },

    watch: {
        fields: {
            handler() {
                this.$parent.$emit('inputAddresses', this.fields);
            },
            deep: true
        }
    },

    created: function () {
        this.showAddresses();
    }
}
</script>
