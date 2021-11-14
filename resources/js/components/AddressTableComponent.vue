<template>
    <div>
        <address-table-averages-component></address-table-averages-component>
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
                    label: 'Address',
                    field: 'address',
                    headerAlign: 'left',
                    align: 'left',
                    interpolate: true,
                    representedAs: function (r) {
                        return r.address + '<br>' + r.city + '<br>' + r.country + '<br>' + r.postal_code;
                    }
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
                    label: 'Cars',
                    field: 'cars_count',
                    headerAlign: 'center',
                    align: 'center'
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
        showAddresses: function () {
            axios.get('/address').then(function (res) {
                this.rows = res.data.map(o => ({...o, 'type': 'address'}));
            }.bind(this));
        }
    },
    created: function () {
        this.showAddresses()
    }
}
</script>
