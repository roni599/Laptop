<template>
  <div class="container">
    <div class="card mt-4 mb-2">
      <div class="card-header border-bottom-0 p-4">
        <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link>
        <span class="text-muted h5"> / Stocks-Create</span>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="card rounded-lg mt-2">
          <div class="card-header d-flex justify-content-between align-items-center">
            <div class="icon_text d-flex gap-2 mt-3">
              <p><i class="fa-solid fa-chart-line"></i></p>
              <p class="text-black font-bold">Stocks Create</p>
            </div>
            <div class="code">
              <router-link class="btn btn-sm btn-success" to="/all_stocks">All Stocks</router-link>
            </div>
          </div>
          <div class="card-body">
            <div class="card-body">
              <form @submit.prevent="handleSubmit" v-show="visible">
                <div class="row mb-3">
                  <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                      <select class="form-select" aria-label="Default select example" v-model="form.product_id">
                        <option v-for="product in products" :key="product.id" :value="product.id">{{
                          product.product_model }}</option>
                      </select>
                      <small class="text-danger" v-if="errors.product_id">{{
                        errors.product_id[0]
                      }}</small>
                      <label for="inputPhone">Product Model</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                      <select class="form-select" readonly aria-label="Default select example" v-model="form.user_id">
                        <option :value="users.id">
                          {{ users.user_name }}
                        </option>
                      </select>
                      <small class="text-danger" v-if="errors.user_id">{{
                        errors.user_id[0]
                      }}</small>
                      <label for="inputAddress">Users Name</label>
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                      <input class="form-control" id="inputDate" type="date" v-model="form.stock_date" />
                      <small class="text-danger" v-if="errors.stock_date">{{ errors.stock_date[0] }}</small>
                      <label for="inputDate">Stock Date</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                      <input class="form-control" v-model="form.stock_quantity" type="text" id="inputQuantity" />
                      <small class="text-danger" v-if="errors.stock_quantity">{{ errors.stock_quantity[0] }}</small>
                      <label for="inputQuantity">Quantity</label>
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                      <input class="form-control" v-model="form.buying_price" type="text" id="buyingPrice" />
                      <small class="text-danger" v-if="errors.buying_price">{{ errors.buying_price[0] }}</small>
                      <label for="buyingPrice">Buying Price</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                      <input class="form-control" v-model="form.selling_price" type="text" id="sellingPrice" />
                      <small class="text-danger" v-if="errors.selling_price">{{ errors.selling_price[0] }}</small>
                      <label for="sellingPrice">Selling Price</label>
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                      <select class="form-select" aria-label="Default select example" v-model="form.paymenttype_id">
                        <option v-for="paymenttype in paymenttypes" :key="paymenttype.id" :value="paymenttype.id">{{
                          paymenttype.pt_name }}</option>
                      </select>
                      <small class="text-danger" v-if="errors.product_id">{{
                        errors.product_id[0]
                      }}</small>
                      <label for="inputPhone">Payment type</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                      <select class="form-select" aria-label="Default select example" v-model="form.supplier_id">
                        <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">{{
                          supplier.name }}</option>
                      </select>
                      <small class="text-danger" v-if="errors.product_id">{{
                        errors.product_id[0]
                      }}</small>
                      <label for="inputPhone">Supplier Name</label>
                    </div>
                  </div>
                </div>
                <div class="mt-2 mb-0">
                  <div class="d-grid">
                    <button class="btn btn-primary btn-block">Submit</button>
                  </div>
                </div>
              </form>

              <div v-if="rows.length > 0">
                <form @submit.prevent="handleDynamicSubmit">
                  <div v-for="(row, index) in rows" :key="index" class="form-row d-flex mb-3">
                    <div class="col-md-2 me-2" hidden>
                      <div class="form-floating mb-3 mb-md-0">
                        <select class="form-select" readonly aria-label="Default select example" v-model="row.stocksId">
                          <option :value="stocksId">
                            {{ stocksId }}
                          </option>
                        </select>
                        <small class="text-danger" v-if="errors.stock_id">{{
                          errors.stock_id[0]
                        }}</small>
                        <label for="inputAddress">Stocks ID</label>
                      </div>
                    </div>
                    <!-- <div class="col-md-4 me-2">
                      <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" v-model="row.serial_no" />
                        <small class="text-danger" v-if="errors.serial_no">{{
                          errors.serial_no[0]
                        }}</small>
                        <label for="inputAddress">Serial Number</label>
                      </div>
                    </div> -->
                    <div class="col-md-3 me-2">
                      <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" v-model="row.barcode_no" @keydown.enter.prevent="focusNext(index)"
                          :ref="'barcode-' + index" :id="'barcode-no-' + index" />
                        <small class="text-danger" v-if="row.errors.barcode_no">{{ row.errors.barcode_no[0] }}</small>
                        <label :for="'barcode-no-' + index">Barcode Number</label>
                      </div>
                    </div>
                    <div class="col-md-3 me-2">
                      <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" v-model="row.serial_no" />
                        <small class="text-danger" v-if="errors.serial_no">{{
                          errors.serial_no[0]
                        }}</small>
                        <label for="inputAddress">Serial Number</label>
                      </div>
                    </div>

                    <div class="col-md-3 me-2">
                      <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" v-model="row.color" />
                        <small class="text-danger" v-if="errors.color">{{
                          errors.color[0]
                        }}</small>
                        <label for="inputAddress">Color</label>
                      </div>
                    </div>
                    <div class="col-md-2 me-2" hidden>
                      <div class="form-floating mb-3 mb-md-0">
                        <select class="form-select" readonly aria-label="Default select example" v-model="row.userid">
                          <option :value="users.id">
                            {{ users.user_name }}
                          </option>
                        </select>
                        <small class="text-danger" v-if="errors.userid">{{
                          errors.userid[0]
                        }}</small>
                        <label for="inputAddress">Users Name</label>
                      </div>
                    </div>
                    <div class="col-md-2 me-2">
                      <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control p-3 px-4" type="file" @change="handleImageUpload(index, $event)" />
                        <small class="text-danger" v-if="row.errors.image">{{ row.errors.image[0] }}</small>
                      </div>
                    </div>
                    <div class="col-md-1">
                      <div class="form-floating mb-3 mb-md-0">
                        <img :src="row.image" width="55" height="55" />
                      </div>
                    </div>
                  </div>
                  <div class="mt-2 mb-0">
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
</template>

<script>
import axios from "axios";
import { inject } from 'vue';
export default {
  name: "Stocks_create",
  data() {
    const userName = inject('userName');
    const profile_img = inject('profile_img');
    return {
      form: {
        product_id: null,
        user_id: null,
        stock_date: null,
        stock_quantity: null,
        buying_price: null,
        selling_price: null,
        paymenttype_id: null,
        supplier_id: null
      },
      errors: {},
      suppliers: [],
      users: [],
      products: [],
      stocksId: null,
      rows: [],
      paymenttypes: [],
      //for inject
      userName,
      profile_img,

      visible: true,
    };
  },
  methods: {
    async handleSubmit() {
      await axios.post("/api/stocks/store", this.form)
        .then((res) => {
          if (res) {
            this.stocksId = res.data.stock_id;
            this.visible = false;
            Toast.fire({
              icon: "success",
              title: res.data.message,
            });
            this.initializeRows();
          }
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
        });
    },
    // initializeRows() {
    //   this.rows = [];
    //   for (let i = 0; i < this.form.stock_quantity; i++) {
    //     this.rows.push({
    //       stocksId: this.stocksId,
    //       serial_no: null,
    //       color: null,
    //       userid: this.form.user_id,
    //       image: "/backend/assets/img/pic.jpeg",
    //       errors: {},
    //     });
    //   }
    // },

    initializeRows() {
      this.rows = [];
      for (let i = 0; i < this.form.stock_quantity; i++) {
        this.rows.push({
          stocksId: this.stocksId,
          serial_no: null,
          barcode_no:null,
          color: null,
          userid: this.form.user_id,
          image: "/backend/assets/img/pic.jpeg",
          errors: {},
        });
      }
      this.focusFirstInput(); // Automatically focus the first input after initialization
    },

    focusNext(index) {
      this.$nextTick(() => {
        const nextInput = this.$refs[`barcode-${index + 1}`]?.[0];
        if (nextInput) {
          nextInput.focus();
        }
      });
    },

    focusFirstInput() {
      this.$nextTick(() => {
        const firstInput = this.$refs['barcode-0']?.[0];
        if (firstInput) {
          firstInput.focus();
        }
      });
    },
    handleImageUpload(index, event) {
      let file = event.target.files[0];
      if (file.size > 1048576) {
        Toast.fire({
          icon: "warning",
          title: "Image must be less than 1 MB!",
        });
      } else {
        let reader = new FileReader();
        reader.onload = (e) => {
          this.rows[index].image = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    },
    async handleDynamicSubmit() {
      await axios.post("/api/serials/store", { rows: this.rows })
        .then((res) => {
          this.$router.push({ name: 'All_stocks' })
        })
        .catch((error) => {
          this.rows.errors = error.response.data.errors;
        })
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
    fetchSuppliers() {
      axios
        .get("/api/suppliers")
        .then((response) => {
          this.suppliers = response.data;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    async fetch_product() {
      await axios.get("/api/products")
        .then((res) => {
          this.products = res.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  created() {
    this.fetchUsers();
    this.fetch_product();
    this.fetch_paymenttype();
    this.fetchSuppliers()
  }
};

</script>

<style></style>
