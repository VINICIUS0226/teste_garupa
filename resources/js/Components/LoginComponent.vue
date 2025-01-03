<template>
    <v-container fluid fill-height class="d-flex justify-center align-center">
        <v-row justify="center" align="center" class="w-100">
            <v-col cols="12" sm="8" md="6" lg="4">
                <v-card elevation="2" class="pa-4">
                    <v-card-title class="text-h6 font-weight-bold text-center">
                        Login
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-form @submit.prevent="handleLogin" v-model="valid" lazy-validation>
                        <v-text-field
                            v-model="email"
                            label="Email"
                            type="email"
                            required
                            :rules="emailRules"
                            variant="solo"
                            class="mb-4"
                        ></v-text-field>
                        <v-text-field
                            v-model="password"
                            label="Senha"
                            type="password"
                            required
                            variant="solo"
                            :rules="passwordRules"
                            class="mb-4"
                        ></v-text-field>
                        <v-btn type="submit" color="primary" :disabled="!valid" class="w-100">
                            Entrar
                        </v-btn>
                    </v-form>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            email: '',
            password: '',
            dialogCircularLoading: false,
            showResult: false,
            errors: [],
            valid: false,
            emailRules: [
                v => !!v || 'E-mail é obrigatório',
                v => /.+@.+\..+/.test(v) || 'E-mail deve ser válido'
            ],
            passwordRules: [
                v => !!v || 'Senha é obrigatória',
                v => v.length >= 6 || 'Senha deve ter pelo menos 6 caracteres'
            ]
        };
    },
    methods: {
        handleLogin() {
            this.dialogCircularLoading = true;
            axios.post('/login', { email: this.email, password: this.password })
                .then((response) => {
                    this.$router.push({ name: 'transferList' });
                    this.dialogCircularLoading = false;
                })
                .catch((error) => {
                    this.dialogCircularLoading = false;
                    console.error('Erro ao tentar logar:', error.response?.data);
                    this.showResult = true;
                    this.errors = [];

                    if (error.response?.status === 422) {
                        this.errors.push('Usuário ou senha incorreta.');
                    } else if (error.response?.status === 500) {
                        this.errors.push('Algo de errado aconteceu, tente novamente.');
                    } else {
                        this.errors.push(error.response?.data?.message || 'Erro ao tentar logar');
                    }
                });
        },
    },
};
</script>
