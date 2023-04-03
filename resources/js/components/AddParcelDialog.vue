<template>
    <v-dialog max-width="500px">
    <v-card>
      <v-card-title>
          Add Parcel
      </v-card-title>
      <v-card-text>
        <v-select
            v-model="parcelItem"
            label="Choose a parcel"
            :items="parcels"
            variant="underlined"
            item-title="carrier"
            item-value="id"

            return-object
        ></v-select>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="emit('cancel')">Cancel</v-btn>
        <v-btn color="blue darken-1" text @click="emit('save', parcelItem.id)">Save</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
import {ref} from "vue"
const props = defineProps({
    parcels: {
            type: Array,
            required: true
        }
})
const emit = defineEmits(['cancel','save'])

const parcelItem = ref(null)

</script>
