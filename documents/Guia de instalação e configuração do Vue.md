# 🚀 Instalação e Configuração do Vue 3 no Laravel 12 com Vite

> ✅ **Compatível com Laravel 12, Vite 7+ e Vue 3.4+**

---

## 🧱 1️⃣ Pré-requisitos

Certifique-se de ter instalado:

* **PHP 8.2+**
* **Composer**
* **Node.js (versão 18 ou superior)**
* **NPM ou Yarn**

---

## 🧱 2️⃣ Criar um novo projeto Laravel

```bash
composer create-project laravel/laravel nome-projeto
cd nome-projeto
```

---

## 🧩 3️⃣ Instalar as dependências do Node

```bash
npm install
```

Isso instala o Vite, Laravel Vite Plugin e outras dependências front-end básicas.

---

## 🧠 4️⃣ Instalar o Vue 3 + plugin do Vite

Execute o comando:

```bash
npm install vue @vitejs/plugin-vue
```

Isso instala:

* `vue`: o framework Vue 3
* `@vitejs/plugin-vue`: plugin para o Vite processar arquivos `.vue`

---

## ⚙️ 5️⃣ Configurar o Vite para usar o Vue

Abra o arquivo `vite.config.js` e substitua seu conteúdo por este:

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});
```

> 🔍 O `alias` é fundamental — ele garante que o Vite use a **versão completa do Vue**, que consegue compilar templates (`.vue`).

---

## 🧰 6️⃣ Criar a estrutura do Vue

Crie o diretório e o componente inicial:

```bash
mkdir -p resources/js/components
```

E dentro dele, crie o arquivo `ExampleComponent.vue` com este conteúdo:

```vue
<template>
  <div class="example-component">
    <h1>Componente Vue funcionando!</h1>
  </div>
</template>

<script>
export default {
  name: 'ExampleComponent',
};
</script>

<style scoped>
.example-component {
  color: #2d3748;
  font-weight: bold;
}
</style>
```

---

## 🧩 7️⃣ Configurar o arquivo `resources/js/app.js`

Substitua ou adicione o seguinte código:

```js
import './bootstrap';
import { createApp } from 'vue';

// Cria a instância da aplicação Vue
const app = createApp({});

// Importa e registra o componente global
import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

// Monta o Vue na div #app
app.mount('#app');

// Verificação no console
console.log('Vue foi carregado!');
```

---

## 🪶 8️⃣ Criar a view Blade de teste

Crie o arquivo `resources/views/testevue.blade.php`:

```blade
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Teste Vue</title>
    @vite('resources/js/app.js')
</head>
<body>
    <div id="app">
        <example-component></example-component>
    </div>
</body>
</html>
```

---

## 🛣️ 9️⃣ Criar a rota para teste

Edite `routes/web.php` e adicione:

```php
Route::get('/testevue', function () {
    return view('testevue');
});
```

---

## ⚡ 10️⃣ Executar o servidor e o Vite

Abra dois terminais (ou use o Laragon):

**Terminal 1:**

```bash
php artisan serve
```

**Terminal 2:**

```bash
npm run dev
```

---

## 🧾 11️⃣ Testar no navegador

Acesse:
👉 [http://localhost:8000/testevue](http://localhost:8000/testevue)

Você deve ver na tela:

```
Componente Vue funcionando!
```

E no console do navegador:

```
Vue foi carregado!
```

---

## 🧱 12️⃣ Compilação para produção

Quando tudo estiver funcionando, gere os arquivos otimizados para produção:

```bash
npm run build
```

Isso cria os assets em `public/build/assets`.

---

## 🧭 Dica: criar novos componentes

Para adicionar novos componentes Vue:

1. Crie o arquivo em `resources/js/components/NovoComponente.vue`
2. Registre no `app.js`:

   ```js
   import NovoComponente from './components/NovoComponente.vue';
   app.component('novo-componente', NovoComponente);
   ```
3. Use na Blade:

   ```blade
   <novo-componente></novo-componente>
   ```

---

## 💡 Problemas comuns e soluções

| Erro                                   | Causa                  | Solução                                        |
| -------------------------------------- | ---------------------- | ---------------------------------------------- |
| `runtime compilation is not supported` | Vue runtime-only       | Adicionar alias no `vite.config.js`            |
| `Vue foi carregado!` não aparece       | JS não está carregando | Verificar `@vite()` ou `npm run dev`           |
| `Failed to resolve component`          | Caminho incorreto      | Corrigir import no `app.js`                    |
| Componente não renderiza               | Vue não montou         | Confirmar `app.mount('#app')` e `div id="app"` |

---

## 🧠 Conclusão

Depois de seguir este guia, você terá um ambiente Laravel 12 com Vue 3 configurado corretamente via Vite, podendo:

✅ Criar componentes Vue.
✅ Usar hot-reload com `npm run dev`.
✅ Compilar para produção com `npm run build`.

