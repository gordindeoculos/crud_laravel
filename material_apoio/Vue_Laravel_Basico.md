# 🟢 **Guia Passo a Passo: Aprendendo Vue com Laravel**

---

## 📖 Introdução ao Vue.js com Laravel

**Vue.js** é uma ferramenta que usamos junto com o **JavaScript** para criar **páginas mais dinâmicas e interativas**. Ele é leve, fácil de aprender e funciona muito bem com o **Laravel**.

No dia a dia com Laravel, muitas vezes escrevemos o mesmo código várias vezes, como campos de formulário, botões e tabelas. Com o Vue, conseguimos transformar esses elementos em **componentes reutilizáveis**, ou seja, **blocos prontos que podemos usar quantas vezes quisermos**.

### ✨ O que o Vue pode fazer junto com o Laravel:

* Deixar os formulários mais inteligentes e fáceis de usar.
* Atualizar informações na tela sem recarregar a página inteira.
* Reaproveitar campos como `<InputField />` ou botões com apenas uma linha de código.
* Fazer validações e exibir mensagens de erro de forma automática e dinâmica.

### ✅ Por que usar o Vue com Laravel?

* Evita repetição de código.
* Deixa o sistema mais organizado e fácil de manter.
* Melhora a experiência do usuário (mais rápido e moderno).

> Em resumo: **o Vue ajuda a deixar o Laravel mais dinâmico e inteligente**, principalmente em sistemas com formulários, tabelas e interfaces que mudam com frequência.

---

## 🔹 **2. Instalação no Laravel (Laravel 11)**

### 📦 Passo 1: Instalar as dependências

Se estiver usando Vite (Laravel 11 usa por padrão):

```bash
npm install vue
```

### 📂 Passo 2: Habilitar Vue no Laravel

No `resources/js/app.js`:

```js
import { createApp } from 'vue';

const app = createApp({});

// Exemplo de componente
import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

// Monta a aplicação no HTML
app.mount('#app');
```

---

## 🔹 **3. Criar o primeiro componente Vue**

Crie um arquivo em `resources/js/components/HelloWorld.vue` com este conteúdo:

```vue
<template>
  <div>
    <h1>Olá, {{ nome }}!</h1>
    <input v-model="nome" placeholder="Digite seu nome">
  </div>
</template>

<script>
export default {
  data() {
    return {
      nome: 'Visitante'
    };
  }
};
</script>
```

---

## 🔹 **4. Usar o componente no Blade**

No seu `welcome.blade.php` ou qualquer view Blade:

```blade
<div id="app">
    <hello-world></hello-world>
</div>

@vite('resources/js/app.js')
```

---

## 🔹 **5. Rodar o Vite para ver no navegador**

No terminal:

```bash
npm run dev
```

Abra no navegador: `http://localhost:8000` e veja seu componente funcionando!

---

## 🔹 **6. Como funciona o Vue (conceitos básicos)**

| Conceito  | O que faz                                    | Exemplo                                     |
| --------- | -------------------------------------------- | ------------------------------------------- |
| `data()`  | Armazena os dados (variáveis)                | `nome: 'João'`                              |
| `v-model` | Liga o input a uma variável                  | `<input v-model="nome">`                    |
| `{{ }}`   | Interpolação de texto                        | `Olá, {{ nome }}`                           |
| `v-if`    | Renderiza se a condição for verdadeira       | `<p v-if="mostrar">Bem-vindo</p>`           |
| `v-for`   | Faz loop em listas                           | `<li v-for="item in lista">{{ item }}</li>` |
| `methods` | Define funções no componente                 | `this.saudacao()`                           |
| `props`   | Permite passar dados para o componente filho | `<componente titulo="Teste">`               |

---

## 🔹 **7. Exemplo com validação simples**

```vue
<template>
  <div>
    <input v-model="email" placeholder="Digite seu e-mail">
    <button @click="validar">Enviar</button>
    <p v-if="erro" style="color:red">{{ erro }}</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: '',
      erro: ''
    };
  },
  methods: {
    validar() {
      const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!regex.test(this.email)) {
        this.erro = 'E-mail inválido';
      } else {
        this.erro = '';
        alert('E-mail válido!');
      }
    }
  }
};
</script>
```

---

## 🔹 **8. Dicas para aprender melhor**

✅ Comece criando pequenos componentes
✅ Use o navegador com DevTools para ver erros
✅ Brinque com `data`, `v-model`, `v-if`, `v-for`
✅ Integre com formulários Blade passo a passo
✅ Use `@push('scripts')` no Blade para scripts extras
✅ Use `console.log()` para entender o que está acontecendo

---

## 🔹 **9. Recursos úteis**

* 📘 [Documentação oficial Vue 3 (em português)](https://br.vuejs.org/)
* 🧪 [Playground Vue online](https://play.vuejs.org/)
* 🧩 [Inertia.js (Vue + Laravel SPA)](https://inertiajs.com/) — para projetos maiores

---

## ✅ Conclusão

Você aprendeu:

* Como instalar e usar Vue no Laravel
* Como criar componentes básicos com reatividade
* Como usar em views Blade com `@vite`
* Como fazer validação simples

---

# 🧪 Projeto Prático: **Formulário de Cadastro com Vue + Laravel**

---

## ✅ 1. Criar o componente `FormularioUsuario.vue`

📁 Em `resources/js/components/FormularioUsuario.vue`:

```vue
<template>
  <form method="POST" action="/usuarios" @submit="validarFormulario">
    <input type="hidden" name="_token" :value="csrfToken">

    <!-- Nome -->
    <div class="mb-3">
      <label for="nome" class="form-label">Nome</label>
      <input
        id="nome"
        name="nome"
        type="text"
        class="form-control"
        v-model="form.nome"
        @blur="validarCampo('nome')"
        :class="{ 'is-invalid': erros.nome }"
      >
      <div v-if="erros.nome" class="invalid-feedback">{{ erros.nome }}</div>
    </div>

    <!-- E-mail -->
    <div class="mb-3">
      <label for="email" class="form-label">E-mail</label>
      <input
        id="email"
        name="email"
        type="email"
        class="form-control"
        v-model="form.email"
        @blur="validarCampo('email')"
        :class="{ 'is-invalid': erros.email }"
      >
      <div v-if="erros.email" class="invalid-feedback">{{ erros.email }}</div>
    </div>

    <!-- Senha -->
    <div class="mb-3">
      <label for="senha" class="form-label">Senha</label>
      <input
        id="senha"
        name="senha"
        type="password"
        class="form-control"
        v-model="form.senha"
        @blur="validarCampo('senha')"
        :class="{ 'is-invalid': erros.senha }"
      >
      <div v-if="erros.senha" class="invalid-feedback">{{ erros.senha }}</div>
    </div>

    <button type="submit" class="btn btn-primary">Cadastrar</button>
  </form>
</template>

<script>
export default {
  data() {
    return {
      form: {
        nome: '',
        email: '',
        senha: ''
      },
      erros: {
        nome: '',
        email: '',
        senha: ''
      },
      csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    };
  },
  methods: {
    validarCampo(campo) {
      if (this.form[campo].trim() === '') {
        this.erros[campo] = 'Campo obrigatório';
        return false;
      }

      if (campo === 'email') {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!regex.test(this.form.email)) {
          this.erros.email = 'E-mail inválido';
          return false;
        }
      }

      this.erros[campo] = '';
      return true;
    },
    validarFormulario(e) {
      let valido = true;

      for (let campo in this.form) {
        if (!this.validarCampo(campo)) {
          valido = false;
        }
      }

      if (!valido) {
        e.preventDefault(); // Impede envio se tiver erro
      }
    }
  }
};
</script>
```

---

## ✅ 2. Registrar o componente em `app.js`

Em `resources/js/app.js`:

```js
import { createApp } from 'vue';

import FormularioUsuario from './components/FormularioUsuario.vue';

const app = createApp({});
app.component('formulario-usuario', FormularioUsuario);

app.mount('#app');
```

---

## ✅ 3. Criar a view Blade

📄 Em `resources/views/usuarios/create.blade.php`:

```blade
@extends('layouts.app')

@section('content')
  <div class="container">
    <h2>Cadastro de Usuário</h2>
    <div id="app">
      <formulario-usuario></formulario-usuario>
    </div>
  </div>
@endsection

@push('scripts')
  @vite('resources/js/app.js')
@endpush
```

---

## ✅ 4. Adicionar rota e controller no Laravel

📁 `routes/web.php`:

```php
use App\Http\Controllers\UsuarioController;

Route::get('/usuarios/create', [UsuarioController::class, 'create']);
Route::post('/usuarios', [UsuarioController::class, 'store']);
```

📁 `app/Http/Controllers/UsuarioController.php`:

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string',
            'email' => 'required|email',
            'senha' => 'required|min:6',
        ]);

        // Aqui você pode salvar no banco se quiser
        return redirect('/usuarios/create')->with('success', 'Usuário cadastrado com sucesso!');
    }
}
```

---

## ✅ 5. Rodar o projeto

```bash
php artisan serve
npm run dev
```

Acesse: `http://localhost:8000/usuarios/create`

---

## 🧪 Extras

* ✅ Validação front-end com Vue
* ✅ Validação back-end com Laravel
* ✅ Integração via formulário tradicional (sem axios)
* ✅ Campo CSRF incluso via `meta`

---

# Formulário Create do Projeto utilizando componente Vue

## Controlador - `app\Http\Controllers\ColaboradorController.php`

```php
public function createvue()
{
    return view('create-colaborador-vue');
}

public function editvue(string $id)
{
    $colaborador = Colaborador::findOrFail($id);
    return view('edit-colaborador-vue', compact('colaborador'));
}
```

## Views

### View - `resources\views\create-colaborador-vue.blade.php`

```php
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
```

### View - `resources\views\edit-colaborador-vue.blade.php`

```php
@extends('layouts.app')

@section('styles')
@endsection

@section('scripts')
    <script src="{{ asset('js/validacao-formulario.js') }}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('colaborador.update', $colaborador->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="conteudo-form">
                        <div class="card">
                            <div class="card-header">
                                Formulário de Edição de Colaboradores
                            </div>

                            <div class="card-body bg-white">
                                <p>Os campos com * são de preenchimento obrigatório.</p>

                                <div class="row g-3 mb-3">
                                    <!-- Nome -->
                                    <div class="col-12 col-sm-6 col-md-8">
                                        <input-field id="nome" label="Nome" tipo="text" placeholder="Nome"
                                            :requerido="true" :valor-inicial="'{{ old('nome', $colaborador->nome) }}'"
                                            mensagem-erro="{{ $errors->first('nome') ? e($errors->first('nome')) : '' }}"
                                            mensagem-erro-padrao="Preenchimento obrigatório."></input-field>
                                    </div>

                                    <!-- Cargo -->
                                    <div class="col-12 col-sm-6 col-md-4">
                                        <input-field id="cargo" label="Cargo" tipo="text" placeholder="Cargo"
                                            :requerido="true"
                                            :valor-inicial="'{{ old('cargo', $colaborador->cargo) }}'"
                                            mensagem-erro="{{ $errors->first('cargo') ? e($errors->first('cargo')) : '' }}"
                                            mensagem-erro-padrao="Preenchimento obrigatório."></input-field>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <!-- Telefone -->
                                    <div class="col-12 col-sm-6 col-md-4">
                                        <input-field id="telefone" label="Telefone" tipo="text"
                                            placeholder="(99) 99999-9999" :requerido="true"
                                            :valor-inicial="'{{ old('telefone', $colaborador->telefone) }}'"
                                            mensagem-erro="{{ $errors->first('telefone') ? e($errors->first('telefone')) : '' }}"
                                            mensagem-erro-padrao="Digite um telefone válido no formato (99) 99999-9999."></input-field>
                                    </div>

                                    <!-- E-mail -->
                                    <div class="col-12 col-sm-6 col-md-8">
                                        <input-field id="email" label="E-mail" tipo="email"
                                            placeholder="Digite seu e-mail" :requerido="true"
                                            :valor-inicial="'{{ old('email', $colaborador->email) }}'"
                                            mensagem-erro="{{ $errors->first('email') ? e($errors->first('email')) : '' }}"
                                            mensagem-erro-padrao="E-mail inválido."></input-field>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <!-- Logradouro -->
                                    <div class="col-12 col-sm-8 col-md-9">
                                        <input-field id="logradouro" label="Logradouro" tipo="text"
                                            placeholder="Logradouro" :requerido="true"
                                            :valor-inicial="'{{ old('logradouro', $colaborador->logradouro) }}'"
                                            mensagem-erro="{{ $errors->first('logradouro') ? e($errors->first('logradouro')) : '' }}"
                                            mensagem-erro-padrao="Preenchimento obrigatório."></input-field>
                                    </div>

                                    <!-- Número -->
                                    <div class="col-12 col-sm-4 col-md-3">
                                        <input-field id="numero" label="Número" tipo="text" placeholder="Número"
                                            :requerido="true"
                                            :valor-inicial="'{{ old('numero', $colaborador->numero) }}'"
                                            mensagem-erro="{{ $errors->first('numero') ? e($errors->first('numero')) : '' }}"
                                            mensagem-erro-padrao="Preenchimento obrigatório."></input-field>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <!-- Município -->
                                    <div class="col-12 col-sm-8 col-md-9">
                                        <input-field id="municipio" label="Município" tipo="text" placeholder="Município"
                                            :requerido="true"
                                            :valor-inicial="'{{ old('municipio', $colaborador->municipio) }}'"
                                            mensagem-erro="{{ $errors->first('municipio') ? e($errors->first('municipio')) : '' }}"
                                            mensagem-erro-padrao="Preenchimento obrigatório."></input-field>
                                    </div>

                                    <!-- Estado -->
                                    <div class="col-12 col-sm-4 col-md-3">
                                        <input-field id="estado" label="Estado" tipo="text" placeholder="UF"
                                            :requerido="true"
                                            :valor-inicial="'{{ old('estado', $colaborador->estado) }}'"
                                            mensagem-erro="{{ $errors->first('estado') ? e($errors->first('estado')) : '' }}"
                                            mensagem-erro-padrao="Deve conter exatamente 2 letras."></input-field>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="col-auto">
                                    <a href="{{ route('coloborador.list') }}" class="btn btn-secondary me-2">Voltar</a>
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
```

## Rotas - `routes\web.php`

```php
Route::get('/create-colaborador-vue', [ColaboradorController::class, 'createvue'])->name('colaborador.createvue');

Route::get('/edit-colaborador-vue/{id}', [ColaboradorController::class, 'editvue'])->name('colaborador.editvue');
```