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
}

export { CategoryResource as default };
