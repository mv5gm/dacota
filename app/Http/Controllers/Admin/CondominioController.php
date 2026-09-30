<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Condominio;
use App\Models\TipoCondominio;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CondominioController extends Controller
{
    public function index(Request $request): View
    {
        $condominios = Condominio::query()
            ->with(['tipoCondominio', 'user'])
            ->when($request->string('search')->isNotEmpty(), function (Builder $query) use ($request) {
                $term = $request->string('search')->toString();

                $query->where(function (Builder $query) use ($term) {
                    $query->where('nombre', 'like', '%'.$term.'%')
                        ->orWhereHas('tipoCondominio', fn (Builder $query) => $query->where('nombre', 'like', '%'.$term.'%'));
                });
            })
            ->when($request->integer('tipo_condominio_id') > 0, function (Builder $query) use ($request) {
                $query->where('tipo_condominio_id', $request->integer('tipo_condominio_id'));
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.condominios.index', [
            'condominios' => $condominios,
            'tipos' => $this->tipos(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'tipo_condominio_id' => ['required', 'integer', 'exists:'.TipoCondominio::class.',id'],
        ], [
            'tipo_condominio_id' => 'tipo de condominio',
        ], [
            'nombre' => 'nombre',
        ]);

        Condominio::create([
            'nombre' => $validated['nombre'],
            'tipo_condominio_id' => $validated['tipo_condominio_id'],
            'user_id' => $request->user()->id,
        ]);

        return back()->with('status', 'Condominio creado correctamente.');
    }

    public function update(Request $request, Condominio $condominio): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'tipo_condominio_id' => ['required', 'integer', 'exists:'.TipoCondominio::class.',id'],
        ], [
            'tipo_condominio_id' => 'tipo de condominio',
        ], [
            'nombre' => 'nombre',
        ]);

        $condominio->update($validated);

        return back()->with('status', 'Condominio actualizado correctamente.');
    }

    public function destroy(Condominio $condominio): RedirectResponse
    {
        $condominio->delete();

        return back()->with('status', 'Condominio eliminado correctamente.');
    }

    /**
     * @return Collection<int, TipoCondominio>
     */
    private function tipos(): Collection
    {
        return TipoCondominio::orderBy('nombre')->get();
    }
}
