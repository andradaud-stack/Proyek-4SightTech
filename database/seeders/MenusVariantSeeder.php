<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Menus\Models\Menus;
use App\Modules\Categories\Models\Categories;

class MenusVariantSeeder extends Seeder
{
    /**
     * Run the database seeds to standardize menu variants.
     *
     * Rules:
     * - ICE: Americano, Cappuccino, Mochaccino, Avocado coffee, Flat white
     * - HOT: Americano, Espresso, Cappuccino, Mochaccino, Cafe latte, Flat white
     * - Pastry: TIDAK menggunakan varian ice dan hot (kosong [])
     *
     * @return void
     */
    public function run(): void
    {
        $variantMap = [
            'Americano'           => ['Ice', 'Hot'],
            'Espresso'            => ['Hot'],
            'Cappuccino'          => ['Ice', 'Hot'],
            'Mochaccino'          => ['Ice', 'Hot'],
            'Cafe Latte'          => ['Hot'],
            'Avocado Coffee'      => ['Ice'],
            'Flat White'          => ['Ice', 'Hot'],
            'Vietnam Drip'        => ['Ice', 'Hot'],
            'Affogato'            => ['Ice', 'Hot'],
            'Pistachio Macchiato' => ['Ice', 'Hot'],
            'Ice Lemon Tea'       => ['Ice'],
            'Thai Tea'            => ['Ice', 'Hot'],
            'Matcha Latte'        => ['Ice', 'Hot'],
        ];

        $pastryCategoryIds = Categories::whereRaw('LOWER(name) = ?', ['pastry'])->pluck('id')->toArray();

        $menus = Menus::all();
        foreach ($menus as $menu) {
            $catName = strtolower($menu->kategori->name ?? ($menu->category->name ?? ''));
            if ($catName === 'pastry' || in_array($menu->category_id, $pastryCategoryIds)) {
                $menu->variants = [];
                $menu->save();
                continue;
            }

            $matched = false;
            foreach ($variantMap as $name => $variants) {
                if (strcasecmp(trim($menu->name), trim($name)) === 0) {
                    $menu->variants = $variants;
                    $menu->save();
                    $matched = true;
                    break;
                }
            }

            // Jika tidak terdaftar di variantMap dan bukan pastry, jangan paksa jika sudah ada
            if (!$matched && is_null($menu->variants)) {
                $menu->variants = [];
                $menu->save();
            }
        }
    }
}

