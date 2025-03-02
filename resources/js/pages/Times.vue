<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { ref, watch } from 'vue';

interface Time {
    year: number;
    month: number;
    day: number;
    hour: number;
    minute: number;
    timezone: string;
}

const times = ref<Time[]>([]);

const today = new Date();

const currentTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

const computedTimes = ref<string[]>({});

watch(
    times,
    (newTimes: Array<Time>) =>
        newTimes.map(function (time: Time, index: number) {
            fetch(
                route('iapi.times', {
                    time: {
                        ...time,
                        currentTimezone,
                    },
                }),
            )
                .then((response) => response.json())
                .then(({ time }) => (computedTimes.value[index] = time));
        }),
    { deep: true },
);

const addTime = () =>
    times.value.push({
        year: today.getFullYear(),
        month: today.getMonth() + 1,
        day: today.getDate(),
        hour: today.getHours(),
        minute: today.getMinutes(),
        timezone: currentTimezone,
    });

addTime();
</script>

<template>
    <AppLayout>
        <div class="flex flex-col divide-y-2">
            <fieldset
                v-for="(time, index) in times"
                :key="index"
                :data-key="index"
                class="flex flex-col py-2"
            >
                <div class="flex flex-row space-x-2">
                    <Label :for="`year-${index}`" class="flex-1">
                        Year
                        <Input :id="`year-${index}`" v-model="time.year" type="number" />
                    </Label>
                    <Label :for="`month-${index}`" class="flex-1">
                        Month
                        <Input :id="`month-${index}`" v-model="time.month" type="number" />
                    </Label>
                    <Label :for="`day-${index}`" class="flex-1">
                        Day
                        <Input :id="`day-${index}`" v-model="time.day" type="number" />
                    </Label>
                </div>
                <div class="flex flex-row space-x-2">
                    <Label :for="`hour-${index}`" class="flex-1">
                        Hour
                        <Input :id="`hour-${index}`" v-model="time.hour" type="number" />
                    </Label>
                    <Label :for="`minute-${index}`" class="flex-1">
                        Minute
                        <Input :id="`minute-${index}`" v-model="time.minute" type="number" />
                    </Label>
                    <Label :for="`timezone-${index}`" class="flex-1">
                        Timezone
                        <Input :id="`timezone-${index}`" v-model="time.timezone" type="text" />
                    </Label>
                </div>
                <div class="text-2xl" v-text="computedTimes[index]" />
            </fieldset>
        </div>
        <Button class="mt-2" @click.prevent="addTime()">Add Time</Button>
    </AppLayout>
</template>

<style scoped></style>
