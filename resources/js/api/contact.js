import Resource from '@/api/resource';
import request from '@/utils/request';

class ContactResource extends Resource {
  constructor() {
    super('contact');
  }
  getListOnlyTrash(query) {
    return request({
      url: '/' + this.uri + '-only-trash-paginate',
      method: 'get',
      params: query,
    });
  }
  restore(unique_id, resource) {
    return request({
      url: '/' + this.uri + '/restore/' + unique_id,
      method: 'put',
      data: resource,
    });
  }
}

export { ContactResource as default };
