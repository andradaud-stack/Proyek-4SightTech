<?php

namespace Tests\Feature;

use App\Modules\Categories\Models\Categories;
use App\Modules\Menus\Models\Menus;
use App\Modules\Pengguna\Models\Pengguna;
use App\Modules\Tables\Models\Tables;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerStockFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_home_and_detail_show_menu_stock(): void
    {
        $category = Categories::create(['name' => 'Coffee']);
        $menu = Menus::create([
            'category_id' => $category->id,
            'name' => 'Americano',
            'description' => 'Rasa kopi yang seimbang.',
            'price' => 25000,
            'stock' => 12,
            'is_active' => true,
        ]);

        $customer = Pengguna::create([
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'password' => 'password123',
            'role' => 'user',
        ]);

        $this->actingAs($customer, 'customer');

        $this->get(route('customer.home'))
            ->assertOk()
            ->assertSeeText('Stok')
            ->assertSeeText('12');

        $this->get(route('customer.menu.show', $menu->id))
            ->assertOk()
            ->assertSeeText('Stok')
            ->assertSeeText('12');
    }

    public function test_adding_menu_redirects_back_to_home(): void
    {
        $category = Categories::create(['name' => 'Coffee']);
        $menu = Menus::create([
            'category_id' => $category->id,
            'name' => 'Latte',
            'description' => 'Kopi susu lembut.',
            'price' => 30000,
            'stock' => 5,
            'is_active' => true,
        ]);

        $customer = Pengguna::create([
            'name' => 'Sari',
            'email' => 'sari@example.com',
            'password' => 'password123',
            'role' => 'user',
        ]);

        $this->actingAs($customer, 'customer');

        $this->from(route('customer.menu.show', $menu->id))
            ->post(route('customer.cart.add'), [
                'product_id' => $menu->id,
            ])
            ->assertRedirect(route('customer.home'));
    }

    public function test_menu_detail_does_not_render_bottom_navbar(): void
    {
        $category = Categories::create(['name' => 'Coffee']);
        $menu = Menus::create([
            'category_id' => $category->id,
            'name' => 'Americano',
            'description' => 'Rasa kopi yang seimbang.',
            'price' => 25000,
            'stock' => 12,
            'is_active' => true,
        ]);

        $customer = Pengguna::create([
            'name' => 'Dina',
            'email' => 'dina@example.com',
            'password' => 'password123',
            'role' => 'user',
        ]);

        $this->actingAs($customer, 'customer');

        $this->get(route('customer.menu.show', $menu->id))
            ->assertOk()
            ->assertDontSee('Beranda')
            ->assertDontSee('Keranjang');
    }

    public function test_checkout_reduces_menu_stock(): void
    {
        $category = Categories::create(['name' => 'Coffee']);
        $menu = Menus::create([
            'category_id' => $category->id,
            'name' => 'Latte',
            'description' => 'Kopi susu lembut.',
            'price' => 30000,
            'stock' => 5,
            'is_active' => true,
        ]);

        $customer = Pengguna::create([
            'name' => 'Sari',
            'email' => 'sari@example.com',
            'password' => 'password123',
            'role' => 'user',
        ]);

        $table = Tables::create(['table_number' => 'A1']);

        $this->actingAs($customer, 'customer');
        session(['customer_table_id' => $table->id]);
        session(['cart' => [
            $menu->id . '_DEFAULT' => [
                'menu_id' => $menu->id,
                'name' => $menu->name,
                'variant' => null,
                'price' => $menu->price,
                'qty' => 2,
                'image' => null,
            ],
        ]]);

        $this->post(route('customer.checkout.store'), [
            'table_id' => $table->id,
            'metode_pembayaran' => 'cash',
        ])->assertRedirect();

        $this->assertSame(3, $menu->fresh()->stock);
    }
}