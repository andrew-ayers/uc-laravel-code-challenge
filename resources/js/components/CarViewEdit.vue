<template>
    <div>
        <h3 class="card-header text-center">Car</h3>
        <div class="card-body">
            <cars-view-edit-component 
                is-from="car" 
                :is-editing="isEditing" 
            />
            <owner-view-edit-component 
                is-from="car" 
                :is-editing="false" 
            />
            <addresses-view-edit-component 
                is-from="car" 
                :is-editing="false" 
            />
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
import OwnerViewEditComponent from "./OwnerViewEditComponent.vue";
import AddressesViewEditComponent from "./AddressesViewEditComponent.vue";
import CarsViewEditComponent from "./CarsViewEditComponent.vue";

export default {
    components: {
        OwnerViewEditComponent,
        AddressesViewEditComponent,
        CarsViewEditComponent
    },

    props: ["isEditing"],

    data() {
        return {
            app_fields: {
                owners: [],
                addresses: [],
                cars: []
            }
        }
    }         
}
</script>