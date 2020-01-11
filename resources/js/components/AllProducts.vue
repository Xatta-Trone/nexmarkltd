<template>
    <div class="row pt-5">
        <div class="col-xl-3 col-lg-4 col-md-5 ">
            <div class="sidebar-categories">
                <input
                    type="text"
                    class="form-control my-2"
                    placeholder="search here"
                    v-model="queryString"
                    @keyup="getProductsByQuery"
                    @submit="getProductsByQuery"
                />
                <div class="head">Categories</div>

                <ul class="main-categories">
                    <li
                        class="main-nav-list"
                        :class="{ active: active_el == '' }"
                    >
                        <a href="#" @click.prevent="allProducts">
                            <span class="lnr lnr-arrow-right"></span>
                            All products
                        </a>
                    </li>

                    <li
                        class="main-nav-list"
                        v-for="category in categories"
                        :key="category.id"
                        :class="{ active: active_el == category.slug }"
                    >
                        <a
                            data-toggle="collapse"
                            :href="returnHref(category.slug)"
                            aria-expanded="false"
                            :aria-controls="category.slug"
                            @click="getProductsByCategory(category.slug)"
                        >
                            <span class="lnr lnr-arrow-right"></span>
                            {{ category.name }}
                        </a>
                        <ul
                            class="collapse"
                            :id="category.slug"
                            data-toggle="collapse"
                            aria-expanded="false"
                            :aria-controls="returnHref(category.slug)"
                        >
                            <li
                                class="main-nav-list child"
                                :class="{ active: active_el == children.slug }"
                                :key="children.slug"
                                v-for="children in category.children"
                            >
                                <a
                                    @click="
                                        getProductsByCategory(children.slug)
                                    "
                                    :href="returnHref(children.slug)"
                                    >{{ children.name }}</a
                                >
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-xl-9 col-lg-8 col-md-7">
            <div class="row">
                <div class="col-12">
                    <div
                        class="filter-bar py-3 d-flex flex-wrap align-items-center text-white"
                    >
                        Showing results for
                        <strong class="text-white ml-1">
                            {{ this.queryString }}
                            {{ this.filterCategory }}
                            {{
                                this.queryString || this.filterCategory
                                    ? ""
                                    : "all products"
                            }}
                        </strong>
                    </div>
                </div>
                <div
                    class="col-12 text-center py-3"
                    v-if="products.length == 0"
                >
                    <h4>No product found</h4>
                </div>

                <div
                    class="col-lg-4 col-md-6"
                    v-for="product in computedProducts"
                    :key="product.id"
                >
                    <div class="single-product">
                        <v-lazy-image :src="product.image" />
                        <!-- <img
                    class="img-fluid"
                    :src="product.image"
                    :alt="product.title"
                    height="200px"
                    width="auto"
                /> -->
                        <div class="product-details">
                            <h6>{{ product.name }}</h6>
                            <div class="price">
                                <span class="currency">
                                    ৳
                                </span>

                                <h6>{{ Number(product.price).toFixed(2) }}</h6>
                                <p>{{ product.incart }}</p>
                            </div>
                            <div class="prd-bottom">
                                <div class="row text-center">
                                    <div class="col-6">
                                        <a
                                            href="#"
                                            class="product-cart-btn mx-auto"
                                            @click.prevent="addToCart(product)"
                                            v-if="!product.incart"
                                            >Add to cart</a
                                        >
                                        <!-- <div
                                            class="btn-group btn-group-sm"
                                            @click.prevent=""
                                            v-if="product.incart"
                                            role="group"
                                            aria-label="Basic example"
                                        >
                                            <button
                                                type="button"
                                                class="btn btn-secondary"
                                                @click.prevent="
                                                    addToCart(product)
                                                "
                                            >
                                                <i class="fa fa-plus"></i>
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-secondary"
                                            >
                                                {{ product.currentqty || 0 }} in
                                                bag
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-secondary"
                                                @click.prevent="
                                                    addToCart(product)
                                                "
                                            >
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div> -->
                                        <a
                                            href="#"
                                            class="product-cart-btn remove mx-auto"
                                            @click="viewCart"
                                            v-if="product.incart"
                                            >view cart</a
                                        >
                                    </div>
                                    <!-- <div class="col-6">
                                        <a
                                            href="#"
                                            class="product-cart-btn mx-auto "
                                            @click.prevent="addToCart(product)"
                                            v-if="!product.incart"
                                            >Add to store</a
                                        >
                                        <a
                                            href="#"
                                            class="product-cart-btn mx-auto  remove"
                                            @click.prevent=""
                                            v-if="product.incart"
                                            >view store</a
                                        >
                                    </div> -->
                                </div>

                                <!-- <a
                                    @click.prevent="addToCart(product)"
                                    href="#"
                                    class="social-info"
                                    v-if="!product.incart"
                                >
                                    <span class="ti-bag"></span>
                                    <span class="fa fa-shopping-basket"></span>
                                    <p class="hover-text">add to cart</p>
                                </a> -->

                                <!-- <a
                                    @click.prevent="addToCart(product)"
                                    href="#"
                                    class="social-info"
                                    v-if="product.incart"
                                >
                                    <span class="ti-bag"></span>
                                    <span class="fa fa-times"></span>
                                    <p class="hover-text">remove from cart</p>
                                </a> -->
                                <!-- <a href="" class="social-info">
                                   <span class="lnr lnr-heart"></span> 
                                    <span class="fa fa-heart-o"></span>
                                    <p class="hover-text">Favorite</p>
                                </a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <infinite-loading @infinite="infiniteHandler" spinner="spiral">
                <div slot="no-more">No more products found</div>
                <div slot="no-results">No results message</div>
            </infinite-loading>
        </div>
    </div>
</template>

<script>
import VLazyImage from "v-lazy-image";
import InfiniteLoading from "vue-infinite-loading";
export default {
    data() {
        return {
            active_el: "",
            products: [],
            tmpproducts: [],
            nextpage: {
                general: 1,
                category: 1,
                query: 1
            },
            queryType: "general",
            queryString: "",
            filterCategory: "",
            categories: []
        };
    },
    computed: {
        productsInCart() {
            return this.$store.getters.cartItems;
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
    },
    // props: ["token"],
    created: function() {
        this.getCategories();
    },
    components: {
        VLazyImage,
        InfiniteLoading
    },
    mounted() {
        console.log("Component mounted.");
        // this.fetchProducts();
    },
    methods: {
        getCategories() {
            axios.get("/api/categories").then(res => {
                // console.log(res.data.data);
                this.categories = res.data.data;
            });
        },
        increment() {
            this.$store.commit("increment");
        },
        decrement() {
            this.$store.commit("decrement");
        },
        allProducts() {
            this.active_el = "";
            this.queryType = "general";
            this.products = this.tmpproducts;
            this.queryString = "";
            this.filterCategory = "";
        },
        currentUrl() {
            var currentUrl = window.location.href;
            console.log(currentUrl);
        },

        returnHref(slug) {
            return "#" + slug;
        },
        fetchProducts() {
            axios.get("/api/products").then(data => {
                // console.log(data);
                this.products = data.data.data;
                this.tmpproducts = data.data.data;
            });
        },
        infiniteHandler($state) {
            // console.log("handles");

            if (this.queryType == "general") {
                axios
                    .get(
                        `/api/products?page=${this.nextpage.general}&cat=${this.filterCategory}&query=${this.queryString}`
                    )
                    .then(data => {
                        // console.log(data.status);
                        if (data.status != 200) {
                            return alert("there is an error");
                        }
                        let products = data.data.data;
                        this.nextpage.general++;
                        // console.log(products);

                        if (products.length > 0) {
                            this.products.push(...products);
                            this.tmpproducts.push(...products);

                            $state.loaded();
                        } else {
                            $state.complete();
                        }
                    });
            }

            if (this.queryType == "category") {
                axios
                    .get(
                        `/api/products?page=${this.nextpage.category}&cat=${this.filterCategory}`
                    )
                    .then(data => {
                        // console.log(data.status);
                        if (data.status != 200) {
                            return alert("there is an error");
                        }
                        let products = data.data.data;
                        this.nextpage.category++;
                        // console.log(products);

                        if (products.length > 0) {
                            this.products.push(...products);
                            $state.loaded();
                        } else {
                            $state.complete();
                        }
                    });
            }

            if (this.queryType == "query") {
                axios
                    .get(
                        `/api/products?page=${this.nextpage.query}&query=${this.queryString}`
                    )
                    .then(data => {
                        // console.log(data.status);
                        if (data.status != 200) {
                            return alert("there is an error");
                        }
                        let products = data.data.data;
                        this.nextpage.query++;
                        // console.log(products);

                        if (products.length > 0) {
                            this.products.push(...products);
                            $state.loaded();
                        } else {
                            $state.complete();
                        }
                    });
            }
        },

        getProductsByCategory(cat) {
            this.filterCategory = cat;
            this.active_el = cat;
            this.queryString = "";
            this.queryType = "category";
            axios.get(`/api/products?cat=${cat}`).then(data => {
                // console.log(data);
                this.products = data.data.data;
                this.products.length > 0
                    ? (this.nextpage.category = 2)
                    : (this.nextpage.category = 1);
                // this.tmpproducts = data.data.data;
            });
        },
        getProductsByQuery() {
            this.active_el = "";
            if (this.queryString == "") {
                this.queryType = "general";
                return (this.products = this.tmpproducts);
            }
            this.queryType = "query";
            this.filterCategory = "";
            axios.get(`/api/products?query=${this.queryString}`).then(data => {
                // console.log(data);
                this.products = data.data.data;
                this.products.length > 0
                    ? (this.nextpage.query = 2)
                    : (this.nextpage.query = 1);

                // this.tmpproducts = data.data.data;
            });
        },
        addToCart(product) {
            // console.log(product);
            // product._token = this.token;
            console.log(this.products.indexOf(product));
            let index = this.products.indexOf(product);
            console.log(this.products[index]);

            this.products[index].currentqty++;
            console.log(this.products[index]);
            this.$store.dispatch("addToCart", product);
        },
        viewCart() {
            window.location.href = "/cart";
        }
    },
    watch: {
        currentUrl(neww, old) {
            console.log(neww, old);
            this.currentUrl();
        }
    }
};
</script>
<style scoped>
.v-lazy-image {
    filter: blur(10px);
    transition: filter 0.3s;
    height: 200px;
    width: auto;
}
.v-lazy-image-loaded {
    filter: blur(0);
}

.sidebar-categories .head,
.filter-bar {
    background: #ff8b00;
}

.img-fluid {
    height: 200px;
}

.single-product .product-details h6 {
    text-transform: none;
}

.single-product img {
    width: auto;
    margin-bottom: 0;
}

.product-details {
    text-align: left;
}

.single-product {
    text-align: center;
    /* box-shadow: 0px 0px 10px #eee; */
}

.product-details {
    padding: 10px 10px 5px;
}
.main-nav-list.active > a,
.main-nav-list.child.active > a {
    color: #ffba00;
}
.product-cart-btn {
    background: #ffa502;
    color: #fff;
    text-transform: uppercase;
    padding: 5px 8px;
    font-size: 12px;
    outline: 1px solid #ffa502;
    outline-offset: 2px;
}

.product-cart-btn:hover {
    color: #fff;
}

.product-cart-btn.remove {
    background: #c0392b;
    outline: 1px solid #c0392b;
}
</style>
