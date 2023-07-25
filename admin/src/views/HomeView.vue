<script setup>

import { useQuery, useMutation, useQueryClient } from "@tanstack/vue-query";
import { QUERY_KEY_PAIRS, getPairs, deletePair } from "../services/api/pairs"
import { ref } from 'vue'
import router from "@/router";

const { data: pairs } = useQuery({
  queryKey: [QUERY_KEY_PAIRS],
  queryFn: getPairs,
})

const dialog = ref(false)

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
function handleDelete(pair) {
  mutation.mutateAsync(pair.id)
  dialog.value = false
}
</script>

<template>
  <v-container>
    <v-row>
      <h1>List of currencies pairs</h1>
    </v-row>
    <v-row align="center">
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
              <th>
                Update/Delete
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in pairs" :key="item.from">
              <td>{{item.from_name}} <span>({{ item.from }})</span> </td>
              <td> {{item.to_name}} <span>({{ item.to }})</span> </td>
              <td>{{ item.conversion_rate }}</td>
              <td>{{ item.count }}</td>
              <td> <v-btn density="compact" color="green" @click="handleUpdate(item.id)">Update</v-btn>
                <v-btn density="compact" color="red" @click="dialog = item">Delete</v-btn>
              </td>
            </tr>
          </tbody>
        </v-table>
      </v-col>
    </v-row>
    <v-dialog v-model="dialog" persistent width="auto">
      <v-card>
        <v-card-title class="text-h5 text-center">
          Are you sure you want to delete this pair?
        </v-card-title>
        <v-card-text class="text-center"> {{ dialog.from }} -> {{ dialog.to }}</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green-darken-1" variant="text" @click="dialog = false">
            Disagree
          </v-btn>
          <v-btn color="red-darken-1" variant="text" @click="handleDelete(dialog)">
            Agree
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<style scoped>
td {
  width: 25%;
}

td > span {
  font-size: 12px;
  font-style: italic;
}
</style>