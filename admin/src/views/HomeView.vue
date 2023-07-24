<script setup>

import { useQuery, useMutation, useQueryClient } from "@tanstack/vue-query";
import { QUERY_KEY_PAIRS, getPairs, deletePair } from "../services/api/pairs"
import { ref, watch } from 'vue'
import router from "@/router";

const { data: pairs } = useQuery({
  queryKey: [QUERY_KEY_PAIRS],
  queryFn: getPairs,
})

const dialog = ref(true)



const queryClient = useQueryClient()

const mutation = useMutation({
    mutationFn: deletePair,
    onSuccess: () => {
        queryClient.invalidateQueries({ queryKey: [QUERY_KEY_PAIRS] })
        router.push('/admin')
    },
})

function handleUpdate(id) {
  router.push(`/admin/pair/update/${id}`)
}
function handleDelete(id){
  mutation.mutateAsync(id)
}
</script>

<template>
  <v-container>
    <v-row>
      <h1>List of currencies pairs</h1>
    </v-row>

    <v-row>
      <v-col xs="12" cols="12">

        <v-table fixed-header height="80vh">
          <thead>
            <tr>
              <th class="text-left">
                From
              </th>
              <th class="text-left">
                To
              </th>
              <th class="text-left">
                Conversion rate
              </th>
              <th>
                Conversion call
              </th>

            </tr>

          </thead>
          <tbody>
            <tr v-for="item in pairs" :key="item.from">
              <td>{{ item.from }}</td>
              <td>{{ item.to }}</td>
              <td>{{ item.conversion_rate }}</td>
              <td>{{ item.count }}</td>
              <td> <v-btn density="compact" color="green" @click="handleUpdate(item.id)">Update</v-btn>
                <v-btn density="compact" color="red"  @click="handleDelete(item.id)">Delete</v-btn>
              </td>
            </tr>
          </tbody>
        </v-table>
      </v-col>
    </v-row>
  </v-container>
</template>

<style scoped>
td {
  width: 25%;
}
</style>