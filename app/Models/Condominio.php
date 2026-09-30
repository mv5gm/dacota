<?php

namespace App\Models;

use Database\Factories\CondominioFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['nombre', 'tipo_condominio_id', 'user_id'])]
class Condominio extends Model
{
    /** @use HasFactory<CondominioFactory> */
    use HasFactory;

    public function tipoCondominio(): BelongsTo
    {
        return $this->belongsTo(TipoCondominio::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWhereNombre(Builder $query, string $termino): Builder
    {
        return $query->where('nombre', 'like', '%'.$termino.'%');
    }
}
