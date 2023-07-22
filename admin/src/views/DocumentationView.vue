<script setup>
import DocComponent from '@/components/DocComponent.vue';

  const url = process.env.VITE_API_URL || 'http://127.0.0.1:8000'

  const docs = [
  {
    route: '/api/ping',
    description: 'This route is used to check if the API is online and functioning correctly.',
    method: 'GET',
    arguments: 'None',
    successfulResponse: '200 OK with the text "pong"',
    exampleRequest: '/api/ping',
    exampleResponse: 'pong'
  },
  {
    route: '/api/count',
    description: 'This route is used to get the exchange rate between two specified currencies.',
    method: 'GET',
    arguments: "'from' (required): The code of the currency you want to convert from (among 'EUR', 'BTC', and 'USD').'to' (required): The code of the currency you want to convert to (among 'EUR', 'BTC', and 'USD').",
    successfulResponse: '200 OK with the exchange rate between the two specified currencies.',
    exampleRequest: '/api/count?from=EUR&to=USD',
    exampleResponse: '{ count : 118 }'
  },
  {
    route: '/api/pairs',
    description: 'This route returns all available currency pairs along with their respective exchange rates.',
    method: 'GET',
    arguments: 'None',
    successfulResponse: '200 OK with a list of available currency pairs and their exchange rates.',
    exampleRequest: '/api/pairs',
    exampleResponse: '{"pairs":<br/>[{"from":"GBP","to":"EUR","conversion_rate":"0.4000"},<br/>{"from":"GBP","to":"USD","conversion_rate":"0.3000"}<br/>]}'
  },
  {
    route: '/api/convert',
    description: 'This route is used to convert an amount from one currency to another.',
    method: 'GET',
    arguments: "'from' (required): The code of the currency you want to convert from (among 'EUR', 'BTC', and 'USD').'to' (required): The code of the currency you want to convert to (among 'EUR', 'BTC', and 'USD').'amount' (required): The amount you want to convert.",
    successfulResponse: '200 OK with the converted amount in the target currency.', 
    exampleRequest: '/api/convert?from=USD&to=EUR&amount=100',
    exampleResponse: '84.75'
  }
];

</script>

<template>
  <v-container>
    <v-row no-gutters>
      <v-col
        cols="12"
        sm="12"
      >
      <h1 class="mb-2">CurrencyConverter API Documentation</h1>
      <P>Welcome to the MoneyConverter API documentation! This API allows you to convert amounts between different currencies. Below are the available routes along with the details for each route.</P>
      <h2 class="mb-2 mt-1">API Name: CurrencyConverter</h2>
      <h2 class="mb-2">Base URL: {{url}}/api</h2>
      </v-col>
    </v-row>
    <v-row v-for="doc in docs" :key="doc.doc">
        <DocComponent :data="doc" :apiUrl="url"/>
    </v-row>
  </v-container>
</template>