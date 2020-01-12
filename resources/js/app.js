/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);
Vue.component("all-products", require("./components/AllProducts.vue").default);
Vue.component("cart-label", require("./components/CartLabel.vue").default);
Vue.component("user-cart", require("./components/UserCart.vue").default);
Vue.component(
    "order-component",
    require("./components/OrderComponent.vue").default
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Vuex from "vuex";
Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        count: 0,
        cart: []
    },
    getters: {
        cartItems: state => {
            return state.cart;
        },
        totalCartItem: state => {
            return state.cart.length;
        },
        totalPrice: state => {
            let total = 0;
            // state.cart.
            for (var i = 0; i < state.cart.length; i++) {
                total += state.cart[i].price * state.cart[i].qty;
            }

            return total;
        }
    },
    actions: {
        addToCart({ commit, state }, products) {
            // console.log(products);
            commit("addToCart", products);
        },
        getCartItems({ commit, state }) {
            // console.log(products);
            commit("getCartItems");
        },
        decrementProdcut({ commit, state }, products) {
            // console.log(products);
            commit("decrementProdcut", products);
        },
        deleteProduct({ commit, state }, products) {
            // console.log(products);
            commit("deleteProduct", products);
        }
    },
    mutations: {
        increment: state => state.count++,
        decrement: state => state.count--,
        getCartItems: state => {
            axios.get("/currentitem").then(res => {
                state.cart = res.data;
                // console.log(res.data);
            });
        },

        addToCart: (state, payload) => {
            // console.log(payload);
            let currentCart = state.cart;
            let index = null;

            const found = currentCart.some((el, i) => {
                if (el.id === payload.id) {
                    index = i;
                }
                return el.id === payload.id;
            });

            if (found) {
                state.cart[index].qty++;
                // console.log(found, index);
                axios
                    .post("/carts/addnew", state.cart[index])
                    .then(function(response) {
                        // console.log(response);
                    })
                    .catch(function(error) {
                        alert("there was an error adding to cart");
                        console.log(error);
                    });
            } else {
                let newItem = payload;
                newItem.qty = 1;
                state.cart.push(newItem);

                axios
                    .post("/carts/addnew", newItem)
                    .then(function(response) {
                        // console.log(response);
                    })
                    .catch(function(error) {
                        alert("there was an error updating cart");
                        console.log(error);
                    });
            }

            console.log(currentCart, found);
            console.log(state.cart);
        },
        decrementProdcut: (state, payload) => {
            // console.log(payload);
            let currentCart = state.cart;
            let index = null;

            const found = currentCart.some((el, i) => {
                if (el.id === payload.id) {
                    index = i;
                }
                return el.id === payload.id;
            });

            if (found) {
                if (state.cart[index].qty == 1) {
                    return;
                }
                state.cart[index].qty--;
                // console.log(found, index);
                axios
                    .post("/carts/addnew", state.cart[index])
                    .then(function(response) {
                        // console.log(response);
                    })
                    .catch(function(error) {
                        alert("there was an error updating cart");
                        console.log(error);
                    });
            } else {
                let newItem = payload;
                newItem.qty = 1;
                state.cart.push(newItem);

                axios
                    .post("/carts/addnew", newItem)
                    .then(function(response) {
                        // console.log(response);
                    })
                    .catch(function(error) {
                        alert("there was an error updating cart");
                        console.log(error);
                    });
            }

            // console.log(currentCart, found);
            // console.log(state.cart);
        },
        deleteProduct: (state, payload) => {
            let currentCart = state.cart;
            let index = null;

            const found = currentCart.some((el, i) => {
                if (el.id === payload.id) {
                    index = i;
                }
                return el.id === payload.id;
            });

            // console.log(currentCart[index]);
            if (found) {
                axios
                    .post("/carts/delete", state.cart[index])
                    .then(function(response) {
                        console.log(response);
                        if (response.data == 1) {
                            state.cart.splice(index, 1);
                        } else {
                            alert("product not in cart");
                        }
                    })
                    .catch(function(error) {
                        alert("there was an error updating cart");
                        console.log(error);
                    });
            }
        }
    }
});
store.dispatch("getCartItems");
const app = new Vue({
    el: "#app",
    store
});
