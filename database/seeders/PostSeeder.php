<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $post = Post::factory(50)->create();
        // i need to make each post has an image so i did not use post_id in image factory
        $post->each(function ($post) {
            Image::factory(2)->create([
                'post_id' => $post->id,
            ]);
        });
    }
}
