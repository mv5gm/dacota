<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(): View
    {
        return view('admin.permissions.index', [
            'permissions' => Permission::with('roles')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'alpha_dash', 'max:255', 'unique:permissions,name'],
        ], [
            'name' => 'nombre',
        ]);

        Permission::create($validated);

        return back()->with('status', 'Permiso creado correctamente.');
    }

    public function update(Request $request, Permission $permission): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'alpha_dash', 'max:255', Rule::unique('permissions', 'name')->ignore($permission->id)],
        ], [
            'name' => 'nombre',
        ]);

        $permission->update($validated);

        return back()->with('status', 'Permiso actualizado correctamente.');
    }

    public function destroy(Permission $permission): RedirectResponse
    {
        $permission->delete();

        return back()->with('status', 'Permiso eliminado correctamente.');
    }
}
