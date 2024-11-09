  <!-- Modal Create -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
      <form method="POST" action="{{route('admin.categories.store')}}" class="modal-content">
          @csrf
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Create Category</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-6">
                      <div class="form-group">
                          <input type="text" name="name" placeholder="Enter Category name" class="form-control">
                          @error('name')
                              <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>
                  <div class="col-6">
                      <div class="form-group">
                          <select name="status" class="form-control">
                              <option selected disabled value="">Select status</option>
                              <option value="1">Active</option>
                              <option value="0">Inactive</option>
                          </select>
                          @error('status')
                              <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Create</button>
          </div>
      </form>
  </div>
</div>
