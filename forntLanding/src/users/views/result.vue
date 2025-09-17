<template>
  <div class="result-page">
    <h1>Your Hair Symphony Result</h1>
    <p>{{ resultMessage }}</p>
  </div>
</template>

<script setup>
import { useRoute } from 'vue-router';

const route = useRoute();

// Get the result message from the query parameters
const resultMessage = route.query.result || 'No result found.';
</script>

<style scoped>
.result-page {
  padding: 20px;
  text-align: center;
}
</style>
