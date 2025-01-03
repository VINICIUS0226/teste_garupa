<template>
    <v-app>
        <v-main>
            <v-container>
                <TransferList :transfers="transfers" />
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import TransferList from './pages/TransferList.vue';
import axios from 'axios';
import Login from "./LoginComponent.vue";

export default {
    components: {Login, TransferList },
    data() {
        return {
            transfers: [],
        };
    },
    methods: {
        fetchTransfers() {
            axios.get('/transferList')
                .then(response => {
                    this.transfers = response.data;
                });
        },
    },
    mounted() {
        this.fetchTransfers();
    },
};
</script>
