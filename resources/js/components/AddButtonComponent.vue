<template>
    <button class="btn btn-primary" @click.prevent="handleAddClick">Add {{ this.buttonLabel }}</button>
</template>

<script>
export default {
    props: {
        buttonLabel: String
    },

    methods: {
        // Note: For future expansion... - ALA
        handleAddClick: function() {
            alert("The Add-" + this.buttonLabel + " functionality is outside of the scope of this exercise, and is currently not implemented...");
        }
    }
}
</script>
