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
                    Product Table
                </div>
                <div class="addNew">
                    <router-link to="/product_create" class="btn btn-sm btn-success">Add New</router-link>
                    <!-- <button class="btn btn-sm btn-success ms-2" @click="exportToExcel">Export to Excel</button> -->
                </div>
            </div>
            <div class="card-body">
                <input type="text" id="searchInput" placeholder="Search for ID.." />
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product Model</th>
                            <th scope="col">Specification</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Touch Status</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Stored By</th>
                            <th scope="col">Category Name</th>
                            <th scope="col">Brand Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
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
            users: '',
        }
    },
    methods: {
        async fetchBillsData() {
            await axios.get("/api/bills/table")
                .then((res) => {
                    console.log(res)
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async fetchData() {
            const token = localStorage.getItem('token');
            await axios.get("/api/auth/me", {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
                .then((res) => {
                    console.log(res)
                    this.userName = res.data.user_name;
                    this.profile_img = res.data.profile_img
                    this.users = res.data;
                })
                .catch((error) => {
                    console.log(error.response ? error.response.data : error.message);
                });
        },
    },
    created() {
        this.fetchData();
        this.fetchBillsData();
    }
}
</script>

<style></style>