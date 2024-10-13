@extends('layouts.app')

@section('styles')
    <style>
        .conteudo-form {
            margin: 10px;
            padding: 10px;
        }

        .conteudo-form input {
            margin-bottom: 10px;
            width: 50%;
        }

        .conteudo-form input[type="submit"] {
            margin-top: 10px;
            width: 100px;
        }
    </style>
@endsection

@section('scripts')
@endsection

@section('content')
    <form action="" method="post">
        <div class="conteudo-form">
            <h1>Formulário de Cadastro de Colaboradores</h1>
            <label for="nome">Nome:</label>
            <br>
            <input type="text" name="nome" id="nome">
            <br>
            <label for="cargo">Cargo:</label>
            <br>
            <input type="text" name="cargo" id="cargo">
            <br>
            <label for="telefone">Telefone:</label>
            <br>
            <input type="text" name="telefone" id="telefone">
            <br>
            <label for="email">E-mail:</label>
            <br>
            <input type="email" name="email" id="email">
            <br>
            <label for="logradouro">Logradouro:</label>
            <br>
            <input type="text" name="logradouro" id="logradouro">
            <br>
            <label for="numero">Número:</label>
            <br>
            <input type="text" name="numero" id="numero">
            <br>
            <label for="municipio">Município:</label>
            <br>
            <input type="text" name="municipio" id="municipio">
            <br>
            <label for="estado">Estado:</label>
            <br>
            <input type="text" name="estado" id="estado">
            <br>
            <input type="submit" value="Enviar">
        </div>
    </form>
@endsection
