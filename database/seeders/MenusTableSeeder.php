<?php

namespace Database\Seeders;

use App\Modules\Categories\Models\Categories;
use App\Modules\Menus\Models\Menus;
use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            ['Coffee Based', 'Americano', 'Kopi hitam espresso dengan air panas', 23000, 50],
            ['Coffee Based', 'Espresso', 'Shot kopi murni rasa pekat', 21000, 50],
            ['Coffee Based', 'Cappuccino', 'Espresso dengan busa susu lembut', 29000, 50],
            ['Coffee Based', 'Mochaccino', 'Kopi dengan cokelat dan susu', 30000, 50],
            ['Coffee Based', 'Cafe Latte', 'Espresso dicampur susu hangat', 29000, 50],
            ['Coffee Based', 'Avocado Coffee', 'Kopi dipadukan alpukat segar', 32000, 50],
            ['Coffee Based', 'Vietnam Drip', 'Kopi Vietnam dengan susu kental manis', 27000, 50],
            ['Coffee Based', 'Affogato', 'Shot espresso di atas es krim vanilla', 32000, 50],
            ['Coffee Based', 'Flat White', 'Espresso double shot dengan microfoam', 29000, 50],
            ['Coffee Based', 'Pistachio Macchiato', 'Latte macchiato rasa pistachio', 33000, 50],
            ['Non-Coffee', 'Ice Lemon Tea', 'Teh dingin perasan lemon segar', 15000, 50],
            ['Non-Coffee', 'Thai Tea', 'Teh Thailand manis dengan susu', 18000, 50],
            ['Non-Coffee', 'Matcha Latte', 'Teh hijau matcha dicampur susu', 17000, 50],
            ['Pastry', 'Butter Croissant', 'Roti croissant bermentega renyah', 14000, 30],
            ['Pastry', 'Cheese Danish', 'Pastry dengan isian keju', 16000, 30],
            ['Pastry', 'Sausage Roll', 'Roti gulung berisi sosis', 17000, 30],
        ];

        foreach ($menus as [$category, $name, $description, $price, $stock]) {
            $cat = Categories::where('name', $category)->first();
            if (! $cat) {
                continue;
            }

            Menus::firstOrCreate(['name' => $name], [
                'category_id' => $cat->id,
                'name'        => $name,
                'description' => $description,
                'price'       => $price,
                'stock'       => $stock,
                'is_active'   => true,
            ]);
        }
    }
}