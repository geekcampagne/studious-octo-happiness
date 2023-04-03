<template>
    <v-dialog max-width="500px">
    <v-card>
      <v-card-title>
          Add a new Parcel
      </v-card-title>
      <v-card-text>
        <v-select
            v-model="carrierValue"
            label="Choose a carrier"
            :items="carrierItems"
            variant="underlined"
        ></v-select>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="emit('cancel')">Cancel</v-btn>
        <v-btn color="blue darken-1" text @click="emit('save',carrierValue)">Save</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
import { ref } from "vue";
const emit = defineEmits(['cancel','save'])

const carrierValue = ref('')
const carrierItems = ref(['UPS', 'FedEx', 'DHL', 'TNT'])
</script>
