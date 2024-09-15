<!-- <template>
  <div class="container">
    <div class="card mt-4 mb-2">
      <div class="card-header border-bottom-0 p-4">
        <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link>
        <span class="text-muted h5"> / Stocks List</span>
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between">
        <div class="employee_table">
          <i class="fas fa-table me-1"></i>
          Stocks List Table
        </div>
        <div class="addNew">
          <router-link to="/stocks_create" class="btn btn-sm btn-success">Add New</router-link>
        </div>
      </div>
      <div class="card-body">
        <input type="text" id="searchInput" placeholder="Search for ID.." />
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Product Name</th>
              <th scope="col">Assing By</th>
              <th scope="col">Stock Quantity</th>
              <th scope="col">Selling Price</th>
              <th scope="col">Buying Price</th>
              <th scope="col">Status</th>
              <th scope="col">Stocks Data</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="stock in Stocks" :key="stock.id">
              <td>{{ stock.id }}</td>
              <td>{{ stock.product.product_model }}</td>
              <td>{{ stock.user.user_name }}</td>
              <td>{{ stock.stock_quantity }}</td>
              <td>{{ stock.selling_price }}</td>
              <td>{{ stock.buying_price }}</td>
              <td>{{ stock.status }}</td>
              <td>{{ stock.stock_date }}</td>
              <td>
                <div class="buttonGroup py-2">
                  <button type="button" class="btn btn-sm btn-success" @click="openEditModal(stock)">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>
                  <button class="btn btn-sm btn-danger mx-2" @click="deleteStock(stock.id)">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                  <button class="btn btn-sm btn-success mx-2" @click="fetchSerialsByStock(stock.id)">
                    <i class="fas fa-print"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editSupplierLabel" aria-hidden="true">
      <div class="modal-dialog full-width-modal mt-3">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-muted" id="editSupplierModal">
              Edit Stocks
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
                      <p class="text-muted font-bold">Edit Stocks</p>
                    </div>
                  </div>
                  <div class="card-body">
                    <form @submit.prevent="Stock_edit" enctype="multipart/form-data">
                      <div class="row mb-3">
                        <div class="col-md-6">
                          <div class="form-floating mb-3 mb-md-0">
                            <select class="form-select" readonly aria-label="Default select example"
                              v-model="form.product_model">
                              <option v-for="product in products" :key="product.id" :value="product.product_model">
                                {{ product.product_model }}
                              </option>
                            </select>
                            <small class="text-danger" v-if="errors.product_model">{{
                              errors.product_model[0]
                            }}</small>
                            <label for="inputEmail">Product Name</label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-floating mb-3 mb-md-0">
                            <select class="form-select" readonly aria-label="Default select example"
                              v-model="form.user_id">
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
                            <input class="form-control" id="inputAddress" type="text" placeholder="Address"
                              v-model="form.stock_quantity" />
                            <small class="text-danger" v-if="errors.stock_quantity">{{
                              errors.stock_quantity[0]
                            }}</small>
                            <label for="inputAddress">Stock Quantity</label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputPhone" type="text" placeholder="Phone"
                              v-model="form.selling_price" />
                            <small class="text-danger" v-if="errors.selling_price">{{
                              errors.selling_price[0]
                            }}</small>
                            <label for="inputPhone">Selling Price</label>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-md-6">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputPhone" type="text" placeholder="Phone"
                              v-model="form.buying_price" />
                            <small class="text-danger" v-if="errors.buying_price">{{
                              errors.buying_price[0]
                            }}</small>
                            <label for="inputAddress">Buying Price</label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-floating mb-3 mb-md-0">
                            <select class="form-select" aria-label="Default select example" v-model="form.status">
                              <option :value="0">Inactive</option>
                              <option :value="1">Active</option>
                            </select>
                            <small class="text-danger" v-if="errors.status">{{ errors.status[0] }}</small>
                            <label for="inputPhone">Product Status</label>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-md-12">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputShopName" type="date" placeholder="Shop Name"
                              v-model="form.stock_date" />
                            <small class="text-danger" v-if="errors.stock_date">{{
                              errors.stock_date[0]
                            }}</small>
                            <label for="inputNid">Stock Date</label>
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
    <div id="print-area" style="display: none;">
      <div v-for="serial in serials" :key="serial.serial_no" class="barcode-section">
        <p>{{ serial.serial_no }}</p>
        <img :src="'data:image/png;base64,' + serial.barcode" alt="barcode" />
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { inject } from 'vue';
export default {
  name: "All_stocks",
  data() {
    const userName = inject('userName');
    const profile_img = inject('profile_img');
    return {
      userName,
      profile_img,
      Stocks: [],
      products: [],
      users: [],
      serials: [],
      form: {
        id: null,
        product_model: null,
        user_id: null,
        stock_quantity: null,
        selling_price: null,
        buying_price: null,
        status: null,
        stock_date: null
      },
      errors: {}
    }
  },
  methods: {
    async fetch_stocks() {
      await axios.get("/api/stocks")
        .then((res) => {
          this.Stocks = res.data;
        })
        .catch((error) => {
          console.log(error)
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
    async fetchSerialsByStock(stockId) {
      await axios.get(`/api/stocks/serial/${stockId}`)
        .then((res) => {
          console.log(res)
          this.serials = res.data;
          this.printBarcodes();
        })
        .catch((error) => {
          console.log(error)
        })

    },
    printBarcodes() {
      const printArea = document.getElementById('print-area');

      // Clear any previous content in the print area
      printArea.innerHTML = '';

      // Dynamically insert barcode data into the print area
      this.serials.forEach(item => {
        const barcodeElement = document.createElement('div');
        barcodeElement.innerHTML = `
      <div>
        <p>Serial Number: ${item.serial_no}</p>
        <img src="data:image/png;base64,${item.barcode}" alt="Barcode" />
      </div>
    `;
        printArea.appendChild(barcodeElement);
      });

      // Display the print area and trigger the print dialog
      printArea.style.display = 'block';
      window.print();

      // Optionally hide the print area after printing
      printArea.style.display = 'none';
    },
    async fetch_products() {
      await axios.get("/api/products")
        .then((res) => {
          this.products = res.data
        })
        .catch((error) => {
          console.log(error)
        })
    },
    async Stock_edit() {
      axios.put("/api/stocks/update", this.form)
        .then((res) => {
          let myModal = bootstrap.Modal.getInstance(
            document.getElementById("editSupplierModal")
          );
          myModal.hide();
          this.fetch_stocks();
          Toast.fire({
            icon: "success",
            title: res.data.message,
          });
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
        })
    },
    async deleteStock(id) {
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
            .delete("/api/stocks/delete/" + id)
            .then((res) => {
              this.fetch_stocks();
            })
            .catch((error) => {
            });
          Swal.fire({
            title: "Deleted!",
            text: "Category has been deleted.",
            icon: "success",
          });
        }
      });
    },
    openEditModal(stock) {
      this.form = { ...stock }
      this.form.product_model = stock.product.product_model
      let myModal = new bootstrap.Modal(
        document.getElementById("editSupplierModal"),
        {}
      );
      myModal.show();
    },
  },
  created() {
    this.fetch_stocks();
    this.fetchUsers();
    this.fetch_products();
  }
}
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
  height: 79vh;
  margin: auto;
}

.barcode-section {
  text-align: center;
  margin: 10px 0;
}

.barcode-section img {
  max-width: 100%;
  height: auto;
}
</style> -->

<template>
  <div class="container">
    <div id="main-content">
      <div class="card mt-4 mb-2">
        <div class="card-header border-bottom-0 p-4">
          <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link>
          <span class="text-muted h5"> / Stocks List</span>
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
          <div class="employee_table">
            <i class="fas fa-table me-1"></i>
            Stocks List Table
          </div>
          <div class="addNew">
            <router-link to="/stocks_create" class="btn btn-sm btn-success">Add New</router-link>
          </div>
        </div>
        <div class="card-body">
          <input type="text" id="searchInput" placeholder="Search for ID.." />
          <table class="table" id="pp">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">Assigned By</th>
                <th scope="col">Stock Quantity</th>
                <th scope="col">Selling Price</th>
                <th scope="col">Buying Price</th>
                <th scope="col">Payment Methods</th>
                <th scope="col">Supplied By</th>
                <th scope="col">Status</th>
                <th scope="col">Stocks Data</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="stock in Stocks" :key="stock.id">
                <td>{{ stock.id }}</td>
                <td>{{ stock.product.product_model }}</td>
                <td>{{ stock.user.user_name }}</td>
                <td>{{ stock.stock_quantity }}</td>
                <td>{{ stock.selling_price }}</td>
                <td>{{ stock.buying_price }}</td>
                <td>{{ stock.paymenttype.pt_name }}</td>
                <td>{{ stock.supplier.name }}</td>
                <td>{{ stock.status }}</td>
                <td>{{ stock.stock_date }}</td>
                <td>
                  <div class="buttonGroup py-2">
                    <button type="button" class="btn btn-sm btn-success" @click="openEditModal(stock)">
                      <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="btn btn-sm btn-danger mx-2" @click="deleteStock(stock.id)">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                    <button class="btn btn-sm btn-success mx-2" @click="fetchSerialsByStock(stock.id)">
                      <i class="fas fa-print"></i>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editSupplierLabel"
        aria-hidden="true">
        <div class="modal-dialog full-width-modal mt-3">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-muted" id="editSupplierModal">
                Edit Stocks
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
                        <p class="text-muted font-bold">Edit Stocks</p>
                      </div>
                    </div>
                    <div class="card-body">
                      <form @submit.prevent="Stock_edit" enctype="multipart/form-data">
                        <div class="row mb-3">
                          <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                              <select class="form-select" readonly aria-label="Default select example"
                                v-model="form.product_model">
                                <option v-for="product in products" :key="product.id" :value="product.product_model">
                                  {{ product.product_model }}
                                </option>
                              </select>
                              <small class="text-danger" v-if="errors.product_model">{{
                                errors.product_model[0]
                              }}</small>
                              <label for="inputEmail">Product Name</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                              <select class="form-select" readonly aria-label="Default select example"
                                v-model="form.user_id">
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
                              <input class="form-control" id="inputAddress" type="text" placeholder="Address"
                                v-model="form.stock_quantity" />
                              <small class="text-danger" v-if="errors.stock_quantity">{{
                                errors.stock_quantity[0]
                              }}</small>
                              <label for="inputAddress">Stock Quantity</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                              <input class="form-control" id="inputPhone" type="text" placeholder="Phone"
                                v-model="form.selling_price" />
                              <small class="text-danger" v-if="errors.selling_price">{{
                                errors.selling_price[0]
                              }}</small>
                              <label for="inputPhone">Selling Price</label>
                            </div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                              <input class="form-control" id="inputPhone" type="text" placeholder="Phone"
                                v-model="form.buying_price" />
                              <small class="text-danger" v-if="errors.buying_price">{{
                                errors.buying_price[0]
                              }}</small>
                              <label for="inputAddress">Buying Price</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                              <select class="form-select" aria-label="Default select example" v-model="form.status">
                                <option :value="0">Inactive</option>
                                <option :value="1">Active</option>
                              </select>
                              <small class="text-danger" v-if="errors.status">{{ errors.status[0] }}</small>
                              <label for="inputPhone">Product Status</label>
                            </div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                              <input class="form-control" id="inputShopName" type="date" placeholder="Shop Name"
                                v-model="form.stock_date" />
                              <small class="text-danger" v-if="errors.stock_date">{{
                                errors.stock_date[0]
                              }}</small>
                              <label for="inputNid">Stock Date</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                              <select class="form-select" readonly aria-label="Default select example"
                                v-model="form.paymenttype_name">
                                <option v-for="paymenttype in paymenttypes" :key="paymenttype.id"
                                  :value="paymenttype.pt_name">
                                  {{ paymenttype.pt_name }}
                                </option>
                              </select>
                              <small class="text-danger" v-if="errors.pt_name">{{
                                errors.pt_name[0]
                              }}</small>
                              <label for="inputEmail">Payment Type</label>
                            </div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-md-12">
                            <div class="form-floating mb-3 mb-md-0">
                              <select class="form-select" aria-label="Default select example"
                                v-model="form.supplier_id">
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

    <div id="print-area" style="display: none;">
      <div v-for="serial in serials" :key="serial.serial_no" class="barcode-section">
        <img v-if="serial.barcode" :src="`data:image/png;base64,${serial.barcode}`" alt="Barcode" />
        <div>
          {{ serial.serial_no }}
        </div>
        <br>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { inject } from 'vue';
export default {
  name: "All_stocks",
  data() {
    const userName = inject('userName');
    const profile_img = inject('profile_img');
    return {
      Stocks: [],
      products: [],
      users: [],
      serials: [],
      paymenttypes: [],
      form: {
        id: null,
        product_model: null,
        paymenttype_name: null,
        user_id: null,
        stock_quantity: null,
        selling_price: null,
        buying_price: null,
        status: null,
        stock_date: null,
        supplier_id: null
      },
      suppliers: [],
      errors: {},
      userName,
      profile_img,
    }
  },
  methods: {
    async fetchSerialsByStock(stockId) {
      try {
        const response = await axios.get(`/api/stocks/serial/${stockId}`);
        console.log('Fetched serials:', response.data);
        this.serials = response.data;
        this.printBarcodes();
      } catch (error) {
        console.error('Error fetching serials:', error);
      }
    },

    printBarcodes() {
      document.getElementById('main-content').style.display = 'none';
      document.getElementById('print-area').style.display = 'block';
      setTimeout(() => {
        window.print();
        document.getElementById('main-content').style.display = 'block';
        document.getElementById('print-area').style.display = 'none';
      }, 0);
    },
    async fetch_stocks() {
      try {
        const response = await axios.get("/api/stocks");
        this.Stocks = response.data;
      } catch (error) {
        console.error('Error fetching stocks:', error);
      }
    },
    async fetchUsers() {
      const token = localStorage.getItem('token');
      try {
        const response = await axios.get("/api/auth/me", {
          headers: {
            'Authorization': `Bearer ${token}`
          }
        });
        this.userName = response.data.user_name;
        this.profile_img = response.data.profile_img;
        this.users = response.data;
      } catch (error) {
        console.error('Error fetching users:', error);
      }
    },
    async fetch_products() {
      try {
        const response = await axios.get("/api/products");
        this.products = response.data;
      } catch (error) {
        console.error('Error fetching products:', error);
      }
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
    async Stock_edit() {
      try {
        const response = await axios.put("/api/stocks/update", this.form);
        console.log(response)
        let myModal = bootstrap.Modal.getInstance(
          document.getElementById("editSupplierModal")
        );
        myModal.hide();
        this.fetch_stocks();
        Toast.fire({
          icon: "success",
          title: response.data.message,
        });
      } catch (error) {
        this.errors = error.response.data.errors;
      }
    },
    async deleteStock(id) {
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
          try {
            await axios.delete("/api/stocks/delete/" + id);
            this.fetch_stocks();
            Swal.fire({
              title: "Deleted!",
              text: "Category has been deleted.",
              icon: "success",
            });
          } catch (error) {
            console.error('Error deleting stock:', error);
          }
        }
      });
    },
    openEditModal(stock) {
      this.form = { ...stock };
      this.form.product_model = stock.product.product_model;
      this.form.paymenttype_name = stock.paymenttype.pt_name;
      let myModal = new bootstrap.Modal(
        document.getElementById("editSupplierModal"),
        {}
      );
      myModal.show();
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
  },
  created() {
    this.fetch_stocks();
    this.fetchUsers();
    this.fetch_products();
    this.fetch_paymenttype();
    this.fetchSuppliers();
  }
}
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
  height: 86vh;
  margin: auto;
}

.barcode-section {
  text-align: center;
  margin: 10px 0px;
}

.barcode-section img {
  max-width: 100%;
  height: auto;
}

#print-area {
  position: absolute;
  text-align: center;
  top: 0;
  left: 0;
  margin: auto;
  width: 100%;
  height: 100%;
}
</style>
