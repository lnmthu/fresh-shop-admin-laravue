<template>
  <OrderDetail v-if="!loading" :order="order" :methods="getOrder" />
</template>

<script>
import OrderResource from '@/api/order';
import OrderDetail from './components/OrderDetail';
const orderResource = new OrderResource();

export default {
  components: { OrderDetail },
  data() {
    return {
      order: {},
      loading: false,
    };
  },
  created() {
    this.loading = true;
    const id = this.$route.params && this.$route.params.id;
    this.getOrder(id);
  },
  methods: {
    async getOrder(id) {
      const { data } = await orderResource.get(id);
      this.loading = false;
      this.order = data;
    },
  },
};
</script>
