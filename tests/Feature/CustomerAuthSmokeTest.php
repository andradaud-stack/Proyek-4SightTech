<?php

namespace Tests\Feature;

use Tests\TestCase;

class CustomerAuthSmokeTest extends TestCase
{
    public function test_customer_login_and_register_pages_render(): void
    {
        $this->get(route('customer.login'))->assertOk();
        $this->get(route('customer.register'))->assertOk();
    }

    public function test_customer_home_requires_customer_guard(): void
    {
        $this->get(route('customer.home'))->assertRedirect(route('customer.login'));
    }

    public function test_customer_pages_have_expected_markup(): void
    {
        $this->get(route('customer.login'))
            ->assertSee('Masuk ke akun Anda')
            ->assertSee('Daftar sekarang');

        $this->get(route('customer.register'))
            ->assertSee('Buat akun baru')
            ->assertSee('Sudah punya akun?');
    }
}
