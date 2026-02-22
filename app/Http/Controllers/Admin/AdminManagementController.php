<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AdminManagementController extends Controller
{
    public function index(): View
    {
        return view('admin.admins.index', [
            'admins' => Admin::query()->latest()->paginate(15),
            'roles' => Role::query()->where('guard_name', 'admin')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:admins,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'string'],
        ]);

        $admin = Admin::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_active' => true,
        ]);
        $admin->syncRoles([$data['role']]);

        return back()->with('status', 'Admin berhasil dibuat.');
    }

    public function update(Request $request, Admin $admin): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:admins,email,'.$admin->id],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', 'string'],
            'is_active' => ['required', 'boolean'],
        ]);

        $admin->name = $data['name'];
        $admin->email = $data['email'];
        $admin->is_active = (bool) $data['is_active'];
        if (! empty($data['password'])) {
            $admin->password = Hash::make($data['password']);
        }
        $admin->save();
        $admin->syncRoles([$data['role']]);

        return back()->with('status', 'Admin berhasil diperbarui.');
    }
}
