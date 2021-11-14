<template>
    <div class="container border p-2">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="container">
                    <div class="row">
                        <div class="col-sm font-weight-bold text-center">
                            Average # Cars Per Address: {{ this.data.cars.average }}
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
                cars: {
                    average: null
                }
            }
        }
    },

    methods: {
        showAverages: function () {
            axios.get('averages/address').then(function (res) {
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