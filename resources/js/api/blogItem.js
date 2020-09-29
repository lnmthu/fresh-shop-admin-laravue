import Resource from '@/api/resource';
import request from '@/utils/request';

class BlogItemResource extends Resource {
  constructor() {
    super('blog-items');
  }
  trash(query) {
    return request({
      url: '/trashed/' + this.uri,
      method: 'get',
      params: query,
    });
  }
  restore(id) {
    return request({
      url: '/restore/' + this.uri + '/' + id,
      method: 'put',
    });
  }
  deactivate(id) {
    return request({
      url: '/deactivate/' + this.uri + '/' + id,
      method: 'put',
    });
  }
  activate(id) {
    return request({
      url: '/activate/' + this.uri + '/' + id,
      method: 'put',
    });
  }
}

export { BlogItemResource as default };
