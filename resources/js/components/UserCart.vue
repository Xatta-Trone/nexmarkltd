<template>
    <div class="container">
        <div class="row">
            <div class="col-10 mx-auto table-responsive ">
                <table class="table my-2 text-center table-hover">
                    <caption>
                        Items in cart
                    </caption>
                    <thead class="thead-light text-uppercase">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(cartItems, i) in productsInCart"
                            :key="cartItems.id"
                        >
                            <th scope="row">{{ i + 1 }}</th>
                            <td>
                                <img
                                    :src="cartItems.image"
                                    :alt="cartItems.slug"
                                    height="50px"
                                    width="auto"
                                />
                            </td>
                            <td>{{ cartItems.name }}</td>
                            <td>
                                <span class="currency">
                                    ৳
                                </span>
                                {{ Number(cartItems.price).toFixed(2) }}
                            </td>
                            <td>
                                <div
                                    class="btn-group btn-group-sm"
                                    @click.prevent=""
                                    role="group"
                                    aria-label="Basic example"
                                >
                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        @click.prevent="addToCart(cartItems)"
                                    >
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                    >
                                        {{ cartItems.qty }}
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        @click.prevent="
                                            decrementProduct(cartItems)
                                        "
                                    >
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <span class="currency">
                                    ৳
                                </span>
                                {{
                                    Number(
                                        cartItems.price * cartItems.qty
                                    ).toFixed(2)
                                }}
                            </td>
                            <td>
                                <a
                                    class="text-danger"
                                    href="#"
                                    @click.prevent="deleteProduct(cartItems)"
                                >
                                    <i class="fa fa-trash-o"></i
                                ></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                class="col-12 col-md-4 offset-1 col-xs-offset-0 mt-2 offest-md-1"
            >
                <button
                    class="btn primary-btn text-uppercase"
                    @click="gotoShop"
                >
                    Continue shopping
                </button>
            </div>

            <div class="col-6">
                <table class="table table-bordered ">
                    <thead class="thead-light text-uppercase">
                        <tr class="text-center">
                            <th colspan="2" scope="col">Cart totals</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Subtotal</th>
                            <td>
                                <span class="currency"> ৳ </span
                                >{{ Number(subTotal).toFixed(2) }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Shipping Charge</th>
                            <td><span class="currency"> ৳ </span>50.00</td>
                        </tr>
                        <tr>
                            <th scope="row">Grand Total</th>
                            <td>
                                <span class="currency"> ৳ </span
                                >{{ Number(subTotal + 50).toFixed(2) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-right">
                                <button
                                    class="btn primary-btn text-uppercase"
                                    @click="gotoCheckout"
                                >
                                    proceed to Checkout
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        console.log("Component mounted.");
    },
    methods: {
        addToCart(product) {
            // console.log(product);
            // product._token = this.token;
            this.$store.dispatch("addToCart", product);
        },
        decrementProduct(product) {
            // console.log(product);
            // product._token = this.token;
            this.$store.dispatch("decrementProdcut", product);
        },
        deleteProduct(product) {
            if (confirm("are you sure!!")) {
                this.$store.dispatch("deleteProduct", product);
            }
        },
        gotoShop() {
            window.location.href = "/shop";
        },

        gotoCheckout() {
            window.location.href = "/checkout";
        }
    },
    computed: {
        productsInCart() {
            return this.$store.getters.cartItems;
        },
        subTotal() {
            return this.$store.getters.totalPrice;
        },
        computedProducts() {
            return this.products.map(product => {
                if (this.productsInCart.length) {
                    let index = null;
                    let check = this.productsInCart.some((p, i) => {
                        if (p.id === product.id) {
                            index = i;
                            return true;
                        }
                    });
                    if (check) {
                        product.incart = true;
                        product.currentqty = this.productsInCart[index].qty;
                    } else {
                        product.incart = false;
                    }
                }

                return product;
            });
        }
    }
};
</script>
