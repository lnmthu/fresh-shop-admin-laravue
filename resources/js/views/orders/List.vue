<template>
  <div class="app-container">
    <el-table
      v-loading="listLoading"
      :data="list"
      border
      fit
      highlight-current-row
      style="width: 100%"
    >
      <el-table-column align="center" label="ID" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.index }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Customer name" width="150">
        <template slot-scope="scope">
          <span>{{ scope.row.user.full_name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Email" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.user.email }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Phone" width="100">
        <template slot-scope="scope">
          <span>{{ scope.row.user.phone_number }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Total Price" width="120">
        <template slot-scope="scope">
          <span>${{ scope.row.total_price }}</span>
        </template>
      </el-table-column>

      <!-- <el-table-column width="180px" align="center" label="Date">
        <template slot-scope="scope">
          <span>{{
            scope.row.timestamp | parseTime('{y}-{m}-{d} {h}:{i}')
          }}</span>
        </template>
      </el-table-column> -->

      <el-table-column min-width="300px" label="Order Code">
        <template slot-scope="{ row }">
          <router-link :to="'show/' + row.id" class="link-type">
            <span>{{ row.order_code }}</span>
          </router-link>
        </template>
      </el-table-column>

      <el-table-column class-name="status-col" label="Status" width="130">
        <template slot-scope="{ row }">
          <el-tag v-if="row.status == 0" :type="row.status | statusFilter">
            pending
          </el-tag>
          <el-tag v-if="row.status == 1" :type="row.status | statusFilter">
            completed
          </el-tag>
          <el-tag v-if="row.status == 2" :type="row.status | statusFilter">
            canceled
          </el-tag>
          <el-tag v-if="row.status == 3" :type="row.status | statusFilter">
            confirmed
          </el-tag>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Actions" width="240">
        <template slot-scope="scope">
          <el-button
            v-if="scope.row.status == 3"
            type="success"
            size="small"
            icon="el-icon-check"
            @click="processOrder(scope.row.id, scope.row.order_code, 1)"
          >
            Complete
          </el-button>
          <el-button
            v-if="scope.row.status == 0"
            type="primary"
            size="small"
            icon="el-icon-check"
            @click="processOrder(scope.row.id, scope.row.order_code, 3)"
          >
            Confirm
          </el-button>
          <el-button
            v-if="scope.row.status != 2 && scope.row.status != 1"
            type="danger"
            size="small"
            icon="el-icon-edit"
            @click="processOrder(scope.row.id, scope.row.order_code, 2)"
          >
            Cancel
          </el-button>
        </template>
      </el-table-column>
    </el-table>

    <pagination
      v-show="total > 0"
      :total="total"
      :page.sync="listQuery.page"
      :limit.sync="listQuery.limit"
      @pagination="getList"
    />
  </div>
</template>

<script>
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
import OrderResource from '@/api/order';
import Resource from '@/api/resource';

const ordersResource = new OrderResource();
const transactionResource = new Resource('transactions');

export default {
  name: 'OrderList',
  components: { Pagination },
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
  data() {
    return {
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 15,
      },
      data: {
        status: '',
      },
      transaction: {
        status: '',
      },
    };
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      const { limit, page } = this.listQuery;
      this.listLoading = true;
      const { data, meta } = await ordersResource.list(this.listQuery);
      this.list = data;
      this.list.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      this.total = meta.total;
      this.listLoading = false;
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
              this.getList();
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

<style scoped>
.edit-input {
  padding-right: 100px;
}
.cancel-btn {
  position: absolute;
  right: 15px;
  top: 10px;
}
</style>
