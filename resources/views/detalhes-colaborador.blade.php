@extends('layouts.app')

@section('styles')
@endsection

@section('scripts')
@endsection

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">
                    <h3 class="m-0">Informações do Colaborador</h3>
                </div>
                <div class="card-body">
                    <p class="card-text"><b>Nome:</b> {{ $colaborador->nome }}</p>
                    <p class="card-text"><b>Cargo:</b> {{ $colaborador->cargo }}</p>
                    <p class="card-text"><b>Telefone:</b> {{ $colaborador->telefone }}</p>
                    <p class="card-text"><b>E-mail:</b> {{ $colaborador->email }}</p>
                    <p class="card-text"><b>Endereço:</b> {{ $colaborador->logradouro }}, nº {{ $colaborador->numero }}</p>
                    <p class="card-text"><b>Município:</b> {{ $colaborador->municipio }}/{{ $colaborador->estado }}</p>
                    <hr>
                    <a href="{{ route('colaborador.list') }}" class="btn btn-primary">Voltar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
