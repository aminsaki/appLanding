<template>
  <div class="card card-body">
    <div class="justify-content-center d-flex p-2">
      <img src="@/users/assets/logo.jpg" class="w-25" alt="">
    </div>

    <div class="result-page card-body">
      <h1>Your Hair Symphony Result</h1>
      <p>{{ resultMessage }}</p>

      <div v-if="resultMessage.includes('Solo')">
        <p v-if="resultMessage.includes('Cello')">Root Resonance — Cello Solo: Your hair speaks with strength and depth. A solo melody that resonates with resilience.</p>
        <p v-if="resultMessage.includes('Harp')">Radiant Strings — Harp Solo: Your hair shines with clarity and grace, a delicate melody of softness and brilliance.</p>
        <p v-if="resultMessage.includes('Piano')">Balanced Harmony — Piano Solo: Your hair sings in perfect tune; calm, steady, and in harmony with itself.</p>
      </div>

      <div v-if="resultMessage.includes('Duo')">
        <p v-if="resultMessage.includes('Cello') && resultMessage.includes('Harp')">Strength & Radiance — Cello + Harp Duo: Your hair’s melody blends power with brilliance, deep roots carrying luminous strands.</p>
        <p v-if="resultMessage.includes('Cello') && resultMessage.includes('Piano')">Grounded Harmony — Cello + Piano Duo: Your hair balances depth and stability, strong foundations with perfect rhythm.</p>
        <p v-if="resultMessage.includes('Harp') && resultMessage.includes('Piano')">Luminous Balance — Harp + Piano Duo: Your hair resonates with serenity and glow, a melody of harmony and brilliance.</p>
      </div>

      <div v-if="resultMessage.includes('Trio')">
        <p>The Complete Symphony — Cello, Harp & Piano: Your hair is in perfect tune. Strength, radiance, and harmony unite to play a full, inspiring symphony.</p>
      </div>

      <button @click="playResult">Experience My Symphony</button>
    </div>
  </div>
</template>

<script setup>
import { useRoute } from 'vue-router';

const route = useRoute();

// دریافت نتیجه از پارامترهای query
const resultMessage = route.query.result || 'No result found.';

const playResult = () => {
  // تابع برای انجام عمل بعدی (مثلاً پخش یا نمایش کامل نتیجه)
  alert('Playing the result');
};
</script>

<style scoped>
.result-page {
  padding: 20px;
  text-align: center;
}
</style>
