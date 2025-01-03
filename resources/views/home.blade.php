<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@vuejs/vue@2.6.14/dist/vue.min.js">
    <link href="https://cdn.jsdelivr.net/npm/@vuetifyjs/vuetify@2.5.10/dist/vuetify.min.css">
</head>
<body>
<div id="app">
    <v-app>
        <v-container>
            <v-row justify="center">
                <v-col cols="12" md="8">
                    <v-card>
                        <v-card-title class="text-h5">Bem-vindo, {{ Auth::user()->name }}</v-card-title>
                        <v-card-subtitle>Você está logado!</v-card-subtitle>
                        <v-card-actions>
                            <v-btn color="primary" @click="window.location.href='/transferList'">Ver Transferências</v-btn>
                            <v-btn color="secondary" @click="window.location.href='/logout'">Logout</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-app>
</div>

<script src="https://cdn.jsdelivr.net/npm/@vuetifyjs/vuetify@2.5.10/dist/vuetify.min.js"></script>
</body>
</html>
