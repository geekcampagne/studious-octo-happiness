:
<template>
    <v-container>
        <v-row dense>
            <v-col>
                <v-card class="pt-3 mt-3 mr-3 pr-3 ml-3 pl-3">
                    <v-card-title>Orders</v-card-title>
                    <v-card-text>
                        <v-data-table-server
                            :items-per-page="itemsPerPage"
                            :headers="headers"
                            :items-length="totalItems"
                            :items="orders"
                            :loading="loading"
                            @update:options="getOrders"
                            @click:row="(_,{item}) => goToOrderPage(item.value)"
                        >
                        </v-data-table-server>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
    import {ref} from "vue"
    import {useRouter} from "vue-router";

    const router = useRouter()
    const headers = ref([
        {key: 'order_date',title: 'Date',value: 'order_date'},
        {key: 'company', title: 'Company', value: 'company'},
        {key: 'products_count', title: 'Products', value: 'products_count', sortable: false},
        {key: 'status', title: 'Status', value: 'status'}
    ])
    const totalItems = ref(0)
    const itemsPerPage = ref(10)
    const loading = ref(true)
    const orders = ref([])

    const getOrders = async (orderListing) => {
        const {page, itemsPerPage, sortBy = [] } = orderListing
        let orderQuery = ''
        if (sortBy.length) {
            orderQuery = '&order_by='+sortBy[0].key+'&order_direction='+sortBy[0].order
        }
        loading.value = true
        const response = await fetch('/api/orders?page='+page+'&per_page='+itemsPerPage+orderQuery)
        const {data,total}= await response.json()
        orders.value = data
        totalItems.value = total
        loading.value = false
    }

    const goToOrderPage = (id) => {
        router.push({name: 'Order', params: {id}})
    }

</script>
