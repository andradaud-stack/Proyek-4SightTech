<?php

namespace Database\Seeders;

use App\Modules\Categories\Models\Categories;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Coffee Based', 'Non-Coffee', 'Pastry', 'Makanan'];

        foreach ($categories as $name) {
            Categories::firstOrCreate(['name' => $name], [
                'name' => $name,
            ]);
        }
    }
}