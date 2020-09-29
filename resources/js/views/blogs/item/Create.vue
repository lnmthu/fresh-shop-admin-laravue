<template>
  <BlogItemDetail :is-edit="false" />
</template>

<script>
import BlogItemDetail from './components/BlogItemDetail';

export default {
  name: 'CreateBlogItem',
  components: { BlogItemDetail },
};
</script>

