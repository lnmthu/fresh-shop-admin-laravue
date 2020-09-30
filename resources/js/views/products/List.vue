<template>
  <div class="app-container">
    <!-- list -->
    <el-table :data="productList" border fit highlight-current-row>
      <el-table-column align="center" label="ID" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Unique_ID" width="90">
        <template slot-scope="scope">
          <span>{{ scope.row.unique_id }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Name" width="140">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Category" width="150">
        <template slot-scope="scope">
          <span>{{ getCategory(scope.row.category_id) }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="SKU" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.sku }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Price" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.price }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Quantity" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.qty }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Description">
        <template slot-scope="scope">
          <span>{{ scope.row.description }}</span>
          <h3 class="medium">
            <el-image
              v-if="scope.row.image_uri"
              :src="scope.row.image_uri"
              class="image"
            />
          </h3>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Sort" width="110">
        <template slot-scope="{row}">
          <el-tag :type="row.sort | Filter">{{ getSort(row.sort) }}</el-tag>
        </template>
      </el-table-column>
      <el-table-column class-name="status-col" label="Status" width="110">
        <template slot-scope="{row}">
          <el-tag :type="row.status | Filter">{{ getStatus(row.status) }}</el-tag>
        </template>
      </el-table-column>
      <!--Edit and delete -->
      <el-table-column
        v-if="checkPermission(['manage product'])"
        align="center"
        label="Actions"
        width="200"
      >
        <template slot-scope="scope">
          <router-link :to="'/products/edit/'+scope.row.unique_id">
            <el-button
              v-permission="['manage product']"
              type="primary"
              size="small"
              icon="el-icon-edit"
            >Edit</el-button>
          </router-link>
          <el-button
            v-permission="['manage product']"
            type="danger"
            size="small"
            icon="el-icon-delete"
            @click="handleDelete(scope.row.unique_id, scope.row.name);"
          >Delete</el-button>
        </template>
      </el-table-column>
      <!--End Edit and delete -->
    </el-table>
    <pagination
      v-show="total>0"
      :total="total"
      :page.sync="listQuery.page"
      :limit.sync="listQuery.limit"
      @pagination="getProductList"
    />
    <!-- end list -->
  </div>
</template>

<script>
import Pagination from '@/components/Pagination';
import permission from '@/directive/permission'; // Import permission directive
import checkPermission from '@/utils/permission';
import ProductResource from '@/api/product';
const productResource = new ProductResource();
import CategoryResource from '@/api/category';
const categoryResource = new CategoryResource();
export default {
  name: 'ProductList',
  directives: { permission },
  components: { Pagination },
  filters: {
    Filter(filter) {
      const filterMap = {
        1: 'success',
        2: 'info',
      };
      return filterMap[filter];
    },
  }, // use permission directive
  data() {
    return {
      productList: [],
      categoryList: [],
      loading: true,
      total: 0,
      listQuery: {
        page: 1,
        limit: 10,
      },
    };
  },
  created() {
    this.getProductList();
    this.getCategoryList();
  },
  methods: {
    checkPermission,
    getCategory($categoryId) {
      let result = '';
      this.categoryList.forEach((element) => {
        if (element.id === $categoryId) {
          result = element.name;
        }
      });
      return result;
    },
    getSort($sort) {
      let result = '';
      if ($sort === 1) {
        result = 'Priority';
      } else {
        result = 'No Priority';
      }
      return result;
    },
    getStatus($status) {
      let result = '';
      if ($status === 1) {
        result = 'published';
      } else {
        result = 'draft';
      }
      return result;
    },
    // list
    async getProductList() {
      this.loading = true;
      const { data, meta } = await productResource.list(this.listQuery);
      this.productList = data;
      this.total = meta.total;
      this.loading = false;
    },
    async getCategoryList() {
      const { data } = await categoryResource.getListWithTrash();
      this.categoryList = data;
    },
    // delete
    handleDelete(unique_id, name) {
      this.$confirm(
        'This will momentarily delete product ' + name + '. Continue?',
        'Warning',
        {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning',
        }
      )
        .then(() => {
          productResource
            .destroy(unique_id)
            .then((response) => {
              this.$message({
                type: 'success',
                message: 'Delete completed',
              });
              this.getProductList();
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
  },
};
</script>
