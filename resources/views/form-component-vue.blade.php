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
                                <input-field id="nome" label="Nome Completo" placeholder="Digite seu nome"
                                    tipo="text" :requerido="true" mensagem-erro="Nome é obrigatório"></input-field>

                                <input-field id="email" label="E-mail" placeholder="Digite seu e-mail" tipo="email"
                                    :requerido="true" mensagem-erro="E-mail inválido"></input-field>
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
