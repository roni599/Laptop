<template>
    <div class="container">
        <h2 class="text-center text-success fw-bold mt-2">
            Scan Product To Sell
        </h2>
        <div v-if="barcodeData.length" class="container">
            <div class="card rounded-lg mt-2">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="icon_text d-flex gap-2 mt-3">
                        <p><i class="fa-solid fa-chart-line"></i></p>
                        <p class="text-black font-bold">Customer Details</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" v-model="customerName" id="inputCustomerName" type="text"
                                    placeholder="Enter Customer name" />
                                <label for="inputCustomerName">Customer Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" v-model="customerPhone" id="inputCustomerPhone" type="text"
                                    placeholder="Enter Customer Phone" />
                                <label for="inputCustomerPhone">Customer Phone</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" v-model="customerAddress" id="inputCustomerAddress"
                                    type="text" placeholder="Enter Customer Address" />
                                <label for="inputCustomerAddress">Customer Address</label>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="buttonpayment d-flex justify-between">
                                <!-- Buttons for toggling inputs -->
                                <button @click="toggleInputs('bank')" class="btn btn-sm btn-success me-2">Bank</button>
                                <button @click="toggleInputs('cash')" class="btn btn-sm btn-primary me-2">Cash</button>
                                <button @click="toggleInputs('others')" class="btn btn-sm btn-danger">Others</button>

                                <!-- Bank input field with close button -->
                                <div v-if="showBankInputs" class="input-container">
                                    <div>
                                        <label for="bank-input-1 ms-1">Bank:</label>
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
                                        <label for="cash-input-1">Cash:</label>
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
                                        <label for="others-input-1">Others:</label>
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
                        <div class="col-md-6" hidden>
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" v-model="customerEmail" id="inputCustomerEmail" type="email"
                                    placeholder="Enter Customer Email" />
                                <label for="inputCustomerEmail">Customer Email</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3" hidden>
                            <div class="form-floating mb-3 mb-md-0">
                                <select class="form-select" v-model="user_id" aria-label="Default select example">
                                    <option :value="users.id">{{ users.user_name }}</option>
                                </select>
                                <label class="h6 text-black mb-0" for="inputSupplier">Login User</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- <div class="form-floating mb-3 mb-md-0">
                                <select class="form-select" aria-label="Default select example"
                                    v-model="paymenttype">
                                    <option v-for="paymenttype in paymenttypes" :key="paymenttype.id"
                                        :value="paymenttype.id">
                                        {{ paymenttype.pt_name }}
                                    </option>
                                </select>
                                <label for="inputSellingPrice">Payment Type</label>
                            </div> -->
                        </div>
                    </div>
                    <div class="row mb-3" hidden>
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" v-model="customerNid" id="inputcustomerNid" type="text"
                                    placeholder="Enter Customer NID" />
                                <label for="inputcustomerNid">Customer NID</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" v-model="customerBirthday" id="inputcustomerBirthday"
                                    type="date" placeholder="Enter Customer Birthday" />
                                <label for="inputcustomerBirthday">Customer BirthDay</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card rounded-lg mt-2">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="icon_text d-flex gap-2 mt-3">
                        <p><i class="fa-solid fa-chart-line"></i></p>
                        <p class="text-black font-bold">Sell Details</p>
                    </div>
                </div>
                <div class="card-body">
                    <div v-for="(data, index) in barcodeData" :key="data.barcode" class="row g-3 mb-3">
                        <div class="col-md-4 mb-2">
                            <div class="form-floating">
                                <input type="text" :value="data.stock.product.product_model" class="form-control"
                                    readonly />
                                <label>Model</label>
                            </div>
                        </div>

                        <div class="col-md-1 mb-2">
                            <div class="form-floating">
                                <input type="text" :value="data.color" class="form-control" readonly />
                                <label>Color</label>
                            </div>
                        </div>

                        <div class="col-md-2 mb-2">
                            <div class="form-floating">
                                <input type="text" :value="data.serial_no" class="form-control" readonly />
                                <label>Serial No</label>
                            </div>
                        </div>
                        <!-- <div class="col-md-3 mb-2">
                            <div class="form-floating">
                                <input type="text" :value="data.stock.selling_price" class="form-control" />
                                <label>Price</label>
                            </div>
                        </div> -->
                        <div class="col-md-2 mb-2">
                            <div class="form-floating">
                                <input type="text" v-model="data.stock.selling_price" @input="updateItemPrice(data)"
                                    @focus="onQuantityFocus" @blur="onQuantityBlur" class="form-control" />
                                <label>Price</label>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="form-floating">
                                <input type="text" v-model="data.quantity" @input="updateTotalPrice"
                                    class="form-control" @focus="onQuantityFocus" @blur="onQuantityBlur" />
                                <label>Quantity</label>
                            </div>
                        </div>
                        <!-- <div class="col-md-3 mb-2">
                            <div class="form-floating">
                                <input type="text" :value="data.totalPrice" class="form-control" readonly />
                                <label>Total Price</label>
                            </div>
                        </div> -->
                        <div class="col-1 mt-4 align-items-center">
                            <button type="button" class="btn btn-danger btn-sm"
                                @click="removeInputIndex(data.stock.product.id, index)">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Total Price -->
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4>Total Price: {{ totalPrice }} Taka</h4>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-primary w-100" :disabled="!barcodeData.length"
                            @click="submitSale">
                            Submit Sale
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="alert.message" :class="['alert', alert.type]" role="alert">
            {{ alert.message }}
        </div>
    </div>
</template>
<script>
import axios from "axios";
import { inject } from 'vue';
import AppStorage from "../../Helpers/AppStorage";
export default {
    data() {
        const userName = inject('userName');
        const profile_img = inject('profile_img');
        return {
            barcode: "",
            barcodeData: [],
            alert: { message: "", type: "" },
            timeout: null,
            isQuantityFocused: false,
            customerName: '',
            customerPhone: '',
            customerAddress: '',
            customerEmail: '',
            customerNid: '',
            customerBirthday: '',
            user_id: '',
            paymenttype: '',
            userName,
            profile_img,
            users: [],
            paymenttypes: [],
            selling_price: null,

            input1: '',
            input2: '',
            input3: '',
            showBankInputs: false,
            showCashInputs: false,
            showOthersInputs: false,
            bankAmount: '',
            cashAmount: '',
            othersAmount: '',
            validInputs: [],
            validInputs2: [],
            cartId: null,
        };
    },
    methods: {
        showInput(inputType) {
            this.currentInput = inputType;
        },

        handleBarcodeInput(e) {
            if (this.isQuantityFocused) return;

            clearTimeout(this.timeout);

            // Append character if it's a valid key
            if (/^[a-zA-Z0-9]$/.test(e.key)) {
                this.barcode += e.key;
            }

            // Process barcode on Enter key press
            if (e.key === "Enter") {
                if (this.barcode) {
                    this.fetchBarcodeData(this.barcode);
                    this.barcode = "";
                }
            } else {
                // Set timeout to clear the barcode if no input for a period
                this.timeout = setTimeout(() => {
                    this.barcode = "";
                }, 200); // Adjust timeout as needed
            }
        },
        fetchBarcodeData(barcode) {
            console.log('Fetching data for barcode:', barcode);

            // Prepare the request payload
            const requestPayload = { barcode, cart_id: this.cartId };

            // Make the API call
            axios.post("/api/barcode-search", requestPayload)
                .then((response) => {
                    console.log(response);

                    const cartIdFromResponse = response.data.cart_id;
                    const serialData = response.data.serial;

                    // Only store the new cart ID if it's different from the current one
                    if (cartIdFromResponse && cartIdFromResponse !== this.cartId) {
                        this.cartId = cartIdFromResponse;
                        AppStorage.storeCartId(cartIdFromResponse);
                    }

                    // Update barcode data
                    this.barcodeData.push({
                        ...serialData,
                        quantity: 1,
                        totalPrice: serialData.stock.selling_price
                    });
                })
                .catch((error) => {
                    // this.alert = {
                    //     message: error.response.data.message,
                    //     type: "alert-danger",
                    // };
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: error.response.data.message + "!",
                    });
                });
        },
        updateItemPrice(item) {
            // Find the corresponding item in barcodeData and update the price
            const foundItem = this.barcodeData.find(barcodeItem => barcodeItem === item);
            if (foundItem) {
                foundItem.totalPrice = foundItem.quantity * foundItem.stock.selling_price;
                this.updateTotalPrice(); // Recalculate total price for all items
            }
        },
        updateTotalPrice() {
            this.barcodeData.forEach(item => {
                item.totalPrice = item.quantity * item.stock.selling_price;
            });
        },
        async removeInputIndex(item_no, index) {
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
                    await axios.delete("/api/delete-saledata/" + item_no)
                        .then((res) => {
                            console.log(res)
                            this.barcodeData.splice(index, 1);
                            Swal.fire({
                                title: "Deleted!",
                                text: "Category has been deleted.",
                                icon: "success",
                            });
                        })
                        .catch((error) => {
                            console.log(error)
                        })
                }
            });
        },

        submitSale() {
            const cartId = AppStorage.getCartId();
            const inputs = [this.input1, this.input2, this.input3];
            const inputs2 = [this.bankAmount, this.cashAmount, this.othersAmount];
            this.validInputs = inputs.filter(input => input !== '' && input !== null);
            this.validInputs2 = inputs2.filter(input => input !== '' && input !== null);
            const totalsaleprice = this.barcodeData.reduce((total, item) => total + (parseFloat(item.totalPrice) || 0), 0);
            const saleData = {
                customerName: this.customerName,
                customerPhone: this.customerPhone,
                customerAddress: this.customerAddress,
                customerEmail: this.customerEmail,
                customerBirthday: this.customerBirthday,
                customerNid: this.customerNid,
                user_id: this.user_id,
                items: this.barcodeData,
                validInputs: this.validInputs,
                validInputs2: this.validInputs2,
                cartId: cartId,
                totalsaleprice: totalsaleprice.toFixed(2),
            };

            axios.post('/api/bills/store', saleData)
                .then(response => {
                    console.log(response.data);
                    this.barcodeData = [];
                    this.customerName = '';
                    this.customerPhone = '';
                    this.customerAddress = '';
                    this.customerEmail = '';
                    this.customerNid = '';
                    this.customerBirthday = '',
                        this.user_id = '',
                        this.validInputs = [],
                        this.validInputs2 = [],
                        this.bankAmount = '',
                        this.cashAmount = '',
                        this.othersAmount = '',
                        AppStorage.clearCard()
                    AppStorage.storebillId(response.data);
                    this.$router.push({ name: "Bill_print" })
                    Toast.fire({
                        icon: "success",
                        title: "Bill generate successfully"
                    });
                })
                .catch(error => {
                    this.alert = { message: error.response.data.message, type: 'alert-danger' };
                    console.error('Error submitting sale:', error);
                });
        },

        onQuantityFocus() {
            this.isQuantityFocused = true; // Set flag when quantity input is focused
        },

        onQuantityBlur() {
            this.isQuantityFocused = false; // Reset flag when quantity input loses focus
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

        toggleInputs(inputType) {
            if (inputType === 'bank') {
                this.input1 = 1;
                this.showBankInputs = true;
            } else if (inputType === 'cash') {
                this.input2 = 2;
                this.showCashInputs = true;
            } else if (inputType === 'others') {
                this.input3 = 3;
                this.showOthersInputs = true;
            }
        },

        removeInput(inputType) {
            if (inputType === 'bank') {
                this.showBankInputs = false;
                this.bankInputs[0] = '';  // Clear the input field
            } else if (inputType === 'cash') {
                this.showCashInputs = false;
                this.cashInputs[0] = '';  // Clear the input field
            } else if (inputType === 'others') {
                this.showOthersInputs = false;
                this.othersInputs[0] = '';  // Clear the input field
            }
        },
        clearCart() {
            // Clear the cart ID and local storage when you generate a bill
            this.cartId = null;
            AppStorage.clearCard(); // Ensure this function clears the local storage
        }
    },

    computed: {
        // Compute the total price of all items
        totalPrice() {
            return this.barcodeData.reduce((total, item) => total + (parseFloat(item.totalPrice) || 0), 0).toFixed(2);
        }
    },

    watch: {
        // Watch for changes in barcodeData and update the total price
        barcodeData: {
            handler() {
                this.updateTotalPrice();
            },
            deep: true
        }
    },

    mounted() {
        document.addEventListener("keydown", this.handleBarcodeInput);
    },

    beforeDestroy() {
        document.removeEventListener("keydown", this.handleBarcodeInput);
    },

    created() {
        this.fetchUsers();
        this.cartId = AppStorage.getCartId();
    }
};
</script>

<style scoped>
h2 {
    color: #333;
    margin-bottom: 20px;
}
</style>