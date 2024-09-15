<template>
    <!-- <h1>i am form Bill Print</h1> -->
    <h2>Invoice : {{ bills.bill_id }}</h2>
    <h1>Total Price : {{ bills.total_price }}</h1>
    <div v-if="bills.customer">
        <h1>Customer Name: {{ bills.customer.customer_name }}</h1>
    </div>
    <div v-else>
        <p>Loading customer information...</p>
    </div>
    <div v-if="bills && bills.cart && bills.cart.cart_items && bills.cart.cart_items.length > 0">
        <ul v-for="cartitem in bills.cart.cart_items" :key="cartitem.id">
            <ol>Model Name : {{ cartitem.serial.stock.product.product_model }}</ol>
            <ol>{{ cartitem.quantity }} -> {{ cartitem.price }}</ol>
        </ul>
    </div>
    <div v-else>
        <p>No cart items available.</p>
    </div>



</template>

<script>
import axios from 'axios';
import { inject } from 'vue';
import AppStorage from '../../Helpers/AppStorage';
export default {
    name: "Bill-vue",
    data() {
        const userName = inject('userName');
        const profile_img = inject('profile_img');
        return {
            userName,
            profile_img,
            bills: []
        }
    },
    methods: {
        async fetchUsers() {
            const token = localStorage.getItem('token');
            await axios.get("/api/auth/me", {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
                .then((res) => {
                    this.userName = res.data.user_name;
                    this.profile_img = res.data.profile_img
                })
                .catch((error) => {

                });
        },
        async fetch_bill() {
            const bill_id = AppStorage.getBillId();
            await axios.get(`/api/bills/generate/${bill_id}`)
                .then((res) => {
                    console.log(res)
                    this.bills = res.data
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    },
    created() {
        this.fetchUsers();
        this.fetch_bill();
    }
}
</script>

<style></style>