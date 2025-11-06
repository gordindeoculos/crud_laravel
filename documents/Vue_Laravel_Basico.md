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

```html
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

```html
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

```html
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

```html
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

```html
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

Perfeito, Renato 👌
Vamos fazer uma **visão geral completa e detalhada** do componente `InputField.vue` que você criou, explicando cada parte do código — incluindo o que ele faz, como funciona a reatividade e como ele se integra ao Laravel + Vite no front-end.

---

## 🧱 **Visão Geral do Componente `InputField.vue`**

Esse componente Vue é um **campo de entrada reutilizável e validável**, feito para ser usado em formulários. Ele encapsula toda a lógica de exibição, validação e estilização de um `<input>` HTML, permitindo reaproveitar código e manter o formulário mais limpo.

---

## 📂 Estrutura do Arquivo

O componente segue o padrão **Single File Component (SFC)** do Vue:

```html
<template> ... </template>
<script> ... </script>
```

Cada parte tem uma função específica:

* **`<template>`** → Define o HTML que será renderizado.
* **`<script>`** → Contém a lógica do componente (dados, propriedades e métodos).
* (Opcionalmente, poderia ter `<style>` se houvesse CSS específico.)

---

## 🧩 **Seção `<template>`**

```html
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
```

### 🔍 Detalhamento

#### `<div class="mb-3">`

* Usa a classe do **Bootstrap** para espaçamento inferior (margem-bottom de 1rem).
* Serve como contêiner do campo e da mensagem de erro.

#### `<label :for="id">`

* Exibe o rótulo do campo.
* O atributo `:for` é **dinâmico** e vinculado à prop `id`.
* Se o campo for obrigatório, exibe um asterisco vermelho (`<span class="text-danger">*</span>`).

#### `<input ...>`

* Cria o campo de entrada principal.
* **Bindings dinâmicos (`:`)** conectam as props ao comportamento:

  * `:type="tipo"` → define o tipo (ex: text, email, password etc.);
  * `:id` e `:name` → ambos com o mesmo valor, facilitando a identificação no formulário;
  * `:placeholder` → mostra o texto de dica no campo;
  * `v-model="valor"` → cria **ligação bidirecional (two-way binding)** entre o input e a variável `valor` no `data()`;
  * `:required="requerido"` → marca o campo como obrigatório se `true`;
  * `@blur="validar"` → executa a validação quando o campo perde o foco.
* A classe `form-control` aplica o estilo padrão do Bootstrap.

#### `<div v-if="erro">`

* Exibe a mensagem de erro apenas se existir algum valor em `erro`.
* Usa `text-danger` para mostrar o texto em vermelho.

---

## ⚙️ **Seção `<script>`**

```js
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
```

### 🔍 Detalhamento

#### `props`

São **propriedades recebidas de fora** (do componente pai).

| Prop           | Tipo      | Descrição                                          |
| -------------- | --------- | -------------------------------------------------- |
| `id`           | `String`  | Identificador único do input.                      |
| `name`         | `String`  | Nome do campo (opcional, já herdado de `id`).      |
| `label`        | `String`  | Texto exibido acima do input.                      |
| `placeholder`  | `String`  | Texto de dica dentro do campo.                     |
| `valorInicial` | `String`  | Valor padrão inicial do campo.                     |
| `tipo`         | `String`  | Tipo do input (`text`, `email`, `password`, etc.). |
| `requerido`    | `Boolean` | Define se o campo é obrigatório.                   |

---

#### `data()`

Cria variáveis **reativas** que pertencem ao estado interno do componente:

* `valor`: o conteúdo atual do campo (ligado ao `v-model`).
* `erro`: armazena a mensagem de erro (exibida se a validação falhar).

---

#### `methods`

Define as funções do componente.

* **`validar()`** → método que valida o campo quando ele perde o foco (`blur`):

  ```js
  if (this.requerido && !this.valor.trim()) {
      this.erro = 'Preenchimento obrigatório.';
  } else {
      this.erro = '';
  }
  ```

  🔸 Verifica se o campo é obrigatório e se está vazio.
  🔸 Se estiver vazio, exibe uma mensagem de erro.
  🔸 Se o campo for preenchido, limpa o erro.

---

## 🧩 **Registro Global do Componente**

Em `resources/js/app.js`:

```js
import InputField from './components/InputField.vue';
app.component('input-field', InputField);
```

Isso **registra o componente globalmente**, permitindo usá-lo em qualquer parte da aplicação sem precisar importá-lo localmente.

---

## 🧠 **Uso no HTML (Exemplo de Instância Vue)**

```html
<div id="app">
  <input-field
    id="nome"
    label="Nome"
    placeholder="Digite seu nome"
    :requerido="true">
  </input-field>
</div>
```

### Como funciona:

* O Vue associa o componente à div com `id="app"`.
* O componente `<input-field>` é renderizado com base nas props.
* O campo de texto é mostrado com label “Nome” e validação obrigatória.

---

## 💡 **Comportamento em Tempo de Execução**

1. O usuário digita algo no campo → o valor é armazenado em `valor` (reativo).
2. Ao sair do campo (`blur`), o método `validar()` é chamado.
3. Se o campo estiver vazio e for obrigatório → exibe a mensagem “Preenchimento obrigatório”.
4. Se o usuário preencher corretamente → a mensagem desaparece.

---