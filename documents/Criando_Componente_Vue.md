# Tutorial: Criando e Usando um Componente Vue.js Básico no Laravel 11

Este guia mostra como criar e registrar um **componente Vue.js simples** dentro de um projeto **Laravel 11** — seja ele baseado em **Breeze, Jetstream ou Inertia**.

O componente será um campo de formulário reutilizável (`FormInput.vue`) com `label`, `placeholder`, `v-model` interno e exibição do valor atual.

---

## Estrutura do Projeto

Certifique-se de que o Vue.js já está configurado no seu projeto.
Você deve ter um arquivo principal em:

```
resources/js/app.js
```

E seus componentes ficam em:

```
resources/js/components/
```

---

## Criando o Componente Vue

Crie o arquivo:

```
resources/js/components/FormInput.vue
```

E adicione o seguinte conteúdo:

```vue
<template>
  <div class="mb-3">
    <label :for="id" class="form-label">{{ label }}</label>
    <input
      :type="type"
      class="form-control"
      :name="name"
      :id="id"
      :placeholder="placeholder"
      :required="required"
      v-model="inputValue"
    />
    <p class="mt-1 text-muted">Valor atual: {{ inputValue }}</p>
  </div>
</template>

<script>
export default {
  name: 'FormInput',
  props: {
    label: { type: String, default: '' },
    type: { type: String, default: 'text' },
    name: { type: String, required: true },
    id: { type: String, required: true },
    placeholder: { type: String, default: '' },
    required: { type: Boolean, default: false },
  },
  data() {
    return {
      inputValue: '' // valor interno do input
    }
  },
  mounted() {
    console.log(`Componente ${this.id} montado.`)
  }
}
</script>

<style scoped>
.text-muted {
  font-size: 0.9rem;
}
</style>
```

💡 **Explicação rápida:**

* `v-model="inputValue"` mantém o valor digitado dentro do próprio componente.
* As `props` permitem configurar o campo dinamicamente (label, id, placeholder, etc.).
* O valor atual é exibido logo abaixo do campo apenas para demonstração.

---

## 3. Registrando o Componente

No arquivo `resources/js/app.js`, importe e registre o componente:

```js
import './bootstrap';
import { createApp } from 'vue';

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
import FormInput from './components/FormInput.vue';

app.component('example-component', ExampleComponent);
app.component('form-input', FormInput);

app.mount('#app');
```

---

## Usando o Componente no Blade

No seu arquivo Blade (por exemplo, `resources\views\testevue.blade.php`), adicione:

```blade
@extends('layouts.app')

@section('content')
    <div class="container p-3 bg-white">
        <h4 class="mb-3">Cadastro</h4>

        <form-input 
            label="Nome"
            name="nome"
            id="nome"
            placeholder="Digite seu nome"
            required
        ></form-input>

        <form-input 
            label="E-mail"
            name="email"
            id="email"
            type="email"
            placeholder="Digite seu e-mail"
            required
        ></form-input>
    </div>
@endsection
```

---

## O que está acontecendo

* O Vue monta o app dentro do elemento `#app` que já está configurado em `resources\views\layouts\app.blade.php`.
* O componente `<form-input>` é renderizado com os atributos informados.
* Cada campo guarda internamente seu valor (`inputValue`), exibido logo abaixo do input.
* O valor pode ser acessado, validado ou enviado via **AJAX** dentro do próprio componente.

---

## Vantagens desse modelo

✅ Componente totalmente **reutilizável** em qualquer formulário.
✅ Permite **padronizar** o estilo e comportamento dos inputs.
✅ Pode ser facilmente expandido (validação, eventos, máscaras etc.).
✅ Dispensa declarar `data()` ou `v-model` no `app.js` ou no Blade.

---

## Testando o componente `FormInput.vue`

Para verificar se o formulário está funcionando corretamente:

**Compile os assets do Vue e Laravel com Vite**

No terminal, na raiz do projeto, rode:

```bash
npm run dev
```

O terminal mostrará algo assim:

```
$ npm run dev

> dev
> vite


  VITE v5.2.11  ready in 463 ms

  ➜  Local:   http://localhost:5173/
  ➜  Network: use --host to expose
  ➜  press h + enter to show help

  LARAVEL v11.0.8  plugin v1.0.2

  ➜  APP_URL: http://localhost:8000
```

Isso inicia o **servidor de desenvolvimento do Vite**, compilando os arquivos Vue automaticamente sempre que salvar alterações nos componentes.

**Inicie o servidor do Laravel**

Abra outro terminal (ou aba) e execute:

```bash
php artisan serve
```

O Laravel iniciará um servidor local, geralmente acessível em:

```
http://localhost:8000
```

**Acesse a página de teste**

Abra no navegador o link da rota que contém o formulário, por exemplo:

```
http://localhost:8000/testevue
```

**Testar o formulário**

* Digite valores nos campos e veja a validação do Vue (`required`) funcionando.
* Se houver erros do Laravel, eles aparecerão dentro dos inputs via `$errors->first('campo')`.
* Os valores antigos (`old('campo')`) permanecem após erro de submissão.

**Finalizar e gerar build de produção**

Após testar e confirmar que tudo funciona:

1. Interrompa o servidor de desenvolvimento do Vite (`Ctrl + C` no terminal do `npm run dev`).
2. Gere os assets otimizados para produção com:

```bash
npm run build
```

Isso criará os arquivos compilados na pasta `public/build` (ou conforme sua configuração do Vite/Laravel Mix).

---

## Conclusão

Você acabou de criar um **componente Vue.js funcional e reutilizável** dentro do **Laravel 11**, sem precisar de bibliotecas externas.

Isso é uma ótima base para criar sua própria **biblioteca de componentes** (inputs, selects, botões, alertas etc.) para uso em todo o sistema.

---

# Adicionando validação de campo requerido

Podemos adicionar **validação interna no próprio componente** para verificar se o campo é `required` e exibir uma mensagem quando o usuário tentar enviar ou quando o input estiver vazio.

Veja como fazer isso **de forma simples e totalmente dentro do componente**:

---

### `FormInput.vue` com validação de `required`

```vue
<template>
  <div class="mb-3">
    <label :for="id" class="form-label">{{ label }}</label>
    <input
      :type="type"
      class="form-control"
      :name="name"
      :id="id"
      :placeholder="placeholder"
      v-model="inputValue"
      :required="required"
      @blur="checkRequired"
    />
    <!-- Mensagem de validação -->
    <p v-if="errorMessage" class="text-danger mt-1">{{ errorMessage }}</p>
  </div>
</template>

<script>
export default {
  name: 'FormInput',
  props: {
    label: { type: String, default: '' },
    type: { type: String, default: 'text' },
    name: { type: String, required: true },
    id: { type: String, required: true },
    placeholder: { type: String, default: '' },
    required: { type: Boolean, default: false },
  },
  data() {
    return {
      inputValue: '',     // Valor do input
      errorMessage: ''    // Mensagem de erro
    }
  },
  methods: {
    checkRequired() {
      if (this.required && !this.inputValue.trim()) {
        this.errorMessage = 'Este campo é de preenchimento obrigatório.'
      } else {
        this.errorMessage = ''
      }
    }
  }
}
</script>
```

---

### Como funciona:

1. **Prop `required`**

   * Se `true`, o componente vai validar o preenchimento do input.

2. **Evento `@blur`**

   * A validação é feita quando o usuário sai do campo (`blur`).

3. **Mensagem de erro (`errorMessage`)**

   * Se o campo estiver vazio e for `required`, mostra:

     > "Este campo é de preenchimento obrigatório."

4. **Flexível**

   * Você ainda pode adicionar mais validações (email, número, regex) dentro do método `checkRequired`.

---

## Testando o componente `FormInput.vue`

Para verificar se o formulário está funcionando corretamente:

**Compile os assets do Vue e Laravel com Vite**

No terminal, na raiz do projeto, rode:

```bash
npm run dev
```

O terminal mostrará algo assim:

```
$ npm run dev

> dev
> vite


  VITE v5.2.11  ready in 463 ms

  ➜  Local:   http://localhost:5173/
  ➜  Network: use --host to expose
  ➜  press h + enter to show help

  LARAVEL v11.0.8  plugin v1.0.2

  ➜  APP_URL: http://localhost:8000
```

Isso inicia o **servidor de desenvolvimento do Vite**, compilando os arquivos Vue automaticamente sempre que salvar alterações nos componentes.

**Inicie o servidor do Laravel**

Abra outro terminal (ou aba) e execute:

```bash
php artisan serve
```

O Laravel iniciará um servidor local, geralmente acessível em:

```
http://localhost:8000
```

**Acesse a página de teste**

Abra no navegador o link da rota que contém o formulário, por exemplo:

```
http://localhost:8000/testevue
```

**Testar o formulário**

* Digite valores nos campos e veja a validação do Vue (`required`) funcionando.
* Se houver erros do Laravel, eles aparecerão dentro dos inputs via `$errors->first('campo')`.
* Os valores antigos (`old('campo')`) permanecem após erro de submissão.

**Finalizar e gerar build de produção**

Após testar e confirmar que tudo funciona:

1. Interrompa o servidor de desenvolvimento do Vite (`Ctrl + C` no terminal do `npm run dev`).
2. Gere os assets otimizados para produção com:

```bash
npm run build
```

Isso criará os arquivos compilados na pasta `public/build` (ou conforme sua configuração do Vite/Laravel Mix).

---

# Criando o formulário com componente `FormInput.vue`

---

## Componente Vue `FormInput.vue`

Crie ou atualize o arquivo:

```
resources/js/components/FormInput.vue
```

Com o seguinte conteúdo:

```vue
<template>
  <div :class="wrapperClass">
    <label :for="id" class="form-label">
      {{ label }} <span v-if="required">*</span>
    </label>

    <input
      :type="type"
      :name="name"
      :id="id"
      class="form-control"
      :class="{ 'is-invalid': serverError || errorMessage }"
      :placeholder="placeholder"
      v-model="internalValue"
      :required="required"
      @blur="checkRequired"
    />

    <!-- mensagem do Laravel -->
    <div v-if="serverError" class="invalid-feedback">{{ serverError }}</div>
    <!-- mensagem de validação do Vue -->
    <div v-else-if="errorMessage" class="invalid-feedback">{{ errorMessage }}</div>
  </div>
</template>

<script>
export default {
  name: 'FormInput',
  props: {
    label: { type: String, default: '' },
    type: { type: String, default: 'text' },
    name: { type: String, required: true },
    id: { type: String, required: true },
    placeholder: { type: String, default: '' },
    required: { type: Boolean, default: false },
    value: { type: String, default: '' },
    wrapperClass: { type: String, default: 'col-12 col-sm-6 col-md-8' },
    serverError: { type: String, default: '' }
  },
  data() {
    return {
      internalValue: this.value,
      errorMessage: ''
    }
  },
  watch: {
    // Mantém o internalValue sincronizado com a prop
    value(newVal) {
      this.internalValue = newVal
    },
    internalValue(newVal) {
      // Emite atualização para o pai
      this.$emit('update:value', newVal)
    }
  },
  methods: {
    checkRequired() {
      if (this.required && !this.internalValue.trim()) {
        this.errorMessage = 'Este campo é de preenchimento obrigatório.'
      } else {
        this.errorMessage = ''
      }
    }
  }
}
</script>
```

---

## Usando o componente no Blade

Em `resources\views\testevue.blade.php` atualize com o código abaixo:

```blade
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

                            <form-input label="Número" name="numero" id="numero" placeholder="Número" type="text"
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
```

---

### ✅ Benefícios desta abordagem

* Mantém os valores antigos (`old('campo')`) após erro de validação.
* Exibe **mensagens de erro do Laravel** dentro do componente (`$errors->first('campo')`).
* Faz validação simples no frontend (`required`) com Vue.
* Facilita a **reutilização do componente** em outros formulários.

---

## Testando o componente `FormInput.vue`

Para verificar se o formulário está funcionando corretamente:

**Compile os assets do Vue e Laravel com Vite**

No terminal, na raiz do projeto, rode:

```bash
npm run dev
```

O terminal mostrará algo assim:

```
$ npm run dev

> dev
> vite


  VITE v5.2.11  ready in 463 ms

  ➜  Local:   http://localhost:5173/
  ➜  Network: use --host to expose
  ➜  press h + enter to show help

  LARAVEL v11.0.8  plugin v1.0.2

  ➜  APP_URL: http://localhost:8000
```

Isso inicia o **servidor de desenvolvimento do Vite**, compilando os arquivos Vue automaticamente sempre que salvar alterações nos componentes.

**Inicie o servidor do Laravel**

Abra outro terminal (ou aba) e execute:

```bash
php artisan serve
```

O Laravel iniciará um servidor local, geralmente acessível em:

```
http://localhost:8000
```

**Acesse a página de teste**

Abra no navegador o link da rota que contém o formulário, por exemplo:

```
http://localhost:8000/testevue
```

**Testar o formulário**

* Digite valores nos campos e veja a validação do Vue (`required`) funcionando.
* Se houver erros do Laravel, eles aparecerão dentro dos inputs via `$errors->first('campo')`.
* Os valores antigos (`old('campo')`) permanecem após erro de submissão.

**Finalizar e gerar build de produção**

Após testar e confirmar que tudo funciona:

1. Interrompa o servidor de desenvolvimento do Vite (`Ctrl + C` no terminal do `npm run dev`).
2. Gere os assets otimizados para produção com:

```bash
npm run build
```

Isso criará os arquivos compilados na pasta `public/build` (ou conforme sua configuração do Vite/Laravel Mix).

---