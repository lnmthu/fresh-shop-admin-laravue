<template>
  <div class="createPost-container">
    <el-form ref="postForm" :model="form" :rules="rules" class="form-container">
      <sticky :class-name="'sub-navbar ' + form.status">
        <!-- <CommentDropdown v-model="postForm.comment_disabled" />
        <PlatformDropdown v-model="postForm.platforms" />
        <SourceUrlDropdown v-model="postForm.source_uri" /> -->
        <div v-if="isEdit">
          <el-button v-loading="loading" style="margin-left: 10px;" type="success" @click="updateData">
            Update
          </el-button>
          <el-button v-loading="loading" type="warning" @click="draftForm">
            Reset
          </el-button>
        </div>

        <div v-else>
          <el-button v-loading="loading" style="margin-left: 10px;" type="success" @click="createData">
            Create
          </el-button>
          <el-button v-loading="loading" type="warning" @click="draftForm">
            Reset
          </el-button>
        </div>
      </sticky>

      <div class="createPost-main-container">
        <el-row>
          <el-col :span="24">
            <el-form-item style="margin-bottom: 40px;" prop="title">
              <MDinput v-model="form.title" :maxlength="100" name="name" required>
                Title
              </MDinput>
            </el-form-item>

            <div class="postInfo-container">
              <el-row>
                <el-col :span="8">
                  <el-form-item label="Category" prop="blog_category_id">
                    <el-select v-model="form.blog_category_id" class="filter-item" placeholder="Please select Category">
                      <el-option v-for="item in blogCategoryList" :key="item.id" :label="item.title | uppercaseFirst" :value="item.id" />
                    </el-select>
                  </el-form-item>
                </el-col>
                <!-- <el-col :span="8">
                  <el-form-item label="Category" prop="category[id]">
                    <el-select v-model="form.category.id" class="filter-item" placeholder="Please select Category">
                      <el-option v-for="item in blogCategoryList" :key="item.id" :label="item.title | uppercaseFirst" :value="item.id" />
                    </el-select>
                  </el-form-item>
                </el-col> -->

                <el-col :span="10">
                  <el-form-item label="User" prop="user_id">
                    <el-select v-model="form.user_id" class="filter-item" placeholder="Please select User">
                      <el-option v-for="item in userList" :key="item.id" :label="item.name | uppercaseFirst" :value="item.id" />
                    </el-select>
                  </el-form-item>
                </el-col>
                <!-- <el-col :span="10">
                  <el-form-item label="User" prop="user[id]">
                    <el-select v-model="form.user.id" class="filter-item" placeholder="Please select User">
                      <el-option v-for="item in userList" :key="item.id" :label="item.name | uppercaseFirst" :value="item.id" />
                    </el-select>
                  </el-form-item>
                </el-col> -->

                <el-col :span="6">
                  <el-form-item label-width="80px" label="Sort:" class="postInfo-container-item" prop="sort">
                    <el-input v-model="form.sort" />
                  </el-form-item>
                </el-col>
              </el-row>
            </div>
          </el-col>
        </el-row>

        <el-form-item style="margin-bottom: 40px;" label-width="100px" label="Description:" prop="description">
          <el-input v-model="form.description" :rows="1" type="textarea" class="article-textarea" autosize placeholder="Please enter the description" />
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
import UserResource from '@/api/user';
import BlogItemResource from '@/api/blogItem';
import BlogCategoryResource from '@/api/blogCategory';

const blogItemResource = new BlogItemResource();
const blogCategoryResource = new BlogCategoryResource();
const userResource = new UserResource();

const defaultForm = {
  title: '',
  description: '',
  category: [],
  user: [],
  blog_category_id: '',
  user_id: '',
  body: '',
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
            trigger: 'change',
          },
        ],
        // user: {
        //   id: [
        //     {
        //       required: true,
        //       message: 'User is required',
        //       trigger: 'blur',
        //     },
        //   ],
        // },
        blog_category_id: [
          {
            required: true,
            message: 'Category is required',
            trigger: 'change',
          },
        ],
        // category: {
        //   id: [
        //     {
        //       required: true,
        //       message: 'Category is required',
        //       trigger: 'blur',
        //     },
        //   ],
        // },
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
        ],
      },
      blogCategoryList: {},
      userList: {},
      // attributes: {
      //   title: '',
      //   desciption: '',
      //   blog_category_id: '',
      //   user_id: '',
      //   body: '',
      //   sort: '',
      //   image: '',
      // },
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

    // console.log(this.form.user_id);
    // console.log(this.form.blog_category_id);
    this.getBlogCategoryList();

    this.getUserList();
  },
  methods: {
    async getBlogCategoryList() {
      const { data } = await blogCategoryResource.list();
      this.blogCategoryList = data;
      // console.log(this.blogCategoryList);
    },
    async getUserList() {
      const { data } = await userResource.list();
      this.userList = data;
      // console.log(this.userList);
    },
    fetchData(id) {
      blogItemResource
        .get(id)
        .then((response) => {
          this.form = response.data;
          // console.log(this.form);
          console.log(this.form.user_id);
          console.log(this.form.blog_category_id);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    createData() {
      this.$refs['postForm'].validate((valid) => {
        if (valid) {
          this.loading = true;

          // this.attributes.title = this.form.title;
          // this.attributes.description = this.form.description;
          // this.attributes.blog_category_id = this.form.category.id;
          // this.attributes.user_id = this.form.user.id;
          // this.attributes.body = this.form.body;
          // this.attributes.sort = this.form.sort;
          // this.attributes.image = this.form.image;

          console.log(this.form);
          // console.log(this.attributes);
          blogItemResource
            .store(this.form)
            .then((response) => {
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
            .catch((error) => {
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
      this.$refs['postForm'].validate((valid) => {
        if (valid) {
          this.loading = true;

          // this.attributes.title = this.form.title;
          // this.attributes.description = this.form.description;
          // this.attributes.blog_category_id = this.form.category.id;
          // this.attributes.user_id = this.form.user.id;
          // this.attributes.body = this.form.body;
          // this.attributes.sort = this.form.sort;
          // this.attributes.image = this.form.image;

          blogItemResource
            .update(this.form.id, this.form)
            .then((response) => {
              this.$router.push({ name: 'BlogItemList' });
              this.$message({
                title: 'Success',
                message: 'Blog item has been updated successfully',
                type: 'success',
                duration: 2000,
              });
              this.dialogFormVisible = false;
              this.handleFilter();
            })
            .catch((error) => {
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
      // console.log(this.form);
      // this.attributes = this.form.title;
      // console.log(this.attributes);
      // this.form.category_id = '';
      // this.form.user_id = '';
      // this.form.description = '';
      // this.form.sort = '';
      // this.form.body = '';
      // this.form.image = '';
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
