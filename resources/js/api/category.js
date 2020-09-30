import Resource from '@/api/resource';
import request from '@/utils/request';

class CategoryResource extends Resource {
  constructor() {
    super('categories');
  }
  getListWithTrash(query) {
    return request({
      url: '/' + this.uri + '-with-trash',
      method: 'get',
      params: query,
    });
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

export { CategoryResource as default };
