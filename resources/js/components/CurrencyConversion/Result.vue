<script setup lang="js">
    import dayjs from 'dayjs';

    const emits = defineEmits(['reset']);

    const props = defineProps({
        conversionData: {
            type: Object,
            default: undefined,
        },
    });

    const date = computed(() => dayjs(props.conversionData?.correct_at).format("D MMM 'YY HH:mm"));

    const reset = () => {
        emits('reset');
    };
</script>

<template>
    <div class="mt-8 flex w-full flex-col items-center justify-center text-center">
        <h2 class="text-lg font-semibold">
            {{ conversionData.from.amount }} {{ conversionData.from.currency }} = {{ conversionData.to.amount }} {{ conversionData.to.currency }}
        </h2>
        <p class="text-xs">Correct as of {{ date }}</p>
    </div>
    <UButton class="mt-8 w-full cursor-pointer justify-center" label="Start again" icon="i-lucide-rocket" type="button" @click="reset" />
</template>
