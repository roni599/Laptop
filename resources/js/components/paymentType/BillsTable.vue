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
                                <th scope="col">Payment Method</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Sell By</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Product Price</th>
                                <th scope="col">Sold_price</th>
                                <th scope="col">Total_price</th>
                                <th scope="col">Unit Profit</th>
                                <th scope="col">Total Profit</th>
                                <th scope="col">Bill Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(bill, index) in filteredBills" :key="bill.id">
                                <td>{{ index + 1 }}</td>
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
                                        {{ cart.serial.stock.product.category.cat_name }}
                                    </div>
                                </td>
                                <td>
                                    <div v-for="cart in bill.cart.cartitems" :key="cart.id">
                                        {{ cart.serial.stock.product.brand.brand_name }}
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <span v-for="(cart, index) in bill.reserves" :key="cart.id">
                                            {{ cart.paymenttype.pt_name }}<span
                                                v-if="index < bill.reserves.length - 1">, </span>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <span v-for="(cart, index) in bill.reserves" :key="cart.id">
                                            {{ cart.amount }}<span v-if="index < bill.reserves.length - 1">, </span>
                                        </span>
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
                                <td>
                                    {{ formatDate(bill.updated_at) }}
                                </td>
                                <td>
                                    <div class="buttonGroup py-2 d-flex justify-between">
                                        <button type="button" class="btn btn-sm btn-success ms-2 mb-1"
                                            @click="openEditModal(bill)">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger mx-2" @click="deleteBill(bill.id)">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                        <button class="btn btn-sm btn-success mx-2" @click.prevent="fetchBill(bill.id)">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editExpenseModal" tabindex="-1" aria-labelledby="editExpenseModalLabel"
            aria-hidden="true">
            <div class="modal-dialog full-width-modal mt-5">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-muted" id="editExpenseModal">
                            Edit Expense
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body mb-2">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card rounded-lg">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <div class="icon_text d-flex gap-2 mt-3">
                                            <p><i class="fa-solid fa-chart-line"></i></p>
                                            <p class="text-muted font-bold">Edit Expense</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form @submit.prevent="bill_edit" enctype="multipart/form-data">
                                            <!-- Customer Name -->
                                            <div class="row mb-4">
                                                <div class="col-md-12">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputCustomerName" type="text"
                                                            v-model="form.customer_name" />
                                                        <small class="text-danger" v-if="errors.customer_name">{{
                                                            errors.customer_name[0] }}</small>
                                                        <label for="inputCustomerName">Customer Name</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Products and Reserves -->
                                            <div class="row mb-4">
                                                <div class="col-md-12">
                                                    <div
                                                        class="form-floating mb-3 mb-md-0 d-flex justify-content-between w-100">
                                                        <!-- Product Name -->
                                                        <div v-for="(cart, index) in products_model" :key="cart.id"
                                                            class="d-flex align-items-center form-floating w-50">
                                                            <div class="w-100 form-floating mx-1">
                                                                <input class="form-control w-100"
                                                                    :id="'inputProductName_' + index" type="text"
                                                                    v-model="cart.serial.stock.product.product_model" />
                                                                <label :for="'inputProductName_' + index">Product
                                                                    Name</label>
                                                            </div>
                                                        </div>

                                                        <!-- Reserves -->
                                                        <div v-for="(reserve, index) in reserves" :key="reserve.id"
                                                            class="d-flex align-items-center w-50 mx-3">
                                                            <div class="w-100">
                                                                <label :for="'inputReserve_' + index">{{
                                                                    reserve.paymenttype.pt_name }}</label>
                                                                <input class="form-control"
                                                                    :id="'inputReserve_' + index" type="text"
                                                                    v-model="reserve.amount" />
                                                            </div>
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm mx-1 mt-4"
                                                                @click="deleteReserve(reserve.id, index)">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sold Price -->
                                            <div class="row mb-3">
                                                <div v-for="(cart, index) in products_model" :key="cart.id"
                                                    class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input class="form-control" :id="'inputSoldPrice_' + index"
                                                            type="text" v-model="cart.sold_price" />
                                                        <label :for="'inputSoldPrice_' + index">{{
                                                            cart.serial.stock.product.product_model.substring(0, 4)
                                                            }}... Sold Price</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- User -->
                                            <div class="row" hidden>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <select class="form-select" readonly v-model="form.user_id">
                                                            <option :value="users.id">{{ users.user_name }}</option>
                                                        </select>
                                                        <small class="text-danger" v-if="errors.user_id">{{
                                                            errors.user_id[0] }}</small>
                                                        <label for="inputSupplier">Login User</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="mt-3 mb-0">
                                                <div class="d-grid">
                                                    <button class="btn btn-primary w-100 mb-2" :disabled="loading">
                                                        <span v-if="loading"
                                                            class="spinner-border spinner-border-sm me-2" role="status"
                                                            aria-hidden="true"></span>
                                                        <span v-if="!loading">Update</span>
                                                        <span v-if="loading">Updating...</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { inject } from 'vue';
import AppStorage from "../../Helpers/AppStorage";
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
            form: {
                id: null,
                user_id: null,
                customer_name: null,
            },
            paymenttypes: [],
            userslist: [],
            users: [],
            errors: {},
            loading: false,
            showInputs: false,
            reserves: [],
            products_model: [],

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
        formatDate(dateString) {
            if (dateString) {
                const date = new Date(dateString);
                const day = String(date.getDate()).padStart(2, '0'); // Get day and pad with leading zero if needed
                const month = String(date.getMonth() + 1).padStart(2, '0'); // Get month (0-11) and add 1, pad with leading zero
                const year = date.getFullYear(); // Get full year
                // Format time (optional)
                const optionsTime = {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true
                };
                const formattedTime = date.toLocaleTimeString("en-BD", optionsTime);

                // Combine date and time
                return `${day}/${month}/${year} ${formattedTime}`.replace(',', ''); // Removes the comma
            }
            return "";
        },
        async fetchBill(billId) {
            const bill_id = billId;
            try {
                const res = await axios.get(`/api/bills/generate/${bill_id}`);
                console.log(res)
                this.$router.push({ name: "Bill_print" })
                AppStorage.storebillId(res.data.bill.id);
                // this.payments = res.data.payment;
                // this.bills = res.data.bill;
                // this.generateBarcode();
                // AppStorage.clearBillId();
                // AppStorage.clearCard();
            } catch (error) {
                console.log(error);
            }
        },
        removeReserve(index) {
            this.reserves.splice(index, 1); // Remove the cart at the given index
        },
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
        openEditModal(expense) {
            this.reserves = [];
            this.products_model = [],
            this.reserves = [...expense.reserves];
            this.products_model = [...expense.cart.cartitems]
            this.form.id = expense.cart.id
            this.form.user_id = this.users.id;
            this.form.customer_name = expense.customer.customer_name
            this.showInputs = true;
            let myModal = new bootstrap.Modal(
                document.getElementById("editExpenseModal"),
                {}
            );
            myModal.show();
        },
        async bill_edit() {
            let formData = {
                id: this.form.id,
                customer_name: this.form.customer_name,
                user_id: this.form.user_id,
                products: this.products_model.map(product => ({
                    product_name: product.serial.stock.product.product_model,
                    sold_price: product.sold_price
                })),
                reserves: this.reserves.map(reserve => ({
                    id: reserve.id,
                    payment_type: reserve.paymenttype.pt_name,
                    amount: reserve.amount
                }))
            }
            try {
                this.loading = true;
                const response = await axios.post('/api/bills/update_bill', formData);
                this.loading = false;
                this.fetchBillsData();
                let myModal = bootstrap.Modal.getInstance(
                    document.getElementById("editExpenseModal")
                );
                myModal.hide();
                Toast.fire({
                    icon: "success",
                    title: response.data.message,
                });
            } catch (error) {
                console.error('Error updating the bill:', error);
                this.loading = false;
                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                }
            }
        },
        async deleteReserve(id, index) {
            try {
                // Send a DELETE request to the server
                const response = await axios.delete(`/api/bills/table/edit_bill_reserve_delete/${id}`);
                console.log(response);
                if (response.status === 200) {
                    // Remove the cart from the array if the deletion is successful
                    this.reserves.splice(index, 1);
                } else {
                    console.error('Failed to delete reserve');
                }
            } catch (error) {
                console.error('Error deleting reserve:', error);
            }
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