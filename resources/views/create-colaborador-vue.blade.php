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
                                        <input-field id="nome" label="Nome" tipo="text" placeholder="Nome"
                                            :requerido="true" :valor-inicial="'{{ old('nome') }}'"
                                            mensagem-erro="{{ $errors->first('nome') ? e($errors->first('nome')) : '' }}"
                                            mensagem-erro-padrao="Preenchimento obrigatório."></input-field>
                                    </div>

                                    <!-- Cargo -->
                                    <div class="col-12 col-sm-6 col-md-4">
                                        <input-field id="cargo" label="Cargo" tipo="text" placeholder="Cargo"
                                            :requerido="true" :valor-inicial="'{{ old('cargo') }}'"
                                            mensagem-erro="{{ $errors->first('cargo') ? e($errors->first('cargo')) : '' }}"
                                            mensagem-erro-padrao="Preenchimento obrigatório."></input-field>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <!-- Telefone -->
                                    <div class="col-12 col-sm-6 col-md-4">
                                        <input-field id="telefone" label="Telefone" tipo="text"
                                            placeholder="(99) 99999-9999" :requerido="true"
                                            :valor-inicial="'{{ old('telefone') }}'"
                                            mensagem-erro="{{ $errors->first('telefone') ? e($errors->first('telefone')) : '' }}"
                                            mensagem-erro-padrao="Digite um telefone válido no formato (99) 99999-9999."></input-field>
                                    </div>

                                    <!-- E-mail -->
                                    <div class="col-12 col-sm-6 col-md-8">
                                        <input-field id="email" label="E-mail" tipo="email"
                                            placeholder="Digite seu e-mail" :requerido="true"
                                            :valor-inicial="'{{ old('email') }}'"
                                            mensagem-erro="{{ $errors->first('email') ? e($errors->first('email')) : '' }}"
                                            mensagem-erro-padrao="E-mail inválido."></input-field>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <!-- Logradouro -->
                                    <div class="col-12 col-sm-8 col-md-9">
                                        <input-field id="logradouro" label="Logradouro" tipo="text"
                                            placeholder="Logradouro" :requerido="true"
                                            :valor-inicial="'{{ old('logradouro') }}'"
                                            mensagem-erro="{{ $errors->first('logradouro') ? e($errors->first('logradouro')) : '' }}"
                                            mensagem-erro-padrao="Preenchimento obrigatório."></input-field>
                                    </div>

                                    <!-- Número -->
                                    <div class="col-12 col-sm-4 col-md-3">
                                        <input-field id="numero" label="Número" tipo="text" placeholder="Número"
                                            :requerido="true" :valor-inicial="'{{ old('numero') }}'"
                                            mensagem-erro="{{ $errors->first('numero') ? e($errors->first('numero')) : '' }}"
                                            mensagem-erro-padrao="Preenchimento obrigatório."></input-field>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <!-- Município -->
                                    <div class="col-12 col-sm-8 col-md-9">
                                        <input-field id="municipio" label="Município" tipo="text" placeholder="Município"
                                            :requerido="true" :valor-inicial="'{{ old('municipio') }}'"
                                            mensagem-erro="{{ $errors->first('municipio') ? e($errors->first('municipio')) : '' }}"
                                            mensagem-erro-padrao="Preenchimento obrigatório."></input-field>
                                    </div>

                                    <!-- Estado -->
                                    <div class="col-12 col-sm-4 col-md-3">
                                        <input-field id="estado" label="Estado" tipo="text" placeholder="UF"
                                            :requerido="true" :valor-inicial="'{{ old('estado') }}'"
                                            mensagem-erro="{{ $errors->first('estado') ? e($errors->first('estado')) : '' }}"
                                            mensagem-erro-padrao="Deve conter exatamente 2 letras."></input-field>
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
