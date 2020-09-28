<template>
  <div class="createPost-container">
    <el-form ref="postForm" :model="postForm" class="form-container">
      <sticky :class-name="'sub-navbar primary'">
        <el-select v-model="postForm.category_id" placeholder="Select Category">
          <el-option
            v-for="item in categoryList"
            :key="item.id"
            :label="item.name"
            :value="item.id"
          />
        </el-select>
        <SortDropdown v-model="postForm.sort" />
        <StatusDropdown v-model="postForm.status" />
        <el-button
          v-loading="loading"
          style="margin-left: 10px;"
          type="success"
          @click="submitForm"
        >Submit</el-button>
        <!-- <el-button v-loading="loading" type="warning" @click="draftForm">Draft</el-button> -->
      </sticky>

      <div class="createPost-main-container">
        <el-row>
          <el-col :span="24">
            <el-form-item style="margin: 20px 0px;" label-width="80px" label="Name:">
              <el-input
                v-model="postForm.name"
                :rows="1"
                type="textarea"
                class="article-textarea"
                autosize
                placeholder="Please enter name"
              />
            </el-form-item>

            <div class="postInfo-container">
              <el-row>
                <el-col :span="8">
                  <el-form-item label-width="80px" label="Sku:" class="postInfo-container-item">
                    <el-input
                      v-model="postForm.sku"
                      :rows="1"
                      type="text"
                      class="article-textarea"
                      autosize
                      placeholder="Please Enter Sku"
                    />
                  </el-form-item>
                </el-col>

                <el-col :span="10">
                  <el-form-item label-width="120px" label="Price:" class="postInfo-container-item">
                    <el-input
                      v-model="postForm.price"
                      :rows="1"
                      type="number"
                      class="article-textarea"
                      autosize
                      placeholder="Please Enter Price"
                    />
                  </el-form-item>
                </el-col>

                <el-col :span="6">
                  <el-form-item
                    label-width="80px"
                    label="Quantity:"
                    class="postInfo-container-item"
                  >
                    <el-input
                      v-model="postForm.qty"
                      :rows="1"
                      type="number"
                      class="article-textarea"
                      autosize
                      placeholder="Please Enter Quantity"
                    />
                  </el-form-item>
                </el-col>
              </el-row>
            </div>
          </el-col>
        </el-row>
        <el-form-item prop="content" style="margin-bottom: 30px;">
          <Tinymce ref="editor" v-model="postForm.description" :height="400" />
        </el-form-item>

        <el-form-item prop="image_uri" style="margin-bottom: 30px;">
          <Upload v-model="postForm.image_uri" />
        </el-form-item>
      </div>
    </el-form>
  </div>
</template>

<script>
import Tinymce from '@/components/Tinymce';
import Upload from '@/components/Upload/SingleImage';
import Sticky from '@/components/Sticky'; // Sticky header
import { StatusDropdown, SortDropdown } from './Dropdown';
import CategoryResource from '@/api/category';
const categoryResource = new CategoryResource();
import ProductResource from '@/api/product';
const productResource = new ProductResource();

const defaultForm = {
  id: undefined,
  category_id: null,
  name: '',
  sku: '',
  price: null,
  qty: null,
  status: 1, // public
  sort: 1, // Priority
  source_uri: '',
  image_uri: '',
};

export default {
  name: 'ProductDetail',
  components: {
    Tinymce,
    Upload,
    Sticky,
    StatusDropdown,
    SortDropdown,
  },
  props: {
    isEdit: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      postForm: Object.assign({}, defaultForm),
      productList: [],
      categoryList: [],
      loading: false,
      userListOptions: [],
      tempRoute: {},
    };
  },
  computed: {
    lang() {
      return this.$store.getters.language;
    },
  },
  created() {
    if (this.isEdit) {
      const id = this.$route.params && this.$route.params.id;
      this.fetchData(id);
    } else {
      this.postForm = Object.assign({}, defaultForm);
    }

    // Why need to make a copy of this.$route here?
    // Because if you enter this page and quickly switch tag, may be in the execution of the setTagsViewTitle function, this.$route is no longer pointing to the current page
    this.tempRoute = Object.assign({}, this.$route);
    this.getProductList();
    this.getCategoryList();
  },
  methods: {
    // edit form
    fetchData(id) {
      productResource
        .get(id)
        .then((response) => {
          this.postForm = response.data;
          // Set tagsview title
          this.setTagsViewTitle();
        })
        .catch((err) => {
          console.log(err);
        });
    },
    setTagsViewTitle() {
      const title = 'productEdit';
      const route = Object.assign({}, this.tempRoute, {
        title: `${title}-${this.postForm.id}`,
      });
      this.$store.dispatch('updateVisitedView', route);
    },
    // list
    async getProductList() {
      const { data } = await productResource.list();
      this.productList = data;
    },
    async getCategoryList() {
      const { data } = await categoryResource.list();
      this.categoryList = data;
    },
    // create and edit submit
    submitForm() {
      if (this.postForm.id !== undefined) {
        productResource
          .update(this.postForm.id, this.postForm)
          .then((response) => {
            this.$message({
              type: 'success',
              message: 'Product info has been updated successfully',
              duration: 5 * 1000,
            });
            this.getProductList();
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        productResource
          .store(this.postForm)
          .then((response) => {
            this.$message({
              message:
                'New procduct ' +
                this.postForm.name +
                ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.postForm = {
              id: undefined,
              category_id: null,
              name: '',
              sku: '',
              description: '',
              price: null,
              qty: null,
              status: 1, // public
              sort: 1, // Priority
              image_uri: '',
            };
            this.getProductList();
          })
          .catch((error) => {
            console.log(error);
          });
      }
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
