/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const productRoutes = {
  path: '/products',
  component: Layout,
  redirect: '/products',
  name: 'Product',
  alwaysShow: true,
  meta: {
    title: 'Products',
    icon: 'admin',
    permissions: ['view menu product'],
  },
  children: [

    /** Category managements */
    {
      path: 'list',
      component: () => import('@/views/products/List'),
      name: 'ProductList',
      meta: { title: 'productList', icon: 'list', permissions: ['view product', 'manage product'] },
    },
    {
      path: 'create',
      component: () => import('@/views/products/Create'),
      name: 'ProductCreate',
      meta: { title: 'productCreate', icon: 'form', permissions: ['manage product'] },
    },
    {
      path: 'edit/:id(\\d+)',
      component: () => import('@/views/products/Edit'),
      name: 'ProductEdit',
      meta: { title: 'productEdit', noCache: true, permissions: ['manage product'] },
      hidden: true,
    },

  ],
};

export default productRoutes;
