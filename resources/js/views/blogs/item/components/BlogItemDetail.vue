<template>
  <div class="createPost-container">
    <el-form ref="postForm" :model="form" :rules="rules" class="form-container">
      <sticky :class-name="'sub-navbar ' + form.status">
        <!-- <CommentDropdown v-model="postForm.comment_disabled" />
        <PlatformDropdown v-model="postForm.platforms" />
        <SourceUrlDropdown v-model="postForm.source_uri" /> -->
        <div v-if="isEdit">
          <el-button
            v-loading="loading"
            style="margin-left: 10px;"
            type="success"
            @click="updateData"
          >
            Update
          </el-button>
          <el-button v-loading="loading" type="warning" @click="draftForm">
            Draft
          </el-button>
        </div>

        <div v-else>
          <el-button
            v-loading="loading"
            style="margin-left: 10px;"
            type="success"
            @click="createData"
          >
            Create
          </el-button>
          <el-button v-loading="loading" type="warning" @click="draftForm">
            Draft
          </el-button>
        </div>
      </sticky>

      <div class="createPost-main-container">
        <el-row>
          <el-col :span="24">
            <el-form-item style="margin-bottom: 40px;" prop="title">
              <MDinput
                v-model="form.title"
                :maxlength="100"
                name="name"
                required
              >
                Title
              </MDinput>
            </el-form-item>

            <div class="postInfo-container">
              <el-row>
                <el-col :span="8">
                  <el-form-item label="Category" prop="blog_category_id">
                    <el-select
                      v-model="form.blog_category_id"
                      class="filter-item"
                      placeholder="Please select Category"
                    >
                      <el-option
                        v-for="item in blogCategoryList"
                        :key="item.id"
                        :label="item.title | uppercaseFirst"
                        :value="item.id"
                      />
                    </el-select>
                  </el-form-item>
                </el-col>

                <el-col :span="10">
                  <el-form-item label="User" prop="user_id">
                    <el-select
                      v-model="form.user_id"
                      class="filter-item"
                      placeholder="Please select User"
                    >
                      <el-option
                        v-for="item in userList"
                        :key="item.id"
                        :label="item.name | uppercaseFirst"
                        :value="item.id"
                      />
                    </el-select>
                  </el-form-item>
                </el-col>

                <el-col :span="6">
                  <el-form-item
                    label-width="80px"
                    label="Sort:"
                    class="postInfo-container-item"
                    prop="sort"
                  >
                    <el-input v-model="form.sort" />
                  </el-form-item>
                </el-col>
              </el-row>
            </div>
          </el-col>
        </el-row>

        <el-form-item
          style="margin-bottom: 40px;"
          label-width="100px"
          label="Description:"
          prop="description"
        >
          <el-input
            v-model="form.description"
            :rows="1"
            type="textarea"
            class="article-textarea"
            autosize
            placeholder="Please enter the description"
          />
          <span v-show="contentShortLength" class="word-counter">
            {{ contentShortLength }} words
          </span>
        </el-form-item>

        <el-form-item prop="body" style="margin-bottom: 30px;">
          <Tinymce ref="editor" v-model="form.body" :height="400" />
        </el-form-item>

        <el-form-item prop="image_uri" style="margin-bottom: 30px;">
          <Upload v-model="form.image" />
        </el-form-item>
      </div>
    </el-form>
  </div>
</template>

<script>
import Tinymce from '@/components/Tinymce';
import Upload from '@/components/Upload/SingleImage';
import MDinput from '@/components/MDinput';
import Sticky from '@/components/Sticky'; // Sticky header
import { userSearch } from '@/api/search';
import UserResource from '@/api/user';
import BlogItemResource from '@/api/blogItem';
import BlogCategoryResource from '@/api/blogCategory';

const blogItemResource = new BlogItemResource();
const blogCategoryResource = new BlogCategoryResource();
const userResource = new UserResource();

const defaultForm = {
  title: '',
  description: '',
  user_id: '',
  blog_category_id: '',
  category: '',
  body: '',
  user: '',
  sort: '',
  image: '',
};

export default {
  name: 'BlogItemDetail',
  components: {
    Tinymce,
    MDinput,
    Upload,
    Sticky,
  },
  props: {
    isEdit: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      list: null,
      form: Object.assign({}, defaultForm),
      loading: false,
      userListOptions: [],
      rules: {
        title: [
          { required: true, message: 'Title is required', trigger: 'change' },
        ],
        description: [
          {
            required: true,
            message: 'Description is required',
            trigger: 'blur',
          },
        ],
        body: [
          {
            required: true,
            message: 'Body is required',
            trigger: 'change',
          },
        ],
        user_id: [
          {
            required: true,
            message: 'User is required',
            trigger: 'blur',
          },
        ],
        blog_category_id: [
          {
            required: true,
            message: 'Category is required',
            trigger: 'blur',
          },
        ],
        sort: [
          {
            required: true,
            message: 'Sort is required',
            trigger: 'blur',
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
      blogCategoryList: {},
      userList: {},
      currentUserId: 0,
      currentUser: {
        name: 's',
      },
      tempUser: ['1', '2', '3'],
      tempRoute: {},
    };
  },
  computed: {
    contentShortLength() {
      return this.form.description.length;
    },
  },
  created() {
    if (this.isEdit) {
      const id = this.$route.params && this.$route.params.id;
      this.fetchData(id);
    } else {
      this.form = Object.assign({}, defaultForm);
    }
    this.getBlogCategoryList();
    this.getUserList();

    // Why need to make a copy of this.$route here?
    // Because if you enter this page and quickly switch tag, may be in the execution of the setTagsViewTitle function, this.$route is no longer pointing to the current page
    this.tempRoute = Object.assign({}, this.$route);
  },
  methods: {
    async getBlogCategoryList() {
      this.listLoading = true;
      const { data } = await blogCategoryResource.list(this.listQuery);
      this.blogCategoryList = data;
      // console.log(this.blogCategoryList);

      this.listLoading = false;
    },
    async getUserList() {
      this.listLoading = true;
      const { data } = await userResource.list(this.listQuery);
      this.userList = data;
      // console.log(this.userList);

      this.listLoading = false;
    },
    fetchData(id) {
      blogItemResource
        .get(id)
        .then(response => {
          this.form = response.data;
        })
        .catch(err => {
          console.log(err);
        });
    },
    createData() {
      this.$refs['postForm'].validate(valid => {
        if (valid) {
          this.loading = true;
          // console.log(this.newUser);
          blogItemResource
            .store(this.form)
            .then(response => {
              this.$router.push({ name: 'BlogItemList' });
              this.$message({
                message:
                  'New Blog Item: ' +
                  this.form.title +
                  ' has been created successfully.',
                type: 'success',
                duration: 5 * 1000,
              });
              this.dialogFormVisible = false;
              this.handleFilter();
            })
            .catch(error => {
              console.log(error);
            })
            .finally(() => {
              this.loading = false;
            });
        } else {
          this.loading = false;
          console.log('error submit!!');
          return false;
        }
      });
    },
    updateData() {
      this.$refs['postForm'].validate(valid => {
        if (valid) {
          this.loading = true;
          blogItemResource
            .update(this.form.id, this.form)
            .then(response => {
              // this.$router.push({ name: 'BlogItemList' });
              // this.$message({
              //   title: 'Success',
              //   message: 'Blog item has been updated successfully',
              //   type: 'success',
              //   duration: 2000,
              // });
              // this.dialogFormVisible = false;
              // this.handleFilter();
              console.log(response);
            })
            .catch(error => {
              console.log(error);
            })
            .finally(() => {
              this.loading = false;
            });
        } else {
          this.loading = false;
          console.log('error submit!!');
          return false;
        }
      });
    },
    draftForm() {
      if (this.form.content.length === 0 || this.form.title.length === 0) {
        this.$message({
          message: 'Please enter required title and content',
          type: 'warning',
        });
        return;
      }
      this.$message({
        message: 'Successfully saved',
        type: 'success',
        showClose: true,
        duration: 1000,
      });
      this.form.status = 'draft';
    },
    getRemoteUserList(query) {
      userSearch(query).then(response => {
        if (!response.data.items) {
          return;
        }
        this.userListOptions = response.data.items.map(v => v.name);
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
