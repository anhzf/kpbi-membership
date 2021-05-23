<template>
  <v-container fluid class="fill-height">
    <v-row justify="center" align="stretch">
      <v-card width="320" class="elevation-4 mb-16">
        <v-form @submit.prevent="onSubmit">
          <v-card-title>Upload bukti transfer</v-card-title>

          <v-card-text>
            <v-file-input
              v-model="file"
              label="Upload bukti transfer"
              name="file"
            />

            <v-text-field
              v-model="forExpiration"
              name="expiration"
              label="Untuk masa berlaku (tahun)"
            />
          </v-card-text>

          <v-card-actions>
            <v-btn type="submit" color="primary" text>Submit</v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: 'PageUploadDocument',
  data() {
    return {
      forExpiration: '',
      file: null,
    };
  },
  methods: {
    onSubmit(e) {
      console.log(e);
    },
  },
};
</script>
