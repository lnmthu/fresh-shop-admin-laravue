/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const categoryRoutes = {
  path: '/categories',
  component: Layout,
  redirect: '/categories',
  name: 'Category',
  alwaysShow: true,
  meta: {
    title: 'Categories',
    icon: 'admin',
    permissions: ['view menu category'],
  },
  children: [

    /** Category managements */
    {
      path: 'list',
      component: () => import('@/views/categories/List'),
      name: 'CategoryList',
      meta: { title: 'categoryList', icon: 'list', permissions: ['view category', 'manage category'] },
    },
    {
      path: 'create',
      component: () => import('@/views/categories/Create'),
      name: 'CategoryCreate',
      meta: { title: 'categoryCreate', icon: 'form', permissions: ['manage category'] },
    },
    {
      path: 'edit/:id(\\d+)',
      component: () => import('@/views/categories/Edit'),
      name: 'CategoryEdit',
      meta: { title: 'categoryEdit', noCache: true, permissions: ['manage category'] },
      hidden: true,
    },

  ],
};

export default categoryRoutes;
