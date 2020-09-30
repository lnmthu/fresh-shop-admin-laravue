import Resource from '@/api/resource';
import request from '@/utils/request';

class ProductResource extends Resource {
  constructor() {
    super('products');
  }
  getListOnlyTrash(query) {
    return request({
      url: '/' + this.uri + '-only-trash-paginate',
      method: 'get',
      params: query,
    });
  }
  restore(id, resource) {
    return request({
      url: '/' + this.uri + '/restore/' + id,
      method: 'put',
      data: resource,
    });
  }
}

export { ProductResource as default };
