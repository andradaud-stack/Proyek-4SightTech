<?php

namespace App\Http\Controllers;

use App\Helpers\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function changeRole($id_role)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        $roles = Permission::getRole($user->id);

        if ($roles->count() == 0) {
            abort(403);
        }

        $active_role = $roles->where('id', $id_role)->first();

        if (!$active_role) {
            $fallbackRole = $roles->first();

            if (!$fallbackRole) {
                abort(403);
            }

            $active_role = $fallbackRole;
        }

        $active_role_data = $active_role->only(['id', 'role']);

        $menus = Permission::getMenu($active_role_data['id']);
        $privileges = Permission::getPrivilege($active_role_data['id']);
        $privileges = $privileges->mapWithKeys(function ($item) {
            return [$item['module'] => $item->only(['create', 'read', 'update', 'delete', 'show_menu'])];
        });

        session(['menus' => $menus]);
        session(['roles' => $roles->pluck('role', 'id')->all()]);
        session(['privileges' => $privileges->all()]);
        session(['active_role' => $active_role_data]);

        return redirect()->route('dashboard')->with('message_success', 'Berhasil memperbarui role/session sebagai ' . $active_role_data['role']);
    }

    public function forceLogout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
