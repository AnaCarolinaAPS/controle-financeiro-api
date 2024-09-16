<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'descricao',
        'tipo',
        'categoria_id',
    ];

    // Relacionamento de categorias com subcategorias
    public function subcategorias()
    {
        return $this->hasMany(Categoria::class, 'categoria_id');
    }

    // Relacionamento inverso para obter a categoria pai
    public function categoriaPai()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
