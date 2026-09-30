<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipoCondominio;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TipoCondominioController extends Controller
{
    public function index(Request $request): View
    {
        $tipos = TipoCondominio::query()
            ->withCount('condominios')
            ->when($request->string('search')->isNotEmpty(), fn (Builder $query) => $query->whereNombre($request->string('search')->toString()))
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        return view('admin.tipo-condominios.index', [
            'tipos' => $tipos,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:'.TipoCondominio::class.',nombre'],
        ], [], [
            'nombre' => 'nombre',
        ]);

        TipoCondominio::create($validated);

        return back()->with('status', 'Tipo de condominio creado correctamente.');
    }

    public function update(Request $request, TipoCondominio $tipoCondominio): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255', Rule::unique(TipoCondominio::class)->ignore($tipoCondominio->id)],
        ], [], [
            'nombre' => 'nombre',
        ]);

        $tipoCondominio->update($validated);

        return back()->with('status', 'Tipo de condominio actualizado correctamente.');
    }

    public function destroy(TipoCondominio $tipoCondominio): RedirectResponse
    {
        if ($tipoCondominio->condominios()->exists()) {
            return back()->with('error', 'El tipo tiene condominios asignados. Reasígnalos antes de eliminarlo.');
        }

        $tipoCondominio->delete();

        return back()->with('status', 'Tipo de condominio eliminado correctamente.');
    }
}
