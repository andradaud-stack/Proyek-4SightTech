<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

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
}