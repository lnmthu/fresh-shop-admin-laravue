<template>
  <div class="createPost-container">
    <el-form ref="postForm" :model="postForm" class="form-container">
      <sticky :class-name="'sub-navbar primary'">
        <el-select v-model="postForm.parent_id" placeholder="Select Parent Category">
          <el-option v-for="item in list" :key="item.id" :label="item.name" :value="item.id" />
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

const defaultForm = {
  id: undefined,
  name: '',
  parent_id: null,
  description: '',
  status: 1, // public
  sort: 1, // Priority
  image_uri: '',
};

export default {
  name: 'CategoryDetail',
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
      list: [],
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
    this.getList();
  },
  methods: {
    fetchData(id) {
      categoryResource
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
      const title = 'categoryEdit';
      const route = Object.assign({}, this.tempRoute, {
        title: `${title}-${this.postForm.id}`,
      });
      this.$store.dispatch('updateVisitedView', route);
    },
    async getList() {
      const { data } = await categoryResource.list({});
      this.list = data;
    },
    // create and edit
    submitForm() {
      if (this.postForm.id !== undefined) {
        categoryResource
          .update(this.postForm.id, this.postForm)
          .then((response) => {
            this.$message({
              type: 'success',
              message: 'Category info has been updated successfully',
              duration: 5 * 1000,
            });
            this.getList();
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        categoryResource
          .store(this.postForm)
          .then((response) => {
            this.$message({
              message:
                'New category ' +
                this.postForm.name +
                ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.postForm = {
              name: '',
              parent_id: null,
              description: '',
              sort: 1,
              status: 1,
              image_uri: '',
            };
            this.getList();
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
