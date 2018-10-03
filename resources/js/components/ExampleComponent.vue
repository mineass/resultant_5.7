<template>
    <div class="row">
        <div class="col-md-2 order-md-2">
            <button class="btn btn-success btn-block"
                    :disabled="isUpdating"
                    v-on:click="updateCurrencies"
            >Обновить</button>
        </div>
        <div class="col-md-10 order-md-1">
            <div v-if="currencies" class="table-responsive">
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
            <div v-else>Идет загрузка...</div>
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
                currencies: [],
            }
        },
        methods: {
            updateCurrencies() {
                this.isUpdating = true;
                const self = this;
                window.axios.post('/update-currencies')
                    .then( (response) => {
                        console.log(response.data);
                        self.currencies = response.data.stock;
                    })
                    .catch( (error) => {
                        console.log(error.response);
                    })
                    .then( () => {
                        self.isUpdating = false;
                    });
            },
        },
    }
</script>
