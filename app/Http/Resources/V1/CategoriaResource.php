<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoriaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    private $types = ['renda' => 'Renda', 'investimento' => 'Investimento', 'despesa' => 'Despesa', 'gasto' => 'Gasto'];

    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'tipo' => $this->categoria_id ? 'Subcategoria' : 'Categoria',
            'categoriaNome' => $this->nome,
            'categoriaDescricao' => $this->descricao,
            'categoriaTipo' => $this->tipo ? $this->types[$this->tipo] : 'Categoria',
            // Subcategorias associadas
            'categoriaSubcategorias' => CategoriaResource::collection($this->whenLoaded('subcategorias'))
        ];
    }
}
