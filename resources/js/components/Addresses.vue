<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <!-- Ref: https://stackoverflow.com/questions/51444735/bootstrap-cardheader-with-buttons-on-the-right -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="font-weight-bold">Addresses</span>
                        <add-button-component button-label="Address" ></add-button-component>
                    </div>
                    <div class="card-body">
                        <address-table-component></address-table-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {}
</script>
