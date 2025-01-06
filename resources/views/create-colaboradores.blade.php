@extends('layouts.app')

@section('styles')
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // ### Faz a validação dos campos de preenchimento obrigatório ###
            const requiredInputs = document.querySelectorAll('input[required]');

            // Aplica o evento 'blur' a cada input
            requiredInputs.forEach(input => {
                input.addEventListener('blur', () => {
                    // Verifica se o campo está vazio
                    if (input.value.trim() === '') {
                        // Remove mensagem de erro duplicada, se houver
                        removeErrorMessage(input);

                        // Adiciona mensagem de erro
                        addErrorMessage(input, `O campo ${input.previousElementSibling.textContent.replace('*', '').trim()} é obrigatório`);
                        input.classList.add('is-invalid');
                    } else {
                        // Remove a mensagem de erro, se existir
                        removeErrorMessage(input);
                        input.classList.remove('is-invalid');
                    }
                });
            });

            // ### Faz a validação do E-mail ###
            const emailInput = document.getElementById('email');

            emailInput.addEventListener('blur', () => {
                const emailValue = emailInput.value.trim();

                // Regex para validar o formato do e-mail
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                // Verifica se o campo está vazio
                if (emailValue === '') {
                    // Remove mensagem de erro duplicada, se houver
                    removeErrorMessage(emailInput);

                    // Adiciona mensagem de erro
                    addErrorMessage(emailInput, 'O campo E-mail é obrigatório.');
                }
                // Verifica se o e-mail é inválido
                else if (!emailRegex.test(emailValue)) {
                    // Remove mensagem de erro duplicada, se houver
                    removeErrorMessage(emailInput);

                    // Adiciona mensagem de erro
                    addErrorMessage(emailInput, 'Insira um e-mail válido.');
                } else {
                    // Remove mensagem de erro e a classe inválida
                    removeErrorMessage(emailInput);
                }
            });

            // ### Faz a validação da sigla do estado exigindo 2 caracateres ###
            const estadoInput = document.getElementById('estado');

            estadoInput.addEventListener('blur', () => {
                const estadoValue = estadoInput.value.trim();

                // Verifica se o campo está vazio
                if (estadoValue === '') {
                    removeErrorMessage(estadoInput);
                    addErrorMessage(estadoInput, 'O campo Estado é obrigatório.');
                } 
                // Verifica se o campo possui exatamente 2 caracteres
                else if (estadoValue.length !== 2) {
                    removeErrorMessage(estadoInput);
                    addErrorMessage(estadoInput, 'O campo deve conter exatamente 2 caracteres.');
                } else {
                    // Remove a mensagem de erro, se existir
                    removeErrorMessage(estadoInput);
                }
            });

            // Função para adicionar uma mensagem de erro
            function addErrorMessage(input, message) {
                if (!input.nextElementSibling || !input.nextElementSibling.classList.contains('invalid-feedback')) {
                    input.insertAdjacentHTML(
                        'afterend',
                        `<div class="invalid-feedback">${message}</div>`
                    );
                }
                input.classList.add('is-invalid');
            }

            // Função para remover a mensagem de erro
            function removeErrorMessage(input) {
                if (input.nextElementSibling && input.nextElementSibling.classList.contains('invalid-feedback')) {
                    input.nextElementSibling.remove();
                }
                input.classList.remove('is-invalid');
            }
        });
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('colaborador.store') }}" method="post">
                    @csrf
                    <div class="conteudo-form">
                        @if (session('msg'))
                            <div class="alert {{ session('msg_type') == 'error' ? 'alert-danger' : 'alert-success' }}">
                                {{ session('msg') }}
                            </div>
                        @endif

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
