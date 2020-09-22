<template>
  <div class="createPost-container">
    <el-form ref="order" :model="order" class="form-container">
      <sticky :class-name="'sub-navbar ' + order.status">
        <el-tag v-if="order.status == 0" :type="order.status | statusFilter">
          pending
        </el-tag>
        <el-tag v-if="order.status == 1" :type="order.status | statusFilter">
          completed
        </el-tag>
        <el-tag v-if="order.status == 2" :type="order.status | statusFilter">
          canceled
        </el-tag>
        <el-tag v-if="order.status == 3" :type="order.status | statusFilter">
          confirmed
        </el-tag>
        <el-button
          v-if="order.status == 0"
          v-permission="['manage order']"
          type="primary"
          @click="processOrder(order.id, order.order_code, 3)"
        >
          Confirm
        </el-button>
        <el-button
          v-if="order.status == 3"
          v-permission="['manage order']"
          type="success"
          @click="processOrder(order.id, order.order_code, 1)"
        >
          Complete
        </el-button>
        <el-button
          v-if="order.status != 2 && order.status != 1"
          v-permission="['manage order']"
          type="danger"
          @click="processOrder(order.id, order.order_code, 2)"
        >
          Cancel
        </el-button>
      </sticky>

      <div class="createPost-main-container">
        <el-row>
          <el-col :span="24">
            <el-form-item style="margin-bottom: 40px;">
              <MDinput
                v-model="order.order_code"
                :maxlength="100"
                name="name"
                required
                readonly
              >
                Order Code
              </MDinput>
            </el-form-item>

            <div class="postInfo-container">
              <el-row>
                <el-col :span="8">
                  <el-form-item
                    label-width="80px"
                    label="Customer:"
                    class="postInfo-container-item"
                  >
                    <el-input
                      v-model="order.user.full_name"
                      filterable
                      remote
                      readonly
                      placeholder="Buyer"
                    />
                  </el-form-item>
                </el-col>

                <el-col :span="10">
                  <el-form-item
                    label-width="130px"
                    label="Customer email:"
                    class="postInfo-container-item"
                  >
                    <el-input
                      v-model="order.user.email"
                      filterable
                      remote
                      readonly
                      placeholder="Buyer"
                    />
                  </el-form-item>
                </el-col>

                <el-col :span="6">
                  <el-form-item
                    label-width="130px"
                    label="Customer phone:"
                    class="postInfo-container-item"
                  >
                    <el-input
                      v-model="order.user.phone_number"
                      filterable
                      remote
                      readonly
                      placeholder="Buyer"
                    />
                  </el-form-item>
                </el-col>
              </el-row>
            </div>

            <el-form-item style="margin-bottom: 40px;">
              <MDinput
                v-model="order.transaction.payment_code"
                :maxlength="100"
                name="name"
                required
                readonly
              >
                Transaction Code
              </MDinput>
              <el-tag
                v-if="order.transaction.payment_status == 0"
                :type="order.transaction.payment_status | statusFilter"
              >
                pending
              </el-tag>
              <el-tag
                v-if="order.transaction.payment_status == 1"
                :type="order.transaction.payment_status | statusFilter"
              >
                completed
              </el-tag>
              <el-tag
                v-if="order.transaction.payment_status == 2"
                :type="order.transaction.payment_status | statusFilter"
              >
                canceled
              </el-tag>
            </el-form-item>
            <el-form-item v-if="order.status == 3">
              <el-button
                v-permission="['manage order']"
                type="success"
                @click="
                  transactionStatus(order.transaction.id, order.order_code, 1)
                "
              >
                Complete transaction
              </el-button>
              <el-button
                v-permission="['manage order']"
                type="danger"
                @click="
                  transactionStatus(order.transaction.id, order.order_code, 2)
                "
              >
                Cancel transaction
              </el-button>
            </el-form-item>
          </el-col>
        </el-row>
      </div>
    </el-form>

    <el-table
      :data="order.products"
      border
      fit
      highlight-current-row
      style="width: 100%"
    >
      <el-table-column align="center" label="ID" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.product_id }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Product Name" width="160">
        <template slot-scope="scope">
          <span>{{ scope.row.product_name }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Product SKU" width="160">
        <template slot-scope="scope">
          <span>{{ scope.row.product_sku }}</span>
        </template>
      </el-table-column>
      <el-table-column min-width="300px" label="Product Description">
        <template slot-scope="scope">
          <span>{{ scope.row.product_description }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Quantity" width="160">
        <template slot-scope="scope">
          <span>{{ scope.row.qty }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Price" width="160">
        <template slot-scope="scope">
          <span>${{ scope.row.price * scope.row.qty }}</span>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import MDinput from '@/components/MDinput';
import Sticky from '@/components/Sticky';
import OrderResource from '@/api/order';
import Resource from '@/api/resource';

const ordersResource = new OrderResource();
const transactionResource = new Resource('transactions');

export default {
  name: 'ArticleDetail',
  components: {
    MDinput,
    Sticky,
  },
  filters: {
    statusFilter(status) {
      const statusMap = {
        0: 'info',
        1: 'success',
        2: 'danger',
        3: 'primary',
      };
      return statusMap[status];
    },
    statusWordFilter(status) {
      const statusMap = {
        1: 'complete',
        2: 'cancel',
        3: 'confirm',
      };
      return statusMap[status];
    },
  },
  props: {
    order: {
      type: Object,
      default: () => {
        return {
          full_name: '',
        };
      },
    },
  },
  data() {
    return {
      data: {
        status: '',
      },
    };
  },
  methods: {
    getOrder() {
      const id = this.$route.params && this.$route.params.id;
      this.$parent.getOrder(id);
    },
    processOrder(id, order_code, status) {
      this.data.status = status;
      this.$confirm(
        'This will permanently ' +
          this.$options.filters.statusWordFilter(status) +
          ' the order ' +
          order_code +
          '. Continue?',
        this.$options.filters.statusWordFilter(status),
        {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning',
        }
      )
        .then(() => {
          ordersResource
            .processOrder(id, this.data)
            .then(response => {
              if (status !== 3) {
                transactionResource.update(id, this.data).then(response => {
                  this.$message({
                    type: 'success',
                    message: 'Order process changed',
                  });
                });
              } else {
                this.$message({
                  type: 'success',
                  message: 'Order process changed',
                });
              }
              this.getOrder();
            })
            .catch(error => {
              console.log(error);
            });
        })
        .catch(() => {
          this.$message({
            type: 'info',
            message:
              'Abort ' +
              this.$options.filters.statusWordFilter(status) +
              ' order',
          });
        });
    },
    transactionStatus(id, order_code, status) {
      this.data.status = status;
      this.$confirm(
        'This will permanently ' +
          this.$options.filters.statusWordFilter(status) +
          ' the transaction of order ' +
          order_code +
          '. Continue?',
        this.$options.filters.statusWordFilter(status),
        {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning',
        }
      )
        .then(() => {
          transactionResource
            .update(id, this.data)
            .then(response => {
              this.$message({
                type: 'success',
                message: 'Transaction status processed',
              });
              this.getOrder();
            })
            .catch(error => {
              console.log(error);
            });
        })
        .catch(() => {
          this.$message({
            type: 'info',
            message:
              'Abort ' +
              this.$options.filters.statusWordFilter(status) +
              ' order',
          });
        });
    },
  },
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
@import '~@/styles/mixin.scss';
.createPost-container {
  position: relative;
  .createPost-main-container {
    padding: 0 45px 20px 50px;
    .postInfo-container {
      position: relative;
      @include clearfix;
      margin-bottom: 10px;
      .postInfo-container-item {
        float: left;
      }
    }
  }
  .word-counter {
    width: 40px;
    position: absolute;
    right: -10px;
    top: 0px;
  }
}
</style>
<style>
.createPost-container label.el-form-item__label {
  text-align: left;
}
</style>
