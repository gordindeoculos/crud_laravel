@extends('layouts.app')

@section('styles')
@endsection

@section('scripts')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if (session('msg'))
                <div class="alert alert-success">
                    {{ session('msg') }}
                </div>
            @endif
            <h3>Lista de Colaboradores</h3>
            <hr>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">Cargo</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @forEach ($colaboradores as $colaborador)
                    <tr>
                        <th scope="row">{{$colaborador->id}}</th>
                        <td>{{$colaborador->nome}}</td>
                        <td>{{$colaborador->telefone}}</td>
                        <td>{{$colaborador->cargo}}</td>
                        <td class="text-end"><a href="{{ route('colaborador.info', $colaborador->id) }}" class="btn btn-warning">Detalhes</a></td>
                        <td class="text-end"><a href="{{ route('colaborador.edit', $colaborador->id) }}" class="btn btn-success">Editar</a></td>
                        <td class="text-end">
                            <form action="{{ route('colaborador.excluir', $colaborador->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir o colaborador {{$colaborador->nome}}?')">
                                    Excluir
                                </button>
                            </form>                            
                        </td>
                    </tr>
                    @endforEach
                </tbody>
            </table>
        </div>
    </div>
@endsection
