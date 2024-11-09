 <!-- Content Row -->
 <div class="row">

     <!-- Content Column -->

     <div class="col-lg-6 mb-4">

         <!-- Project Card Example -->
         <div class="card shadow mb-4">
             <div class="card-header py-3">
                 <h6 class="m-0 font-weight-bold text-primary">Last Posts</h6>
             </div>
             <div class="table-responsive">
                 <table class="table">
                     <thead>
                         <tr>
                             <th>Title</th>
                             <th>Comments</th>
                             <th>Category</th>
                             <th>Status</th>
                         </tr>
                     </thead>
                     <tbody>
                         @forelse ($latestPosts as $post)
                             <tr>
                                 <td>
                                     @can('posts')
                                         <a href="{{ route('admin.posts.show', $post) }}">{{ $post->title }}</a>
                                     @endcan
                                     @cannot('posts')
                                         {{ $post->title }}
                                     @endcannot
                                 </td>
                                 <td>{{ $post->comments_count }}</td>
                                 <td>{{ $post->category->name }}</td>
                                 <td>{{ $post->status_name }}</td>

                             </tr>
                         @empty
                             <tr>
                                 <td colspan="4">No posts found</td>
                             </tr>
                         @endforelse

                     </tbody>
                 </table>
             </div>
         </div>



     </div>

     <div class="col-lg-6 mb-4">

         <!-- Project Card Example -->
         <div class="card shadow mb-4">
             <div class="card-header py-3">
                 <h6 class="m-0 font-weight-bold text-primary">Last Comments</h6>
             </div>
             <div class="table-responsive">
                 <table class="table">
                     <thead>
                         <tr>
                             <th>Name</th>
                             <th>Comment</th>
                             <th>Post</th>
                             <th>Status</th>
                         </tr>
                     </thead>
                     <tbody>
                         @forelse ($latestComments as $comment)
                             <tr>
                                 <td>{{ $comment->user->name }}</td>
                                 <td>{{ Str::limit($comment->comment, 40) }}</td>
                                 <td>
                                     @can('posts')
                                         <a
                                             href="{{ route('admin.posts.show', $comment->post) }}">{{ $comment->post->title }}</a>
                                     @endcan
                                     @cannot('posts')
                                         {{ $comment->post->title }}
                                     @endcannot
                                 </td>

                                 <td>{{ $comment->status_name }}</td>

                             </tr>
                         @empty
                             <tr>
                                 <td colspan="4">No Comments found</td>
                             </tr>
                         @endforelse

                     </tbody>
                 </table>
             </div>
         </div>



     </div>
 </div>
