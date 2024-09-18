<template>
    <div class="container">
        <div class="card mt-4 mb-2">
            <div class="card-header border-bottom-0 p-4">
                <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span
                    class="text-muted h5"> /
                    Expense Create</span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card rounded-lg mt-2">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="icon_text d-flex gap-2 mt-3">
                            <p><i class="fa-solid fa-chart-line"></i></p>
                            <p class="text-black font-bold">Expense Create</p>
                        </div>
                        <div class="code">
                            <router-link class="btn btn-sm btn-success" to="/all_expense">Expense List</router-link>
                        </div>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="Expense_create" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <select class="form-select" aria-label="Default select example"
                                            v-model="form.expenserName">
                                            <option v-for="userlist in userslist" :key="userlist.id"
                                                :value="userlist.id">
                                                {{ userlist.user_name }}
                                            </option>
                                        </select>
                                        <small class="text-danger" v-if="errors.expenserName">{{
                                            errors.expenserName[0]
                                        }}</small>
                                        <label for="inputSellingPrice">Expenser Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="inputProductName" type="text"
                                            placeholder="Enter product name" v-model="form.expense_description" />
                                        <small class="text-danger" v-if="errors.expense_description">{{
                                            errors.expense_description[0]
                                        }}</small>
                                        <label for="inputProductName">Expense Description</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <!-- <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <select class="form-select" aria-label="Default select example"
                                            v-model="form.paymenttype">
                                            <option v-for="paymenttype in paymenttypes" :key="paymenttype.id"
                                                :value="paymenttype.id">
                                                {{ paymenttype.pt_name }}
                                            </option>
                                        </select>
                                        <small class="text-danger" v-if="errors.paymenttype">{{
                                            errors.paymenttype[0]
                                        }}</small>
                                        <label for="inputSellingPrice">Payment Type</label>
                                    </div>
                                </div> -->
                                <div class="col-md-6 mt-2">
                                    <div class="buttonpayment d-flex justify-between">
                                        <!-- Buttons for toggling inputs -->
                                        <button type="button" @click="toggleInputs('bank')"
                                            class="btn btn-sm btn-success me-2">Bank</button>
                                        <button type="button" @click="toggleInputs('cash')"
                                            class="btn btn-sm btn-primary me-2">Cash</button>
                                        <button type="button" @click="toggleInputs('others')"
                                            class="btn btn-sm btn-danger">Others</button>

                                        <!-- Bank input field with close button -->
                                        <div v-if="showBankInputs" class="input-container">
                                            <div>
                                                <label for="bank-input-1">Bank:</label>
                                                <div class="d-flex">
                                                    <input class="form-control ms-1" id="bank-input-1" type="text"
                                                        v-model="bankAmount" placeholder="Enter Bank Amount">
                                                    <button @click="removeInput('bank')"
                                                        class="btn btn-sm btn-danger ms-1">×</button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Cash input field with close button -->
                                        <div v-if="showCashInputs" class="input-container">
                                            <div>
                                                <label for="cash-input-1 ms-1">Cash:</label>
                                                <div class="d-flex">
                                                    <input class="form-control ms-1" id="cash-input-1" type="text"
                                                        v-model="cashAmount" placeholder="Enter cash Amount">
                                                    <button @click="removeInput('cash')"
                                                        class="btn btn-sm btn-danger ms-1">×</button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Others input field with close button -->
                                        <div v-if="showOthersInputs" class="input-container">
                                            <div>
                                                <label for="others-input-1 ms1">Others:</label>
                                                <div class="d-flex">
                                                    <input class="form-control ms-1" id="others-input-1" type="text"
                                                        v-model="othersAmount" placeholder="Enter others Amount">
                                                    <button @click="removeInput('others')"
                                                        class="btn btn-sm btn-danger ms-1">×</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <!-- <textarea class="form-control" id="inputProductCode" type="text"
                                            placeholder="Product Code" v-model="form.amount"></textarea> -->
                                        <input class="form-control ms-1" type="text" :value="totalAmount" readonly>
                                        <small class="text-danger" v-if="errors.amount">{{
                                            errors.amount[0]
                                        }}</small>
                                        <label for="inputEmail">Amount</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="inputDate" type="date" v-model="form.date" />
                                        <small class="text-danger" v-if="errors.date">{{ errors.date[0]
                                            }}</small>
                                        <label for="inputDate">Expense Date</label>
                                    </div>
                                </div>
                                <!-- <div class="col-md-6 mb-3">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <select class="form-select" readonly aria-label="Default select example"
                                            v-model="form.cost_type">
                                            <option value="1">Fixed Cost</option>
                                            <option value="2">Running Cost</option>
                                        </select>
                                        <small class="text-danger" v-if="errors.cost_type">{{ errors.cost_type[0]
                                            }}</small>
                                        <label class="h6 text-black mb-0" for="inputSupplier">Cost Type</label>
                                    </div>
                                </div> -->

                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <select class="form-select" aria-label="Default select example"
                                            v-model="form.expensecategory">
                                            <option v-for="expensecategory in expensecategories"
                                                :key="expensecategory.id" :value="expensecategory.id">
                                                {{ expensecategory.category_name }}
                                            </option>
                                        </select>
                                        <small class="text-danger" v-if="errors.expensecategory">{{
                                            errors.expensecategory[0]
                                        }}</small>
                                        <label for="inputSellingPrice">Expense Category Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3" hidden>
                                    <div class="form-floating mb-3 mb-md-0">
                                        <select class="form-select" readonly aria-label="Default select example"
                                            v-model="form.user_id">
                                            <option :value="users.id">
                                                {{ users.user_name }}
                                            </option>
                                        </select>
                                        <small class="text-danger" v-if="errors.user_id">{{ errors.user_id[0] }}</small>
                                        <label class="h6 text-black mb-0" for="inputSupplier">Login User</label>
                                    </div>
                                </div>
                                <!-- <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <select class="form-select" aria-label="Default select example"
                                            v-model="form.expensecategory">
                                            <option v-for="expensecategory in expensecategories"
                                                :key="expensecategory.id" :value="expensecategory.id">
                                                {{ expensecategory.category_name }}
                                            </option>
                                        </select>
                                        <small class="text-danger" v-if="errors.expensecategory">{{
                                            errors.expensecategory[0]
                                            }}</small>
                                        <label for="inputSellingPrice">Expense Category Name</label>
                                    </div>
                                </div> -->
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-11">
                                    <div class="form-floating mb-2 mb-md-0">
                                        <input class="form-control p-3 px-4" id="inputFile" type="file"
                                            @change="onFileSelect" />
                                        <small class="text-danger" v-if="errors.image">{{
                                            errors.image[0] }}</small>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <img :src="form.image" width="55" height="55" />
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 mb-0">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary w-100 mb-2" :disabled="loading">
                                        <span v-if="loading" class="spinner-border spinner-border-sm me-2" role="status"
                                            aria-hidden="true"></span>
                                        <span v-if="!loading">Submit</span>
                                        <span v-if="loading">Submitting...</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import axios from 'axios';
import { inject } from 'vue';
export default {
    name: "Expance_create",
    data() {
        const userName = inject('userName');
        const profile_img = inject('profile_img');
        return {
            form: {
                expenserName: null,
                expense_description: null,
                amount: null,
                date: null,
                user_id: null,
                expensecategory: null,
                // paymenttype: null,
                // cost_type: null,
                validInputspaymenttype: [],
                validInputsamount: [],
                // bankAmount: null,
                // cashAmount: null,
                // othersAmount: null,
                // input1: '',
                // input2: '',
                // input3: '',
                // validInputs: [],
                // validInputs2: [],
                image: '/backend/assets/img/pic.jpeg',
            },
            userName,
            profile_img,
            paymenttypes: [],
            userslist: [],
            expensecategories: [],
            users: [],
            errors: {},
            bankAmount: null,
            cashAmount: null,
            othersAmount: null,
            showBankInputs: false,
            showCashInputs: false,
            showOthersInputs: false,
            input1: '',
            input2: '',
            input3: '',
            loading: false,
            validInputs: [],
            validInputs2: []
        }
    },
    methods: {
        async Expense_create() {
            const inputspaymenttype = [this.input1, this.input2, this.input3];
            const inputsamount = [this.bankAmount, this.cashAmount, this.othersAmount];
            this.form.validInputspaymenttype = inputspaymenttype.filter(input => input !== '' && input !== null);
            this.form.validInputsamount = inputsamount.filter(input => input !== '' && input !== null);

            this.loading = true
            const formData = new FormData();

            formData.append('expenserName', this.form.expenserName);
            formData.append('expense_description', this.form.expense_description);
            formData.append('amount', this.totalAmount);
            formData.append('date', this.form.date);
            formData.append('user_id', this.form.user_id);
            formData.append('expensecategory', this.form.expensecategory);
            // formData.append('cost_type', this.form.cost_type);

            // Append valid payment types and methods
            this.form.validInputspaymenttype.forEach((type, index) => {
                formData.append('paymenttype[]', type); // Append each valid payment type
                formData.append('paymentamount[]', this.form.validInputsamount[index]); // Append corresponding method
            });
            // formData.append('expenserName', this.form.expenserName);
            // formData.append('expense_description', this.form.expense_description);
            // formData.append('amount', this.form.amount);
            // formData.append('date', this.form.date);
            // formData.append('user_id', this.form.user_id);
            // formData.append('expensecategory', this.form.expensecategory);
            // formData.append('paymenttype', this.form.paymenttype);
            // formData.append('cost_type', this.form.cost_type);

            if (this.form.image && this.form.image !== '/backend/assets/img/pic.jpeg') {
                // Append the image if it's not the default
                formData.append('image', this.form.image);
            }

            await axios.post("/api/expense/store", formData)
                .then((res) => {
                    console.log(res)
                    Toast.fire({
                        icon: "success",
                        title: res.data.message
                    });
                    this.$router.push({ name: 'All_expense' })
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                })
                .finally(() => {
                    this.loading = false
                })
        },
        onFileSelect(event) {
            let file = event.target.files[0]
            if (file.size > 1048576) {
                Toast.fire({
                    icon: "warning",
                    title: "image must be less then 1 mb!"
                });
            }
            else {
                let reader = new FileReader();
                reader.onload = (event) => {
                    this.form.image = event.target.result;
                }
                reader.readAsDataURL(file);
            }
        },
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
                    this.users = res.data;
                    this.form.user_id = res.data.id
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async fetch_paymenttype() {
            await axios.get('/api/payment-types')
                .then((res) => {
                    this.paymenttypes = res.data;
                })
                .catch((res) => {
                    console.log(res)
                })
        },
        async fetch_user() {
            await axios.get('/api/alluser')
                .then((res) => {
                    if (Array.isArray(res.data)) {
                        this.userslist = res.data;
                    } else {
                        this.userslist = [];
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async fetch_expensecategories() {
            axios.get('/api/expensecategory')
                .then((res) => {
                    this.expensecategories = res.data;
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        toggleInputs(inputType) {
            if (inputType === 'bank') {
                this.input1 = 2;
                this.showBankInputs = true;
            } else if (inputType === 'cash') {
                this.input2 = 3;
                this.showCashInputs = true;
            } else if (inputType === 'others') {
                this.input3 = 1;
                this.showOthersInputs = true;
            }
        },
        removeInput(inputType) {
            if (inputType === 'bank') {
                this.showBankInputs = false;
                this.form.bankAmount = '';// Clear the input field
            } else if (inputType === 'cash') {
                this.showCashInputs = false;
                this.form.cashAmount = '';  // Clear the input field
            } else if (inputType === 'others') {
                this.showOthersInputs = false;
                this.form.othersAmount = ''; // Clear the input field
            }
        }

    },
    created() {
        this.fetchUsers();
        this.fetch_paymenttype();
        this.fetch_user();
        this.fetch_expensecategories();
    },
    computed: {
        totalAmount() {
            const bank = parseFloat(this.bankAmount) || 0;
            const cash = parseFloat(this.cashAmount) || 0;
            const others = parseFloat(this.othersAmount) || 0;
            const sum = bank + cash + others;
            return sum;
        }
    }
}
</script>

<style>
#searchInput {
    background-image: url("/backend/assets/img/searchicon.png");
    background-position: 10px 12px;
    background-repeat: no-repeat;
    width: 100%;
    font-size: 16px;
    padding: 12px 20px 12px 40px;
    border: 1px solid #ddd;
    margin-bottom: 12px;
}

.full-width-modal {
    max-width: 100%;
    max-height: 100vh;
}

.full-width-modal .modal-content {
    width: 60%;
    height: 68vh;
    margin: auto;
}
</style>