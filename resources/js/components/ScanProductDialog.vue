<template>
    <v-dialog max-width="500px">
        <v-card>
            <v-form v-model="isValid">
                <v-card-title>
                    Product Code Scan
                </v-card-title>
                <v-card-text>
                    <v-text-field
                        v-model="serializedScan"
                        label="Scan the product code"
                        autofocus
                        :rules="rules"
                    ></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="emit('cancel')">Cancel</v-btn>
                    <v-btn :disabled="!isValid" color="blue darken-1" text @click="emit('save', serializedScan)" >Save</v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-dialog>
</template>

<script setup>
    import {ref} from "vue"


    const props = defineProps({
        rules: {
            type: Array,
            required: true
        }

    })

    const emit = defineEmits(['cancel','save'])

    const serializedScan = ref('')

    const isValid = ref(false)
</script>
