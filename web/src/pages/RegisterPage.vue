<template>
  <q-page
    padding
    class="column items-center"
  >
    <q-card class="w-full max-w-screen-sm">
      <q-card-section>
        <h1 class="text-h5">
          Daftar menjadi anggota
        </h1>
      </q-card-section>

      <q-separator spaced />

      <q-card-section class="q-pb-lg">
        blablabla
      </q-card-section>

      <q-separator spaced />

      <q-card-actions align="between">
        <q-btn
          label="Masuk"
          flat
          color="blue-grey"
          icon="chevron_left"
          :to="{name: 'Login'}"
        />
        <q-btn
          label="Daftar"
          type="submit"
          color="primary"
          form="form_register"
        />
      </q-card-actions>
    </q-card>
  </q-page>
</template>
