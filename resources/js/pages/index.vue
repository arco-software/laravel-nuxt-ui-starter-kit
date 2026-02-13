<script setup lang="js">
    import CurrencyConversionForm from '@/components/CurrencyConversion/Form.vue';
    import CurrencyConversionResult from '@/components/CurrencyConversion/Result.vue';

    const conversionData = ref(undefined);

    const handleSuccess = (responseData) => {
        console.log(responseData);
        conversionData.value = responseData;
    };

    const clearConversionData = () => {
        conversionData.value = undefined;
    };
</script>

<template>
    <main class="mx-auto flex min-h-[100svh] w-full max-w-[80ch] flex-col items-center justify-center px-8">
        <h1 class="text-center text-xl font-medium uppercase">Currency Convertr</h1>
        <CurrencyConversionForm v-if="conversionData === undefined" class="mt-8" @success="handleSuccess" />
        <CurrencyConversionResult v-else :conversionData="conversionData" @reset="clearConversionData" />
    </main>
    <UToaster />
</template>
