<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colaborador;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class ColaboradorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colaboradores = Colaborador::all();

        return view('list-colaboradores', compact('colaboradores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create-colaboradores');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        // Defina as regras de validação
        $rules = [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:colaboradores,email',
            'telefone' => ['required', 'regex:/^\(\d{2}\) \d{4,5}-\d{4}$/'],
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|integer',
            'municipio' => 'required|string|max:255',
            'estado' => 'required|string|size:2',
            'cargo' => 'required|string|max:255',
        ];

        $messages = [
            'nome.required' => 'O campo Nome é obrigatório.',
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'O E-mail informado não é válido.',
            'email.unique' => 'O E-mail informado já está cadastrado.',
            'telefone.required' => 'O campo Telefone é obrigatório.',
            'telefone.regex' => 'O telefone deve estar no formato (99) 9999-9999 ou (99) 99999-9999.',
            'logradouro.required' => 'O campo Logradouro é obrigatório.',
            'numero.required' => 'O campo Número é obrigatório.',
            'numero.integer' => 'O campo Número deve ser um número inteiro.',
            'municipio.required' => 'O campo Município é obrigatório.',
            'estado.required' => 'O campo Estado é obrigatório.',
            'estado.size' => 'O campo Estado deve ter exatamente 2 caracteres.',
            'cargo.required' => 'O campo Cargo é obrigatório.',
        ];

        // Crie o validador
        $validator = Validator::make($data, $rules, $messages);

        // Verifique se a validação falhou
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $colaborador = Colaborador::create($data);
            return redirect()->route('colaborador.list')->with('msg', "Colaborador $colaborador->nome foi incluído com sucesso!");
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
        $colaborador = Colaborador::findOrFail($id);
        return view('detalhes-colaborador', compact('colaborador'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $colaborador = Colaborador::findOrFail($id);
        return view('edit-colaborador', compact('colaborador'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();

        // Defina as regras de validação
        $rules = [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:colaboradores,email,' . $id,
            'telefone' => ['required', 'regex:/^\(\d{2}\) \d{4,5}-\d{4}$/'],
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|integer',
            'municipio' => 'required|string|max:255',
            'estado' => 'required|string|size:2',
            'cargo' => 'required|string|max:255',
        ];

        $messages = [
            'nome.required' => 'O campo Nome é obrigatório.',
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'O E-mail informado não é válido.',
            'email.unique' => 'O E-mail informado já está cadastrado.',
            'telefone.required' => 'O campo Telefone é obrigatório.',
            'telefone.regex' => 'O telefone deve estar no formato (99) 9999-9999 ou (99) 99999-9999.',
            'logradouro.required' => 'O campo Logradouro é obrigatório.',
            'numero.required' => 'O campo Número é obrigatório.',
            'numero.integer' => 'O campo Número deve ser um número inteiro.',
            'municipio.required' => 'O campo Município é obrigatório.',
            'estado.required' => 'O campo Estado é obrigatório.',
            'estado.size' => 'O campo Estado deve ter exatamente 2 caracteres.',
            'cargo.required' => 'O campo Cargo é obrigatório.',
        ];

        // Crie o validador
        $validator = Validator::make($data, $rules, $messages);

        // Verifique se a validação falhou
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $colaborador = Colaborador::findOrFail($id);
            $colaborador->update($data);
            return redirect()->route('colaborador.list')->with('msg', "Colaborador $colaborador->nome foi atualizado com sucesso!");
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $colaborador = Colaborador::find($id);
        $colaborador->delete();

        return redirect()->back()->with('msg', "O colaborador $colaborador->nome foi excluído com sucesso!");
    }
}
