<script setup>
const props = defineProps(['data', 'apiUrl'])
console.log(props.data)

</script>

<template>
    <div class="my-3 w-100 container">
        <v-card-title class="doc-title"><strong>Route:</strong> <a :href="props.apiUrl+props.data.route" target="_blank"
                rel="noopener noreferrer">{{ props.apiUrl }}{{ props.data.route }}</a></v-card-title>
        <v-card-text class="doc-text">
            <p><strong>Description:</strong> {{ props.data.description }}</p>
            <p><strong>Method:</strong> {{ props.data.method }}</p>
            <p><strong>Arguments:</strong> {{ props.data.arguments }}</p>
            <p><strong>Successful Response:</strong> {{ props.data.successfulResponse }}</p>
            <p><strong>Example Request:</strong> <code v-html="props.data.exampleRequest"></code></p>
            <p><strong>Example Response:</strong> <code v-html="props.data.exampleResponse"></code></p>
        </v-card-text>
    </div>
</template>

<style scoped>
.container {
    border-top: 2px solid black !important;
    padding: 15px;
}

.container a {
    color: red;
    font-weight: 600;
}

.doc-title {
    font-size: 20px;
    margin-bottom: 10px;
}

.doc-text {
    margin-bottom: 10px;
}

strong {
    font-weight: bold;
}

code { display: block;
    background-color: black;
    color: azure;
    padding: 10px 15px;
    border-radius: 3px;
    font-family: 'Courier New', Courier, monospace;
}
</style>