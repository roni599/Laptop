<template>
    <div class="container">
        <div class="card mt-4 mb-2">
            <div class="card-header border-bottom-0 p-4">
                <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span
                    class="text-muted h5"> /
                    Bills-Table</span>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <div class="employee_table">
                    <i class="fas fa-table me-1"></i>
                    Bills Table
                </div>
                <div class="addNew">
                    <router-link to="/bill_generate" class="btn btn-sm btn-success">Add New</router-link>
                    <!-- <button class="btn btn-sm btn-success ms-2" @click="exportToExcel">Export to Excel</button> -->
                </div>
            </div>
            <div class="card-body">
                <input type="text" id="searchInput" v-model="searchBill" placeholder="Search for ID.." />
                <div class="table_size">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#Sn</th>
                                <th scope="col">Bill-Id</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Product Model</th>
                                <th scope="col">Category Name</th>
                                <th scope="col">Brand Name</th>
                                <th scope="col">Sell By</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Unit Price</th>
                                <th scope="col">Sold_price</th>
                                <th scope="col">Total_price</th>
                                <th scope="col">Unit Profit</th>
                                <th scope="col">Total Profit</th>
                                <!-- <th scope="col">Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(bill) in filteredBills" :key="bill.id">
                                <td>{{ bill.id }}</td>
                                <td>{{ bill.bill_id }}</td>
                                <td>{{ bill.customer.customer_name }}</td>
                                <td>
                                    <div>
                                        <div v-for="(cart, index) in bill.cart.cartitems" :key="cart.id">
                                            {{ cart.serial.stock.product.product_model }}
                                            <span v-if="index < bill.cart.cartitems.length - 1">,</span>
                                        </div>
                                    </div>

                                </td>
                                <td>
                                    <div v-for="cart in bill.cart.cartitems" :key="cart.id">
                                        {{ cart.serial.stock.product.brand.brand_name }}
                                    </div>
                                </td>
                                <td>
                                    <div v-for="cart in bill.cart.cartitems" :key="cart.id">
                                        {{ cart.serial.stock.product.category.cat_name }}
                                    </div>
                                </td>
                                <td>{{ bill.user.user_name }}</td>
                                <td>
                                    <div>
                                        <div v-for="(cart) in bill.cart.cartitems" :key="cart.id">
                                            {{ cart.quantity }}
                                        </div>
                                    </div>

                                </td>
                                <td>
                                    <div>
                                        <div v-for="(cart) in bill.cart.cartitems" :key="cart.id">
                                            {{ cart.unit_price }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div v-for="(cart) in bill.cart.cartitems" :key="cart.id">
                                            {{ cart.sold_price }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{ bill.total_price }}
                                </td>
                                <td>
                                    <div>
                                        <div v-for="(cart) in bill.cart.cartitems" :key="cart.id">
                                            {{ cart.profit }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div v-for="(cart) in bill.cart.cartitems" :key="cart.id">
                                            {{ cart.total_profit }}
                                        </div>
                                    </div>
                                </td>
                                <!-- <td>
                                    <div class="buttonGroup py-2 d-flex justify-between">
                                        <button type="button" class="btn btn-sm btn-success ms-2 mb-1"
                                            @click="openEditModal(bill)">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger mx-2" @click="deleteBill(bill.id)">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td> -->
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import axios from 'axios';
import { inject } from 'vue';
import * as XLSX from "xlsx";
export default {
    name: 'Bills-Table',

    data() {
        const userName = inject('userName');
        const profile_img = inject('profile_img');
        return {
            userName,
            profile_img,
            searchBill: '',
            users: '',
            bills: [],
        }
    },
    computed: {
        filteredBills() {
            return this.bills.filter((bill) => {
                return (
                    bill.id.toString().includes(this.searchBill) || bill.bill_id.toLowerCase().includes(this.searchBill.toLowerCase())
                );
            });
        },
    },
    methods: {
        async fetchBillsData() {
            await axios.get("/api/bills/table")
                .then((res) => {
                    this.bills = res.data
                })
                .catch((error) => { })
        },
        async fetchData() {
            const token = localStorage.getItem('token');
            await axios.get("/api/auth/me", {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
                .then((res) => {
                    this.userName = res.data.user_name;
                    this.profile_img = res.data.profile_img
                    this.users = res.data;
                })
                .catch((error) => {
                    console.log(error.response ? error.response.data : error.message);
                });
        },
        async deleteBill(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    await axios
                        .delete("/api/bills/delete/" + id)
                        .then((res) => {
                            console.log(res)
                            this.bills = this.bills.filter((bill) => {
                                return bill.id != id;
                            });
                        })
                        .catch((error) => {
                            this.$router.push({ name: "BillsTable" });
                        });
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success",
                    });
                }
            });
        },
    },
    created() {
        this.fetchData();
        this.fetchBillsData();
    }
}
</script>

<style scoped>
.table_size {
    overflow: auto;
    width: 100%;
}
</style>