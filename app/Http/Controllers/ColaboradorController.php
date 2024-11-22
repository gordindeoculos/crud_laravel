<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colaborador;
use Illuminate\Database\QueryException;

class ColaboradorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        // Colaborador::create($data);
        // return redirect()->back()->with('msg', 'Registro incluído com sucesso!');

        try {
            Colaborador::create($data);
            return redirect()->back()->with('msg', 'Registro incluído com sucesso!');
        } catch (QueryException $e) {
            // Verifique se o erro é de chave única
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->with('msg', 'O e-mail informado já está cadastrado!')
                    ->with('msg_type', 'error');
            }
            // Verifique se o erro é de coluna obrigatória
            else if ($e->errorInfo[1] == 1048) {
                // Extraia o nome da coluna que está vazia
                preg_match("/Column '(.*?)'/", $e->getMessage(), $matches);
                $columnName = $matches[1] ?? 'um campo obrigatório';

                return redirect()->back()->with('msg', "O campo '{$columnName}' é obrigatório!")
                    ->with('msg_type', 'error');
            }
            // Verifique se o erro é de coluna obrigatória
            else if ($e->errorInfo[1] == 1406) {
                // Extraia o nome da coluna que está vazia
                preg_match("/Data too long for column '(.*?)'/", $e->getMessage(), $matches);
                $columnName = $matches[1] ?? 'um campo ';

                return redirect()->back()->with('msg', "O campo '{$columnName}' excede o tamanho permitido!")
                    ->with('msg_type', 'error');
            }

            // Caso outro erro ocorra
            return redirect()->back()->with('msg', 'Ocorreu um erro ao salvar o registro.')
                ->with('msg_type', 'error');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
