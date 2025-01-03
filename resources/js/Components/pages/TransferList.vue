<template>
    <v-container class="py-5">
        <v-card elevation="2" class="pa-4">
            <v-card-title class="text-h6 font-weight-bold">
                Lista de Transferências
            </v-card-title>
            <v-divider></v-divider>
            <v-data-table
                dense
                :headers="headers"
                :items="transfers"
                class="elevation-1 mt-4"
                loading-text="Carregando transferências... Por favor aguarde!"
            >
                <template v-slot:item.created_at="{ item }">
                    {{ formatDate(item.created_at) }}
                </template>

                <template v-slot:item.amount="{ item }">
                    <span class="text-center">R$ {{ formatAmount(item.amount) }}</span>
                </template>

                <template v-slot:item.status="{ item }">
                    <v-chip
                        :color="item.status === 'completed' ? 'green' : 'red'"
                        dark
                        small
                    >
                        {{ item.status }}
                    </v-chip>
                </template>

                <template v-slot:item.due_date="{ item }">
                    <span>{{ item.due_date ? formatDate(item.due_date) : 'Não informada' }}</span>
                </template>

                <template v-slot:item.actions="{ item }">
                    <v-btn
                        color="primary"
                        @click="viewTransferDetails(item)"
                    >
                        Ver Detalhes
                    </v-btn>
                </template>

                <template #top>
                    <v-toolbar flat>
                        <v-toolbar-title>Transferências</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="primary"
                            dark
                            @click="newTransfer"
                        >
                            Nova Transferência
                        </v-btn>
                    </v-toolbar>
                </template>
            </v-data-table>
        </v-card>

        <v-dialog v-model="dialogVisible" max-width="700px">
            <v-card class="pa-8" elevation="3">
                <v-card-title class="text-h5 font-weight-bold text-center">
                    Detalhes da Transferência
                </v-card-title>
                <v-card-text>
                    <v-form>
                        <v-text-field
                            :value="selectedTransfer.external_id"
                            label="ID Externo"
                            readonly
                            outlined
                            class="mb-4"
                            variant="solo"
                        />

                        <v-text-field
                            :value="formatAmount(selectedTransfer.amount)"
                            label="Quantia"
                            readonly
                            outlined
                            prefix="R$"
                            class="mb-4"
                            variant="solo"
                        />

                        <v-text-field
                            :value="formatDate(selectedTransfer.expected_on)"
                            label="Data Esperada"
                            readonly
                            outlined
                            type="date"
                            class="mb-4"
                            variant="solo"
                        />

                        <v-text-field
                            :value="selectedTransfer.status"
                            label="Status"
                            readonly
                            outlined
                            class="mb-4"
                            variant="solo"
                        />
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-btn
                        color="secondary"
                        @click="dialogVisible = false"
                    >
                        Fechar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>


        <v-dialog v-model="dialogVisibleNew" max-width="700px">
            <v-card class="pa-8" elevation="3">
                <v-card-title class="text-h5 font-weight-bold text-center">
                    Nova Transferência
                </v-card-title>
                <v-card-text>
                    <v-form @submit.prevent="createTransfer" ref="form">
                        <v-text-field
                            v-model="externalId"
                            label="ID Externo"
                            required
                            outlined
                            class="mb-4"
                            variant="solo"
                        />

                        <v-text-field
                            v-model="formattedAmount"
                            label="Quantia"
                            required
                            outlined
                            prefix="R$"
                            class="mb-4"
                            variant="solo"
                            @input="updateAmount"
                        />

                        <v-text-field
                            v-model="expectedOn"
                            label="Esperado em"
                            type="date"
                            required
                            outlined
                            variant="solo"
                            class="mb-4"
                        />

                        <v-btn
                            type="submit"
                            color="primary"
                            class="mt-4"
                            block
                            large
                        >
                            Criar Transferência
                        </v-btn>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>

        <!-- Toasts -->
        <v-snackbar v-model="snackbar.visible" :color="snackbar.color" timeout="3000">
            {{ snackbar.message }}
        </v-snackbar>
    </v-container>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            dialogVisible: false,
            dialogVisibleNew: false,
            selectedTransfer: {},
            externalId: "",
            amount: 0,
            expectedOn: "",
            formattedAmount: "0.00",
            headers: [
                { text: 'Identificador', value: 'external_id', align: 'center' },
                { text: 'Valor', value: 'amount', align: 'center' },
                { text: 'Expedido', value: 'expected_on', align: 'center' },
                { text: 'Status', value: 'status', align: 'center' },
                { text: 'Ações', value: 'actions', align: 'center' }
            ],
            transfers: [],
            snackbar: {
                visible: false,
                message: "",
                color: ""
            },
            loading: false,
            externalIdError: "",
            amountError: "",
            expectedOnError: "",
        };
    },
    computed: {
        // Valida se todos os campos estão preenchidos corretamente
        isFormValid() {
            return this.externalId && this.amount > 0 && this.expectedOn;
        }
    },
    created() {
        this.fetchTransfers();
    },
    methods: {
        initialize() {
            this.fetchTransfers();
        },
        fetchTransfers() {
            axios.get('/transferList')
                .then((response) => {
                    if (Array.isArray(response.data)) {
                        this.transfers = response.data;
                    } else {
                        console.error("Resposta inválida: não foi retornado um array.");
                    }
                })
                .catch((error) => {
                    console.error("Erro ao buscar transferências:", error.response?.data);
                });
        },
        viewTransferDetails(item) {
            let id = item.external_id;
            axios.get(`/transfers/${id}`)
                .then((response) => {
                    if (response.data && response.data.length > 0) {
                        this.selectedTransfer = response.data[0]; // Preenche selectedTransfer com o primeiro item
                        this.dialogVisible = true; // Abre o diálogo somente depois que os dados estiverem carregados
                    } else {
                        this.snackbar.message = "Nenhuma transferência encontrada.";
                        this.snackbar.color = "red";
                        this.snackbar.visible = true;
                    }
                })
                .catch((error) => {
                    console.error("Erro ao buscar detalhes da transferência:", error.response?.data);
                    this.snackbar.message = "Erro ao obter detalhes da transferência";
                    this.snackbar.color = "red";
                    this.snackbar.visible = true;
                });
        },
        formatAmount(amount) {
            return parseFloat(amount).toLocaleString("pt-BR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });
        },
        formatDate(date) {
            return new Date(date).toLocaleDateString("pt-BR");
        },
        newTransfer() {
            this.dialogVisibleNew = true;
            this.clearErrors();
        },
        clearErrors() {
            this.externalIdError = "";
            this.amountError = "";
            this.expectedOnError = "";
        },
        createTransfer() {
            axios.post("/transfers", {
                external_id: this.externalId,
                amount: this.formattedAmount,
                expected_on: this.expectedOn,
            })
                .then(() => {
                    this.$emit("transfer-created");
                    this.externalId = "";
                    this.amount = 0;
                    this.expectedOn = "";
                    this.dialogVisibleNew = false;
                    this.initialize();

                    this.snackbar.message = "Transferência criada com sucesso!";
                    this.snackbar.color = "green";
                    this.snackbar.visible = true;
                })
                .catch((error) => {
                    this.dialogVisibleNew = false;
                    console.error("Erro ao criar transferência:", error.response?.data);

                    this.snackbar.message = error.response?.data?.message || "Erro ao criar transferência.";
                    this.snackbar.color = "red";
                    this.snackbar.visible = true;
                });
        },
        updateAmount(value) {
            const numericValue = value.replace(/\D/g, "");
            this.amount = parseFloat(numericValue) / 100;

            this.formattedAmount = (this.amount || 0).toLocaleString("pt-BR", {
                minimumFractionDigits: 2,
            });
        },
        validateForm() {
            if (!this.externalId) {
                this.externalIdError = "ID Externo é obrigatório.";
            }

            if (this.amount <= 0) {
                this.amountError = "Quantia deve ser maior que zero.";
            }

            if (!this.expectedOn) {
                this.expectedOnError = "Data Esperada é obrigatória.";
            }
        }
    }
};
</script>
