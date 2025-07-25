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
                    <h3 class="m-0">Sistema Colaboradores</h3>
                </div>
                <div class="card-body">
                    <p><a href="{{ route('coloborador.list') }}" class="link-primary">Listagem de Colabordores</a></p>
                    <p><a href="{{ route('exemplovue') }}" class="link-primary">Exemplo Vue</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
