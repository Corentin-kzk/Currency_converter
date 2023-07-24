<script setup>
import { defineProps, reactive } from "vue";
import { useQuery, useMutation,useQueryClient } from "@tanstack/vue-query";
import { QUERY_KEY_PAIRS, getPair, updatePair } from "../services/api/pairs"
import router from "@/router";

const queryClient = useQueryClient()

const props = defineProps({
    id: {
        type: String,
        required: true,
    }
})

const form = reactive({
    from: "",
    to: "",
    conversion_rate: ""
})

const { isLoading, isSuccess } = useQuery({
    queryKey: [QUERY_KEY_PAIRS],
    queryFn: () => getPair(props.id),
    onSuccess: (data) => {
        form.from = data.from
        form.to = data.to
        form.conversion_rate = data.conversion_rate
    }
})

const mutation = useMutation({
    mutationFn: updatePair,
    onSuccess: () => {
        queryClient.invalidateQueries({ queryKey: [QUERY_KEY_PAIRS] })
        router.push('/admin');
    },
})

function onUpdateSubmit() {
    mutation.mutateAsync({ from: form.from, to: form.to, conversion_rate: form.conversion_rate, id: props.id })
}
</script>

<template>
    <v-container>
        <v-row>
            <h1>Update Pair</h1>
        </v-row>
        <v-row v-if="isLoading && !isSuccess">
            <v-progress-circular :size="50" color="primary" indeterminate></v-progress-circular>
        </v-row>
        <v-form @submit.prevent="onUpdateSubmit" v-else>
            <v-row>
                <v-col>
                    <v-responsive class="mx-auto my-4">
                        <v-text-field v-model="form.from" clearable hide-details="auto" disabled
                            label="From"></v-text-field>
                    </v-responsive>
                </v-col>
                <v-col>
                    <v-responsive class="mx-auto my-4">
                        <v-text-field v-model="form.to" clearable hide-details="auto" disabled label="to"></v-text-field>
                    </v-responsive>
                </v-col>
            </v-row>


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