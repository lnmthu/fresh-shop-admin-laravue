<template>
  <div class="app-container">
    <el-table
      v-loading="loading"
      :data="listPaginated"
      border
      fit
      highlight-current-row
    >
      <el-table-column align="center" label="ID" width="50">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Unique_ID" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.unique_id }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Name" width="100">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Email" width="150">
        <template slot-scope="scope">
          <span>{{ scope.row.email }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Message" width="200">
        <template slot-scope="scope">
          <span v-html="scope.row.message" />
        </template>
      </el-table-column>
      <el-table-column class-name="status-col" label="Status" width="80">
        <template slot-scope="{ row }">
          <el-tag :type="row.status | Filter">{{
            getStatus(row.status)
          }}</el-tag>
        </template>
      </el-table-column>
      <!--Edit and delete -->
      <el-table-column
        v-if="checkPermission(['manage contact'])"
        align="center"
        label="Actions"
        width="290"
      >
        <template slot-scope="scope">
          <el-button
            type="success"
            size="small"
            icon="el-icon-delete"
            @click="handleRestore(scope.row.unique_id, scope.row.name)"
          >Restore</el-button>

          <el-button
            type="danger"
            size="small"
            icon="el-icon-delete"
            @click="handleDelete(scope.row.unique_id, scope.row.name)"
          >Delete</el-button>
        </template>
      </el-table-column>
      <!--End Edit and delete -->
    </el-table>
    <pagination
      v-show="total > 0"
      :total="total"
      :page.sync="listQuery.page"
      :limit.sync="listQuery.limit"
      @pagination="getListPaginated"
    />
  </div>
</template>

<script>
import Pagination from '@/components/Pagination';
import permission from '@/directive/permission'; // Import permission directive
import checkPermission from '@/utils/permission';
import ContactResource from '@/api/contact';
const contactResource = new ContactResource();
export default {
  name: 'ContactTrash',
  components: { Pagination },
  directives: { permission },
  filters: {
    Filter(filter) {
      const filterMap = {
        1: 'success',
        2: 'info',
      };
      return filterMap[filter];
    },
  },
  data() {
    return {
      listPaginated: [],
      total: 0,
      loading: true,
      listQuery: {
        page: 1,
        limit: 10,
      },
    };
  },
  created() {
    this.getListPaginated();
  },
  methods: {
    checkPermission,
    getStatus($status) {
      let result = '';
      if ($status === 1) {
        result = 'Read';
      } else {
        result = 'Unread';
      }
      return result;
    },
    // list
    async getListPaginated() {
      this.loading = true;
      const { data, meta } = await contactResource.getListOnlyTrash(this.listQuery);
      this.listPaginated = data;
      this.total = meta.total;
      this.loading = false;
    },
    // delete
    handleDelete(unique_id, name) {
      this.$confirm(
        'This will permanently delete contact ' + name + '. Continue?',
        'Warning',
        {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning',
        }
      )
        .then(() => {
          contactResource
            .destroy(unique_id)
            .then((response) => {
              this.$message({
                type: 'success',
                message: 'Delete completed',
              });
              this.getListPaginated();
            })
            .catch((error) => {
              console.log(error);
            });
        })
        .catch(() => {
          this.$message({
            type: 'info',
            message: 'Delete canceled',
          });
        });
    },
    // restore
    handleRestore(unique_id, name) {
      this.$confirm(
        'This will restore contact ' + name + '. Continue?',
        'Warning',
        {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning',
        }
      )
        .then(() => {
          contactResource
            .restore(unique_id)
            .then((response) => {
              this.$message({
                type: 'success',
                message: 'Restore completed',
              });
              this.getListPaginated();
            })
            .catch((error) => {
              console.log(error);
            });
        })
        .catch(() => {
          this.$message({
            type: 'info',
            message: 'Restore canceled',
          });
        });
    },
  },
};
</script>
