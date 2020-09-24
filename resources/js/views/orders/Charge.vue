<template>
  <div class="d-flex flex-column align-items-center">
    <h2 class="text-primary">{{ msg }} ${{ order.total_price }}</h2>
    <form
      id="payment-form"
      class="w-75 px-5 d-flex flex-column align-items-center"
    >
      <div ref="card" class="form-control m-2">
        <!-- A Stripe Element will be inserted here. -->
      </div>
      <input
        :disabled="lockSubmit"
        class="btn btn-primary shadow-sm"
        type="submit"
        value="Pay"
        v-on:click.prevent="purchase"
      />
    </form>
  </div>
</template>

<script>
import { loadStripe } from '@stripe/stripe-js';
import TransactionResource from '@/api/transaction';
import OrderResource from '@/api/order';

const transactionResource = new TransactionResource();
const orderResource = new OrderResource();

export default {
  data() {
    return {
      spk:
        'pk_test_51HU4o2HNCxgLnTLGUTQMrhYaWprTarTwOPsEJ8fHJNRi2cWCWa1lhU9ApVaTCLsS9xNgQdKh8aKEdfMJfW0FwDbP00OfuUUe0v',
      stripe: undefined,
      card: undefined,
      msg: 'Pay amount: ',
      payAmount: 1000,
      lockSubmit: false,
      dt: undefined,
      order: {},
    };
  },
  created() {
    const id = this.$route.params && this.$route.params.id;
    this.getOrder(id);
  },
  mounted: async function() {
    var self = this;
    self.stripe = await loadStripe(self.spk);
    self.card = self.stripe.elements().create('card');
    self.card.mount(self.$refs.card);
  },
  methods: {
    async getOrder(id) {
      const { data } = await orderResource.get(id);
      this.order = data;
      if (this.order.transaction.payment_status !== '0') {
        this.$router.replace('/orders/show/' + id);
      }
    },
    purchase() {
      var self = this;
      self.lockSubmit = true;

      self.stripe
        .createToken(self.card)
        .then(function(result) {
          if (result.error) {
            alert(result.error.message);
            self.$forceUpdate(); // Forcing the DOM to update so the Stripe Element can update.
            self.lockSubmit = false;
            return;
          } else {
            self.processTransaction(result.token.id);
          }
        })
        .catch(err => {
          alert('error: ' + err.message);
          self.lockSubmit = false;
        });
    },
    processTransaction(transactionToken) {
      var self = this;
      self.dt = {
        id: self.order.id,
        amount: parseInt(self.order.total_price), // stripe uses an int [with shifted decimal place] so we must convert our payment amount
        currency: 'USD',
        description: 'Payment for order: ' + self.order.order_code,
        token: transactionToken,
      };
      transactionResource
        .chargeCard(self.dt)
        .then(response => {
          this.$message({
            type: 'success',
            message: 'Order is paid',
          });
          this.$router.replace('/orders/show/' + self.dt.id);
          self.lockSubmit = false;
        })
        .catch(error => {
          console.log(error);
        });
    },
  },
};
</script>
