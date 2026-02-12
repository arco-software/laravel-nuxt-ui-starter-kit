<script setup lang="js">
    import FormLabel from '@/components/form/Label.vue';
    import FormMessage from '@/components/form/Message.vue';
    import apiCall from '@/lib/apiCall';
    import { toTypedSchema } from '@vee-validate/zod';
    import { Field, useForm } from 'vee-validate';
    import * as z from 'zod';

    const currencies = [
        {
            label: '🇬🇧 British Pound Sterling',
            value: 'GBP',
        },
        {
            label: '🇺🇸 US Dollar',
            value: 'USD',
        },
        {
            label: '🇪🇺 Euro',
            value: 'EUR',
        },
    ];

    const loading = ref(false);

    const formSchema = toTypedSchema(
        z.object({
            amount: z.coerce.number().min(0).multipleOf(0.01),
            fromCurrency: z.string().min(3).max(3),
            toCurrency: z.string().min(3).max(3),
        })
    );

    const { handleSubmit, resetForm, values } = useForm({
        validationSchema: formSchema,
        initialValues: {
            amount: 1,
            fromCurrency: 'GBP',
            toCurrency: 'USD',
        },
    });

    const onSubmit = handleSubmit(async (values, actions) => {
        try {
            loading.value = true;
            const response = await apiCall('convert-currency', 'post', {
                data: values,
            });
        } catch (e) {
            console.error(e);
            if (e.status === 422) {
                actions.setErrors(e.response.data.errors);
            }
        } finally {
            loading.value = false;
        }
    });
</script>

<template>
    <form class="grid w-full grid-cols-1 gap-4 md:grid-cols-3" @submit="onSubmit">
        <div class="w-full md:col-span-3">
            <Field v-slot="{ componentField }" name="amount">
                <FormLabel> Amount </FormLabel>
                <UInputNumber v-bind="componentField" class="w-full" />
                <FormMessage />
            </Field>
        </div>
        <div class="flex flex-col gap-2">
            <Field v-slot="{ componentField }" name="fromCurrency">
                <Label> Convert from </Label>
                <USelect v-bind="componentField" :items="currencies" />
                <FormMessage />
            </Field>
        </div>
        <div class="flex flex-col gap-2">
            <Field v-slot="{ componentField }" name="toCurrency">
                <Label> Convert to </Label>
                <USelect v-bind="componentField" :items="currencies" />
                <FormMessage />
            </Field>
        </div>
        <div class="flex h-full flex-col justify-end">
            <UButton class="w-full" label="Convert" icon="i-lucide-rocket" type="submit" />
        </div>
    </form>
</template>
