<template>
    <div>
        <div id="accordion">
            <div class="card" v-for="order in orders" :key="order.id">
                <div class="card-header" :id="getIdString(order.id)">
                    <h5 class="mb-0">
                        <button
                            class="btn btn-link"
                            data-toggle="collapse"
                            :data-target="getcollapse(order.id, true)"
                            aria-expanded="false"
                            :aria-controls="getcollapse(order.id)"
                        >
                            Order NMS{{ String("00000" + order.id).slice(-5) }}
                            <span class="badge badge-pill badge-light">
                                ৳ {{ Number(order.total_amount).toFixed(2) }}
                            </span>
                            <span v-html="orderLabel(order.status)"></span>
                        </button>
                    </h5>
                </div>

                <div
                    :id="getcollapse(order.id)"
                    class="collapse"
                    :aria-labelledby="getIdString(order.id)"
                    data-parent="#accordion"
                >
                    <div class="card-body">
                        <p>
                            <strong>Name:</strong>
                            {{ order.name }}
                        </p>
                        <p>
                            <strong>Phone:</strong>
                            {{ order.phone }}
                        </p>
                        <p>
                            <strong>Address:</strong>
                            {{ order.shipping_address }}
                        </p>

                        <ul class="list-group">
                            <li class="list-group-item active">
                                Items
                            </li>
                            <li
                                class="list-group-item"
                                v-for="(item, i) in order.items"
                                :key="i"
                            >
                                {{ JSON.parse(item).name }}
                                <strong>Qty:</strong>
                                {{ JSON.parse(item).qty }}
                                <strong>Price:</strong>
                                {{ Number(JSON.parse(item).price).toFixed(2) }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <infinite-loading @infinite="infiniteHandler" spinner="spiral">
            <div slot="no-more">No more orders found</div>
            <div slot="no-results">No results message</div>
        </infinite-loading>
    </div>
</template>

<script>
import InfiniteLoading from "vue-infinite-loading";

export default {
    data() {
        return {
            orders: [],
            page: 1
        };
    },
    components: {
        InfiniteLoading
    },
    mounted() {
        // this.getOrders();
    },
    methods: {
        getIdString(id) {
            return "id_" + id;
        },

        getcollapse(id, hash = false) {
            return hash ? "#collapse_" + id : "collapse_" + id;
        },
        getOrders() {
            axios.get("/orders/currentuser").then(res => {
                this.orders = res.data.data;
                console.log(res.data);
            });
        },
        infiniteHandler($state) {
            axios.get(`/orders/currentuser?page=${this.page}`).then(res => {
                let orders = res.data.data;

                if (orders.length > 0) {
                    this.page++;
                    this.orders.push(...orders);
                    $state.loaded();
                } else {
                    $state.complete();
                }
            });
        },
        orderLabel(orderstatus) {
            switch (orderstatus) {
                case "pending":
                    return `<span class="badge badge-pill badge-warning">
                            Pending
                        </span>`;
                    break;
                case "pending_payment":
                    return `<span class="badge badge-pill badge-info">
                            Pending Payment
                        </span>`;
                    break;
                case "pending_verification":
                    return `<span class="badge badge-pill badge-info">
                            Pending Payment verification
                        </span>`;
                    break;
                case "paid":
                    return `<span class="badge badge-pill badge-success">
                            Paid
                        </span>`;
                    break;
                case "cancelled":
                    return `<span class="badge badge-pill badge-danger">
                            Cancelled
                        </span>`;
                    break;
                case "delivered":
                    return `<span class="badge badge-pill badge-success">
                            Delivered
                        </span>`;
                    break;
                default:
                    return `<span class="badge badge-pill badge-dark">
                            Pending
                        </span>`;
                    break;
            }
        }
    }
};
</script>
