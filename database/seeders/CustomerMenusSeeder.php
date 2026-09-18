<?php

namespace Database\Seeders;

use App\Modules\Categories\Models\Categories;
use App\Modules\Menus\Models\Menus;
use Illuminate\Database\Seeder;

class CustomerMenusSeeder extends Seeder
{
    /**
     * Seed menu customer yang siap ditampilkan di halaman beranda.
     */
    public function run(): void
    {
        $categories = [
            'Coffee Based' => [
                ['name' => 'Americano', 'description' => 'Espresso dengan air panas, rasa seimbang dan bersih.', 'price' => 18000, 'stock' => 20],
                ['name' => 'Cappuccino', 'description' => 'Kopi espresso dengan busa susu lembut.', 'price' => 22000, 'stock' => 18],
                ['name' => 'Cafe Latte', 'description' => 'Espresso dan susu yang creamy.', 'price' => 24000, 'stock' => 20],
                ['name' => 'Mochaccino', 'description' => 'Cokelat, espresso, dan susu yang lembut.', 'price' => 26000, 'stock' => 15],
            ],
            'Non-Coffee' => [
                ['name' => 'Thai Tea', 'description' => 'Minuman teh khas dengan rasa creamy dan manis seimbang.', 'price' => 21000, 'stock' => 25],
                ['name' => 'Ice Lemon Tea', 'description' => 'Minuman penyegar dengan rasa lemon dan teh yang segar.', 'price' => 17000, 'stock' => 30],
                ['name' => 'Matcha Latte', 'description' => 'Matcha premium yang lembut dan harum.', 'price' => 26000, 'stock' => 12],
            ],
            'Pastry' => [
                ['name' => 'Croissant', 'description' => 'Pastry renyah dan lembut dengan aroma mentega.', 'price' => 15000, 'stock' => 16],
                ['name' => 'Cheese Cake', 'description' => 'Manis lembut dengan rasa keju yang hangat.', 'price' => 20000, 'stock' => 14],
            ],
            'Makanan' => [
                ['name' => 'Nasi Ayam Gulai', 'description' => 'Nasi hangat dengan ayam gulai dan sambal.', 'price' => 39000, 'stock' => 10],
                ['name' => 'Nasi Gulai Otak', 'description' => 'Combo nasi, gulai otak, dan pelengkap khas.', 'price' => 42000, 'stock' => 8],
            ],
        ];

        foreach ($categories as $categoryName => $menuList) {
            $category = Categories::firstOrCreate(['name' => $categoryName]);

            foreach ($menuList as $item) {
                Menus::firstOrCreate([
                    'category_id' => $category->id,
                    'name' => $item['name'],
                ], [
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'stock' => $item['stock'],
                    'is_active' => true,
                    'image' => null,
                ]);
            }
        }
    }
}
