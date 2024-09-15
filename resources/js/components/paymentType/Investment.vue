<template>
  <div class="container">
    <div class="card mt-4 mb-2">
      <div class="card-header border-bottom-0 p-4">
        <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span class="text-muted h5"> /
          Investments</span>
      </div>
    </div>
    <button class="btn shadow-sm btn-primary mb-2" @click="openCreateInvestmentModal()">Add Investments</button>

    <div class="card mb-4 tt">
      <div class="card-header d-flex justify-content-between">
        <div class="employee_table fw-bold text-muted">
          <i class="fas fa-table me-1"></i>
          Investments
        </div>
      </div>
      <div class="card-body">
        <table class="table text-muted">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Investmentor Name</th>
              <th scope="col">Amount</th>
              <th scope="col">Payment Type</th>
              <th scope="col">Assign By</th>
              <th scope="col">Investment Date</th>
              <th scope="col">Status</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="investment in investments" :key="investment.id">
              <td>{{ investment.id }}</td>
              <td>{{ investment.In_name }}</td>
              <td>{{ investment.Amount }}</td>
              <td>{{ investment.paymenttype.pt_name }}</td>
              <td>{{ investment.user.user_name }}</td>
              <td>{{ investment.date }}</td>
              <td>
                <span v-if="investment.status == 0">Inactive</span>
                <span v-else>Active</span>
              </td>
              <td>
                <div class="buttonGroup py-2">
                  <button type="button" class="btn btn-sm btn-success" @click="openEditModal(investment)">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>
                  <button class="btn btn-sm btn-danger mx-2" @click="deleteInvestment(investment.id)">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="modal fade" id="createInvestmentModal" tabindex="-1" aria-labelledby="createInvestmentModalLabel"
      aria-hidden="true">
      <div class="modal-dialog full-width-modal mt-4">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-muted" id="createInvestmentModal">
              Add Investment
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
                      <p class="text-muted font-bold">Add Investment</p>
                    </div>
                  </div>
                  <div class="card-body">
                    <form @submit.prevent="investment_create" enctype="multipart/form-data">
                      <div class="row mb-1">
                        <div class="col-md-6 mb-2">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputCategoryName" type="text" placeholder="Enter your name"
                              v-model="form.investment_name" />
                            <small class="text-danger" v-if="errors.investment_name">{{
                              errors.investment_name[0]
                            }}</small>
                            <label for="inputName">Investmentor Name</label>
                          </div>
                        </div>
                        <div class="col-md-6 mb-2">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputCategoryName" type="text" placeholder="Enter your name"
                              v-model="form.amount" />
                            <small class="text-danger" v-if="errors.amount">{{
                              errors.amount[0]
                            }}</small>
                            <label for="inputName">Amount</label>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-1">
                        <div class="col-md-6 mb-3">
                          <div class="form-floating mb-3 mb-md-0">
                            <select class="form-select" readonly aria-label="Default select example"
                              v-model="form.user_id">
                              <option :value="users.id">
                                {{ users.user_name }}
                              </option>
                            </select>
                            <small class="text-danger" v-if="errors.user_id">{{
                              errors.user_id[0] }}</small>
                            <label class="h6 text-black mb-0" for="inputSupplier">User
                              Name</label>
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-floating mb-3 mb-md-0">
                            <select class="form-select" readonly aria-label="Default select example"
                              v-model="form.paymenttype">
                              <option v-for="payment in paymenttypes" :key="payment.id" :value="payment.id">
                                {{ payment.pt_name }}
                              </option>
                            </select>
                            <small class="text-danger" v-if="errors.paymenttype">{{
                              errors.paymenttype[0] }}</small>
                            <label class="h6 text-black mb-0" for="inputSupplier">Payment Type</label>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-1">
                        <div class="col-md-12 mb-2">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputCategoryName" type="date" placeholder="Enter your name"
                              v-model="form.invest_date" />
                            <small class="text-danger" v-if="errors.invest_date">{{
                              errors.invest_date[0]
                            }}</small>
                            <label for="inputName">Investment date</label>
                          </div>
                        </div>
                      </div>
                      <div class="mt-3 mb-0">
                        <div class="d-grid">
                          <button class="btn btn-primary w-100 mb-2" :disabled="loading">
                            <span v-if="loading" class="spinner-border spinner-border-sm me-2" role="status"
                              aria-hidden="true"></span>
                            <span v-if="!loading">Submit</span>
                            <span v-if="loading">Submit...</span>
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

    <div class="modal fade" id="editInvestmentModal" tabindex="-1" aria-labelledby="editInvestmentModalLabel"
      aria-hidden="true">
      <div class="modal-dialog full-width-modal mt-5">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-muted" id="editInvestmentModal">
              Edit Payment-type
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
                      <p class="text-muted font-bold">Edit Payment-type</p>
                    </div>
                  </div>
                  <div class="card-body">
                    <form @submit.prevent="investment_update" enctype="multipart/form-data">
                      <div class="row mb-1">
                        <div class="col-md-6 mb-2">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputCategoryName" type="text" placeholder="Enter your name"
                              v-model="editForm.edit_investment_name" />
                            <small class="text-danger" v-if="errors.edit_investment_name">{{
                              errors.edit_investment_name[0]
                            }}</small>
                            <label for="inputName">Investmentor Name</label>
                          </div>
                        </div>
                        <div class="col-md-6 mb-2">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputCategoryName" type="text" placeholder="Enter your name"
                              v-model="editForm.edit_amount" />
                            <small class="text-danger" v-if="errors.edit_amount">{{
                              errors.edit_amount[0]
                            }}</small>
                            <label for="inputName">Amount</label>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-1">
                        <div class="col-md-6 mb-3">
                          <div class="form-floating mb-3 mb-md-0">
                            <select class="form-select" readonly aria-label="Default select example"
                              v-model="editForm.edit_user_id">
                              <option :value="users.id">
                                {{ users.user_name }}
                              </option>
                            </select>
                            <small class="text-danger" v-if="errors.edit_user_id">{{
                              errors.edit_user_id[0] }}</small>
                            <label class="h6 text-black mb-0" for="inputSupplier">User
                              Name</label>
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-floating mb-3 mb-md-0">
                            <select class="form-select" readonly aria-label="Default select example"
                              v-model="editForm.edit_paymenttype">
                              <option v-for="payment in paymenttypes" :key="payment.id" :value="payment.id">
                                {{ payment.pt_name }}
                              </option>
                            </select>
                            <small class="text-danger" v-if="errors.edit_paymenttype">{{
                              errors.edit_paymenttype[0] }}</small>
                            <label class="h6 text-black mb-0" for="inputSupplier">Payment Type</label>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-1">
                        <div class="col-md-6 mb-2">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputCategoryName" type="date" placeholder="Enter your name"
                              v-model="editForm.edit_invest_date" />
                            <small class="text-danger" v-if="errors.edit_invest_date">{{
                              errors.edit_invest_date[0]
                            }}</small>
                            <label for="inputName">Investment date</label>
                          </div>
                        </div>
                        <div class="col-md-6 mb-2">
                          <div class="form-floating mb-3 mb-md-0">
                            <select class="form-select" aria-label="Default select example"
                              v-model="editForm.edit_status">
                              <option :value="0">Inactive</option>
                              <option :value="1">Active</option>
                            </select>
                            <small class="text-danger" v-if="errors.edit_status">{{
                              errors.edit_status[0]
                            }}</small>
                            <label for="inputName">Status</label>
                          </div>
                        </div>
                      </div>
                      <div class="mt-3 mb-0">
                        <div class="d-grid">
                          <button class="btn btn-primary w-100 mb-2" :disabled="loading">
                            <span v-if="loading" class="spinner-border spinner-border-sm me-2" role="status"
                              aria-hidden="true"></span>
                            <span v-if="!loading">Submit</span>
                            <span v-if="loading">Submit...</span>
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
  name: "Investment-vue",
  data() {
    const userName = inject('userName');
    const profile_img = inject('profile_img');
    return {
      form: {
        investment_name: null,
        amount: null,
        user_id: null,
        paymenttype: null,
        invest_date: null
      },
      editForm: {
        id: null,
        edit_investment_name: null,
        edit_amount: null,
        edit_user_id: null,
        edit_paymenttype: null,
        edit_invest_date: null,
        edit_status: null,
      },
      loading: false,
      errors: {},
      userName,
      profile_img,
      users: [],
      paymenttypes: [],
      investments: []
    }
  },
  methods: {
    async investment_create() {
      this.loading = true
      await axios.post("/api/investments/store", this.form)
        .then((res) => {
          console.log(res)
          this.form = {
            investment_name: null,
            amount: null,
            user_id: null,
            paymenttype: null,
            invest_date: null
          };
          let myModal = bootstrap.Modal.getInstance(
            document.getElementById("createInvestmentModal")
          );
          myModal.hide();
          this.fetch_investment();
          Toast.fire({
            icon: "success",
            title: res.data.message,
          });
        })
        .catch((error) => {
          this.errors = error.response.data.errors
        })
        .finally(() => {
          this.loading = false
        })
    },
    async fetch_investment() {
      await axios.get('/api/investments')
        .then((res) => {
          this.investments = res.data;
        })
        .catch((res) => {
          console.log(res)
        })
    },
    openCreateInvestmentModal() {
      let myModal = new bootstrap.Modal(
        document.getElementById("createInvestmentModal"),
        {}
      );
      myModal.show();
    },
    openEditModal(investment) {
      this.editForm.id = investment.id
      this.editForm.edit_investment_name = investment.In_name;
      this.editForm.edit_amount = investment.Amount;
      this.editForm.edit_invest_date = investment.date;
      this.editForm.edit_paymenttype = investment.paymenttype_id;
      this.editForm.edit_user_id = investment.user_id;
      this.editForm.edit_status = investment.status;
      let myModal = new bootstrap.Modal(
        document.getElementById("editInvestmentModal"),
        {}
      );
      myModal.show();
    },
    async investment_update() {
      this.updating = true;
      axios.put('/api/investments/upate', this.editForm)
        .then((res) => {
          console.log(res)
          this.editForm = {
            id: null,
            edit_investment_name: null,
            edit_amount: null,
            edit_user_id: null,
            edit_paymenttype: null,
            edit_invest_date: null,
            edit_status: null,
          }
          this.fetch_investment();
          let myModal = bootstrap.Modal.getInstance(
            document.getElementById("editInvestmentModal")
          );
          myModal.hide();
          Toast.fire({
            icon: "success",
            title: res.data.message,
          });
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
        })
        .finally(() => {
          this.updating = false
        })
    },
    async deleteInvestment(id) {
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
            .delete("/api/investments/delete/" + id)
            .then((res) => {
              this.fetch_investment()
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
    async fetch_paymenttype() {
      await axios.get('/api/payment-types')
        .then((res) => {
          this.paymenttypes = res.data;
        })
        .catch((res) => {
          console.log(res)
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
          this.users = res.data;
          this.userName = res.data.user_name;
          this.profile_img = res.data.profile_img
        })
        .catch((error) => {
          console.log(error.response ? error.response.data : error.message);
        });
    }
  },
  created() {
    this.fetch_investment();
    this.fetch_paymenttype();
    this.fetchData();
  }
}
</script>

<style></style>