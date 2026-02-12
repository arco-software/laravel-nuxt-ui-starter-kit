<script setup lang="js">
  import CurrencyConversionForm from '@/components/CurrencyConversion/Form.vue'
  const value = ref(0)
</script>

<template>
  <main class="mx-auto flex min-h-[100svh] w-full max-w-[80ch] flex-col items-center justify-center px-8">
    <h1 class="text-xl font-medium uppercase">Currency Convertr</h1>
    <CurrencyConversionForm class="mt-8" />
  </main>
</template>
