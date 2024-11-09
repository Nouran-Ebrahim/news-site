<?php

namespace Database\Seeders;

use App\Models\RelativeSite;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;
class RelativeSiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker=Factory::create();
        for ($i=0; $i <5 ; $i++) {
            RelativeSite::create([
                'name' => $faker->sentence(1),
                'url'=>$faker->url()
            ]);
        }
    }
}
