<template>
  <OrderDetail :order="order" :methods="getOrder" />
</template>

<script>
import OrderResource from '@/api/order';
import OrderDetail from './components/OrderDetail';
const ordersResource = new OrderResource();

export default {
  components: { OrderDetail },
  data() {
    return {
      order: {},
    };
  },
  created() {
    const id = this.$route.params && this.$route.params.id;
    this.getOrder(id);
  },
  methods: {
    async getOrder(id) {
      const { data } = await ordersResource.get(id);
      this.order = data;
    },
  },
};
</script>
