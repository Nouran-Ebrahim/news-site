<?php

namespace Database\Seeders;

use App\Models\Autherization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permessions = [];
        foreach (config('authrizationPermessions.permessions') as $key => $value) {
            $permessions[] = $key;
        }

        Autherization::firstOrCreate([
            'role' => "manger",
            "permessions" => json_encode($permessions)
        ]);
    }
}
