<template>
    <div class="row">
        <div class="col-md-2 order-md-2 mb-3">
            <button class="btn btn-success btn-block"
                    :disabled="isUpdating"
                    v-on:click="updateCurrencies"
            >Обновить</button>
        </div>
        <div class="col-md-10 order-md-1">
            <div v-if="currencies.length"
                 class="table-responsive"
            >
                <p>{{ updatedAt }}</p>
                <p v-show="statusText" class="text-danger">{{ statusText }}</p>
                <table class="table currecnies-list">
                    <thead>
                    <tr>
                        <th scope="col">Название валюты</th>
                        <th scope="col">Цена</th>
                        <th scope="col">Количество</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="currency in currencies">
                        <th scope="row">{{ currency.name }}</th>
                        <td>{{ currency.volume.toFixed(0) }}</td>
                        <td>{{ currency.price.amount.toFixed(2) }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <p class="text-danger" v-else>{{ statusText || 'Идет загрузка...' }}</p>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.updateCurrencies();

            const self = this;
            setInterval(function () {
                self.updateCurrencies();
            }, 15000);
        },
        data: function() {
            return {
                isUpdating: true,
                updatedAt: '',
                statusText: '',
                currencies: [],
            }
        },
        methods: {
            updateCurrencies() {
                this.isUpdating = true;
                const self = this;
                window.axios.post('/update-currencies')
                    .then( (response) => {
                        self.currencies = response.data.stock;

                        let d = new Date();
                        self.updatedAt = 'Обновлено: ' + d.toLocaleString();
                        self.statusText = '';
                    })
                    .catch( (error) => {
                        console.log(error.response);
                        self.statusText = 'Ошибка: ' + error.response.data.error;
                    })
                    .then( () => {
                        self.isUpdating = false;
                    });
            },
        },
    }
</script>
