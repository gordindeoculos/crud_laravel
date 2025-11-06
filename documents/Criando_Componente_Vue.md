# Criando e Usando um Componente Vue.js Básico no Laravel 11

Este guia mostra como criar e registrar um **componente Vue.js simples** dentro de um projeto **Laravel 11** — seja ele baseado em **Breeze, Jetstream ou Inertia**.

O objetivo deste tutorial é demonstrar como criar e utilizar um componente no Vue.js. Para isso, vamos desenvolver um componente que será utilizado nos formulários de cadastro e edição de colaboradores do nosso projeto CRUD com Laravel 11.

Para facilitar o entendimento, começaremos com a criação de um componente básico e, aos poucos, adicionaremos novas funcionalidades até chegarmos à versão final — capaz de realizar toda a validação dos campos do formulário.

Vale ressaltar que o foco deste tutorial não é o estudo aprofundado do Vue.js, mas sim a compreensão prática de como esse recurso pode ser aplicado em nosso projeto.

O componente será um campo de formulário reutilizável (`FormInput.vue`) com `label`, `placeholder`, `v-model` interno e exibição do valor atual.

---

## 1. Estrutura do Projeto

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

## 2. Criando o Componente Vue

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

**Explicação rápida:**

* `v-model="inputValue"` mantém o valor digitado dentro do próprio componente.
* As `props` permitem configurar o campo dinamicamente (label, id, placeholder, etc.).
* O valor atual é exibido logo abaixo do campo apenas para demonstração.

---

## 3. Registrando o Componente

No arquivo `resources/js/app.js`, importe e registre o componente:

```js
import './bootstrap';
// import './validacao-formulario'   <--- Comente esta linha para desabilitar a validacao do arquivo validacao-formulario.js
import { createApp } from 'vue';

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
import FormInput from './components/FormInput.vue';

app.component('example-component', ExampleComponent);
app.component('form-input', FormInput);

app.mount('#app');
```

---

## 4. Usando o Componente no Blade

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

### O que está acontecendo

* O Vue monta o app dentro do elemento `#app` que já está configurado em `resources\views\layouts\app.blade.php`.
* O componente `<form-input>` é renderizado com os atributos informados.
* Cada campo guarda internamente seu valor (`inputValue`), exibido logo abaixo do input.
* O valor pode ser acessado, validado ou enviado via **AJAX** dentro do próprio componente.

---

### Vantagens desse modelo

* Componente totalmente **reutilizável** em qualquer formulário.
* Permite **padronizar** o estilo e comportamento dos inputs.
* Pode ser facilmente expandido (validação, eventos, máscaras etc.).
* Dispensa declarar `data()` ou `v-model` no `app.js` ou no Blade.

---

## 5. Testando o componente `FormInput.vue`

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

* Digite valores nos campos e veja a validação do Vue funcionando.

**Finalizar e gerar build de produção**

Após testar e confirmar que tudo funciona:

1. Interrompa o servidor de desenvolvimento do Vite (`Ctrl + C` no terminal do `npm run dev`).
2. Gere os assets otimizados para produção com:

```bash
npm run build
```

Isso criará os arquivos compilados na pasta `public/build` (ou conforme sua configuração do Vite/Laravel Mix).

---

## 6. Conclusão

Você acabou de criar um **componente Vue.js funcional e reutilizável** dentro do **Laravel 11**, sem precisar de bibliotecas externas.

Isso é uma ótima base para criar sua própria **biblioteca de componentes** (inputs, selects, botões, alertas etc.) para uso em todo o sistema.

---

## 7. Adicionando validação de campo requerido

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

**Prop `required`**

   * Se `true`, o componente vai validar o preenchimento do input.

**Evento `@blur`**

  * A validação é feita quando o usuário sai do campo (`blur`).

**Mensagem de erro (`errorMessage`)**

  * Se o campo estiver vazio e for `required`, mostra:

    > "Este campo é de preenchimento obrigatório."

**Flexível**

  * Você ainda pode adicionar mais validações (email, número, regex) dentro do método `checkRequired`.

---

### Testando o componente `FormInput.vue`

Se tiver dúvida de quais comandos executar para suber o servidor de desenvolvimento Vite e do Laravel, veja no **item 5**.

---

## 8. Criando o formulário com o uso do componente `FormInput.vue`

---

### Componente Vue `FormInput.vue`

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

### Usando o componente no Blade

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

### Benefícios desta abordagem

* Mantém os valores antigos (`old('campo')`) após erro de validação.
* Exibe **mensagens de erro do Laravel** dentro do componente (`$errors->first('campo')`).
* Faz validação simples no frontend (`required`) com Vue.
* Facilita a **reutilização do componente** em outros formulários.

---

### Testando o componente `FormInput.vue`

Se tiver dúvida de quais comandos executar para suber o servidor de desenvolvimento Vite e do Laravel, veja no **item 5**.

---

## 9. Modificar o componente `FormInput.vue` para fazer a validação do e-mail

Vamos aprimorar o componente para suportar **validação de e-mail**, mantendo a integração com Laravel. A ideia é:

1. Usar a prop `type` para definir se é `"text"` ou `"email"`.
2. Se for `"email"`, o input será `type="email"`.
3. Adicionar um método `checkEmail` que valida se o valor é um e-mail válido.
4. Combinar com a validação `required`.

---

### Componente atualizado: `FormInput.vue`

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
      v-model="inputValue"
      :required="required"
      @blur="checkInput"
    />

    <div v-if="serverError" class="invalid-feedback">{{ serverError }}</div>
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
      inputValue: this.value,
      errorMessage: ''
    }
  },
  methods: {
    checkInput() {
      const val = this.inputValue.trim();

      // Required
      if (this.required && !val) {
        this.errorMessage = 'Este campo é de preenchimento obrigatório.';
        return;
      }

      // Validação de e-mail
      if (this.type === 'email' && val && !this.isValidEmail(val)) {
        this.errorMessage = 'Por favor, insira um e-mail válido.';
        return;
      }

      this.errorMessage = '';
    },
    isValidEmail(email) {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return re.test(email);
    }
  }
}
</script>
```

---

### Atualize o componente para o e-mail no arquivo `resources\views\testevue.blade.php` conforme abaixo:

```blade
<form-input
    label="E-mail"
    name="email"
    id="email"
    type="email"
    placeholder="Digite seu e-mail"
    required
    value="{{ old('email') }}"
    :server-error="'{{ $errors->first('email') }}'"
    wrapper-class="col-12 col-sm-6 col-md-8"
></form-input>
```

---

**O que mudou:**

- Agora o input muda automaticamente para `type="email"` se a prop `type` for `"email"`.
- Adicionamos validação de e-mail no método `checkInput()`.
- Mantemos a validação `required` e as mensagens de erro do Laravel.
- Continua funcionando com Laravel `old()` e `$errors`.

---

### Testando o componente `FormInput.vue`

Se tiver dúvida de quais comandos executar para suber o servidor de desenvolvimento Vite e do Laravel, veja no **item 5**.

---

## 10. Modificar o componente `FormInput.vue` para fazer a validação do telefone

Podemos adicionar ao componente a validação de **telefone** de forma semelhante à validação de e-mail, usando:

- Uma prop `type="tel"` para indicar que o input é de telefone.
- Um método `isValidPhone` que usa a expressão regular que você forneceu.
- A validação será feita ao perder o foco (`@blur`) ou quando o campo for required.

---

### Componente atualizado `FormInput.vue` com validação de telefone

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
      v-model="inputValue"
      :required="required"
      @blur="checkInput"
      :pattern="phonePattern"
      :title="phoneTitle"
    />

    <div v-if="serverError" class="invalid-feedback">{{ serverError }}</div>
    <div v-else-if="errorMessage" class="invalid-feedback">{{ errorMessage }}</div>
  </div>
</template>

<script>
export default {
  name: 'FormInput',
  props: {
    label: { type: String, default: '' },
    type: { type: String, default: 'text' }, // "text", "email", "tel"
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
      inputValue: this.value,
      errorMessage: ''
    }
  },
  computed: {
    phonePattern() {
      return this.type === 'tel'
        ? '\\(\\d{2}\\) \\d{4,5}-\\d{4}'
        : null
    },
    phoneTitle() {
      return this.type === 'tel'
        ? 'Digite um telefone no formato (99) 9999-9999 ou (99) 99999-9999'
        : null
    }
  },
  methods: {
    checkInput() {
      const val = this.inputValue.trim()

      // Required
      if (this.required && !val) {
        this.errorMessage = 'Este campo é de preenchimento obrigatório.'
        return
      }

      // Validação de e-mail
      if (this.type === 'email' && val && !this.isValidEmail(val)) {
        this.errorMessage = 'Por favor, insira um e-mail válido.'
        return
      }

      // Validação de telefone
      if (this.type === 'tel' && val && !this.isValidPhone(val)) {
        this.errorMessage = 'Digite um telefone no formato (99) 9999-9999 ou (99) 99999-9999.'
        return
      }

      // Limpa mensagem de erro
      this.errorMessage = ''
    },

    isValidEmail(email) {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
      return re.test(email)
    },

    isValidPhone(phone) {
      const re = /^\(\d{2}\) \d{4,5}-\d{4}$/
      return re.test(phone)
    }
  }
}
</script>
```

---

### Como usar no Blade

```blade
<form-input
    label="Telefone"
    name="telefone"
    id="telefone"
    type="tel"
    placeholder="(99) 99999-9999"
    required
    value="{{ old('telefone') }}"
    :server-error="'{{ $errors->first('telefone') }}'"
    wrapper-class="col-12 col-sm-6 col-md-4"
></form-input>
```

---

✅ **O que isso faz:**

1. Se você digitar um telefone inválido, o componente mostra a mensagem de erro `"Digite um telefone no formato correto."`.
2. Mantém a validação `required`.
3. Mantém integração com Laravel `old()` e `$errors`.
4. Define o `pattern` e `title` automaticamente para `<input>` quando `type="tel"`.

---

### Testando o componente `FormInput.vue`

Se tiver dúvida de quais comandos executar para suber o servidor de desenvolvimento Vite e do Laravel, veja no **item 5**.

---

## 11. Modificar o componente `FormInput.vue` para reconhecer quando o tipo for `"number"`

O campo `number` tem um comportamento um pouco diferente dos tipos `text`, `email` e `tel`, porque:

* Ele não aceita letras nem espaços.
* O valor retornado pelo `input` é **string** (por padrão no Vue), mas você pode convertê-lo em número se quiser.
* Ele pode ter restrições como `min`, `max` e `step`.

Então o ideal é ajustar seu componente para:
Reconhecer quando o tipo for `"number"`
Permitir passar `min`, `max` e `step` via props
Fazer uma verificação simples de número válido

---

### Versão atualizada do `FormInput.vue` com suporte a `type="number"`

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
      v-model="inputValue"
      :required="required"
      @blur="checkInput"
      :pattern="inputPattern"
      :title="inputTitle"
      :min="min"
      :max="max"
      :step="step"
    />

    <div v-if="serverError" class="invalid-feedback">{{ serverError }}</div>
    <div v-else-if="errorMessage" class="invalid-feedback">{{ errorMessage }}</div>
  </div>
</template>

<script>
export default {
  name: 'FormInput',
  props: {
    label: { type: String, default: '' },
    type: { type: String, default: 'text' }, // "text", "email", "tel", "number"
    name: { type: String, required: true },
    id: { type: String, required: true },
    placeholder: { type: String, default: '' },
    required: { type: Boolean, default: false },
    value: { type: [String, Number], default: '' },
    wrapperClass: { type: String, default: 'col-12 col-sm-6 col-md-8' },
    serverError: { type: String, default: '' },
    min: { type: [String, Number], default: null },
    max: { type: [String, Number], default: null },
    step: { type: [String, Number], default: null }
  },
  data() {
    return {
      inputValue: this.value,
      errorMessage: ''
    }
  },
  computed: {
    inputPattern() {
      if (this.type === 'tel') return '\\(\\d{2}\\) \\d{4,5}-\\d{4}'
      return null
    },
    inputTitle() {
      if (this.type === 'tel')
        return 'Digite um telefone no formato (99) 9999-9999 ou (99) 99999-9999'
      return null
    }
  },
  methods: {
    checkInput() {
      const val = String(this.inputValue).trim()

      // Required
      if (this.required && !val) {
        this.errorMessage = 'Este campo é de preenchimento obrigatório.'
        return
      }

      // Validação e-mail
      if (this.type === 'email' && val && !this.isValidEmail(val)) {
        this.errorMessage = 'Por favor, insira um e-mail válido.'
        return
      }

      // Validação telefone
      if (this.type === 'tel' && val && !this.isValidPhone(val)) {
        this.errorMessage = 'Digite um telefone no formato (99) 9999-9999 ou (99) 99999-9999.'
        return
      }

      // Validação número
      if (this.type === 'number' && val && isNaN(val)) {
        this.errorMessage = 'Por favor, insira um número válido.'
        return
      }

      this.errorMessage = ''
    },

    isValidEmail(email) {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
      return re.test(email)
    },

    isValidPhone(phone) {
      const re = /^\(\d{2}\) \d{4,5}-\d{4}$/
      return re.test(phone)
    }
  }
}
</script>
```

---

### Exemplo de uso no Blade

```blade
<form-input
    label="Número"
    name="numero"
    id="numero"
    type="number"
    placeholder="Digite o número"
    required
    min="1"
    max="9999"
    step="1"
    value="{{ old('numero') }}"
    :server-error="'{{ $errors->first('numero') }}'"
    wrapper-class="col-12 col-sm-4 col-md-3"
></form-input>
```

---

**Comportamento final:**

* `type="number"` → muda automaticamente o input para numérico
* `min`, `max` e `step` são aplicados dinamicamente
* Validação `required`, `email`, `telefone` e `number` coexistem
* O valor digitado não é perdido
* As mensagens de erro do Laravel e do Vue aparecem corretamente

---

### Testando o componente `FormInput.vue`

Se tiver dúvida de quais comandos executar para suber o servidor de desenvolvimento Vite e do Laravel, veja no **item 5**.

---

## 12. Modificar o componente `FormInput.vue` para validação do estado (UF)

Incluir a validação do estado (UF), seguindo o mesmo padrão que fizemos para **telefone** e **número**.

A ideia é simples:

* Quando o `type` for `"text"` (ou `"estado"`, se quiser usar algo específico),
* E tiver um `maxlength` de **2**,
* Podemos validar se o valor tem **exatamente 2 caracteres**.

Assim mantemos o componente **genérico**, mas flexível o bastante para lidar com esse tipo de caso.

---

### Versão atualizada do `FormInput.vue` com validação de 2 caracteres (UF)

```vue
<template>
  <div :class="wrapperClass">
    <label :for="id" class="form-label">
      {{ label }}
      <span v-if="required">*</span>
    </label>

    <input
      :type="type"
      :name="name"
      :id="id"
      class="form-control"
      :class="{ 'is-invalid': errorMessage }"
      :placeholder="placeholder"
      v-model="inputValue"
      :pattern="inputPattern"
      :title="inputTitle"
      :maxlength="maxlength"
      :required="required"
      @blur="checkInput"
    />

    <div v-if="errorMessage" class="invalid-feedback">{{ errorMessage }}</div>
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
    value: { type: [String, Number], default: '' },
    wrapperClass: { type: String, default: 'col-12 col-sm-6 col-md-8' },
    pattern: { type: String, default: null },
    title: { type: String, default: null },
    maxlength: { type: [String, Number], default: null },
  },
  data() {
    return {
      inputValue: this.value,
      errorMessage: '',
    }
  },
  computed: {
    inputPattern() {
      if (this.type === 'tel') return '\\(\\d{2}\\) \\d{4,5}-\\d{4}'
      const max = Number(this.maxlength)
      if (!Number.isNaN(max) && max > 0) return `.{${max}}`
      return this.pattern || null
    },
    inputTitle() {
      if (this.type === 'tel')
        return 'Digite um telefone no formato (99) 9999-9999 ou (99) 99999-9999'
      const max = Number(this.maxlength)
      if (!Number.isNaN(max) && max > 0)
        return `O campo deve conter exatamente ${max} caracteres`
      return this.title || null
    },
  },
  watch: {
    value(newVal) {
      this.inputValue = newVal
    },
  },
  methods: {
    checkInput() {
      const val = String(this.inputValue || '').trim()

      // Requerido
      if (this.required && !val) {
        this.errorMessage = 'Este campo é de preenchimento obrigatório.'
        return
      }

      // E-mail
      if (this.type === 'email' && val && !this.isValidEmail(val)) {
        this.errorMessage = 'Por favor, insira um e-mail válido.'
        return
      }

      // Telefone
      if (this.type === 'tel' && val && !this.isValidPhone(val)) {
        this.errorMessage = 'Digite um telefone no formato (99) 9999-9999 ou (99) 99999-9999.'
        return
      }

      // Número
      if (this.type === 'number' && val && isNaN(val)) {
        this.errorMessage = 'Por favor, insira um número válido.'
        return
      }

      // Verificação de tamanho exato (ex.: Estado com 2 caracteres)
      const max = Number(this.maxlength)
      if (!Number.isNaN(max) && max > 0 && val && val.length !== max) {
        this.errorMessage = `O campo deve conter exatamente ${max} caracteres.`
        return
      }

      this.errorMessage = ''
    },

    isValidEmail(email) {
      const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
      return regex.test(email)
    },

    isValidPhone(phone) {
      const regex = /^\(\d{2}\) \d{4,5}-\d{4}$/
      return regex.test(phone)
    },
  },
}
</script>
```

---

### Exemplo de uso no Blade

```blade
<form-input
    label="Estado"
    name="estado"
    id="estado"
    type="text"
    placeholder="UF"
    required
    maxlength="2"
    value="{{ old('estado') }}"
    :server-error="'{{ $errors->first('estado') }}'"
    wrapper-class="col-12 col-sm-4 col-md-3"
></form-input>
```

---

**O que esse ajuste faz:**

* Se o `maxlength` for `2`, automaticamente aplica:

  * `pattern=".{2}"`
  * `title="O campo deve conter exatamente 2 caracteres"`
* A validação Vue também impede envio com menos/more de 2 caracteres.
* Mantém as validações de **required**, **email**, **telefone** e **número**.
* Continua compatível com Laravel (`old()` e `$errors`).

---

### Testando o componente `FormInput.vue`

Se tiver dúvida de quais comandos executar para suber o servidor de desenvolvimento Vite e do Laravel, veja no **item 5**.

---

## 13. Atualizar o formulário de cadastro de colaboradores para uso do componente `FormInput.vue`

Faça uma cópia do arquivo `resources\views\create-colaboradores.blade.php` e renomeie a cópia para `resources\views\create-colaboradores.blade_old.php`

Subistitua o formulário `<form></form>` pelo código com uso do componente `FormInput.vue`, o arquivo `resources\views\create-colaboradores.blade.php` deve ficar assim:

```blade
@extends('layouts.app')

@section('styles')
@endsection

@section('scripts')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
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
                                    <form-input label="Nome" name="nome" id="nome" placeholder="Nome" required
                                        value="{{ old('nome') }}" :server-error="'{{ $errors->first('nome') }}'"
                                        wrapper-class="col-12 col-sm-6 col-md-8"></form-input>

                                    <form-input label="Cargo" name="cargo" id="cargo" placeholder="Cargo" required
                                        value="{{ old('cargo') }}" :server-error="'{{ $errors->first('cargo') }}'"
                                        wrapper-class="col-12 col-sm-6 col-md-4"></form-input>
                                </div>

                                <div class="row g-3 mb-3">
                                    <form-input label="Telefone" name="telefone" id="telefone" type="tel"
                                        placeholder="(99) 99999-9999" required value="{{ old('telefone') }}"
                                        :server-error="'{{ $errors->first('telefone') }}'"
                                        wrapper-class="col-12 col-sm-6 col-md-6"></form-input>

                                    <form-input label="E-mail" name="email" id="email" type="email"
                                        placeholder="Digite seu e-mail" required value="{{ old('email') }}"
                                        :server-error="'{{ $errors->first('email') }}'"
                                        wrapper-class="col-12 col-sm-6 col-md-6"></form-input>

                                </div>

                                <div class="row g-3 mb-3">
                                    <form-input label="Logradouro" name="logradouro" id="logradouro"
                                        placeholder="Logradouro" required value="{{ old('logradouro') }}"
                                        :server-error="'{{ $errors->first('logradouro') }}'"
                                        wrapper-class="col-12 col-sm-8 col-md-9"></form-input>

                                    <form-input label="Número" name="numero" id="numero" placeholder="Número"
                                        type="number" required value="{{ old('numero') }}"
                                        :server-error="'{{ $errors->first('numero') }}'"
                                        wrapper-class="col-12 col-sm-4 col-md-3"></form-input>
                                </div>

                                <div class="row g-3 mb-3">
                                    <form-input label="Município" name="municipio" id="municipio" placeholder="Município"
                                        required value="{{ old('municipio') }}"
                                        :server-error="'{{ $errors->first('municipio') }}'"
                                        wrapper-class="col-12 col-sm-8 col-md-9"></form-input>

                                    <form-input label="Estado" name="estado" id="estado" type="text" placeholder="UF"
                                        required maxlength="2" value="{{ old('estado') }}"
                                        :server-error="'{{ $errors->first('estado') }}'"
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
    </div>
@endsection
```

----

### Testando o componente `FormInput.vue`

Se tiver dúvida de quais comandos executar para suber o servidor de desenvolvimento Vite e do Laravel, veja no **item 5**.

----

## 14. Atualizar o formulário de edição de colaboradores para uso do componente `FormInput.vue`

Faça uma cópia do arquivo `resources\views\edit-colaboradores.blade.php` e renomeie a cópia para `resources\views\edit-colaboradores.blade_old.php`

Subistitua o formulário `<form></form>` pelo código com uso do componente `FormInput.vue`, o arquivo `resources\views\edit-colaboradores.blade.php` deve ficar assim:

```blade
@extends('layouts.app')

@section('styles')
@endsection

@section('scripts')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
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
                                    <form-input label="Nome" name="nome" id="nome" placeholder="Nome" required
                                        value="{{ old('nome', $colaborador->nome) }}"
                                        :server-error="'{{ $errors->first('nome') }}'"
                                        wrapper-class="col-12 col-sm-6 col-md-8"></form-input>

                                    <form-input label="Cargo" name="cargo" id="cargo" placeholder="Cargo" required
                                        value="{{ old('cargo', $colaborador->cargo) }}"
                                        :server-error="'{{ $errors->first('cargo') }}'"
                                        wrapper-class="col-12 col-sm-6 col-md-4"></form-input>
                                </div>

                                <div class="row g-3 mb-3">
                                    <form-input label="Telefone" name="telefone" id="telefone" type="tel"
                                        placeholder="(99) 99999-9999" required
                                        value="{{ old('telefone', $colaborador->telefone) }}"
                                        :server-error="'{{ $errors->first('telefone') }}'"
                                        wrapper-class="col-12 col-sm-6 col-md-6"></form-input>

                                    <form-input label="E-mail" name="email" id="email" type="email"
                                        placeholder="Digite seu e-mail" required
                                        value="{{ old('email', $colaborador->email) }}"
                                        :server-error="'{{ $errors->first('email') }}'"
                                        wrapper-class="col-12 col-sm-6 col-md-6"></form-input>
                                </div>

                                <div class="row g-3 mb-3">
                                    <form-input label="Logradouro" name="logradouro" id="logradouro"
                                        placeholder="Logradouro" required
                                        value="{{ old('logradouro', $colaborador->logradouro) }}"
                                        :server-error="'{{ $errors->first('logradouro') }}'"
                                        wrapper-class="col-12 col-sm-8 col-md-9"></form-input>

                                    <form-input label="Número" name="numero" id="numero" placeholder="Número"
                                        type="number" required value="{{ old('numero', $colaborador->numero) }}"
                                        :server-error="'{{ $errors->first('numero') }}'"
                                        wrapper-class="col-12 col-sm-4 col-md-3"></form-input>
                                </div>

                                <div class="row g-3 mb-3">
                                    <form-input label="Município" name="municipio" id="municipio" placeholder="Município"
                                        required value="{{ old('municipio', $colaborador->municipio) }}"
                                        :server-error="'{{ $errors->first('municipio') }}'"
                                        wrapper-class="col-12 col-sm-8 col-md-9"></form-input>

                                    <form-input label="Estado" name="estado" id="estado" type="text" placeholder="UF"
                                        required maxlength="2" value="{{ old('estado', $colaborador->estado) }}"
                                        :server-error="'{{ $errors->first('estado') }}'"
                                        wrapper-class="col-12 col-sm-4 col-md-3"></form-input>
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
@endsection
```

----

### Testando o componente `FormInput.vue`

Se tiver dúvida de quais comandos executar para suber o servidor de desenvolvimento Vite e do Laravel, veja no **item 5**.

----

