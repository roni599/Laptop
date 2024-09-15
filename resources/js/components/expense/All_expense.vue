<template>
  <div class="container">
    <div class="card mt-4 mb-2">
      <div class="card-header border-bottom-0 p-4">
        <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span class="text-muted h5"> /
          Expense List</span>
      </div>
    </div>

    <div class="card mb-4 tt">
      <div class="card-header d-flex justify-content-between">
        <div class="employee_table">
          <i class="fas fa-table me-1"></i>
          Expense List Table
        </div>
        <div class="addNew">
          <router-link to="/expence_create" class="btn btn-sm btn-success">Create Expense</router-link>
        </div>
      </div>
      <div class="card-body">
        <table class="table text-muted">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Expenser Name</th>
              <th scope="col">Expense Description</th>
              <th scope="col">Expense Amount</th>
              <th scope="col">Cost Type</th>
              <th scope="col">Expense Category</th>
              <th scope="col">Payment Type</th>
              <th scope="col">Assinged By</th>
              <th scope="col">Date</th>
              <th scope="col">Status</th>
              <th scope="col">Image</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="expense in expenses" :key="expense.id">
              <td>{{ expense.id }}</td>
              <td>{{ expense.expenser.user_name }}</td>
              <td>{{ expense.expense_desc }}</td>
              <td>{{ expense.amount }}</td>
              <td v-if="expense.cost_type == 1">Fixed</td>
              <td v-else>Running</td>
              <td>{{ expense.expensecategory.category_name }}</td>
              <td>{{ expense.paymenttype.pt_name }}</td>
              <td>{{ expense.user.user_name }}</td>
              <td>{{ expense.date }}</td>
              <td>{{ expense.status }}</td>
              <td>
                <img :src="`/backend/images/expense/${expense.receipt_img}`" alt="User Image" width="50" height="50" />
              </td>
              <td>
                <div class="buttonGroup py-2">
                  <button type="button" class="btn btn-sm btn-success ms-2 mb-1" @click="openEditModal(expense)">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>
                  <button class="btn btn-sm btn-danger mx-2" @click="deleteExpense(expense.id)">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
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
                    <form @submit.prevent="Expense_update" enctype="multipart/form-data">
                      <div class="row mb-3">
                        <div class="col-md-6">
                          <div class="form-floating mb-3 mb-md-0">
                            <select class="form-select" aria-label="Default select example" v-model="form.expenserName">
                              <option v-for="userlist in userslist" :key="userlist.id" :value="userlist.id">
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
                        <div class="col-md-6">
                          <div class="form-floating mb-3 mb-md-0">
                            <select class="form-select" aria-label="Default select example" v-model="form.paymenttype">
                              <option v-for="paymenttype in paymenttypes" :key="paymenttype.id" :value="paymenttype.id">
                                {{ paymenttype.pt_name }}
                              </option>
                            </select>
                            <small class="text-danger" v-if="errors.paymenttype">{{
                              errors.paymenttype[0]
                            }}</small>
                            <label for="inputSellingPrice">Payment Type</label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-floating mb-3 mb-md-0">
                            <textarea class="form-control" id="inputProductCode" type="text" placeholder="Product Code"
                              v-model="form.amount"></textarea>
                            <small class="text-danger" v-if="errors.amount">{{
                              errors.amount[0]
                            }}</small>
                            <label for="inputEmail">Amount</label>
                          </div>
                        </div>
                      </div>

                      <div class="row mb-1">
                        <div class="col-md-6">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputDate" type="date" v-model="form.date" />
                            <small class="text-danger" v-if="errors.date">{{ errors.date[0]
                              }}</small>
                            <label for="inputDate">Expense Date</label>
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
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
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 mb-3">
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
                        <div class="col-md-6">
                          <div class="form-floating mb-3 mb-md-0">
                            <select class="form-select" aria-label="Default select example"
                              v-model="form.expensecategory">
                              <option v-for="expensecategory in expensecategories" :key="expensecategory.id"
                                :value="expensecategory.id">
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
                      <div class="row mb-2">
                        <div class="col-md-6 mb-2">
                          <div class="form-floating mb-3 mb-md-0">
                            <select class="form-select" aria-label="Default select example" v-model="form.status">
                              <option :value="0">Inactive</option>
                              <option :value="1">Active</option>
                            </select>
                            <small class="text-danger" v-if="errors.status">{{
                              errors.status[0]
                            }}</small>
                            <label for="inputName">Status</label>
                          </div>
                        </div>
                        <div class="col-md-5">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control p-3 px-4" id="inputFile" type="file" @change="onFileSelect" />
                            <small class="text-danger" v-if="errors.image">{{
                              errors.image[0]
                            }}</small>
                          </div>
                        </div>
                        <div class="col-md-1">
                          <div class="form-floating mb-3 mb-md-0">
                            <img v-if="form.image !== null" :src="getimageSrc()" alt="" width="55" height="55" />
                          </div>
                        </div>
                      </div>
                      <div class="mt-3 mb-0">
                        <div class="d-grid">
                          <button class="btn btn-primary w-100 mb-2" :disabled="loading">
                            <span v-if="loading" class="spinner-border spinner-border-sm me-2" role="status"
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
export default {
  name: "All_expense",
  data() {
    const userName = inject('userName');
    const profile_img = inject('profile_img');
    return {
      expenses: [],
      form: {
        id: null,
        expenserName: null,
        expense_description: null,
        amount: null,
        date: null,
        user_id: null,
        expensecategory: null,
        paymenttype: null,
        cost_type: null,
        status: null,
        image: '/backend/assets/img/pic.jpeg',
      },
      userName,
      profile_img,
      paymenttypes: [],
      userslist: [],
      expensecategories: [],
      users: [],
      errors: {},
      loading: false
    }
  },
  methods: {
    async fetch_expense() {
      await axios.get("/api/expense")
        .then((res) => {
          this.expenses = res.data;
        })
        .catch((error) => {
          console.log(error.response ? error.response.data : error.message);
        })
    },
    openEditModal(expense) {
      console.log(expense)
      this.form = { ...expense }
      this.form.expenserName = expense.expenser.id;
      this.form.paymenttype = expense.paymenttype.id
      this.form.expensecategory = expense.expensecategory.id
      this.form.expense_description = expense.expense_desc
      this.form.image = expense.receipt_img
      let myModal = new bootstrap.Modal(
        document.getElementById("editExpenseModal"),
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
        }
        reader.readAsDataURL(file);
      }
    },
    getimageSrc() {
      if (this.form.image) {
        if (this.form.image.startsWith("data")) {
          return this.form.image;
        } else {
          return `/backend/images/expense/${this.form.image}`;
        }
      }
      return "";
    },
    async Expense_update() {
      this.loading=true
      await axios.put("/api/expense/upate", this.form)
        .then((res) => {
          this.form = {
            id: null,
            expenserName: null,
            expense_description: null,
            amount: null,
            date: null,
            user_id: null,
            expensecategory: null,
            paymenttype: null,
            cost_type: null,
            status: null,
            image: '',
          },
            this.fetch_expense();
          let myModal = bootstrap.Modal.getInstance(
            document.getElementById("editExpenseModal")
          );
          myModal.hide();
          Toast.fire({
            icon: "success",
            title: res.data.message,
          });

        })
        .catch((error) => {
          console.log(error)
        })
        .finally(()=>{
          this.loading=false;
        })
    },
    async deleteExpense(id) {
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
            .delete("/api/expense/delete/" + id)
            .then((res) => {
              console.log(res)
              this.fetch_expense()
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
    }

  },
  created() {
    this.fetch_expense()
    this.fetchUsers();
    this.fetch_paymenttype();
    this.fetch_user();
    this.fetch_expensecategories();
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
</style>