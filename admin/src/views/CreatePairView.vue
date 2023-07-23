<script setup>
import { reactive } from "vue";
import { useMutation } from "@tanstack/vue-query";
import { QUERY_KEY_PAIRS, getPair, updatePair, createPair } from "../services/api/pairs"
import { getCurrencies, QUERY_KEY_CURRENCY } from '../services/api/currencies'


const form = reactive({
    from: "",
    to: "",
    conversion_rate: ""
})

const mutation = useMutation({
    mutationFn: createPair,
    onSuccess: () => {
        // this.invalidateQueries({ queryKey: [QUERY_KEY_PAIRS] })
    },
})

function onUpdateSubmit() {
    mutation.mutateAsync({ from: form.from, to: form.to, conversion_rate: form.conversion_rate })
}
</script>

<template>
    <v-container>
        <v-row>
            <h1>Create Pair</h1>
        </v-row>
        <v-row v-if="isLoading && !isSuccess">
            <v-progress-circular :size="50" color="primary" indeterminate></v-progress-circular>
        </v-row>
        <v-form @submit.prevent="onUpdateSubmit" v-else>
            <v-responsive class="mx-auto my-4">
                <v-text-field v-model="form.from" clearable hide-details="auto" label="from"></v-text-field>
            </v-responsive>
            <v-responsive class="mx-auto my-4">
                <v-text-field v-model="form.to" clearable hide-details="auto" label="to"></v-text-field>
            </v-responsive>
            <v-responsive class="mx-auto my-4">
                <v-text-field v-model="form.conversion_rate" clearable hide-details="auto"
                    label="Conversion rate"></v-text-field>
            </v-responsive>
            <v-btn block type="submit" class="mb-8" color="blue" size="large" variant="green">
                Update
            </v-btn>
        </v-form>
    </v-container>
</template>