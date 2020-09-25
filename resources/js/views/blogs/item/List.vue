<template>
  <div class="app-container">
    <el-table v-loading="listLoading" :data="list" border fit highlight-current-row style="width: 100%">
      <el-table-column align="center" label="ID">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Category">
        <template slot-scope="scope">
          <span>{{ scope.row.category.title }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Publish by">
        <template slot-scope="scope">
          <span>{{ scope.row.user.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Title">
        <template slot-scope="scope">
          <span>{{ scope.row.title }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Description">
        <template slot-scope="scope">
          <span>{{ scope.row.description }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Position">
        <template slot-scope="scope">
          <span>{{ scope.row.sort }}</span>
        </template>
      </el-table-column>

      <el-table-column :label="$t('table.status')" class-name="status-col" width="100">
        <template slot-scope="scope">
          <el-tag :type="scope.row.status | statusFilter">
            {{ scope.row.status | statusWordFilter }}
          </el-tag>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Actions" width="350" class-name="small-padding fixed-width">
        <template slot-scope="scope">

          <router-link :to="'/blogs/item/edit/'+scope.row.id">
            <el-button type="primary" size="small" icon="el-icon-edit" style="margin-right: 10px">
              Edit
            </el-button>
          </router-link>

          <el-button v-if="scope.row.status!='1'" size="small" type="success" icon="el-icon-caret-top" @click="handleActiveStatus(scope.row.id,'1')">
            Activate
          </el-button>
          <el-button v-if="scope.row.status!='0'" size="small" type="info" icon="el-icon-caret-bottom" @click="handleDeactivateStatus(scope.row.id,'0')">
            Deactivate
          </el-button>

          <el-button type="danger" size="small" icon="el-icon-delete" @click="handleDelete(scope.row.id, scope.row.title)">
            Trash
          </el-button>

        </template>
      </el-table-column>
    </el-table>

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />
  </div>
</template>

<script>
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
import BlogItemResource from '@/api/blogItem';
// import BlogCategoryResource from '@/api/blogCategory';

const blogItemResource = new BlogItemResource();

export default {
  name: 'BlogItemList',
  components: { Pagination },
  filters: {
    statusFilter(status) {
      const statusMap = {
        1: 'success',
        0: 'info',
      };
      return statusMap[status];
    },
    statusWordFilter(status) {
      const statusMap = {
        1: 'Activate',
        0: 'Deactivate',
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
        limit: 20,
      },
      statusOptions: ['Activate', 'Deactivate'],
    };
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      const { limit, page } = this.listQuery;
      this.listLoading = true;
      const { data, meta } = await blogItemResource.list(this.listQuery);
      // console.log(data);
      this.list = data;
      this.list.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      this.total = meta.total;
      this.listLoading = false;
    },
    handleDeactivateStatus(id, status) {
      blogItemResource
        .deactivate(id)
        .then((response) => {
          this.$message({
            message: 'Deactivated Status',
            type: 'success',
          });
          this.getList();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    handleActiveStatus(id) {
      blogItemResource
        .activate(id)
        .then((response) => {
          this.$message({
            message: 'Activated Status',
            type: 'success',
          });
          this.getList();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    handleDelete(id, title) {
      this.$confirm(
        'Trash Blog Category: ' + title + '. Continue?',
        'Warning',
        {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning',
        }
      )
        .then(() => {
          blogItemResource
            .destroy(id)
            .then((response) => {
              this.$message({
                type: 'success',
                message: 'Trash completed',
              });
              this.handleFilter();
            })
            .catch((error) => {
              console.log(error);
            });
        })
        .catch(() => {
          this.$message({
            type: 'info',
            message: 'Trash canceled',
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
