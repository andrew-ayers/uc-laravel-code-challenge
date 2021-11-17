<template>
    <button class="btn btn-primary" @click.prevent="handleLinkClick">Assign {{ this.buttonLabel }}</button>
</template>

<script>
export default {
    props: {
        buttonLabel: String
    },

    methods: {
        // Note: For future expansion... - ALA
        handleLinkClick: function() {
            alert("The " + this.buttonLabel + "-Assignment functionality is outside of the scope of this exercise, and is currently not implemented...");
        }
    }
}
</script>
