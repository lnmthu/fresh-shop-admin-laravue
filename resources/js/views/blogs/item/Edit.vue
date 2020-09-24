<template>
  <BlogItemDetail :is-edit="true" />
</template>

<script>
import BlogItemDetail from './components/BlogItemDetail';

export default {
  name: 'EditBlogItem',
  components: { BlogItemDetail },
};
</script>

