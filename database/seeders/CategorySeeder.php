<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date=fake()->date(format: 'Y-m-d h:m:s');

        $data = ['technology category', 'sports category', 'fashoin category'];
        foreach ($data as $cat) {
            Category::create([
                'name' => $cat,
                'slug' => Str::slug($cat),
                'status' => 1,
                'created_at' => $date,
                'updated_at' => $date
            ]);
        }
    }
}
