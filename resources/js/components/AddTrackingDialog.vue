<template>
    <v-dialog max-width="500px">
    <v-card>
      <v-card-title>
          Sending Parcel
      </v-card-title>
      <v-card-text>
        <v-text-field
          v-model="tracking_number"
          clearable
          label="Add tracking number"
          autofocus></v-text-field>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="emit('cancel')">Cancel</v-btn>
        <v-btn color="blue darken-1" text @click="emit('save',tracking_number)">Save</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>

const emit = defineEmits(['cancel','save'])

const tracking_number = ''

</script>
