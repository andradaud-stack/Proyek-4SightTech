<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('menu')
            ->where('routing', 'orders_management.index')
            ->update([
                'routing' => 'orders.management',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('menu')
            ->where('routing', 'orders.management')
            ->where('menu', 'Konfirmasi Pesanan')
            ->update([
                'routing' => 'orders_management.index',
                'updated_at' => now(),
            ]);
    }
};