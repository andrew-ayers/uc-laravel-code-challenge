<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center" v-if="isFrom != 'car'">
                    <span class="font-weight-bold py-3">Car<span v-if="isFrom != 'car'">s</span></span>
                    <link-button-component button-label="Car" v-if="canLink"></link-button-component>
                </div>                
                <div class="container p-2 alert alert-warning border border-warning" v-if="fields.length == 0">No assigned car<span v-if="isFrom != 'car'">s</span> found...</div>
                <div class="container p-0 m-0 border">
                    <div class="container border-bottom">
                        <div class="d-flex flex-row">
                            <div class="d-flex justify-content-left px-3 py-2 font-weight-bold" style="width:100%;">Make</div>
                            <div class="d-flex justify-content-left px-3 py-2 font-weight-bold" style="width:100%;">Model</div>
                            <div class="d-flex justify-content-center px-3 py-2 font-weight-bold" style="width:100%;">Year</div>
                            <div class="d-flex justify-content-center px-3 py-2 font-weight-bold" style="width:100%;" v-if="canUnlink">Remove?</div>
                        </div>
                    </div>
                    <div class="container">
                        <template v-for="(field, index) in fields">                        
                            <div class="d-flex align-items-center flex-row my-0 py-0 form-group" :key="index">
                                <div class="d-flex justify-content-left text-left p-3" style="width:100%;">
                                    <input type="text" :name="'field-make-' + index" class="form-control" v-model="fields[index].make" placeholder="Enter the make" minlength=1 maxlength=255 :readonly="!isEditing" required>
                                </div>
                                <div class="d-flex justify-content-left text-left p-3" style="width:100%;">
                                    <input type="text" :name="'field-model-' + index" class="form-control" v-model="fields[index].model" placeholder="Enter the model" minlength=1 maxlength=255 :readonly="!isEditing" required>
                                </div>
                                <div class="d-flex justify-content-center text-left p-3" style="width:100%;">
                                    <input type="number" :name="'field-year-' + index" class="form-control" v-model="fields[index].year" placeholder="Enter the year" min=1886 max=9999 :readonly="!isEditing" required>
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
        showCars: function () {
            let resturl = "/car" 
                + (this.isFrom == "car" ? "" : "/" + this.isFrom)
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
            return (this.$route.params.action == "edit");
        },

        canUnlink: function() {
            return (this.$route.params.action == "edit" && this.fields.length > 0 && this.isFrom != "car");
        }        
    },

    watch: {
        fields: {
            handler() {
                this.$parent.$emit('inputCars', this.fields);
            },
            deep: true
        }
    },

    created: function () {
        this.showCars();
    }
}
</script>
