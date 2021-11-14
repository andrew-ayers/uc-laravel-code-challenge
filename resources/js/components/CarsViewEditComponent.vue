<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <label class="font-weight-bold pt-2" v-if="isFrom != 'car'">Cars</label>                    
                <div class="container p-0 m-0 border">
                    <div class="container border-bottom">
                        <div class="d-flex flex-row">
                            <div class="d-flex text-center pl-2 pr-4 py-2 font-weight-bold" v-if="isFrom != 'car'">ID</div>
                            <div class="d-flex text-left px-3 py-2 font-weight-bold" style="width:100%;">Make</div>
                            <div class="d-flex text-left px-3 py-2 font-weight-bold" style="width:100%;">Model</div>
                            <div class="d-flex text-left px-3 py-2 font-weight-bold" style="width:100%;">Year</div>
                        </div>
                    </div>
                    <div class="container">
                        <template v-for="(field, index) in fields">                        
                            <div class="d-flex flex-row my-0 py-0 form-group" :key="index">
                                <div class="d-flex text-center pl-2 pr-4 pt-4 pb-2" v-if="isFrom != 'car'">
                                    <input type="hidden" :name="'field-id-' + index" class="form-control" v-model="field.id">
                                    {{ field.id }}
                                </div>
                                <div class="d-flex text-left p-3" style="width:100%;">
                                    <input type="text" :name="'field-make-' + index" class="form-control" v-model="field.make" placeholder="Enter the make" minlength=1 maxlength=255 :readonly="!isEditing" required>
                                </div>
                                <div class="d-flex text-left p-3" style="width:100%;">
                                    <input type="text" :name="'field-model-' + index" class="form-control" v-model="field.model" placeholder="Enter the model" minlength=1 maxlength=255 :readonly="!isEditing" required>
                                </div>
                                <div class="d-flex text-left p-3" style="width:100%;">
                                    <input type="number" :name="'field-year-' + index" class="form-control" v-model="field.year" placeholder="Enter the year" min=1886 max=9999 :readonly="!isEditing" required>
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
    props: ['isFrom', 'isEditing'],

    data() {
        return {
            fields: []
        }
    },

    methods: {
        showCars: function () {
            let resturl = '/car' 
                + (this.isFrom == 'car' ? '' : '/' + this.isFrom)
                + '/' + this.$route.params.id;

            axios.get(resturl).then(function (res) {
                if (Array.isArray(res.data)) {
                    this.fields = res.data.map(o => ({...o}));
                }
                else {
                    this.fields = [ res.data ];
                }
            }.bind(this));
            // Ideally, we'd have some error handling here... - ALA
        },

        // Call the RESTful service to update the cars data...
        doCarsSubmit: function() {
            // Not the most elegant... - ALA
            this.fields.forEach(car => {
                axios.put('/car/' + car.id, car).then(function (res) {
                }.bind(this));
                // Ideally, we'd have some error handling here... - ALA
            });

            // Let View/Edit component know it was submitted...
            this.$emit("submittedCars");
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
        // component, and call this component's "doCarsSubmit"
        // method...
        //
        this.$parent.$on("doSubmit", () => {
            // Only do the needful if in edit mode...
            this.isEditing && this.doCarsSubmit();
        });
    },

    created: function () {
        this.showCars();
    }
}
</script>
