<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Modules\Categories\Models\Categories;
use App\Modules\Menus\Models\Menus;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customer.auth.index');
    }
    public function showLogin()
{
    return view('customer.auth.login');
}
public function showRegister()
{
    return view('customer.auth.register');
}

    public function home()
    {
        $categories = Categories::orderBy('name')->get();
        $menus      = Menus::active()->with('kategori')->get();

        return view('customer.home', compact('categories', 'menus'));
    }
}