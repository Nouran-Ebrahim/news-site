<div class="card-body">
    <form method="GET" action="{{route('admin.posts.index')}}">
        <div class="row">
            <div class="col-2">
                <div class="form-group">
                    <select name="sortby" id="sortby" class="form-control">
                        <option selected  value="">Sort By</option>
                        <option {{@request()->sortby=='id'?'selected':''}} value="id">Id</option>
                        <option {{@request()->sortby=='name'?'selected':''}} value="name">Name</option>
                        <option {{@request()->sortby=='created_at'?'selected':''}} value="created_at">Created At</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <select name="orderby" id="orderby" class="form-control">
                        <option selected  value="">Order By</option>

                        <option {{@request()->orderby=='asc'?'selected':''}} value="asc">Ascending</option>
                        <option {{@request()->orderby=='desc'?'selected':''}} value="desc">descending</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <select name="limit" id="Limit" class="form-control">
                        <option selected  value="">Limit By</option>

                        <option {{@request()->limit==10?'selected':''}} value="10">10</option>
                        <option {{@request()->limit==20?'selected':''}} value="20">20</option>
                        <option {{@request()->limit==40?'selected':''}} value="40">40</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <select name="status" id="Status" class="form-control">
                        <option   value="">Status</option>

                        <option {{@request()->status==1?'selected':''}} value="1">Active</option>
                        <option {{@request()->status==0 && @request()->status !=null ?'selected':''}} value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <input class="form-control" value="{{@request()->keyword}}" name="keyword" placeholder="search...">
                </div>
            </div>
            <div class="col-1">
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-info">Search</button>
                </div>
            </div>
        </div>
    </form>

</div>
