@extends('layouts.app')

@section('styles')
@endsection

@section('scripts')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('colaborador.store') }}" method="post">
                    @csrf
                    <div class="conteudo-form">
                        <p>
                            @if (session('msg'))
                                <div class="alert alert-success">
                                    {{ session('msg') }}
                                </div>
                            @endif
                        </p>

                        <div class="card">
                            <div class="card-header">
                                Formulário de Cadastro de Colaboradores
                            </div>
                            <div class="card-body bg-white">

                                <div class="row g-3 mb-3">
                                    <div class="col-12 col-sm-6 col-md-6">
                                        <label for="nome" class="form-label">Nome</label>
                                        <input type="text" class="form-control" name="nome" id="nome"
                                            placeholder="Nome">
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <label for="cargo" class="form-label">Cargo</label>
                                        <input type="text" class="form-control" name="cargo" id="cargo"
                                            placeholder="Cargo">
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-3">
                                        <label for="telefone" class="form-label">Telefone</label>
                                        <input type="text" class="form-control" name="telefone" id="telefone"
                                            placeholder="Telefone">
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="E-mail">
                                </div>
                                <div class="mb-3">
                                    <label for="logradouro" class="form-label">Logradouro</label>
                                    <input type="text" class="form-control" name="logradouro" id="logradouro"
                                        placeholder="Logradouro">
                                </div>
                                <div class="mb-3">
                                    <label for="numero" class="form-label">Número</label>
                                    <input type="text" class="form-control" name="numero" id="numero"
                                        placeholder="Número">
                                </div>
                                <div class="mb-3">
                                    <label for="municipio" class="form-label">Município</label>
                                    <input type="text" class="form-control" name="municipio" id="municipio"
                                        placeholder="Município">
                                </div>
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <input type="text" class="form-control" name="estado" id="estado"
                                        placeholder="Estado">
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
