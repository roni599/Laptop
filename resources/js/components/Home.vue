<template>
  <div class="container-fluid px-4">
    <div class="card mt-4 mb-3">
      <div class="card-header border-bottom-0 p-4">
        <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span class="text-muted h5"> /
          Overview</span>
      </div>
    </div>
    <div class="row">
      <div class="col-xl-3 col-md-6">
        <div class="card mb-3">
          <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="../../../public/backend/assets/img/laptop2.jpg" class="d-block w-100 rounded-top" alt="...">
              </div>
              <div class="carousel-item">
                <img src="../../../public/backend/assets/img/ipad1.png" class="d-block w-100 rounded-top" height="144"
                  alt="...">
              </div>
              <!-- <div class="carousel-item">
                <img src="..." class="d-block w-100" alt="...">
              </div> -->
            </div>
          </div>
          <div class="card-body rounded-bottom">
            <div id="carouselExampleCaptions2" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <h5>Laptop : {{ totalLaptop }}</h5>
                </div>
                <div class="carousel-item">
                  <h5>IPad : {{ totalIpad }}</h5>
                </div>
                <!-- <div class="carousel-item">

                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card mb-3">
          <div id="carouselExampleCaptions3" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="../../../public/backend/assets/img/laptop2.jpg" class="d-block w-100 rounded-top" alt="...">
              </div>
              <div class="carousel-item">
                <img src="../../../public/backend/assets/img/ipad1.png" class="d-block w-100 rounded-top" height="144"
                  alt="...">
              </div>
              <!-- <div class="carousel-item">
                <img src="..." class="d-block w-100" alt="...">
              </div> -->
            </div>
          </div>
          <div class="card-body rounded-bottom">
            <div id="carouselExampleCaptions4" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <h5>In : {{ totalIn }}</h5>
                </div>
                <div class="carousel-item">
                  <h5>Out : {{ totalOut }}</h5>
                </div>
                <!-- <div class="carousel-item">

                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card mb-3">
          <div id="carouselExampleCaptions5" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="../../../public/backend/assets/img/laptop2.jpg" class="d-block w-100 rounded-top" alt="...">
              </div>
              <div class="carousel-item">
                <img src="../../../public/backend/assets/img/ipad1.png" class="d-block w-100 rounded-top" height="144"
                  alt="...">
              </div>
              <!-- <div class="carousel-item">
                <img src="..." class="d-block w-100" alt="...">
              </div> -->
            </div>
          </div>
          <div class="card-body rounded-bottom">
            <div id="carouselExampleCaptions6" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <h5>In : {{ totalIn }}</h5>
                </div>
                <div class="carousel-item">
                  <h5>Out : {{ totalOut }}</h5>
                </div>
                <!-- <div class="carousel-item">

                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card mb-3">
          <div id="carouselExampleCaptions3" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="../../../public/backend/assets/img/laptop2.jpg" class="d-block w-100 rounded-top" alt="...">
              </div>
              <div class="carousel-item">
                <img src="../../../public/backend/assets/img/ipad1.png" class="d-block w-100 rounded-top" height="144"
                  alt="...">
              </div>
              <!-- <div class="carousel-item">
                <img src="..." class="d-block w-100" alt="...">
              </div> -->
            </div>
          </div>
          <div class="card-body rounded-bottom">
            <div id="carouselExampleCaptions4" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <h5>In : {{ totalIn }}</h5>
                </div>
                <div class="carousel-item">
                  <h5>Out : {{ totalOut }}</h5>
                </div>
                <!-- <div class="carousel-item">

                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    InVestment Amount {{ investmentTotalAmount }} <br>
    Total In {{ totalIn }} +Total Out {{ totalOut }} = {{ balance }} Balance <br>
    Net Balance {{ netbalance }}
    <br><br><br>
    TodaysSells {{ todaysBills }} Item Products <br>
    yesterdaysBills {{ yesterdaysBills }} Item Products
    <div class="card mb-4 tt">
      <div class="card-header d-flex justify-content-between">
        <div class="employee_table fw-bold text-muted">
          <i class="fas fa-table me-1"></i>
          Stocks List
        </div>
      </div>
      <div class="card-body">
        <input type="text" id="searchInput" v-model="searchProducts" @input="handleSearchInput"
          placeholder="Search for Product Name..." />

        <div class="table_size">
          <table class="table text-muted table-striped table-bordered">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">Product Quantity</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(product, index) in paginatedFilteredProducts" :key="product.id">
                <td>{{ index + 1 + (currentPage - 1) * perPage }}</td>
                <td>{{ product.name }}</td>
                <td>{{ product.quantity }}</td>
                <td>
                  <span v-if="product.quantity > 0" class="badge bg-success">Available</span>
                  <span v-else class="badge bg-danger">Out Of Stock</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="page d-flex justify-around align-items-center w-100">
          <div class="text-muted mb-2 w-50">
            Showing {{ startEntry }} to {{ endEntry }} of {{ filteredTotalEntries }} entries
          </div>
          <div class="pagination_link mt-2 w-50 d-flex justify-content-end">
            <nav>
              <ul class="pagination justify-content-center">
                <li class="page-item" :class="{ disabled: currentPage === 1 }">
                  <a class="page-link" href="#" @click.prevent="goToPage(currentPage - 1)">
                    <i class="fas fa-angle-left"></i>
                  </a>
                </li>
                <li class="page-item" v-for="page in totalFilteredPages" :key="page"
                  :class="{ active: currentPage === page }">
                  <a class="page-link" href="#" @click.prevent="goToPage(page)">{{ page }}</a>
                </li>
                <li class="page-item" :class="{ disabled: currentPage === totalFilteredPages }">
                  <a class="page-link" href="#" @click.prevent="goToPage(currentPage + 1)">
                    <i class="fas fa-angle-right"></i>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { inject } from 'vue';
import AppStorage from '../Helpers/AppStorage';
import axios from 'axios';
export default {
  name: "Home-vue",
  data() {
    const userName = inject('userName');
    const profile_img = inject('profile_img');
    return {
      userName,
      profile_img,
      products: [],
      currentPage: 1,
      perPage: 10,
      searchProducts: '',
      totalProduct: 0,
      totalLaptop: 0,
      totalIpad: 0,
      totalIn: 0,
      totalOut: 0,
      balance: 0,
      netbalance: 0,
      investmentTotalAmount: 0,
      todaysBills:0,
      yesterdaysBills:0
    };
  },
  computed: {
    filteredProducts() {
      return this.products.filter((product) => {
        return product.name.toLowerCase().includes(this.searchProducts.toLowerCase());
      });
    },
    paginatedFilteredProducts() {
      let start = (this.currentPage - 1) * this.perPage;
      let end = start + this.perPage;
      return this.filteredProducts.slice(start, end);
    },
    filteredTotalEntries() {
      return this.filteredProducts.length;
    },
    totalFilteredPages() {
      return Math.ceil(this.filteredProducts.length / this.perPage);
    },
    startEntry() {
      return (this.currentPage - 1) * this.perPage + 1;
    },
    endEntry() {
      const end = this.currentPage * this.perPage;
      return end > this.filteredTotalEntries ? this.filteredTotalEntries : end;
    }
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
          this.userName = res.data.user_name;
          this.profile_img = res.data.profile_img
          this.users = res.data
        })
        .catch((error) => {
          console.log(error);
        });
    },
    goToPage(page) {
      if (page > 0 && page <= this.totalFilteredPages) {
        this.currentPage = page;
      }
    },
    handleSearchInput() {
      if (this.searchProducts !== '') {
        this.currentPage = 1;
      }
    },
    handleSearchInput() {
      if (this.searchProducts !== '') {
        this.currentPage = 1;
      }
    },
    fetchProduct() {
      axios.get('/api/product/calculate')
        .then((res) => {
          this.products = res.data.products;
          this.totalProduct = res.data.total_products;
          this.totalLaptop = res.data.total_laptop;
          this.totalIpad = res.data.ipadQuantity;
          this.totalIn = res.data.total_in;
          this.totalOut = res.data.total_out;
          this.balance = res.data.balance;
          this.investmentTotalAmount = res.data.investmentTotalAmount
          this.netbalance = res.data.netbalance,
          this.todaysBills=res.data.todaysBills,
          this.yesterdaysBills=res.data.yesterdaysBills
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    AppStorage.clearBillId();
    AppStorage.clearCard();
    if (!User.loggedIn()) {
      this.$router.push({ name: "LoginForm" });
    }
    else {
      this.$router.push({ name: "Home" })
    }
  },
  created() {
    this.fetchData()
    this.fetchProduct()
  }
};
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

.table_size {
  width: 100%;
  overflow: auto;
}
</style>