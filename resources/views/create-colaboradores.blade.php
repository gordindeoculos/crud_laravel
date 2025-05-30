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
                        <div class="card">
                            <div class="card-header">
                                Formulário de Cadastro de Colaboradores
                            </div>
                            <div class="card-body bg-white">
                                <p>Os campos com * são de preenchimento obrigatório.</p>
                                <div class="row g-3 mb-3">
                                    <!-- Nome -->
                                    <div class="col-12 col-sm-6 col-md-8">
                                        <label for="nome" class="form-label">Nome*</label>
                                        <input type="text" class="form-control @error('nome') is-invalid @enderror"
                                            name="nome" id="nome" placeholder="Nome" value="{{ old('nome') }}"
                                            required>
                                        @error('nome')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Cargo -->
                                    <div class="col-12 col-sm-6 col-md-4">
                                        <label for="cargo" class="form-label">Cargo*</label>
                                        <input type="text" class="form-control @error('cargo') is-invalid @enderror"
                                            name="cargo" id="cargo" placeholder="Cargo" value="{{ old('cargo') }}"
                                            required>
                                        @error('cargo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <!-- Telefone -->
                                    <div class="col-12 col-sm-6 col-md-4">
                                        <label for="telefone" class="form-label">Telefone*</label>
                                        <input type="text" class="form-control @error('telefone') is-invalid @enderror"
                                            name="telefone" id="telefone" placeholder="Telefone"
                                            value="{{ old('telefone') }}" pattern="\(\d{2}\) \d{4,5}-\d{4}"
                                            title="Digite um telefone no formato (99) 9999-9999 ou (99) 99999-9999"
                                            required>
                                        @error('telefone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- E-mail -->
                                    <div class="col-12 col-sm-6 col-md-8">
                                        <label for="email" class="form-label">E-mail*</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" id="email" placeholder="E-mail" value="{{ old('email') }}"
                                            required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <!-- Logradouro -->
                                    <div class="col-12 col-sm-8 col-md-9">
                                        <label for="logradouro" class="form-label">Logradouro*</label>
                                        <input type="text" class="form-control @error('logradouro') is-invalid @enderror"
                                            name="logradouro" id="logradouro" placeholder="Logradouro"
                                            value="{{ old('logradouro') }}" required>
                                        @error('logradouro')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Número -->
                                    <div class="col-12 col-sm-4 col-md-3">
                                        <label for="numero" class="form-label">Número*</label>
                                        <input type="number" class="form-control @error('numero') is-invalid @enderror"
                                            name="numero" id="numero" placeholder="Número" value="{{ old('numero') }}"
                                            required>
                                        @error('numero')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <!-- Município -->
                                    <div class="col-12 col-sm-8 col-md-9">
                                        <label for="municipio" class="form-label">Município*</label>
                                        <input type="text" class="form-control @error('municipio') is-invalid @enderror"
                                            name="municipio" id="municipio" placeholder="Município"
                                            value="{{ old('municipio') }}" required>
                                        @error('municipio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Estado -->
                                    <div class="col-12 col-sm-4 col-md-3">
                                        <label for="estado" class="form-label">Estado*</label>
                                        <input type="text" class="form-control @error('estado') is-invalid @enderror"
                                            name="estado" id="estado" placeholder="Estado" value="{{ old('estado') }}"
                                            pattern=".{2}" title="O campo deve conter exatamente 2 caracteres"
                                            maxlength="2" required>
                                        @error('estado')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="col-auto">
                                    <a href="{{ route('coloborador.list') }}" class="btn btn-secondary me-2">Voltar</a>
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
