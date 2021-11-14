<template>
    <div>
        <bootstrap-4-datatable :columns="columns" :data="rows" :filter="filter" :per-page="perPage" class="table-bordered"></bootstrap-4-datatable>
        <bootstrap-4-datatable-pager v-model="page" type="abbreviated"></bootstrap-4-datatable-pager>
    </div>
</template>

<script>
import TableButtonsComponent from "./TableButtonsComponent";

// Ref: https://gerkindev.github.io/vuejs-datatable/

export default {
    data() {
        return {
            columns: [
                {
                    label: 'ID',
                    field: 'id',
                    align: 'center'
                },
                {
                    label: 'Make',
                    field: 'make',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: 'Model',
                    field: 'model',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: 'Year',
                    field: 'year',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: 'Owner',
                    field: 'full_name',
                    headerAlign: 'left',
                    align: 'left',
                    representedAs: function (r) {
                        return r.owner.first_name + ' ' + r.owner.last_name;
                    }
                },
                {
                    label: 'Address',
                    field: 'address',
                    headerAlign: 'left',
                    align: 'left',
                    interpolate: true,
                    representedAs: function (r) {
                        return r.address.address + '<br>' + r.address.city + '<br>' + r.address.country + '<br>' + r.address.postal_code;
                    }
                },
                {
                    label: 'Actions',
                    headerAlign: 'right',
                    align: 'right',
                    component: TableButtonsComponent
                }
            ],
            rows: [],
            page: 1,
            filter:  '',
            perPage: 20,
            loading: true
        }
    },
    methods: {
        showCars: function () {
            axios.get('/car').then(function (res) {
                this.rows = res.data.map(o => ({...o, 'type': 'car'}));
            }.bind(this));
        }
    },
    created: function () {
        this.showCars()
    }
}
</script>
