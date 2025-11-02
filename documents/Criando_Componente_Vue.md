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

