<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'id'=>$this->id,
            // 'post_url' => route('frontend.post.show', $this->slug),
            // 'end_point' => url('api/post/' . $this->slug),
            'images' => ImageResource::collection($this->images)
            ,'category_name'=> $this->category->name
        ];
        if ($request->is('api/posts/show/*')) {
            $data['comment_able'] = $this->comment_able;
            $data['category'] = new CategoryResource($this->category);
            $data['comments'] =  CommentResource::collection($this->comments);

        }
        return $data;
    }
}
