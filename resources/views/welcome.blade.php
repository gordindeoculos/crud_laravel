@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row align-items-center justify-content-center g-4">
            <div class="col-lg-7">
                <div class="mb-4">
                    <span class="badge text-bg-primary mb-3">Gestao de colaboradores</span>
                    <h1 class="display-6 fw-semibold mb-3">Sistema de Colaboradores</h1>
                    <p class="lead text-muted mb-0">
                        Cadastre, consulte, edite e acompanhe os dados dos colaboradores em um unico lugar.
                    </p>
                </div>

                <div class="d-flex flex-column flex-sm-row gap-2">
                    <a href="{{ route('colaborador.list') }}" class="btn btn-primary btn-lg">
                        Ver colaboradores
                    </a>
                    <a href="{{ route('colaborador.create') }}" class="btn btn-outline-primary btn-lg">
                        Novo colaborador
                    </a>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h2 class="h5 mb-0">Acesso rapido</h2>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('colaborador.list') }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0">
                                Lista de colaboradores
                                <span class="text-primary">&rsaquo;</span>
                            </a>
                            <a href="{{ route('colaborador.create') }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0">
                                Cadastrar colaborador
                                <span class="text-primary">&rsaquo;</span>
                            </a>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <small class="text-muted">
                            Dados principais: nome, cargo, telefone, e-mail e endereco.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
