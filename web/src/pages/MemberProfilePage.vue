<template>
  <q-page class="row justify-center items-center">
    <h1>
      {{ $route.params.memberId }}
    </h1>

    <q-btn
      icon="arrow_back"
      @click="$router.back"
    />
  </q-page>
</template>
