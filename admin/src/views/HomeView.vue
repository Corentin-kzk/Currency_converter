<script setup>

import { useQuery } from "@tanstack/vue-query";
import {QUERY_KEY_PAIRS, getPairs} from "../services/api/pairs"

const { isLoading, isFetching, isError, data, error } = useQuery({
  queryKey: [QUERY_KEY_PAIRS],
  queryFn: getPairs,
})
console.log("🚀 ~ file: HomeView.vue:10 ~ isLoading, isFetching, isError, data, error:", isLoading, isFetching, isError, data, error)

</script>

<template>
  <v-container>
    <v-row>
      <h1>List of currencies pairs</h1>
    </v-row>
    <v-row>
      <v-col xs="12" cols="12">
        <v-table>
          <thead>
            <tr>
              <th class="text-left">
                Name
              </th>
              <th class="text-left">
                Calories
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in desserts" :key="item.name">
              <td>{{ item.name }}</td>
              <td>{{ item.calories }}</td>
            </tr>
          </tbody>
        </v-table>
      </v-col>
    </v-row>
  </v-container>
</template>