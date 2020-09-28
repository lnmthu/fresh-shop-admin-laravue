import request from '@/utils/request';
import Resource from '@/api/resource';

class TransactionResource extends Resource {
  constructor() {
    super('transactions');
  }

  chargeCard(resource) {
    return request({
      url: '/' + this.uri + '/charge-card',
      method: 'post',
      data: resource,
    });
  }
}

export { TransactionResource as default };
