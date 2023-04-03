<template>
    <v-container>
        <v-row>
            <v-col>
                <v-card
                    v-if="order.customer"
                    max-width="400"
                    min-height="300"
                    class="mx-auto">
                    <v-card-title class="font-weight-bold">{{ order.customer.company }}</v-card-title>
                    <v-card-subtitle>{{ order.customer.first_name }} {{ order.customer.last_name }}</v-card-subtitle>
                    <v-card-text>
                        <p>
                            {{ order.customer.address }}<br/>
                            {{ order.customer.zip_code }}&nbsp;{{ order.customer.city }}<br/>
                            {{ order.customer.country }}
                        </p>
                    </v-card-text>
                    <v-card-text><v-icon icon="mdi-phone"/>{{ order.customer.phone }}</v-card-text>
                    <v-card-text><v-icon icon="mdi-email"/>{{ order.customer.email }}</v-card-text>
                </v-card>
            </v-col>
            <v-col cols="6" md="6">
                <v-card max-width="400" min-height="300"
                    class="mx-auto">
                    <v-card-title>Order N°{{order.id}} on {{order.order_date}}</v-card-title>
                    <v-card-subtitle>{{order.status}}</v-card-subtitle>
                    <v-card-text v-if = "order.delivery_date !== null">Delivery Date : {{order.delivery_date}}</v-card-text>
                    <v-card-text v-if = "order.closing_date !== null">Closing Date : {{order.closing_date}}</v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <v-card class="pt-3 mt-3 mr-3 pr-3 ml-3 pl-3">
            <v-card-title>Products</v-card-title>
            <v-data-table
                :headers="headers"
                :items="order.products"
                :loading="loading"
                :items-length="totalItems"
                :items-per-page="5"
                :item-value="item => item"
            >
            <template
                #[`item.parcel`]="{ item }">
              <span v-if="item.value.parcel !== null">
                {{ item.value.parcel.id +' - '+ item.value.parcel.carrier }}
              </span>
            </template>
                <template v-slot:item.actions="{item}">
                    <v-btn
                        class="rounded-xl btn_action"
                        :disabled = "item.props.value.serial_number !== null"
                        @click="scanProduct(item.props.value)"
                        value="item"
                    >
                        <v-icon
                            small
                            icon="mdi-barcode-scan"

                       />
                    </v-btn>
                    <v-btn
                        class="rounded-xl btn_action"
                        :disabled = "item.props.value.parcel !== null"
                        @click="addParcel(item.props.value)"
                        value="item"
                    >
                        <v-icon
                            icon = "mdi-package-variant"
                            small
                        />
                    </v-btn>
                </template>
            </v-data-table>
        </v-card>
        <v-card class="pt-3 mt-3 mr-3 pr-3 ml-3 pl-3">
            <v-card-title>
                <v-row>
                    <v-col>
                    Parcels
                    </v-col>
                    <v-col class="text-right">
                    <v-btn
                        class="rounded-xl btn_action"
                        :disabled = "order.closing_date !== null"
                        @click="createParcel">
                        <v-icon
                            icon="mdi-package-variant-plus"
                            small
                        />
                    </v-btn>
                    </v-col>
                </v-row>
            </v-card-title>
            <v-data-table
                :headers="headersParcels"
                :items="order.parcels"
                :loading="loading"
                :items-per-page="-1"
                :item-value="item => item"
            >
                <template v-slot:item.actions="{item}">
                    <v-btn
                        round="true"
                        class="rounded-xl btn_action"
                        :disabled = "item.props.value.shipping_date !== null"
                        @click="sendParcel(item.props.value)"
                        value="item"
                    >
                        <v-icon
                        icon="mdi-truck"
                        small

                        />
                    </v-btn>
                </template>

            </v-data-table>
        </v-card>
        <scan-product-dialog
            v-model="scanDialog"
            :rules="serializedRules"
            @cancel = "() => scanDialog = false"
            @save = "saveScanProduct"
        />
        <add-parcel-dialog
            v-model="parcelDialog"
            :parcels="parcels"
            @cancel = "() => parcelDialog = false"
            @save = "saveParcel"
        />
        <add-tracking-dialog
            v-model="trackingDialog"
            @cancel = "() => trackingDialog = false"
            @save = "saveTracking"
        />
        <create-parcel-dialog
            v-model="displayParcelDialog"
            @cancel = "() => displayParcelDialog = false"
            @save = "saveNewParcel"
        />
    </v-container>
</template>

<script setup>
    import { onMounted ,ref} from 'vue'
    import {useRouter} from "vue-router";
    const router = useRouter()
    const headers = ref([
        {key: 'id', title: 'ID', value: 'id'},
        {key: 'type',title: 'Product',value: 'type'},
        {key: 'version',title: 'Version',value: 'version'},
        {key: 'serial_number',title: 'SN',value: 'serial_number'},
        {key: 'weight',title: 'Weight',value: 'weight'},
        {key: 'parcel',title: 'Parcel',value: 'parcel'},
        {key: 'actions', title: "Actions", sortable: false, align: 'center' },

    ])
    const headersParcels = ref([
        {key: 'id', title: 'ID', value: 'id'},
        {key: 'carrier',title: 'Carrier',value: 'carrier'},
        {key: 'products_count',title: 'Products',value: 'products_count'},
        {key: 'weight',title: 'Weight',value: 'weight'},
        {key: 'shipping_date',title: 'Shipping',value: 'shipping_date'},
        {key: 'tracking_number',title: 'Tracking',value: 'tracking_number'},
        {key: 'delivery_date',title: 'Delivery',value: 'delivery_date'},
        {key: 'actions', title: "Actions", sortable: false, align: 'center' },
    ])
    const totalItems = ref(0)
    const loading = ref(true)
    const page = ref(1)
    const props = defineProps({
        order: {
            type: Object,
            required: false
        }
    })
    const order = ref({})
    let parcels = ref([])

    let parcelDialog = ref(false)
    let parcelDialogItem = ref({})

    let scanDialog = ref(false)
    let scanDialogItem = ref({})

    let displayParcelDialog = ref(false)


    let trackingDialog = ref(false)
    let trackingDialogItem = ref({})

    onMounted( ()=> {
            fetchOrder()
        }
    )

    const fetchOrder = async () => {
        const response = await fetch(`/api/order/` +router.currentRoute.value.params.id)
        order.value = await response.json()
        parcels = order.value.parcels
    }

    const serializedRules = [
        v => !!v || 'Product code is required',
        v => /^(KeyNetic|KeyVibe)_V\d{1}_\w{6}$/.test(v) || 'Product code must be in format KeyNetic_VX_XXXXXX or KeyVibe_VX_XXXXXX'
    ]

    const scanProduct = (item) => {
        scanDialogItem = item
        scanDialog.value = true
    }

    const saveScanProduct = (scan) => {
        const requestOptions = {
            method: "PATCH",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                'serialized_scan': scan
            })
        };
        callApi("/api/product/"+scanDialogItem.id+"/scan", requestOptions)

        scanDialog.value = false
    }

    const addParcel = (item) => {
        parcelDialogItem = item
        parcelDialog.value = true
    }

    const saveParcel = (parcelItem) => {
        const requestOptions = {
            method: "PATCH",
        };
        callApi("/api/product/"+parcelDialogItem.id+"/parcel/"+parcelItem, requestOptions)

        parcelDialog.value = false
    }

    const saveTracking = (tracking) => {
        const requestOptions = {
            method: "PATCH",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                'tracking_number': tracking
            })
        };
        callApi("/api/parcel/"+trackingDialogItem.id+"/tracking", requestOptions)

        trackingDialog.value = false
    }

    const sendParcel = (item) => {
        trackingDialogItem = item
        trackingDialog.value = true
    }

    const createParcel = (item) => {
        displayParcelDialog.value = true
    }

    const saveNewParcel =  (carrierValue) => {
        const requestOptions = {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                'carrier': carrierValue
            })
        };
        callApi("/api/order/"+order.value.id+"/newparcel", requestOptions)

        displayParcelDialog.value = false
    }

    const callApi = async (url, options) => {
        await fetch(url, options).then(
            (response) => {
                if (response.ok) {
                    fetchOrder()
                } else {
                    throw new Error("Something went wrong ...");
                }
            }
        )
    }


</script>
