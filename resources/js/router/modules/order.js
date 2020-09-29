/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const ordersRoutes = {
  path: '/orders',
  component: Layout,
  redirect: 'noredirect',
  name: 'Orders',
  meta: {
    title: 'orders',
    icon: 'shopping',
    permissions: ['view order', 'manage order'],
  },
  children: [
    {
      path: 'index', // When clicking on this menu, it will redirect to /#/foo/index
      name: 'OrderList',
      component: () => import('@/views/orders/List'),
      meta: { title: 'orderlist' }, // Show `foo` on the sidebar
    },
    {
      path: 'show/:id(\\d+)',
      component: () => import('@/views/orders/Detail'),
      name: 'OrderDetail',
      meta: {
        title: 'Order Detail',
        noCache: true,
      },
      hidden: true,
    },
    {
      path: 'charge/:id(\\d+)',
      component: () => import('@/views/orders/Charge'),
      name: 'OrderCharge',
      meta: {
        title: 'Charge Order',
        noCache: true,
      },
      hidden: true,
    },
  ],
};

export default ordersRoutes;
