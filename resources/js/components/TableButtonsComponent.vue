<template>
    <div>
        <button class="btn btn-primary" @click="handleViewClick">View</button>
        <button class="btn btn-primary" @click="handleEditClick">Edit</button>
        <delete-confirm-button-component 
            :model="row.type" 
            :rowid="row.id"
        ></delete-confirm-button-component>
    </div>
</template>

<script>
export default {
    props: {
        row: Object
    },

    methods: {
        // Ref: https://v3.vuejs.org/guide/events.html
        handleViewClick: function() {
            this.handleRouting("view");
        },
        
        handleEditClick: function() {
            this.handleRouting("edit");
        },

        handleRouting: function(action) {
            // Ref: https://router.vuejs.org/guide/essentials/navigation.html
            this.$router.push({
                path: `${this.row.type}/${this.row.id}`,
                query: { action: action }
            });
        }
    }
}
</script>
