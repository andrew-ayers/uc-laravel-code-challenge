<template>
    <button class="btn btn-danger" @click.prevent="handleDeleteClick">Delete</button>
</template>

<script>
export default {
    props: {
        row: Object
    },
    
    methods: {
        // Ref: https://v3.vuejs.org/guide/events.html
        handleDeleteClick: function() {
            // If I had more time, I'd do something better 
            // using Vue and Bootstrap, but this will work
            // ok for now - ALA
            if (confirm("Are you sure you want to delete this " + this.row.type + "?")) {
                axios.delete('/' + this.row.type + '/' + this.row.id).then(function (res) {
                    this.$router.go(0);
                }.bind(this));
                // Ideally, we'd have some error handling here... - ALA
            }
        }
    }
}
</script>
