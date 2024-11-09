<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // we can remove map so the collection will filterd accourding to post resource but we must make the tow files with same name like postresouce and postcolection
        // we can use PostResource::colection($this->collection) insted of map
        return [
            // 'data' => $this->collection->map(function ($post) {
            //     return [
            //         'id' => $post->id,
            //         'title' => $post->title,
            //     ];
            // }),
            'data' => $this->collection,
            'count' => $this->collection->count()
        ];
    }
}
