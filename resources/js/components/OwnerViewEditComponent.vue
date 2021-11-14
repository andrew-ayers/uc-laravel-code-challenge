<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <label class="font-weight-bold pt-2" v-if="isFrom != 'owner'">Owner</label>                    
                <div class="container p-0 m-0 border">
                    <div class="container pt-1">
                        <div class="form-group">
                            <label for="ownerFirstName" class="font-weight-bold">First Name</label>
                            <input type="text" class="form-control" id="ownerFirstName" v-model="fields.first_name" placeholder="Enter the first name" minlength=1 maxlength=255 :readonly="!isEditing" required>
                        </div>
                        <div class="form-group">
                            <label for="ownerLastName" class="font-weight-bold">Last Name</label>
                            <input type="text" class="form-control" id="ownerLastName" v-model="fields.last_name" placeholder="Enter the last name" minlength=1 maxlength=255 :readonly="!isEditing" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['isFrom', 'isEditing'],

    data() {
        return {
            fields: {
                first_name: '',
                last_name: ''
            }
        }
    },

    methods: {
        showOwner: function() {
            let resturl = '/owner' 
                + (this.isFrom == 'owner' ? '' : '/' + this.isFrom) 
                + '/' + this.$route.params.id;

            axios.get(resturl).then(function (res) {
                this.fields = res.data;
            }.bind(this));
            // Ideally, we'd have some error handling here... - ALA
        },

        // Call the RESTful service to update the owner data...
        doOwnerSubmit: function() {
            axios.put('/owner/' + this.$route.params.id, this.fields).then(function (res) {
                // Let View/Edit component know it was submitted...
                this.$emit("submittedOwner");
            }.bind(this));
            // Ideally, we'd have some error handling here... - ALA
        },    
    },

    mounted: function() {
        // Ref: https://stackoverflow.com/questions/38616167/communication-between-sibling-components-in-vue-js-2-0
        //
        // Note: This whole event emitter thing was because I
        // wanted to have reusable components, to build all the
        // forms with a minimum of repetition of code and 
        // components; I'm not really sure how successful I was
        // there... - ALA
        //
        // We capture the "doSubmit" event signal from our sibling
        // component, and call this component's "doOwnerSubmit" 
        // method...
        //
        this.$parent.$on("doSubmit", () => {
            // Only do the needful if in edit mode...
            this.isEditing && this.doOwnerSubmit();
        });
    },
    
    created: function() {
        this.showOwner();
    }
}
</script>