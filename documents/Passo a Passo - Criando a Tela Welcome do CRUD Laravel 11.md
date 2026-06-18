# Passo a Passo - Criando a Tela Welcome do CRUD Laravel 11

Este material serve como apoio para gravar uma aula mostrando como melhorar a pagina inicial `welcome.blade.php` de um sistema CRUD em Laravel 11.

A ideia e transformar a tela inicial, que antes tinha apenas um link, em uma entrada mais organizada para o sistema de colaboradores.

## Objetivo da aula

Ao final desta etapa, a pagina inicial do projeto tera:

- Um titulo claro para o sistema.
- Uma descricao curta explicando a finalidade da tela.
- Um botao para acessar a lista de colaboradores.
- Um botao para cadastrar um novo colaborador.
- Um card lateral com atalhos rapidos.
- Layout responsivo usando Bootstrap.

## Arquivo que sera alterado

Abra o arquivo:

```text
resources/views/welcome.blade.php
```

Esse arquivo e carregado quando acessamos a rota principal do sistema:

```php
Route::get('/', function () {
    return view('welcome');
});
```

Essa rota normalmente fica em:

```text
routes/web.php
```

## Situacao inicial

Antes da melhoria, a tela pode estar parecida com isto:

```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <a href="{{ route('colaborador.list') }}">Sistema Colaboradores</a>
    </div>
</div>
@endsection
```

Essa versao funciona, mas visualmente ainda esta muito simples. Ela apenas mostra um link para acessar o sistema.

## Passo 1 - Entender a estrutura Blade

O arquivo comeca com:

```blade
@extends('layouts.app')
```

Isso significa que a tela `welcome.blade.php` esta usando o layout principal do projeto, que normalmente fica em:

```text
resources/views/layouts/app.blade.php
```

Depois usamos:

```blade
@section('content')
```

Tudo que estiver dentro dessa section sera exibido no local onde o layout possui:

```blade
@yield('content')
```

No nosso caso, vamos melhorar apenas o conteudo da pagina, sem mexer no layout principal.

## Passo 2 - Criar o container principal

Vamos manter a estrutura do Bootstrap usando a classe `container`.

```blade
@extends('layouts.app')

@section('content')
    <div class="container">

    </div>
@endsection
```

O `container` centraliza o conteudo e aplica margens laterais adequadas em diferentes tamanhos de tela.

## Passo 3 - Criar uma linha responsiva

Dentro do container, vamos criar uma `row` com alinhamento vertical e espacamento entre as colunas:

```blade
<div class="row align-items-center justify-content-center g-4">

</div>
```

Explicando as classes:

- `row`: cria uma linha do grid do Bootstrap.
- `align-items-center`: centraliza verticalmente os itens da linha.
- `justify-content-center`: centraliza horizontalmente.
- `g-4`: adiciona espacamento entre as colunas.

## Passo 4 - Criar a primeira coluna com o titulo

A primeira coluna sera a area principal da tela:

```blade
<div class="col-lg-7">
    <div class="mb-4">
        <span class="badge text-bg-primary mb-3">Gestao de colaboradores</span>
        <h1 class="display-6 fw-semibold mb-3">Sistema de Colaboradores</h1>
        <p class="lead text-muted mb-0">
            Cadastre, consulte, edite e acompanhe os dados dos colaboradores em um unico lugar.
        </p>
    </div>
</div>
```

Explicando os principais pontos:

- `col-lg-7`: em telas grandes, essa coluna ocupa 7 partes do grid.
- `badge text-bg-primary`: cria uma etiqueta visual azul.
- `display-6`: deixa o titulo maior.
- `fw-semibold`: aplica uma fonte com peso intermediario.
- `lead`: destaca o paragrafo como texto introdutorio.
- `text-muted`: deixa o texto com cor mais suave.

## Passo 5 - Adicionar os botoes principais

Abaixo do texto, vamos colocar dois botoes:

```blade
<div class="d-flex flex-column flex-sm-row gap-2">
    <a href="{{ route('colaborador.list') }}" class="btn btn-primary btn-lg">
        Ver colaboradores
    </a>
    <a href="{{ route('colaborador.create') }}" class="btn btn-outline-primary btn-lg">
        Novo colaborador
    </a>
</div>
```

Aqui usamos as rotas nomeadas do Laravel:

```blade
{{ route('colaborador.list') }}
```

Essa rota leva para a listagem de colaboradores.

```blade
{{ route('colaborador.create') }}
```

Essa rota leva para o formulario de cadastro de colaboradores.

Explicando as classes:

- `d-flex`: ativa o Flexbox.
- `flex-column`: em telas pequenas, os botoes ficam um embaixo do outro.
- `flex-sm-row`: a partir de telas pequenas, os botoes ficam lado a lado.
- `gap-2`: adiciona espacamento entre os botoes.
- `btn btn-primary`: botao principal.
- `btn btn-outline-primary`: botao secundario com borda.
- `btn-lg`: deixa os botoes maiores.

## Passo 6 - Criar a segunda coluna com acesso rapido

Agora vamos criar a segunda coluna, que tera um card com links rapidos:

```blade
<div class="col-lg-5">
    <div class="card shadow-sm border-0">

    </div>
</div>
```

Explicando:

- `col-lg-5`: em telas grandes, essa coluna ocupa 5 partes do grid.
- `card`: cria um card do Bootstrap.
- `shadow-sm`: adiciona uma sombra leve.
- `border-0`: remove a borda padrao do card.

Somando as duas colunas, temos:

```text
col-lg-7 + col-lg-5 = 12
```

Ou seja, usamos as 12 colunas do grid do Bootstrap.

## Passo 7 - Adicionar o cabecalho do card

Dentro do card, adicione:

```blade
<div class="card-header bg-white">
    <h2 class="h5 mb-0">Acesso rapido</h2>
</div>
```

Explicando:

- `card-header`: cria a area de cabecalho do card.
- `bg-white`: deixa o fundo branco.
- `h5`: aplica visual de titulo menor.
- `mb-0`: remove a margem inferior.

## Passo 8 - Adicionar a lista de atalhos

No corpo do card, vamos colocar uma lista com os atalhos:

```blade
<div class="card-body">
    <div class="list-group list-group-flush">
        <a href="{{ route('colaborador.list') }}"
            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0">
            Lista de colaboradores
            <span class="text-primary">&rsaquo;</span>
        </a>
        <a href="{{ route('colaborador.create') }}"
            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0">
            Cadastrar colaborador
            <span class="text-primary">&rsaquo;</span>
        </a>
    </div>
</div>
```

Explicando:

- `list-group`: cria uma lista estilizada do Bootstrap.
- `list-group-flush`: remove algumas bordas externas para ficar melhor dentro do card.
- `list-group-item-action`: deixa o item com comportamento visual de link.
- `d-flex justify-content-between align-items-center`: alinha o texto de um lado e a seta do outro.
- `px-0`: remove o padding horizontal.
- `&rsaquo;`: exibe o simbolo de seta para a direita.

## Passo 9 - Adicionar o rodape do card

No final do card, vamos adicionar uma pequena observacao:

```blade
<div class="card-footer bg-light">
    <small class="text-muted">
        Dados principais: nome, cargo, telefone, e-mail e endereco.
    </small>
</div>
```

Explicando:

- `card-footer`: cria o rodape do card.
- `bg-light`: aplica um fundo claro.
- `small`: deixa o texto menor.
- `text-muted`: deixa o texto em tom mais discreto.

## Codigo final

Depois de montar todos os blocos, o arquivo `resources/views/welcome.blade.php` deve ficar assim:

```blade
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row align-items-center justify-content-center g-4">
            <div class="col-lg-7">
                <div class="mb-4">
                    <span class="badge text-bg-primary mb-3">Gestao de colaboradores</span>
                    <h1 class="display-6 fw-semibold mb-3">Sistema de Colaboradores</h1>
                    <p class="lead text-muted mb-0">
                        Cadastre, consulte, edite e acompanhe os dados dos colaboradores em um unico lugar.
                    </p>
                </div>

                <div class="d-flex flex-column flex-sm-row gap-2">
                    <a href="{{ route('colaborador.list') }}" class="btn btn-primary btn-lg">
                        Ver colaboradores
                    </a>
                    <a href="{{ route('colaborador.create') }}" class="btn btn-outline-primary btn-lg">
                        Novo colaborador
                    </a>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h2 class="h5 mb-0">Acesso rapido</h2>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('colaborador.list') }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0">
                                Lista de colaboradores
                                <span class="text-primary">&rsaquo;</span>
                            </a>
                            <a href="{{ route('colaborador.create') }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0">
                                Cadastrar colaborador
                                <span class="text-primary">&rsaquo;</span>
                            </a>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <small class="text-muted">
                            Dados principais: nome, cargo, telefone, e-mail e endereco.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
```

## Passo 10 - Testar no navegador

Para testar, inicie o servidor do Laravel:

```bash
php artisan serve
```

Depois acesse no navegador:

```text
http://127.0.0.1:8000
```

Se o projeto tambem estiver usando Vite para carregar CSS e JavaScript, deixe o Vite rodando em outro terminal:

```bash
npm run dev
```

## O que explicar no video

Durante a gravacao, uma boa sequencia de explicacao seria:

1. Mostrar a tela inicial antiga com apenas um link.
2. Explicar que a pagina inicial deve orientar melhor o usuario.
3. Mostrar que o projeto ja usa um layout principal com `@extends('layouts.app')`.
4. Criar o `container`.
5. Criar a `row` com duas colunas.
6. Montar a coluna principal com titulo, descricao e botoes.
7. Usar `route()` para gerar os links corretamente.
8. Criar o card de acesso rapido.
9. Testar a pagina no navegador.
10. Reforcar que usamos apenas Blade e Bootstrap, sem precisar criar CSS personalizado.

## Pontos importantes para destacar

- O Blade permite reaproveitar layouts com `@extends`.
- A section `content` injeta o conteudo dentro do layout principal.
- O helper `route()` evita escrever URLs fixas no HTML.
- O Bootstrap facilita a criacao de layouts responsivos.
- A pagina inicial ficou mais profissional, mas continua simples e facil de manter.

## Resultado esperado

Ao acessar a rota principal do sistema, o usuario vera uma tela inicial mais organizada, com acesso direto as principais funcionalidades do CRUD:

- Listar colaboradores.
- Cadastrar novo colaborador.

Essa melhoria deixa o sistema com uma apresentacao melhor e tambem ajuda o usuario a entender rapidamente o que pode fazer na aplicacao.
