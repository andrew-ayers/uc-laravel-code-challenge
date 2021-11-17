<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center font-weight-bold" v-if="isFrom != 'owner'">
                    <div class="d-flex py-2">Owner</div>
                </div>                
                <div class="container p-2 alert alert-warning border border-warning" v-if="fields.length == 0">No assigned owner found...</div>
                <template v-for="(field, index) in fields">
                    <div class="container py-3 border" :key="index">
                        <div class="container">
                            <div class="form-group">
                                <label :for="'field-first_name-' + index" class="font-weight-bold">First Name</label>
                                <input type="text" :name="'field-first_name-' + index" class="form-control" v-model="fields[index].first_name" placeholder="Enter the first name" minlength=1 maxlength=255 :readonly="!isEditing" required>
                            </div>
                            <div class="form-group">
                                <label :for="'field-last_name-' + index" class="font-weight-bold">Last Name</label>
                                <input type="text" :name="'field-last_name-' + index" class="form-control" v-model="fields[index].last_name" placeholder="Enter the last name" minlength=1 maxlength=255 :readonly="!isEditing" required>
                            </div>
                        </div>
                        <div class="d-flex py-0 font-weight-bold">
                            <div class="d-flex container justify-content-end align-items-center">
                                <link-button-component button-label="Owner" v-if="canLink"></link-button-component>
                                <div class="d-flex flex-nowrap align-items-center" v-if="canUnlink">
                                    <div class="d-flex pr-2">Remove?</div>
                                    <div class="d-flex">
                                        <input type="checkbox" :name="'field-remove-' + index" class="form-control" v-model="fields[index].remove" style="width: 2em;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["isFrom", "isEditing"],

    data() {
        return {
            fields: []
        }
    },

    methods: {
        showOwners: function() {
            let resturl = "/owner"
                + (this.isFrom == "owner" ? "" : "/" + this.isFrom) 
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
        },
    },

    computed: {
        canLink: function() {
            return (this.$route.params.action == "edit" && this.fields.length == 0);
        },
 
        canUnlink: function() {
            return (this.$route.params.action == "edit" && this.fields.length > 0 && this.isFrom != "owner");
        }        
    },

    watch: {
        fields: {
            handler() {
                this.$parent.$emit('inputOwners', this.fields);
            },
            deep: true
        }
    },
    
    created: function() {
        this.showOwners();
    }
}
</script>