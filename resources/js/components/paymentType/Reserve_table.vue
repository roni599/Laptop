<template>
  <div class="container">
    <div class="card mt-4 mb-2">
      <div class="card-header border-bottom-0 p-4">
        <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span class="text-muted h5"> /
          Reserves-Table</span>
      </div>
    </div>

    <div class="card mb-4 tt">
      <div class="card-header d-flex justify-content-between">
        <div class="employee_table fw-bold text-muted">
          <i class="fas fa-table me-1"></i>
          Investments
        </div>
      </div>
      <div class="card-body">
        <div class="table_size">
          <table class="table text-muted">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Transaction Type</th>
                <th scope="col">Amount</th>
                <th scope="col">Investmentor Name / Expenser name</th>
                <th scope="col">Payment Type</th>
                <th scope="col">Assign By</th>
                <th scope="col">Investment Date / Expense Date</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(reserve, index) in reserves" :key="reserve.id">
                <td>{{ index + 1 }}</td>
                <td>{{ reserve.transaction_type }}</td>
                <td>{{ reserve.amount }}</td>
                <td>
                  <!-- <span v-if="!reserve.investment">
                    {{ reserve.expense ? reserve.expense.expenser.user_name + ' (expenser) ' : '' }}
                  </span>
                  <span v-else-if="!reserve.expense">
                    {{ reserve.investment ? reserve.investment.In_name + ' (investor) ' : '' }}
                  </span>
                  <span v-if="reserve.bill_id">
                    For Product Sell
                  </span>
                  <span
                    v-if="reserve.bill === null || (reserve.bill.cart && reserve.bill.cart.cartitems && reserve.bill.cart.cartitems.some(item => item.serial && item.serial.status === '1'))">
                    Show for return
                  </span> -->
                  <!-- <span v-if="!reserve.investment && (reserve.bill === null || !reserve.bill.cart) && (reserve.expense)">
                    {{ reserve.expense ? reserve.expense.expenser.user_name + ' (expenser)' : '' }}
                  </span>

                  <span v-else-if="!reserve.expense && (reserve.bill === null || !reserve.bill.cart)">
                    {{ reserve.investment ? reserve.investment.In_name + ' (investor)' : '' }}
                  </span>

                  <span v-if="reserve.bill_id">
                    For Product Sell
                  </span>

                  <span
                    v-else-if="(reserve.expense === null && reserve.investment === null) || (reserve.bill === null || (reserve.bill.cart && reserve.bill.cart.cartitems && reserve.bill.cart.cartitems.some(item => item.serial && item.serial.status === '1')))">
                    Show for return
                  </span> -->

                  <span v-if="!reserve.investment && (reserve.bill === null || !reserve.bill.cart) && reserve.expense">
                    {{ reserve.expense.expenser.user_name }} (expenser)
                  </span>

                  <span v-else-if="!reserve.expense && (reserve.bill === null || !reserve.bill.cart)">
                    {{ reserve.investment ? reserve.investment.In_name + ' (investor)' : '' }}
                  </span>
                  <span v-if="reserve.bill_id">
                    For Product Sale
                  </span>

                  <span
                    v-else-if="!reserve.expense && !reserve.investment && (reserve.bill === null || (reserve.bill.cart && reserve.bill.cart.cartitems && reserve.bill.cart.cartitems.some(item => item.serial && item.serial.status === '1')))">
                    For Product Return
                  </span>
                </td>
                <td>{{ reserve.paymenttype.pt_name }}</td>
                <td>{{ reserve.user.user_name }}</td>
                <td>
                  <div>Date: {{ formatDate(reserve.created_at) }}</div>
                  <div>Time: {{ formatTime(reserve.created_at) }}</div>
                </td>
                <td>
                  <span v-if="reserve.status == 1" class="badge bg-danger">Inactive</span>
                  <span v-else class="badge bg-success">Active</span>
                </td>
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
export default {
  name: "Reserve-table",
  data() {
    const userName = inject('userName');
    const profile_img = inject('profile_img');
    return {
      users: [],
      reserves: [],
      userName,
      profile_img,
    }
  },
  computed: {
    formatDate() {
      return (date) => {
        return new Date(date).toLocaleDateString('en-GB', {
          timeZone: 'Asia/Dhaka',
          year: 'numeric',
          month: '2-digit',
          day: '2-digit',
        });
      };
    },
    formatTime() {
      return (date) => {
        return new Date(date).toLocaleTimeString('en-GB', {
          timeZone: 'Asia/Dhaka',
          hour: '2-digit',
          minute: '2-digit',
          second: '2-digit',
          hour12: true,
        });
      };
    },
  },
  methods: {
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
    },
    async fetch_reserve() {
      await axios.get("/api/reserves")
        .then((res) => {
          console.log(res)
          this.reserves = res.data
        })
        .catch((error) => {
          console.log(error.response ? error.response.data : error.message);
        })
    },
  },
  created() {
    this.fetchData();
    this.fetch_reserve();
  }

}
</script>

<style scoped>
.table_size {
  overflow: auto;
  width: 100%;
}
</style>