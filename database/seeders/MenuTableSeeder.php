<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Modules\Menu\Models\Menu;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $main = Menu::firstOrCreate(['menu' => 'Main Menu', 'level' => 0], [
            'module' => 'no', 'routing' => 'no', 'is_tampil' => 1,
            'icon' => 'fa-folder', 'urutan' => 1, 'parent_id' => '-'
        ]);
        $man = Menu::firstOrCreate(['menu' => 'Management Menu', 'level' => 0], [
            'module' => 'no', 'routing' => 'no', 'is_tampil' => 1,
            'icon' => 'fa-folder', 'urutan' => 2, 'parent_id' => '-'
        ]);
        $dev = Menu::firstOrCreate(['menu' => 'Advance Menu', 'level' => 0], [
            'module' => 'no', 'routing' => 'no', 'is_tampil' => 1,
            'icon' => 'fa-folder', 'urutan' => 3, 'parent_id' => '-'
        ]);
        Menu::firstOrCreate([
            'menu' => 'Dashboard', 'module' => 'dashboard', 'routing' => 'dashboard', 'level' => 1
        ], [
            'is_tampil' => 1,
            'icon' => 'fa-tachometer-alt',
            'urutan' => 1,
            'parent_id' => $main->id,
        ]);
        Menu::firstOrCreate([
            'menu' => 'Konfigurasi', 'module' => 'config', 'routing' => 'config.index', 'level' => 1
        ], [
            'is_tampil' => 1,
            'icon' => 'fa-cogs',
            'urutan' => 2,
            'parent_id' => $man->id,
        ]);
        Menu::firstOrCreate([
            'menu' => 'User', 'module' => 'users', 'routing' => 'users.index', 'level' => 1
        ], [
            'is_tampil' => 1,
            'icon' => 'fa-user',
            'urutan' => 3,
            'parent_id' => $man->id,
        ]);

        // dev
        Menu::firstOrCreate([
            'menu' => 'Role', 'module' => 'role', 'routing' => 'role.index', 'level' => 1
        ], [
            'is_tampil' => 1,
            'icon' => 'fa-user-tag',
            'urutan' => 1,
            'parent_id' => $dev->id,
        ]);
        Menu::firstOrCreate([
            'menu' => 'Menu', 'module' => 'menu', 'routing' => 'menu.index', 'level' => 1
        ], [
            'is_tampil' => 1,
            'icon' => 'fa-list',
            'urutan' => 2,
            'parent_id' => $dev->id,
        ]);
        Menu::firstOrCreate([
            'menu' => 'Privilege', 'module' => 'privilege', 'routing' => 'privilege.index', 'level' => 1
        ], [
            'is_tampil' => 0,
            'icon' => 'fa-user-cog',
            'urutan' => 3,
            'parent_id' => $dev->id,
        ]);
        Menu::firstOrCreate([
            'menu' => 'Storage', 'module' => 'files', 'routing' => 'files.index', 'level' => 1
        ], [
            'is_tampil' => 1,
            'icon' => 'fa-box-open',
            'urutan' => 4,
            'parent_id' => $dev->id,
        ]);
        Menu::firstOrCreate([
            'menu' => 'Jenis File', 'module' => 'jenisfile', 'routing' => 'jenisfile.index', 'level' => 1
        ], [
            'is_tampil' => 0,
            'icon' => 'fa-boxes',
            'urutan' => 5,
            'parent_id' => $dev->id,
        ]);
        Menu::firstOrCreate([
            'menu' => 'Log', 'module' => 'log', 'routing' => 'log.index', 'level' => 1
        ], [
            'is_tampil' => 1,
            'icon' => 'fa-wave-square',
            'urutan' => 6,
            'parent_id' => $dev->id,
        ]);
    }
}
