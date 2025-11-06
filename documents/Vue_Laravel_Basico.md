# 🟢 **Guia Passo a Passo: Aprendendo Vue com Laravel**

---

## 📖 Introdução ao Vue.js com Laravel

**Vue.js** é uma ferramenta que usamos junto com o **JavaScript** para criar **páginas mais dinâmicas e interativas**. Ele é leve, fácil de aprender e funciona muito bem com o **Laravel**.

No dia a dia com Laravel, muitas vezes escrevemos o mesmo código várias vezes, como campos de formulário, botões e tabelas. Com o Vue, conseguimos transformar esses elementos em **componentes reutilizáveis**, ou seja, **blocos prontos que podemos usar quantas vezes quisermos**.

### ✨ O que o Vue pode fazer junto com o Laravel:

* Deixar os formulários mais inteligentes e fáceis de usar.
* Atualizar informações na tela sem recarregar a página inteira.
* Reaproveitar campos ou botões com apenas uma linha de código.
* Fazer validações e exibir mensagens de erro de forma automática e dinâmica.

### ✅ Por que usar o Vue com Laravel?

* Evita repetição de código.
* Deixa o sistema mais organizado e fácil de manter.
* Melhora a experiência do usuário (mais rápido e moderno).

> Em resumo: **o Vue ajuda a deixar o Laravel mais dinâmico e inteligente**, principalmente em sistemas com formulários, tabelas e interfaces que mudam com frequência.

---

## 🔹 **Instalação no Laravel (Laravel 11)**

### 📦 Instalar as dependências

Se estiver usando Vite (Laravel 11 usa por padrão):

```bash
npm install vue
```

### 📂 Habilitar Vue no Laravel (criado automaticamente no Laravel)

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

## Criando o primeiro compomente Vue

### 🔹 **Criar o componente Vue**

Crie um arquivo em `resources/js/components/OlaMundo.vue` com este conteúdo:

```vue
<template>
  <div class="container">
    <h1>Olá, {{ nome }}!</h1>
    <input type="text" v-model="nome" placeholder="Digite seu nome" />
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

<style scoped>
.container {
  padding: 10px;
  text-align: center;
}

h1 {
  color: #444;
  font-size: 24px;
}

input {
  padding: 6px;
  font-size: 16px;
  border: 1px solid #999;
  border-radius: 4px;
}
</style>
```

### 🔹 **Importar e Registrar o Componente Vue** em `resources/js/app.js`:

```js
import { createApp } from 'vue';

const app = createApp({});

// Exemplo de componente
import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

// Novo componente
import OlaMundo from './components/OlaMundo.vue';
app.component('ola-mundo', OlaMundo);

// Monta a aplicação no HTML
app.mount('#app');
```

### 🔹 **Usar o componente no Blade**

No seu `testevue.blade.php` ou qualquer view Blade:

```blade
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Testando o Vue</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app" class="container mt-5">
        <h1>Testando o Vue</h1>

        <div id="app">
            <hello-world></hello-world>
        </div>
    </div>
</body>
</html>
```

### 🔹 **Incluir a rota para a view do novo componente** em `routes/web.php`:

```php
Route::get('/testevue', function () {
    return view('testevue');
});
```

### 🔹 **Rodar o Vite**

No terminal:

```bash
npm run dev
```

### 🔹 **Exetutar o servidor de desenvolvimento do Laravel**

No terminal:

```bash
php artisan serve
```

Abra no navegador: `http://localhost:8000/testevue` e veja seu componente funcionando!

---

## ✅ Finalidade do componente

Esse componente tem um objetivo **simples e didático**:

> Exibir uma saudação personalizada, que muda conforme o usuário digita o próprio nome.

## 🧩 Estrutura do componente Vue

Um componente `.vue` é dividido em 3 blocos principais:

```
<template>  → estrutura (HTML)
<script>    → comportamento (JS)
<style>     → aparência (CSS)
```

Agora vamos analisar cada um deles:

---

## 🔷 `<template>`

```vue
<template>
  <div class="container">
    <h1>Olá, {{ nome }}!</h1>
    <input type="text" v-model="nome" placeholder="Digite seu nome" />
  </div>
</template>
```

### Explicação linha a linha:

* `<div class="container">`: bloco principal, com uma classe usada para aplicar o CSS.

* `<h1>Olá, {{ nome }}!</h1>`:

  * `{{ nome }}` é uma **interpolação** do Vue.
  * Ele exibe o valor da variável `nome` na tela.
  * Quando `nome` muda, o texto do `<h1>` muda automaticamente. Exemplo:

    * Se `nome = "Renato"` → aparece: **Olá, Renato!**

* `<input type="text" v-model="nome" placeholder="Digite seu nome" />`:

  * Campo de texto para o usuário digitar seu nome.
  * `v-model="nome"` cria uma **ligação bidirecional** com a variável `nome` do `data()`.

    * Se o usuário digitar "Carlos", `nome` passa a valer `"Carlos"`.
    * Como o `<h1>` usa `{{ nome }}`, ele atualiza automaticamente com esse valor.

---

## 🔷 `<script>`

```js
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

### Explicação:

* `export default { ... }`: define o **componente Vue**.

* `data()` é uma **função que retorna um objeto** com os dados reativos do componente.

* `nome: 'Visitante'`:

  * Define o valor **inicial** da variável `nome`.
  * Quando o componente é carregado, aparece "Olá, Visitante!".

---

## 🔷 `<style scoped>`

```css
<style scoped>
.container {
  padding: 10px;
  text-align: center;
}

h1 {
  color: #444;
  font-size: 24px;
}

input {
  padding: 6px;
  font-size: 16px;
  border: 1px solid #999;
  border-radius: 4px;
}
</style>
```

### Explicação:

* `scoped`: significa que o CSS vai ser aplicado **somente a esse componente**, evitando interferência em outros.

* `.container`: adiciona espaço interno (`padding`) e centraliza o conteúdo com `text-align: center`.

* `h1`: define a cor e o tamanho da fonte do título.

* `input`: dá um estilo básico ao campo de texto:

  * `padding`: espaço interno.
  * `font-size`: tamanho do texto.
  * `border`: borda cinza.
  * `border-radius`: cantos levemente arredondados.

---

## 🧠 O que o componente faz na prática?

1. Mostra o texto: `Olá, Visitante!`
2. O usuário digita algo (ex: “Renato”) no campo.
3. O `v-model` atualiza a variável `nome`.
4. O texto muda para: `Olá, Renato!` — **em tempo real!**

---

## 🔹 **Como funciona o Vue (conceitos básicos)**

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

## **Exemplo com validação simples**

### **Crie o componente Vue**

Crie um arquivo em `resources/js/components/InputField.vue` com este conteúdo:

```vue
<template>
  <div class="mb-3">
    <label :for="id" class="form-label">
      {{ label }} <span v-if="requerido" class="text-danger">*</span>
    </label>
    
    <input
      :type="tipo"
      :id="id"
      :name="id"
      :placeholder="placeholder"
      v-model="valor"
      :required="requerido"
      @blur="validar"
      class="form-control"
    >

    <div v-if="erro" class="form-text text-danger">
      {{ erro }}
    </div>
  </div>
</template>

<script>
export default {
  props: {
    id: String,
    name: String,
    label: String,
    placeholder: String,
    valorInicial: {
      type: String,
      default: ''
    },
    tipo: {
      type: String,
      default: 'text'
    },
    requerido: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      valor: this.valorInicial,
      erro: ''
    };
  },
  methods: {
    validar() {
      if (this.requerido && !this.valor.trim()) {
        this.erro = 'Preenchimento obrigatório.';
      } else {
        this.erro = '';
      }
    }
  }
};
</script>
```

### **Importar e Registrar o Componente Vue** em `resources/js/app.js`:

```js
import { createApp } from 'vue';

const app = createApp({});


// Importação dos componentes Vue
import ExampleComponent from './components/ExampleComponent.vue';
import OlaMundo from './components/OlaMundo.vue';
import InputField from './components/InputField.vue';


// Registro dos componentes Vue
app.component('example-component', ExampleComponent);
app.component('ola-mundo', OlaMundo);
app.component('input-field', InputField);


// Monta a aplicação no HTML
app.mount('#app');
```

### **Usar o componente no Blade**

No seu `testevue.blade.php` ou qualquer view Blade:

```blade
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Testando o Vue</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app" class="container mt-5">
        <h1>Testando o Vue</h1>

        <div id="app">
            <input-field id="nome" label="Nome" placeholder="Digite seu nome" :requerido="true"><input-field>
        </div>
    </div>
</body>
</html>
```

### **Rodar o Vite**

No terminal:

```bash
npm run dev
```

### **Exetutar o servidor de desenvolvimento do Laravel**

No terminal:

```bash
php artisan serve
```

Abra no navegador: `http://localhost:8000/testevue` e veja seu componente funcionando!

---

## ✅ Visão geral do componente

Esse componente é um **campo de formulário reutilizável**, com:

* **Rótulo (label)**
* **Campo de input**
* **Validação simples se o campo for obrigatório**
* Estilização usando **Bootstrap 5.2**

---

## 🔹 `<template>`

```vue
<template>
  <div class="mb-3">
```

* Aqui começa o **HTML do componente**.
* A classe `mb-3` do Bootstrap aplica uma margem inferior (margin-bottom) para espaçar o campo dos outros.

---

### 🔸 Label

```vue
<label :for="id" class="form-label">
  {{ label }} <span v-if="requerido" class="text-danger">*</span>
</label>
```

* `<label>`: exibe o nome do campo.
* `:for="id"`: associa o `<label>` ao `<input>` com o mesmo `id` (acessibilidade).
* `{{ label }}`: mostra o texto passado como propriedade (ex: "Nome", "Email").
* `v-if="requerido"`: se for obrigatório, mostra um asterisco vermelho com a classe `text-danger`.

---

### 🔸 Campo de input

```vue
<input
  :type="tipo"
  :id="id"
  :name="id"
  :placeholder="placeholder"
  v-model="valor"
  :required="requerido"
  @blur="validar"
  class="form-control"
/>
```

Cada parte faz o seguinte:

| Atributo                     | O que faz                                                                           |
| ---------------------------- | ----------------------------------------------------------------------------------- |
| `:type="tipo"`               | Tipo do campo (`text`, `email`, `password`, etc), definido pela prop                |
| `:id="id"` e `:name="id"`    | Define o `id` e `name` do input com base na prop recebida                           |
| `:placeholder="placeholder"` | Texto de sugestão dentro do campo                                                   |
| `v-model="valor"`            | Faz o **data binding**: conecta o valor digitado com a variável `valor` do `data()` |
| `:required="requerido"`      | Só aplica o atributo HTML `required` se for `true`                                  |
| `@blur="validar"`            | Quando o campo perde o foco (blur), chama o método `validar()`                      |
| `class="form-control"`       | Aplica estilo Bootstrap para campos de formulário                                   |

---

### 🔸 Exibição do erro

```vue
<div v-if="erro" class="form-text text-danger">
  {{ erro }}
</div>
```

* Só aparece se existir algum texto na variável `erro`.
* Mostra a mensagem de erro com estilo vermelho (`text-danger`).

---

## 🔹 `<script>`

Aqui começa a parte de lógica e comportamento do componente.

```js
export default {
```

Isso define que o conteúdo é um **componente Vue**.

---

### 🔸 `props`

```js
props: {
  id: String,
  name: String,
  label: String,
  placeholder: String,
  valorInicial: {
    type: String,
    default: ''
  },
  tipo: {
    type: String,
    default: 'text'
  },
  requerido: {
    type: Boolean,
    default: false
  }
},
```

As **props** são parâmetros que o componente recebe de fora. Por exemplo:

```vue
<CampoTexto id="email" label="Email" placeholder="Digite seu email" requerido />
```

* `id`, `name`, `label` e `placeholder` são textos simples.
* `valorInicial`: valor inicial que será usado para preencher o campo, se desejar.
* `tipo`: tipo do input, ex: `"text"`, `"email"`, `"password"`.
* `requerido`: define se o campo é obrigatório (`true` ou `false`).

---

### 🔸 `data()`

```js
data() {
  return {
    valor: this.valorInicial,
    erro: ''
  };
},
```

* `valor`: é a variável que guarda o valor digitado no campo (ligada ao `v-model`).
* `erro`: guarda a mensagem de erro que será mostrada abaixo do campo, se houver.

---

### 🔸 `methods`

```js
methods: {
  validar() {
    if (this.requerido && !this.valor.trim()) {
      this.erro = 'Preenchimento obrigatório.';
    } else {
      this.erro = '';
    }
  }
}
```

* `validar()` é chamado quando o campo perde o foco (`blur`).
* Ele verifica se o campo é obrigatório (`this.requerido`) e se está vazio (`!this.valor.trim()`).
* Se estiver vazio, mostra uma mensagem de erro.
* Se estiver preenchido, limpa o erro.

---

## ✅ Exemplo de uso

Aqui está como você pode usar esse componente em outro arquivo:

```vue
<CampoTexto
  id="nome"
  label="Nome completo"
  placeholder="Digite seu nome"
  requerido
  tipo="text"
/>
```
