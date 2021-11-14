<template>
    <div class="container border p-2">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="container">
                    <div class="row">
                        <div class="col-sm font-weight-bold text-center">
                            Average # Addresses Per Owner: {{ this.data.addresses.average }}
                        </div>
                        <div class="col-sm font-weight-bold text-center">
                            Average # Cars Per Owner: {{ this.data.cars.average }}
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            data: {
                addresses: {
                    average: null
                },
                cars: {
                    average: null
                }
            }
        }
    },

    methods: {
        showAverages: function () {
            axios.get('averages/owner').then(function (res) {
                this.data = res.data;
            }.bind(this));
            // Ideally, we'd have some error handling here... - ALA
        }
    },

    created: function() {
        this.showAverages();
    }
}
</script>