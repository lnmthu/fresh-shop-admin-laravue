/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const contactRoute = {
  path: '/contact',
  component: Layout,
  redirect: '/contact',
  name: 'Contact',
  alwaysShow: true,
  meta: {
    title: 'Contact',
    icon: 'star',
    permissions: ['view menu contact'],
  },
  children: [
    {
      path: 'list',
      component: () => import('@/views/contact/List'),
      name: 'contactList',
      meta: { title: 'contactList', icon: 'list', permissions: ['view contact', 'manage contact'] },
    },
    {
      path: 'trash',
      component: () => import('@/views/contact/Trash'),
      name: 'contactTrash',
      meta: { title: 'contactTrash', icon: 'el-icon-delete', permissions: ['manage contact'] },
    },
  ],
};

export default contactRoute;
