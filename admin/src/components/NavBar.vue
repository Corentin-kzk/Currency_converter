<script setup>
import { store } from '@/services/auth';
import { computed, unref } from 'vue'
import { useDisplay } from 'vuetify'

const display = useDisplay()
const isSmartPhone = computed(() => {
  return unref(display.xs)
})



// Liste des éléments de menu de l'application
const routes = [
  { to: '/', text: 'Accueil' },
  { to: '/admin', text: 'List' },
  { to: '/admin/pair/create', text: 'New pair' }
]
</script>

<template>
  <v-app-bar color="black" scroll-behavior="elevate">
    <v-app-bar-title>Money converter</v-app-bar-title>

    <!-- Menu Mobile -->
    <v-menu v-if="isSmartPhone">
      <template v-slot:activator="{ props }">
        <v-app-bar-nav-icon v-bind="props" />
      </template>

      <v-list>
        <v-list-item v-for="{ to, text } in routes" :to="to" :key="to">
          <v-list-item-title>{{ text }}</v-list-item-title>
        </v-list-item>
        <v-list-item @click="store.handleLogout">
          <v-list-item-title>Log out</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>

    <!-- Menu Desktop -->
    <v-toolbar-items v-else>
      <template v-for="{ to, text } in routes" :key="to">
        <v-btn :to="to" variant="text">{{ text }}</v-btn>
        <v-divider vertical></v-divider>
      </template>
      <v-btn @click="store.handleLogout()" variant="text">log out</v-btn>
    </v-toolbar-items>
  </v-app-bar>
</template>