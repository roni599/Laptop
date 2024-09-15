<template>
    <div class="container">
        <div class="card mt-4 mb-3">
            <div class="card-header border-bottom-0 p-3">
                <router-link class="text-decoration-none" to="/home">Dashboard</router-link><span class="text-muted"> /
                    Point Of Sale</span>
            </div>
        </div>
        <div class="row mt-3 mb-2">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="employee_table fw-bold">
                            <i class="fas fa-table me-1"></i>
                            Card
                        </div>
                        <div class="addNew">
                            <button type="button" class="btn btn-sm btn-success" @click="openEditModal">
                                Add New Customer
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table mb-3">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="Allposes.length == 0">
                                    <td colspan="5" class="text-center">No data found</td>
                                </tr>
                                <tr v-for="allpos in Allposes" :key="allpos.id">
                                    <td>{{ allpos.pro_name }}</td>
                                    <td>
                                        <div class="d-flex justify-content-start align-items-center">
                                            <input type="text" class="form-control w-50 me-1 quantity_input"
                                                :value="allpos.pro_quantity">
                                            <button @click.prevent="increment(allpos.id)"
                                                class="btn btn-sm btn-success p-2 me-1">+
                                            </button>
                                            <button :disabled="allpos.pro_quantity <= 1"
                                                @click.prevent="decrement(allpos.id)"
                                                class="btn btn-sm btn-danger p-2">-
                                            </button>
                                        </div>

                                    </td>
                                    <td>{{ allpos.pro_price }}</td>
                                    <td>{{ allpos.sub_total }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger mx-2"
                                            @click.prevent="productItemDelete(allpos.id)">
                                            <i class="fa-solid fa-xmark"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="card-footer">
                            <ul class="list-group mt-2 mb-4">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Total Quentity:
                                    <span class="badge text-dark rounded-pill fs-6">{{ totalQty }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Sub Total:
                                    <span class="badge text-dark rounded-pill fs-6">{{ subTotal }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Vat:
                                    <span class="badge text-dark rounded-pill fs-6">{{ vats.vat }}%</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Total:
                                    <span class="badge text-dark rounded-pill fs-6">{{ calculateTotal }}</span>
                                </li>
                            </ul>
                            <form @submit.prevent="orderDone" enctype="multipart/form-data">
                                <label class="ms-1 mb-1 fw-bold">Customer Name</label>
                                <select class="form-control mb-2" v-model="customer_id">
                                    <option :value="customer.id" v-for="customer in customers" :key="customer.id">
                                        {{ customer.name }}
                                    </option>
                                </select>

                                <label class="ms-1 mb-1 fw-bold">Pay</label>
                                <input type="text" class="form-control mb-2" v-model="pay">

                                <label class="ms-1 mb-1 fw-bold">Due</label>
                                <input type="text" class="form-control mb-2" :value="due" readonly>

                                <label class="ms-1 mb-1 fw-bold">Pay By</label>
                                <select class="form-control mb-3" v-model="payby">
                                    <option value="Hand Cash">Hand Cash</option>
                                    <option value="Cheque">Cheque</option>
                                    <option value="Gift Card">Gift Card</option>
                                </select>

                                <button class="btn btn-success mb-2 w-100">Submit</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="employee_table fw-bold">
                            <i class="fas fa-table me-1"></i>
                            All Product
                        </div>
                    </div>
                    <div class="container mt-3">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                    aria-selected="true">All Products</button>
                            </li>
                            <li class="nav-item" role="presentation" v-for="category in categories" :key="category.id">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-profile" type="button" role="tab"
                                    aria-controls="pills-profile" aria-selected="false"
                                    @click.prevent="subproduct(category.id)">{{ category.category_name
                                    }}</button>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="card-body">
                                <input type="text" id="searchInput" v-model="searchProducts"
                                    placeholder="Search for product Name.." />

                                <div class="row">
                                    <div class="col-md-3 mb-3 col-6" v-for="product in filteredProducts" :key="product">
                                        <a href="#" @click.prevent="productby(product.id)"
                                            class="text-decoration-none list-unstyled">
                                            <div class="card" style="width: 9.5rem;">
                                                <img :src="`/backend/images/product/${product.image}`"
                                                    alt="Employee Image" height="65" width="65" />
                                                <div class="card-body max-height-200">
                                                    <small class="card-title">{{ product.product_name }}</small><br>
                                                    <span v-if="product.product_quantity >= 1">Available({{
                                                        product.product_quantity }})</span>
                                                    <span v-else class="text-danger">Stock out</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                            aria-labelledby="pills-profile-tab">
                            <div class="card-body">
                                <input type="text" id="searchInput" v-model="searchSubProducts"
                                    placeholder="Search for product Name.." />

                                <div class="row">
                                    <div class="col-md-3 mb-3 col-6" v-for="subCategory in filteredSubProducts"
                                        :key="subCategory.id">
                                        <a href="#" @click.prevent="productby(subCategory.id)"
                                            class="text-decoration-none list-unstyled">
                                            <div class="card" style="width: 9.5rem;">
                                                <img :src="`/backend/images/product/${subCategory.image}`"
                                                    alt="Employee Image" height="65" width="65" />
                                                <div class="card-body  max-height-200">
                                                    <small class="card-title">{{ subCategory.product_name }}</small><br>
                                                    <span v-if="subCategory.product_quantity >= 1">Available({{
                                                        subCategory.product_quantity }})</span>
                                                    <span v-else class="text-danger">Stock out</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerModalLabel"
            aria-hidden="true">
            <div class="modal-dialog full-width-modal mt-5">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCustomerModalLabel">
                            Add New Customer
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <div class="card rounded-lg">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <div class="icon_text d-flex gap-2 mt-3">
                                            <p><i class="fa-solid fa-chart-line"></i></p>
                                            <p class="text-black font-bold">Add New Customer</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form @submit.prevent="customer_create" enctype="multipart/form-data">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputName" type="text"
                                                            placeholder="Enter your name" v-model="form.name" />
                                                        <small class="text-danger" v-if="errors.name">{{ errors.name[0]
                                                            }}</small>
                                                        <label for="inputName">Full Name</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputEmail" type="email"
                                                            placeholder="name@example.com" v-model="form.email" />
                                                        <small class="text-danger" v-if="errors.email">{{
                                                            errors.email[0] }}</small>
                                                        <label for="inputEmail">Email address</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputNid" type="text"
                                                            placeholder="Phone" v-model="form.phone" />
                                                        <small class="text-danger" v-if="errors.phone">{{
                                                            errors.phone[0] }}</small>
                                                        <label for="inputNid">Phone</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputAddress" type="text"
                                                            placeholder="Address" v-model="form.address" />
                                                        <small class="text-danger" v-if="errors.address">{{
                                                            errors.address[0] }}</small>
                                                        <label for="inputAddress">Address</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputNid" type="text"
                                                            placeholder="NID" v-model="form.nid" />
                                                        <small class="text-danger" v-if="errors.nid">{{ errors.nid[0]
                                                            }}</small>
                                                        <label for="inputNid">NID</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-floating mb-3 mb-md-0">
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

                                            <div class="mt-4 mb-0">
                                                <div class="d-grid">
                                                    <button class="btn btn-primary btn-block">Submit</button>
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
import axios from "axios";
export default {
    name: "POS_vue",
    data() {
        return {
            products: [],
            categories: [],
            subCategories: [],
            customers: [],
            Allposes: [],
            vats: '',
            errors: {},
            searchProducts: "",
            searchSubProducts: "",
            form: {
                name: null,
                email: null,
                address: null,
                phone: null,
                nid: null,
                image: '/backend/assets/img/pic.jpeg'
            },
            errors: {},
            customer_id: '',
            pay: '',
            payby: '',
        };
    },
    computed: {
        due() {
            return this.calculateTotal - this.pay
        },
        filteredProducts() {
            return this.products.filter((product) => {
                return (
                    product.id.toString().includes(this.searchProducts) || product.product_name.toLowerCase().includes(this.searchProducts)
                );
            });
        },

        filteredSubProducts() {
            return this.subCategories.filter((product) => {
                return (
                    product.id.toString().includes(this.searchSubProducts) || product.product_name.toLowerCase().includes(this.searchSubProducts)
                );
            });
        },
        totalQty() {
            let sum = 0;
            for (let i = 0; i < this.Allposes.length; i++) {
                sum += (parseFloat(this.Allposes[i].pro_quantity))
            }
            return sum;
        },
        subTotal() {
            let sum = 0;
            for (let i = 0; i < this.Allposes.length; i++) {
                sum += (parseFloat(this.Allposes[i].pro_quantity)) * parseFloat(this.Allposes[i].pro_price);
            }
            return sum;
        },
        calculateTotal() {
            return this.subTotal + (this.subTotal * this.vats.vat / 100);
        }
    },
    methods: {
        async productsfetch() {
            await axios.get("/api/products").then((res) => {
                this.products = res.data;
            });
        },
        async productby(id) {
            axios.get("/api/addProduct/" + id)
                .then((res) => {
                    this.allPoseList();
                    Toast.fire({
                        icon: "success",
                        title: res.data.message,
                    });
                })
                .catch((error) => {

                })
        },
        async allPoseList() {
            await axios.get('/api/allPos')
                .then((res) => {
                    this.Allposes = res.data
                })
                .catch((error) => {

                })
        },
        async increment(id) {
            await axios.get("/api/posincrement/" + id)
                .then((res) => {
                    this.allPoseList();
                    Toast.fire({
                        icon: "success",
                        title: res.data.message,
                    });
                })
                .catch((error) => {

                })
        },
        async decrement(id) {
            await axios.get("/api/posdecrement/" + id)
                .then((res) => {
                    this.allPoseList();
                    Toast.fire({
                        icon: "success",
                        title: res.data.message,
                    });
                })
                .catch((error) => {

                })
        },
        async vat() {
            await axios.get("/api/allvat")
                .then((res) => {
                    this.vats = res.data;
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async productItemDelete(id) {
            await axios.get("/api/posremove/" + id)
                .then((res) => {
                    this.Allposes = this.Allposes.filter((pos) => {
                        return pos.id != id;
                    });
                    Toast.fire({
                        icon: "success",
                        title: res.data.message,
                    });
                })
                .catch((error) => {

                })
        },
        async categoriesfetch() {
            await axios.get("/api/categories").then((res) => {
                this.categories = res.data;
            });
        },
        async subproduct(id) {
            await axios.get('/api/subproducts/' + id)
                .then((res) => {
                    this.subCategories = res.data
                })
                .catch((error) => {
                    this.errors = error.response.data.errors
                })
        },

        openEditModal() {
            let myModal = new bootstrap.Modal(
                document.getElementById("editCustomerModal"),
                {}
            );
            myModal.show();
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
                    console.log(this.form.image)
                }
                reader.readAsDataURL(file);
            }
        },
        async customer_create() {
            await axios.post('/api/customers/store', this.form)
                .then((res) => {
                    this.form = {
                        name: null,
                        email: null,
                        address: null,
                        phone: null,
                        nid: null,
                        image: '/backend/assets/img/pic.jpeg'
                    };
                    let myModal = bootstrap.Modal.getInstance(
                        document.getElementById("editCustomerModal")
                    );
                    myModal.hide();
                    Toast.fire({
                        icon: "success",
                        title: res.data.message,
                    });
                    this.All_customers();
                })
                .catch((error) => {
                    this.errors = error.response.data.errors
                })
        },
        async All_customers() {
            axios
                .get("/api/customers")
                .then((response) => {
                    this.customers = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        async orderDone() {
            let data = {
                qty: this.totalQty,
                subtotal: this.subTotal,
                vat: this.vats.vat,
                total: this.calculateTotal,
                customer_id: this.customer_id,
                pay: this.pay,
                due: this.due,
                payby: this.payby
            }
            await axios.post("/api/order", data)
                .then((res) => {
                    this.$router.push({ name: "Home" })
                    Toast.fire({
                        icon: "success",
                        title: res.data.message,
                    });
                })
                .catch((error) => {
                    console.log(error)
                })
        }
    },
    created() {
        this.productsfetch();
        this.categoriesfetch();
        this.allPoseList();
        this.All_customers();
        this.vat();

    },
};
</script>

<style scoped>
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
    height: 75vh;
    margin: auto;
}

.max-height-200 {
    min-height: 100px;
    max-height: 90px;
    max-width: 200px;
    overflow: hidden;
}

.cursor-pointer {
    cursor: pointer;
}

.quantity_input {
    max-width: 29px;
    min-width: 25px;
    border-radius: 5px;
    padding: 6px 5px;
    border: 1px solid black;
}
</style>