<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input v-model="query.keyword" :placeholder="$t('table.keyword')" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter" />
      <el-button v-waves class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">
        {{ $t('table.search') }}
      </el-button>
      <el-button class="filter-item" style="margin-left: 10px;" type="primary" icon="el-icon-plus" @click="handleCreate">
        {{ $t('table.add') }}
      </el-button>
      <el-button v-waves :loading="downloading" class="filter-item" type="primary" icon="el-icon-download" @click="handleDownload">
        {{ $t('table.export') }}
      </el-button>
    </div>

    <el-table v-loading="loading" :data="list" border fit highlight-current-row style="width: 100%">

      <el-table-column align="center" label="Index" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.index }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Id" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Title">
        <template slot-scope="scope">
          <span>{{ scope.row.title }}</span>
        </template>
      </el-table-column>

      <!-- <el-table-column align="center" label="Count">
        <template slot-scope="scope">
          <span>{{ scope.row.blogItems.count() }}</span>
        </template>
      </el-table-column> -->

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

      <el-table-column align="center" label="Count blog items">
        <template slot-scope="scope">
          <span>{{ scope.row.child_count }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Actions" width="350">
        <template slot-scope="{row}">
          <el-button type="primary" size="small" icon="el-icon-edit" @click="handleUpdate(row)">
            Edit
          </el-button>

          <el-button type="danger" size="small" icon="el-icon-delete" @click="handleDelete(row.id, row.title)">
            Trash
          </el-button>
        </template>
      </el-table-column>
    </el-table>

    <pagination v-show="total > 0" :total="total" :page.sync="query.page" :limit.sync="query.limit" @pagination="getList" />

    <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible">
      <div v-loading="blogCategoryCreating" class="form-container">
        <el-form ref="dataForm" :rules="rules" :model="blogCategoryData" label-position="left" label-width="150px" style="max-width: 500px;">

          <el-form-item label="Title" prop="title">
            <el-input v-model="blogCategoryData.title" />
          </el-form-item>

          <el-form-item label="Sort" prop="sort">
            <el-input v-model="blogCategoryData.sort" />
          </el-form-item>

          <el-form-item label="Description" prop="description">
            <el-input v-model="blogCategoryData.description" :autosize="{ minRows: 2, maxRows: 4}" type="textarea" placeholder="Please input" />
          </el-form-item>

        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="dialogFormVisible = false">
            {{ $t('table.cancel') }}
          </el-button>
          <!-- <el-button type="primary" @click="createData()">
            {{ $t('table.confirm') }}
          </el-button> -->
          <el-button type="primary" @click="dialogStatus==='create'?createData():updateData()">
            {{ $t('table.confirm') }}
          </el-button>
        </div>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
import BlogCategoryResource from '@/api/blogCategory';
import waves from '@/directive/waves'; // Waves directive

const blogCategoryResource = new BlogCategoryResource();

export default {
  name: 'BlogCategoryList',
  components: { Pagination },
  directives: { waves },
  data() {
    return {
      list: null,
      total: 0,
      loading: true,
      downloading: false,
      blogCategoryCreating: false,
      query: {
        page: 1,
        limit: 15,
      },
      blogCategoryData: {
        type: Object,
        default: () => {
          return {
            title: '',
            description: '',
          };
        },
      },
      dialogFormVisible: false,
      dialogStatus: '',
      textMap: {
        update: 'Edit',
        create: 'Create',
      },
      rules: {
        title: [
          { required: true, message: 'Title is required', trigger: 'change' },
        ],
        description: [
          {
            required: true,
            message: 'Description is required',
            trigger: 'change',
          },
        ],
        sort: [
          {
            required: true,
            message: 'Sort is required',
            trigger: 'change',
          },
          {
            pattern: /^\d*$/,
            message: 'Must be all numbers, greater than or equals 0',
            trigger: 'blur',
          },
          {
            // type: 'number',
            min: 0,
            // max: 10,
            message: 'Sort must be at least 0',
            trigger: 'blur',
          },
        ],
      },
    };
  },
  created() {
    this.resetBlogCategoryData();
    this.getList();
  },
  methods: {
    async getList() {
      const { limit, page } = this.query;
      this.loading = true;
      const { data, meta } = await blogCategoryResource.list(this.query);
      this.list = data;
      this.list.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      this.total = meta.total;
      this.loading = false;
    },
    handleFilter() {
      this.query.page = 1;
      this.getList();
    },
    handleCreate() {
      this.resetBlogCategoryData();
      this.dialogStatus = 'create';
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate();
      });
    },
    handleDelete(id, title) {
      this.$confirm('Trash Category: ' + title + '. Continue?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      })
        .then(() => {
          blogCategoryResource
            .destroy(id)
            .then((response) => {
              if (response.data.data === false) {
                this.$message({
                  type: 'error',
                  message: 'Cannot trash this category because it has some blogs',
                });
                this.handleFilter();
              } else {
                this.$message({
                  type: 'success',
                  message: 'Trash completed',
                });
                this.handleFilter();
              }
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

    createData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          this.blogCategoryCreating = true;
          // console.log(this.newUser);
          blogCategoryResource
            .store(this.blogCategoryData)
            .then((response) => {
              this.$message({
                message:
                  'New Blog Category: ' +
                  this.blogCategoryData.title +
                  ' has been created successfully.',
                type: 'success',
                duration: 5 * 1000,
              });
              this.resetBlogCategoryData();
              this.dialogFormVisible = false;
              this.handleFilter();
            })
            .catch((error) => {
              console.log(error);
            })
            .finally(() => {
              this.blogCategoryCreating = false;
            });
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    },
    handleUpdate(row) {
      // console.log(row);
      this.blogCategoryData = Object.assign({}, row); // copy obj
      this.dialogStatus = 'update';
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate();
      });
    },
    updateData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          blogCategoryResource
            .update(this.blogCategoryData.id, this.blogCategoryData)
            .then((response) => {
              this.dialogFormVisible = false;
              this.getList();
              this.$message({
                message: 'Blog Category has been updated successfully',
                type: 'success',
                duration: 5 * 1000,
              });
            })
            .catch((error) => {
              console.log(error);
              this.updating = false;
            });
        }
      });
    },
    resetBlogCategoryData() {
      this.blogCategoryData = {
        title: '',
        description: '',
      };
    },
    handleDownload() {
      this.downloading = true;
      import('@/vendor/Export2Excel').then((excel) => {
        const tHeader = ['id', 'user_id', 'name', 'email'];
        const filterVal = ['index', 'id', 'name', 'email'];
        const data = this.formatJson(filterVal, this.list);
        excel.export_json_to_excel({
          header: tHeader,
          data,
          filename: 'user-list',
        });
        this.downloading = false;
      });
    },
    formatJson(filterVal, jsonData) {
      return jsonData.map((v) => filterVal.map((j) => v[j]));
    },
  },
};
</script>

<style lang="scss" scoped>
.edit-input {
  padding-right: 100px;
}
.cancel-btn {
  position: absolute;
  right: 15px;
  top: 10px;
}
.dialog-footer {
  text-align: left;
  padding-top: 0;
  margin-left: 150px;
}
.app-container {
  flex: 1;
  justify-content: space-between;
  font-size: 14px;
  padding-right: 8px;
  .block {
    float: left;
    min-width: 250px;
  }
  .clear-left {
    clear: left;
  }
}
</style>
