<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CategoriaResource;
use App\Models\Categoria;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return CategoriaResource::collection(Categoria::all());
        // Busca todas as categorias no sistema, e suas subcategorias;
        $categorias = Categoria::whereNull('categoria_id')->with('subcategorias')->get();
        return CategoriaResource::collection($categorias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validação dos dados
            $validator = Validator::make($request->all(), [
                'categoriaNome' => 'required|string|max:255',
                'categoriaDescricao' => 'nullable|string',
                'categoriaTipo' => 'nullable|in:renda,investimento,despesa,gasto',
                'categoria_id' => 'nullable|exists:categorias,id',
                // Adicione outras regras de validação conforme necessário
            ]);

            if ($validator->fails()) {
                // Exibir Json de Erro
                return $this->error('Dados Invalidos', 422, $validator->errors());
            }

            // Criação de um novo item no banco de dados
            $created = Categoria::create([
                'nome' => $request->input('categoriaNome'),
                'descricao' => $request->input('categoriaDescricao'),
                'tipo' => $request->input('categoriaTipo'),
                'categoria_id' => $request->input('categoria_id'),
                // Adicione outros campos conforme necessário
            ]);

            $texto = "";
            if($request->input('categoria_id')) {
                $texto = "Subcategoria";
            } else {
                $texto = "Categoria";
            }

            // Exibir Json de sucesso
            return $this->response($texto.' criada com sucesso!', 200, new CategoriaResource($created->load('subcategorias')));
        } catch (\Exception $e) {
            // Exibir Json de Erro
            return $this->error('Ocorreu um erro ao criar a Categoria', 400, [$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // return new CategoriaResource (Categoria::find($id));
        // Carregar a categoria junto com suas subcategorias
        $categoria = Categoria::with('subcategorias')->find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoria não encontrada'], 404);
        }

        // Retornar a categoria e suas subcategorias usando o resource
        return new CategoriaResource($categoria);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
