<template>
    <div class="container">
        <div class="invoice-card container" ref="invoice">
            <!-- <div class="invoice-header">
            <img src="./logos.png" alt="Invoice Logo" class="invoice-logo" />
          </div> -->
            <div class="invoice-subHeader d-flex justify-content-between container">
                <div class="left">
                    <h6>Invoice : <span class="invoice-number">{{ bills.bill_id }}</span></h6>
                    <h6 v-if="bills.customer">Client : <span>{{ bills.customer.customer_name }}</span></h6>
                    <h6 v-if="bills.customer">Mobile : <span>{{ bills.customer.phone }}</span></h6>
                </div>
                <div class="right">
                    <h6>Invoice Date : <span>{{ formattedDate }}</span></h6>
                    <svg id="barcode"></svg>
                </div>
            </div>

            <div class="invoice-table">
                <div class="container mt-4">
                    <table v-if="bills.cart && bills.cart.cart_items.length > 0">
                        <thead>
                            <tr>
                                <th class="col-8">Product</th>
                                <th class="col-2">Quantity</th>
                                <th class="col-2">Unit Price</th>
                                <th class="col-2">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="cartitem in bills.cart.cart_items" :key="cartitem.id">
                                <td>{{ cartitem.serial.stock.product.product_model }}</td>
                                <td>{{ cartitem.quantity }} Pc(s)</td>
                                <td>{{ cartitem.sold_price }}</td>
                                <td>{{ cartitem.sold_price * cartitem.quantity }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <p v-else>No cart items available.</p>
                    <hr />
                    <div class="invoice-main-bill">
                        <div v-for="payment in payments" :key="payment.id" class="d-flex justify-content-between w-100">
                            <div class="title">
                                <p>{{ payment.paymenttype.pt_name }}</p>
                            </div>
                            <div class="amount gap-5">
                                <p>Taka : <span>{{ payment.amount }} BDT</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="summary right col-md-6 d-flex justify-content-between w-100">
                        <div class="title">
                            <p>Total Quantity</p>
                        </div>
                        <div class="amount">
                            <p><span>{{ totalQuantity }}</span></p>
                        </div>
                    </div>
                    <div class="summary right col-md-6 d-flex justify-content-between w-100">
                        <div class="title">
                            <p>Total Price</p>
                        </div>
                        <div class="amount">
                            <p><span>Taka : {{ bills.total_price }} BDT</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="invoice-qr d-flex align-items-center justify-content-center gap-4 pt-1">
                <p class="fw-bold">Thank You For Your Purchases</p>
                <img src="/public/backend/assets/img/paid3.png" alt="QR Code" width="50px" />
            </div>

            <!-- Print Button -->
            <div class="print-button d-flex justify-content-center pt-4">
                <button @click="printInvoice" class="btn btn-primary print-button">Print Invoice</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import AppStorage from "../../Helpers/AppStorage";
import { inject } from 'vue';
import JsBarcode from 'jsbarcode';
export default {
    name: "Bill-vue",
    setup() {
        const userName = inject('userName');
        const profile_img = inject('profile_img');
        return { userName, profile_img };
    },
    data() {
        return {
            bills: {
                bill_id: "",
                customer: {
                    customer_name: "",
                    phone: "",
                },
                cart: {
                    cart_items: [],
                },
                total_price: 0,
                updated_at: "",
            },
            payments: [],
        };
    },
    methods: {
        async fetchBill() {
            const bill_id = AppStorage.getBillId();
            try {
                const res = await axios.get(`/api/bills/generate/${bill_id}`);
                this.payments = res.data.payment;
                this.bills = res.data.bill;
                this.generateBarcode();
                AppStorage.clearBillId();
                AppStorage.clearCard();
            } catch (error) {
                console.log(error);
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
                    this.users = res.data;
                    this.user_id = res.data.id;
                    this.userName = res.data.user_name;
                    this.profile_img = res.data.profile_img;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        printInvoice() {
            window.print();
            AppStorage.clearBillId();
            AppStorage.clearCard();
            this.$router.push({ name: "Home" })
        },
        generateBarcode() {
            const billId = this.bills.bill_id || 'No Bill ID';
            JsBarcode("#barcode", billId, {
                format: "CODE128",
                lineColor: "#000000",
                width: 1.5,
                height: 30,
                displayValue: false,
            });
        },
    },
    computed: {
        formattedDate() {
            if (this.bills && this.bills.updated_at) {
                const date = new Date(this.bills.updated_at);
                return date.toLocaleString("en-BD", {
                    timeZone: "Asia/Dhaka",
                    day: "2-digit",
                    month: "2-digit",
                    year: "numeric",
                    hour12: true,
                });
            }
            return "";
        },
        totalQuantity() {
            if (this.bills && this.bills.cart && this.bills.cart.cart_items) {
                return this.bills.cart.cart_items.reduce(
                    (sum, item) => sum + item.quantity,
                    0
                );
            }
            return 0;
        },
    },
    mounted() {
        this.fetchBill();
        this.fetchUsers();
    },
};
</script>

<style scoped>
/* Styling for the invoice */
.invoice-card {
    padding: 10px;
    border: 1px solid #ddd;
    margin-top: 20px;
    font-size: 15px;
    background-color: white;
}

.invoice-logo {
    width: 100px;
    height: auto;
}

.invoice-header {
    text-align: center;
    margin-bottom: 20px;
}

.invoice-subHeader {
    margin-bottom: 10px;
}

.invoice-table {
    margin-bottom: 20px;
}

.invoice-table table {
    width: 100%;
    border-collapse: collapse;
}

.invoice-table th,
.invoice-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.invoice-table th {
    background-color: #f4f4f4;
}

.invoice-qr img {
    margin-top: -25px;
    margin-left: -20px;
}

/* Print styles */
@media print {
    .print-button {
        display: none;
        /* Hide print button in print view */
    }

    .container {
        padding: 0px;
        /* Remove container padding for printing */
        margin: 50px 165px;
        /* Set margins for print view */
    }

    .invoice-card {
        margin: 0;
        /* Remove margin for print view */
        border: none;
        /* Remove border for print view */
    }

    .invoice-qr {
        margin: 50px 165px;
        display: flex;
        justify-content: space-between;
    }

    .invoice-qr p {
        font-size: 12px;
    }

    .invoice-qr img {
        width: 30px;
        margin-top: -25px;
        margin-left: -20px;
    }

    header,
    footer,
    .navbar,
    .footer {
        display: none !important;
    }
}
</style>