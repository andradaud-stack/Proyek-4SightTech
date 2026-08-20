<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Controller;
use App\Modules\Categories\Models\Categories;
use App\Modules\Menus\Models\Menus;
use App\Modules\Orders\Models\Orders;

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

    public function show(Menus $menu)
    {
        if (! $menu->is_active) {
            abort(404);
        }

        return view('customer.menu.detail', compact('menu'));
    }

    public function profile()
    {
        $user = Auth::guard('customer')->user();

        return view('customer.profile.index', compact('user'));
    }

    public function showChangePassword()
    {
        return view('customer.profile.change-password');
    }

    public function orderHistory()
    {
        $user = Auth::guard('customer')->user();

        $orders = Orders::with(['orderItems', 'tabel'])
            ->where('pengguna_id', $user->id)
            ->latest()
            ->get();

        return view('customer.order.history', compact('orders'));
    }

    public function showOrder(Orders $order)
    {
        $user = Auth::guard('customer')->user();

        if ($order->pengguna_id !== $user->id) {
            abort(404);
        }

        return view('customer.order.detail', compact('order'));
    }

    public function editProfile()
    {
        $user = Auth::guard('customer')->user();

        return view('customer.profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('customer')->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:pengguna,email,' . $user->id],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('customer.profile.index')->with('message_success', 'Profil berhasil diperbarui.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::guard('customer')->user();

        if (! $user || ! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi lama tidak sesuai.'])->withInput();
        }

        $user->password = $request->password;
        $user->save();

        return redirect()->route('customer.profile.index')->with('message_success', 'Kata sandi berhasil diubah.');
    }
}