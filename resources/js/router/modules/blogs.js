/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const blogsRoutes = {
  path: '/blogs',
  component: Layout,
  redirect: 'noredirect',
  name: 'Blogs',
  meta: {
    title: 'Blogs',
    icon: 'form',
    permissions: ['view menu blogs'],
  },
  children: [
    {
      path: 'category',
      component: () => import('@/views/blogs/index'), // Parent router-view
      name: 'BlogCategories',
      meta: { title: 'Blog Categories', icon: 'form' },
      children: [
        {
          path: 'list',
          component: () => import('@/views/blogs/category/List.vue'),
          name: 'BlogCategoryList',
          meta: { title: 'Blog Category List', icon: 'list' },
        },
        {
          path: 'trash',
          component: () => import('@/views/blogs/category/Trash.vue'),
          name: 'TrashedBlogCategory',
          meta: { title: 'Trash', icon: 'el-icon-delete' },
        },
      ],
    },
    {
      path: 'item',
      component: () => import('@/views/blogs/index'), // Parent router-view
      name: 'BlogItems',
      meta: { title: 'Blog Items', icon: 'form' },
      children: [
        {
          path: 'create',
          component: () => import('@/views/blogs/item/Create.vue'),
          name: 'CreateBlogItem',
          meta: { title: 'Create Blog Item', icon: 'edit' },
        },
        {
          path: 'edit/:id(\\d+)',
          component: () => import('@/views/blogs/item/Edit.vue'),
          name: 'EditBlogItem',
          meta: { title: 'Edit Blog Item', noCache: true },
          hidden: true,
        },
        {
          path: 'list',
          component: () => import('@/views/blogs/item/List.vue'),
          name: 'BlogItemList',
          meta: { title: 'Blog Item List', icon: 'list' },
        },
        {
          path: 'trash',
          component: () => import('@/views/blogs/item/Trash.vue'),
          name: 'TrashedBlogItem',
          meta: { title: 'Trash', icon: 'el-icon-delete' },
        },
      ],
    },
  ],
};

export default blogsRoutes;
