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
        <div class="card  mb-3">
          <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <!-- Loop through a fixed number (5) for the same image -->
              <div class="carousel-item" :class="{ active: index === 0 }" v-for="(product, index) in products"
                :key="index">
                <img :src="imageSrc" class="d-block w-100 rounded-top" alt="Laptop" />
              </div>
            </div>
            <!-- Carousel controls -->
          </div>
          <div class="card-body rounded-bottom">
            <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item" :class="{ active: index === 0 }" v-for="(product, index) in products"
                  :key="index">
                  <p class="mt-4">
                    <span class="h6">Total {{ product.category.cat_name }}</span> :
                    <span class="h6 fs-5">{{ product.total_quantity }}</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="card mb-3">
          <div id="carouselExample1" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <!-- Loop through a fixed number (5) for the same image -->
              <div class="carousel-item" :class="{ active: index === 0 }" v-for="(product, index) in products"
                :key="index">
                <img :src="imageSrc" class="d-block w-100 rounded-top" alt="Laptop" />
              </div>
            </div>
            <!-- Carousel controls -->
          </div>
          <div class="card-body rounded-bottom">
            <div id="carouselExample2" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item" :class="{ active: index === 0 }" v-for="(product, index) in brandProducts"
                  :key="index">
                  <p class="mt-4">
                    <span class="h6">{{ product.brand.brand_name }} {{ product.category.cat_name }}</span> :
                    <span class="h6 fs-5">{{ product.total_quantity }}</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="card">
          <div id="carouselExample32" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <!-- Loop through a fixed number (5) for the same image -->
              <div class="carousel-item" :class="{ active: index === 0 }" v-for="(product, index) in products"
                :key="index">
                <img :src="imageSrc" class="d-block w-100 rounded-top" alt="Laptop" />
              </div>
            </div>
            <!-- Carousel controls -->
          </div>
          <div class="card-body rounded-bottom">
            <div id="carouselExample35" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item" :class="{ active: index === 0 }" v-for="(product, index) in brandProducts"
                  :key="index">
                  <p class="mt-2">
                    <span class="h6">
                      Todays Sales : {{ todaysBills || 0 }} <br>
                      Todays Profit : {{ todaysProfit || 0 }}
                    </span>
                  </p>
                </div>
                <!-- <div class="carousel-item active">
                 
                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="card mb-3">
          <div id="carouselExampl5" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <!-- Loop through a fixed number (5) for the same image -->
              <div class="carousel-item" :class="{ active: index === 0 }" v-for="(product, index) in products"
                :key="index">
                <img :src="imageSrc" class="d-block w-100 rounded-top" alt="Laptop" />
              </div>
            </div>
            <!-- Carousel controls -->
          </div>
          <div class="card-body rounded-bottom">
            <div id="carouselExample6" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item" :class="{ active: index === 0 }" v-for="(product, index) in brandProducts"
                  :key="index">
                  <span class="h6">
                    This Month Cost : {{ currentMonthCost || 0 }}<br>
                    This Month Profit : {{ thisMonthProfit || 0 }}<br>
                    <span v-if="thisMonthCostProfit < 0">
                      You need to sell more : {{ thisMonthCostProfit || 0 }}
                    </span>
                    <span v-else>
                      You are profitable : {{ thisMonthCostProfit || 0 }}
                    </span>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-xl-3 col-md-6">
        <div class="card mb-">
          <div id="carouselExample3" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <!-- Loop through a fixed number (5) for the same image -->
              <!-- <div class="carousel-item" :class="{ active: index === 0 }" v-for="(product, index) in products"
                :key="index">
                <img :src="imageSrc" class="d-block w-100 rounded-top" alt="Laptop" />
              </div> -->
            </div>
            <!-- Carousel controls -->
          </div>
          <div class="card-body rounded">
            <div id="carouselExample4" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <p class=""><span>Today Bank In : {{ insums.Bank }} <br>
                      Today Cash In : {{ insums.Cash || 0 }} <br>
                      Today Others In : {{ insums.Others || 0 }}</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card mb-">
          <div id="carouselExample3" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <!-- Loop through a fixed number (5) for the same image -->
              <!-- <div class="carousel-item" :class="{ active: index === 0 }" v-for="(product, index) in products"
                :key="index">
                <img :src="imageSrc" class="d-block w-100 rounded-top" alt="Laptop" />
              </div> -->
            </div>
            <!-- Carousel controls -->
          </div>
          <div class="card-body rounded-bottom">
            <div id="carouselExample4" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <p><span>Today Bank out : {{ outsums.Bank || 0 }} <br>
                      Today Cash out : {{ outsums.Cash || 0 }} <br>
                      Today Others out : {{ outsums.Others || 0 }}</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card mb-">
          <div id="carouselExample3" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <!-- Loop through a fixed number (5) for the same image -->
              <!-- <div class="carousel-item" :class="{ active: index === 0 }" v-for="(product, index) in products"
                :key="index">
                <img :src="imageSrc" class="d-block w-100 rounded-top" alt="Laptop" />
              </div> -->
            </div>
            <!-- Carousel controls -->
          </div>
          <div class="card-body rounded-bottom">
            <div id="carouselExample4" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <p><span>Today Net Bank Volume : {{ differences.Bank || 0 }} <br>
                      Today Net Cash Volume : {{ differences.Cash || 0 }} <br>
                      Today Net Others Volume : {{ differences.Others || 0 }}</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="card mb-">
          <div id="carouselExample3" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <!-- Loop through a fixed number (5) for the same image -->
              <!-- <div class="carousel-item" :class="{ active: index === 0 }" v-for="(product, index) in products"
                :key="index">
                <img :src="imageSrc" class="d-block w-100 rounded-top" alt="Laptop" />
              </div> -->
            </div>
            <!-- Carousel controls -->
          </div>
          <div class="card-body rounded-bottom">
            <div id="carouselExample4" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <p><span>Today total in : {{ totalin || 0 }} <br>
                      Today total out : {{ totalout || 0 }} <br>
                      Today total difference : {{ totaldifference || 0 }}</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="chart row">
      <div class="col-md-6">
        <ColumnChart :labels="monthlyLabels" :data="monthlyData" />
      </div>
      <div class="col-md-6">
        <MonthlyprofitChart :labels="monthlyProfitLabels" :data="monthlyProfitData" />
      </div>
    </div>
    <div class="row chart">

    </div>
  </div>
</template>

<script>
import ColumnChart from './auth/ColumnChart.vue';
import MonthlyprofitChart from './auth/MonthlyprofitChart.vue';
import { inject } from 'vue';
import AppStorage from '../Helpers/AppStorage';
import axios from 'axios';
export default {
  name: "Home-vue",
  components: {
    ColumnChart,
    MonthlyprofitChart
  },
  data() {
    const userName = inject('userName');
    const profile_img = inject('profile_img');
    return {
      userName,
      profile_img,
      products: [],
      brandProducts: [],
      todaysProfit: 0,
      todaysBills: 0,
      insums: [],
      outsums: [],
      differences: [],
      totaldifference: null,
      totalin: null,
      totalout: null,
      thisMonthCostProfit: 0,
      currentMonthCost: 0,
      thisMonthProfit: 0,
      imageSrc: '/backend/assets/img/laptop2.jpg',
      monthlyLabels: [], // For monthly labels
      monthlyData: [],   // For monthly data
      monthlyProfitLabels: [], // For monthly labels
      monthlyProfitData: [],   // For monthly data
    };
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
    fetchProduct() {
      axios.get('/api/product/calculate')
        .then((res) => {
          this.products = res.data.categories
          this.brandProducts = res.data.products
          this.todaysBills = res.data.todaysBills
          this.todaysProfit = res.data.todaysProfit
          this.insums = res.data.insums
          this.outsums = res.data.outsums
          this.differences = res.data.differences
          this.totalin = res.data.totalin
          this.totalout = res.data.totalout
          this.totaldifference = res.data.totaldifference
          this.thisMonthCostProfit = res.data.thisMonthCostProfit
          this.thisMonthProfit = res.data.thisMonthProfit
          this.currentMonthCost = res.data.currentMonthCost

          this.monthlyLabels = res.data.monthlyData.map(item => item.month_name);
          this.monthlyData = res.data.monthlyData.map(item => item.bill_count);

          this.monthlyProfitLabels = res.data.responsedatatotal.map(item => item.month_name);
          this.monthlyProfitData = res.data.responsedatatotal.map(item => item.net_profit);
          console.log(res.data.responsedatatotal)
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