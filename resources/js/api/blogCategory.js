import Resource from '@/api/resource';
import request from '@/utils/request';

class BlogCategoryResource extends Resource {
  constructor() {
    super('blog-categories');
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
}

export { BlogCategoryResource as default };
