<?php

namespace App\Models;

use Database\Factories\TipoCondominioFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nombre'])]
class TipoCondominio extends Model
{
    /** @use HasFactory<TipoCondominioFactory> */
    use HasFactory;

    public function condominios(): HasMany
    {
        return $this->hasMany(Condominio::class);
    }

    public function scopeWhereNombre(Builder $query, string $termino): Builder
    {
        return $query->where('nombre', 'like', '%'.$termino.'%');
    }
}
