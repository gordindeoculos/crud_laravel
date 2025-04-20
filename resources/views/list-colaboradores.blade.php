@extends('layouts.app')

@section('styles')
@endsection

@section('scripts')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">Telefone</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($colaboradores as $colaborador)
                        <tr>
                            <th scope="row">{{ $colaborador->id }}</th>
                            <td>{{ $colaborador->nome }}</td>
                            <td>{{ $colaborador->cargo }}</td>
                            <td>{{ $colaborador->telefone }}</td>
                            <td class="text-end"><a href="{{ route('colaborador.detalhes', $colaborador->id) }}" class="btn btn-warning">Detalhes</a></td>
                            <td class="text-end"><a href="#" class="btn btn-success">Editar</a></td>
                            <td class="text-end"><a href="#" class="btn btn-danger">Excluir</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
