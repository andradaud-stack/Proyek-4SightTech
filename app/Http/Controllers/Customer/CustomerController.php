<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Controller;
use App\Modules\Categories\Models\Categories;
use App\Modules\Menus\Models\Menus;
use App\Modules\Order_items\Models\Order_items;
use App\Modules\Orders\Models\Orders;
use App\Modules\Pengguna\Models\Pengguna;
use App\Modules\Tables\Models\Tables;

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

        $orders = Orders::with(['orderItems.menu.category', 'tabel'])
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

        $order->load(['orderItems.menu.category', 'tabel']);

        return view('customer.order.detail', compact('order'));
    }

    public function getOrderStatus(Orders $order)
    {
        $user = Auth::guard('customer')->user();

        if ($order->pengguna_id !== $user->id) {
            abort(404);
        }

        $statusStage = [
            'menunggu_konfirmasi' => 0,
            'diproses'            => 1,
            'siap_disajikan'      => 2,
            'selesai'             => 3,
            'dibatalkan'          => -1,
        ];

        return response()->json([
            'status' => $order->status,
            'stage' => $statusStage[$order->status] ?? -1,
            'updated_at' => $order->updated_at,
        ]);
    }

    public function editProfile()
    {
        $user = Auth::guard('customer')->user();

        return view('customer.profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        /** @var Pengguna $user */
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

        /** @var Pengguna $user */
        $user = Auth::guard('customer')->user();

        if (! $user || ! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi lama tidak sesuai.'])->withInput();
        }

        $user->password = $request->password;
        $user->save();

        return redirect()->route('customer.profile.index')->with('message_success', 'Kata sandi berhasil diubah.');
    }

    public function scanTableQr(string $token)
    {
        $table = Tables::where('qr_token', $token)->firstOrFail();

        session(['customer_table_id' => $table->id]);

        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.home');
        }

        return redirect()->route('customer.login');
    }

    public function cartIndex()
    {
        $cart = session('cart', []);

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        return view('customer.cart.index', compact('cart', 'total'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'integer', 'exists:menus,id'],
            'variant'    => ['nullable', 'string', 'max:50'],
        ]);

        $menu = Menus::findOrFail($request->product_id);

        if (! $menu->is_active || $menu->stock <= 0) {
            return back()->with('message_error', 'Menu sedang tidak tersedia.');
        }

        $variant = $request->input('variant');
        $key     = $menu->id . '_' . ($variant ?? 'DEFAULT');

        $cart = session('cart', []);
        $currentQty = $cart[$key]['qty'] ?? 0;

        if ($currentQty + 1 > $menu->stock) {
            return back()->with('message_error', 'Stok tidak cukup untuk menambah item ini.');
        }

        if (isset($cart[$key])) {
            $cart[$key]['qty']++;
        } else {
            $cart[$key] = [
                'menu_id' => $menu->id,
                'name'    => $menu->name,
                'variant' => $variant,
                'price'   => $menu->price,
                'qty'     => 1,
                'image'   => $menu->image,
            ];
        }

        session(['cart' => $cart]);

        return redirect()->route('customer.cart.index');
    }

    public function cartUpdate(Request $request)
    {
        $key  = $request->input('key');
        $qty  = max(0, (int) $request->input('qty'));
        $cart = session('cart', []);

        if (isset($cart[$key])) {
            $menu = Menus::find($cart[$key]['menu_id']);

            if ($menu && $qty > $menu->stock) {
                return back()->with('message_error', 'Stok menu tidak cukup untuk kuantitas yang diminta.');
            }

            if ($qty <= 0) {
                unset($cart[$key]);
            } else {
                $cart[$key]['qty'] = $qty;
            }
        }

        session(['cart' => $cart]);

        return back();
    }

    public function checkoutIndex()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('customer.cart.index')->with('message_error', 'Keranjang masih kosong.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $selectedTableId = session('customer_table_id');
        $tableOptions = Tables::orderBy('table_number')->pluck('table_number', 'id');

        return view('customer.checkout.index', compact('cart', 'total', 'selectedTableId', 'tableOptions'));
    }

    public function checkoutStore(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('customer.cart.index')->with('message_error', 'Keranjang masih kosong.');
        }

        $request->validate([
            'table_id' => ['required', 'exists:tables,id'],
            'metode_pembayaran' => ['required', 'string', 'max:50'],
        ]);

        foreach ($cart as $item) {
            $menu = Menus::find($item['menu_id']);

            if (! $menu || $menu->stock <= 0 || $item['qty'] > $menu->stock) {
                return redirect()->route('customer.cart.index')->with('message_error', 'Stok untuk ' . ($item['name'] ?? 'menu') . ' tidak cukup.');
            }
        }

        $table = Tables::findOrFail($request->table_id);

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $order = DB::transaction(function () use ($cart, $request, $table, $total) {
            $customerId = Auth::guard('customer')->id();
            $orderData = [
                'pengguna_id' => $customerId,
                'table_id' => $table->id,
                'status' => 'menunggu_konfirmasi',
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pembayaran' => 'belum_bayar',
                'total' => $total,
            ];

            if (Schema::hasColumn('orders', 'user_id')) {
                $orderData['user_id'] = $customerId ? (string) $customerId : null;
            }

            $order = Orders::create($orderData);

            foreach ($cart as $item) {
                Order_items::create([
                    'order_id' => $order->id,
                    'menu_id' => $item['menu_id'],
                    'menu_name' => $item['name'],
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                    'subtotal' => $item['price'] * $item['qty'],
                ]);

                $menu = Menus::find($item['menu_id']);
                if ($menu) {
                    $menu->decrement('stock', $item['qty']);
                }
            }

            return $order;
        });

        session()->forget('cart');
        session(['customer_table_id' => $table->id]);

        return redirect()->route('customer.order.detail', $order->id)->with('message_success', 'Pesanan berhasil dibuat.');
    }
}
