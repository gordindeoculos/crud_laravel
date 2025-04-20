@extends('layouts.app')

@section('styles')
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const deleteModal = document.getElementById('confirmDeleteModal');
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const colaboradorId = button.getAttribute('data-colaborador-id');
                const colaboradorNome = button.getAttribute('data-colaborador-nome');

                const form = document.getElementById('deleteColaboradorForm');
                form.action = `/excluir-colaborador/${colaboradorId}`;

                const message = document.getElementById('modal-message');
                message.innerHTML =
                    `Tem certeza que deseja excluir o colaborador <b>${colaboradorNome}</b>?`;
            });
        });
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="mb-3">
            <a href="{{ route('colaborador.create') }}" class="btn btn-primary">Novo</a>
        </div>
        <div class="row justify-content-center">
            @if (session('msg'))
                <div class="alert {{ session('msg_type') == 'error' ? 'alert-danger' : 'alert-success' }}">
                    {{ session('msg') }}
                </div>
            @endif
            <h3>Lista de Colaboradores</h3>
            <hr>
            @if ($colaboradores->isEmpty())
                <h5>Nenhum colaborador cadastrado.</h5>
            @else
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
                                <td class="text-end"><a href="{{ route('colaborador.detalhes', $colaborador->id) }}"
                                        class="btn btn-warning">Detalhes</a></td>
                                <td class="text-end"><a href="{{ route('colaborador.edit', $colaborador->id) }}" class="btn btn-success">Editar</a></td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteModal" data-colaborador-id="{{ $colaborador->id }}"
                                        data-colaborador-nome="{{ $colaborador->nome }}">
                                        Excluir
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h1 class="modal-title fs-5" id="confirmDeleteModalLabel">Excluir</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="modal-message">Tem certeza que deseja excluir esse registro?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form method="POST" id="deleteColaboradorForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
