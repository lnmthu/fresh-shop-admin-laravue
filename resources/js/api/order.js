import request from '@/utils/request';
import Resource from '@/api/resource';

class OrderResource extends Resource {
  constructor() {
    super('orders');
  }

  processOrder(id, resource) {
    return request({
      url: '/' + this.uri + '/' + id + '/status',
      method: 'put',
      data: resource,
    });
  }
}

export { OrderResource as default };
