@extends('layouts.app')

@section('content')
    <div class="container p-3 bg-white">
        <form action="{{ route('colaborador.store') }}" method="POST">
            @csrf
            <div class="conteudo-form">
                <div class="card">
                    <div class="card-header">
                        Formulário de Cadastro de Colaboradores
                    </div>
                    <div class="card-body bg-white">
                        <p>Os campos com * são de preenchimento obrigatório.</p>

                        <div class="row g-3 mb-3">
                            <form-input label="Nome" name="nome" id="nome" placeholder="Nome" required
                                value="{{ old('nome') }}" :server-error="'{{ $errors->first('nome') }}'"
                                wrapper-class="col-12 col-sm-6 col-md-8"></form-input>

                            <form-input label="Cargo" name="cargo" id="cargo" placeholder="Cargo" required
                                value="{{ old('cargo') }}" :server-error="'{{ $errors->first('cargo') }}'"
                                wrapper-class="col-12 col-sm-6 col-md-4"></form-input>
                        </div>

                        <div class="row g-3 mb-3">
                            <form-input label="Telefone" name="telefone" id="telefone" placeholder="Telefone" required
                                value="{{ old('telefone') }}" :server-error="'{{ $errors->first('telefone') }}'"
                                wrapper-class="col-12 col-sm-6 col-md-4"></form-input>

                            <form-input label="E-mail" name="email" id="email" type="email" placeholder="E-mail"
                                required value="{{ old('email') }}" :server-error="'{{ $errors->first('email') }}'"
                                wrapper-class="col-12 col-sm-6 col-md-8"></form-input>
                        </div>

                        <div class="row g-3 mb-3">
                            <form-input label="Logradouro" name="logradouro" id="logradouro" placeholder="Logradouro"
                                required value="{{ old('logradouro') }}"
                                :server-error="'{{ $errors->first('logradouro') }}'"
                                wrapper-class="col-12 col-sm-8 col-md-9"></form-input>

                            <form-input label="Número" name="numero" id="numero" placeholder="Número" type="number"
                                required value="{{ old('numero') }}" :server-error="'{{ $errors->first('numero') }}'"
                                wrapper-class="col-12 col-sm-4 col-md-3"></form-input>
                        </div>

                        <div class="row g-3 mb-3">
                            <form-input label="Município" name="municipio" id="municipio" placeholder="Município" required
                                value="{{ old('municipio') }}" :server-error="'{{ $errors->first('municipio') }}'"
                                wrapper-class="col-12 col-sm-8 col-md-9"></form-input>

                            <form-input label="Estado" name="estado" id="estado" placeholder="Estado" required
                                value="{{ old('estado') }}" :server-error="'{{ $errors->first('estado') }}'"
                                wrapper-class="col-12 col-sm-4 col-md-3"></form-input>
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
@endsection
