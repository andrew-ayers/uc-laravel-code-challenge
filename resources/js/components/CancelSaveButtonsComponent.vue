<template>
    <div>
        <button class="btn btn-secondary" @click.prevent="handleCancelClick">Cancel</button>
        <button class="btn btn-primary" v-if="isEditing" @click.prevent="handleSaveClick">Save</button>
    </div>
</template>

<script>
export default {
    props: {
        isEditing: Boolean
    },

    methods: {
        // Ref: https://v3.vuejs.org/guide/events.html
        handleCancelClick: function() {
            this.$router.go(-1);
        },
        
        handleSaveClick: function() {
            // Ref: https://stackoverflow.com/questions/38616167/communication-between-sibling-components-in-vue-js-2-0
            //
            // Note: This whole event emitter thing was because I
            // wanted to have reusable components, to build all the
            // forms with a minimum of repetition of code and 
            // components; I'm not really sure how successful I was
            // there... - ALA
            //
            // So when the use clicks on the "Save" button, we first
            // do a bit of basic form validation...
            //
            if (document.getElementById("viewedit-form").reportValidity()) {
                // Then, if that passes, we emit a "doSubmit" event 
                // signal to our parent's parent component
                //
                this.$parent.$emit("doSubmit");
            }
        }
    }
}
</script>