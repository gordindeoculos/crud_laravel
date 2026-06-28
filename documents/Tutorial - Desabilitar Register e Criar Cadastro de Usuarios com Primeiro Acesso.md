# Tutorial - Desabilitar Register e Criar Cadastro de Usuarios com Primeiro Acesso

Este material serve como apoio para uma aula do projeto CRUD Laravel 11.

A ideia e desabilitar o cadastro publico do Laravel, reaproveitar o formulario de `resources/views/auth/register.blade.php` e criar uma tela interna para cadastrar usuarios que terao acesso ao sistema.

Depois que o usuario for cadastrado, o sistema enviara um e-mail com o link de acesso. No primeiro acesso, a senha inicial sera o CPF do usuario. Assim que ele entrar, o sistema obrigara o cadastro de uma nova senha.

> Importante para a aula: usar o CPF como senha inicial e uma estrategia didatica para projeto de curso. Em sistemas reais, o ideal e enviar um link seguro para criacao de senha ou gerar uma senha temporaria aleatoria.

## Objetivo da aula

Ao final desta etapa, o sistema tera:

- Registro publico desabilitado.
- Link "Cadastrar" removido da tela de visitantes.
- Uma pagina interna para cadastro de usuarios do sistema.
- Campo CPF na tabela `users`.
- Campo de controle para obrigar troca de senha no primeiro acesso.
- E-mail de boas-vindas com link para login.
- Middleware bloqueando o uso do sistema ate o usuario trocar a senha inicial.

## Situacao atual do projeto

No arquivo `routes/web.php`, o projeto usa:

```php
Auth::routes();
```

Esse comando cria automaticamente as rotas de login, logout, register, recuperacao de senha e outras rotas de autenticacao.

Como o projeto e um sistema de cadastro de colaboradores, nao faz sentido deixar qualquer pessoa criar uma conta pelo link publico de register. Por isso vamos desabilitar apenas o register publico e criar nosso proprio cadastro de usuarios dentro da area autenticada.

Antes de desabilitar o register, confirme que voce ja tem pelo menos um usuario para entrar no sistema. Esse usuario sera usado como administrador inicial para cadastrar os demais usuarios.

## Passo 1 - Desabilitar o register publico

Abra o arquivo:

```text
routes/web.php
```

Procure:

```php
Auth::routes();
```

Troque por:

```php
Auth::routes(['register' => false]);
```

Com isso, o Laravel continua mantendo login, logout e recuperacao de senha, mas remove as rotas automaticas de cadastro publico:

```text
GET  /register
POST /register
```

## Passo 2 - Remover o link Cadastrar do menu

Abra:

```text
resources/views/layouts/app.blade.php
```

Procure este trecho:

```blade
@if (Route::has('register'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('register') }}">Cadastrar</a>
    </li>
@endif
```

Remova esse bloco.

Agora visitantes terao apenas o link de login, e nao mais o link para criar conta.

## Passo 3 - Criar campos extras na tabela users

Vamos precisar guardar:

- `cpf`: CPF do usuario, que sera usado como senha inicial.
- `must_change_password`: indica se o usuario precisa trocar a senha no primeiro acesso.

Crie uma migration:

```bash
php artisan make:migration add_cpf_and_must_change_password_to_users_table --table=users
```

Abra a migration criada em:

```text
database/migrations
```

Coloque o seguinte codigo:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cpf', 14)->unique()->after('email');
            $table->boolean('must_change_password')->default(true)->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cpf', 'must_change_password']);
        });
    }
};
```

Se a tabela `users` ja tiver usuarios cadastrados, o banco pode reclamar ao adicionar `cpf` como obrigatorio e unico. Para uma aula com banco limpo, o codigo acima funciona bem. Se voce ja tiver usuarios no banco, uma alternativa didatica e criar o campo `cpf` como `nullable()` primeiro, preencher o CPF dos usuarios existentes, e depois criar outra migration para tornar o campo obrigatorio.

Depois execute:

```bash
php artisan migrate
```

## Passo 4 - Atualizar o model User

Abra:

```text
app/Models/User.php
```

No array `$fillable`, adicione `cpf` e `must_change_password`:

```php
protected $fillable = [
    'name',
    'email',
    'cpf',
    'password',
    'must_change_password',
];
```

No metodo `casts`, adicione:

```php
protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'must_change_password' => 'boolean',
    ];
}
```

## Passo 5 - Criar um controller para cadastro de usuarios

Crie um controller:

```bash
php artisan make:controller UserController
```

Abra:

```text
app/Http/Controllers/UserController.php
```

Use este codigo:

```php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\UsuarioCriadoNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'cpf' => ['required', 'string', 'max:14', 'unique:users,cpf'],
        ]);

        $cpfSomenteNumeros = preg_replace('/\D/', '', $request->cpf);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'password' => Hash::make($cpfSomenteNumeros),
            'must_change_password' => true,
        ]);

        $user->notify(new UsuarioCriadoNotification());

        return redirect()
            ->route('users.create')
            ->with('success', 'Usuario cadastrado com sucesso. O e-mail de acesso foi enviado.');
    }
}
```

Neste controller:

- O metodo `create` mostra o formulario.
- O metodo `store` valida os dados.
- O CPF e limpo para guardar a senha inicial apenas com numeros.
- A senha inicial e criada com `Hash::make`.
- O campo `must_change_password` fica como `true`.
- A notificacao envia o e-mail para o usuario.

## Passo 6 - Criar a view aproveitando o register

Crie a pasta:

```text
resources/views/users
```

Dentro dela, crie o arquivo:

```text
resources/views/users/create.blade.php
```

Agora copie a estrutura do arquivo:

```text
resources/views/auth/register.blade.php
```

E adapte para este codigo:

```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cadastrar usuario do sistema</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Nome</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">E-mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="cpf" class="col-md-4 col-form-label text-md-end">CPF</label>

                            <div class="col-md-6">
                                <input id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror"
                                    name="cpf" value="{{ old('cpf') }}" required>

                                @error('cpf')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Cadastrar usuario
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

Observe que removemos os campos de senha e confirmacao de senha. Agora quem define a senha inicial e o sistema, usando o CPF.

## Passo 7 - Criar as rotas internas de usuarios

Abra:

```text
routes/web.php
```

Adicione o import do controller:

```php
use App\Http\Controllers\UserController;
```

Depois adicione as rotas dentro de um grupo com middleware `auth`:

```php
Route::middleware('auth')->group(function () {
    Route::get('/usuarios/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
});
```

Com isso, somente usuarios logados conseguirao cadastrar novos usuarios do sistema.

## Passo 8 - Criar a notificacao por e-mail

Crie uma notificacao:

```bash
php artisan make:notification UsuarioCriadoNotification
```

Abra:

```text
app/Notifications/UsuarioCriadoNotification.php
```

Use este codigo:

```php
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UsuarioCriadoNotification extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Acesso ao Sistema de Colaboradores')
            ->greeting('Ola, ' . $notifiable->name)
            ->line('Seu usuario foi criado no Sistema de Colaboradores.')
            ->line('Para acessar, use seu e-mail e informe seu CPF como senha inicial.')
            ->action('Acessar sistema', route('login'))
            ->line('No primeiro acesso, o sistema solicitara o cadastro de uma nova senha.');
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
```

## Passo 9 - Configurar envio de e-mail para teste

Para gravar a aula sem depender de servidor SMTP real, voce pode usar o log do Laravel.

No arquivo `.env`, configure:

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="sistema@crudlaravel.test"
MAIL_FROM_NAME="Sistema de Colaboradores"
```

Depois de cadastrar um usuario, o e-mail aparecera em:

```text
storage/logs/laravel.log
```

Se quiser usar Mailpit, Mailtrap ou outro servico SMTP, basta ajustar as variaveis `MAIL_*` no `.env`.

## Passo 10 - Criar tela para alterar senha no primeiro acesso

Crie um controller:

```bash
php artisan make:controller ChangePasswordController
```

Abra:

```text
app/Http/Controllers/ChangePasswordController.php
```

Use este codigo:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function edit()
    {
        return view('auth.change-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();

        $user->update([
            'password' => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        return redirect()
            ->route('home')
            ->with('success', 'Senha alterada com sucesso.');
    }
}
```

Crie a view:

```text
resources/views/auth/change-password.blade.php
```

Use este codigo:

```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cadastrar nova senha</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.change.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Nova senha</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirmar senha</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Salvar nova senha
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

## Passo 11 - Criar as rotas de troca de senha

No arquivo `routes/web.php`, adicione o import:

```php
use App\Http\Controllers\ChangePasswordController;
```

Depois crie as rotas protegidas por login:

```php
Route::middleware('auth')->group(function () {
    Route::get('/alterar-senha', [ChangePasswordController::class, 'edit'])->name('password.change.edit');
    Route::put('/alterar-senha', [ChangePasswordController::class, 'update'])->name('password.change.update');
});
```

Se voce ja criou um grupo `Route::middleware('auth')->group(...)` no passo dos usuarios, pode colocar essas duas rotas dentro do mesmo grupo.

## Passo 12 - Criar middleware para obrigar troca da senha

Crie o middleware:

```bash
php artisan make:middleware ForcePasswordChange
```

Abra:

```text
app/Http/Middleware/ForcePasswordChange.php
```

Use este codigo:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        if (
            $request->user()
            && $request->user()->must_change_password
            && ! $request->routeIs('password.change.edit')
            && ! $request->routeIs('password.change.update')
            && ! $request->routeIs('logout')
        ) {
            return redirect()->route('password.change.edit');
        }

        return $next($request);
    }
}
```

Esse middleware verifica se o usuario logado ainda precisa trocar a senha. Se precisar, ele redireciona para a tela de nova senha.

As excecoes evitam loop infinito:

- `password.change.edit`: permite abrir a tela.
- `password.change.update`: permite salvar a nova senha.
- `logout`: permite sair do sistema.

## Passo 13 - Registrar o middleware no Laravel 11

No Laravel 11, os middlewares sao configurados em:

```text
bootstrap/app.php
```

Abra o arquivo e procure:

```php
->withMiddleware(function (Middleware $middleware) {
    //
})
```

Altere para:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'force.password.change' => \App\Http\Middleware\ForcePasswordChange::class,
    ]);
})
```

Agora aplique o middleware no grupo de rotas autenticadas:

```php
Route::middleware(['auth', 'force.password.change'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/usuarios/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');

    Route::get('/create-colaboradores', [ColaboradorController::class, 'create'])->name('colaborador.create');
    Route::get('/edit-colaborador/{id}', [ColaboradorController::class, 'edit'])->name('colaborador.edit');
    Route::put('/update-colaborador/{id}', [ColaboradorController::class, 'update'])->name('colaborador.update');
    Route::get('/detalhes-colaborador/{id}', [ColaboradorController::class, 'show'])->name('colaborador.detalhes');
    Route::delete('/excluir-colaborador/{id}', [ColaboradorController::class, 'destroy'])->name('colaborador.excluir');
    Route::get('/list-colaboradores', [ColaboradorController::class, 'index'])->name('colaborador.list');
    Route::post('/colaboradores-store', [ColaboradorController::class, 'store'])->name('colaborador.store');
});
```

As rotas de troca de senha devem ficar apenas com `auth`, fora do middleware `force.password.change`:

```php
Route::middleware('auth')->group(function () {
    Route::get('/alterar-senha', [ChangePasswordController::class, 'edit'])->name('password.change.edit');
    Route::put('/alterar-senha', [ChangePasswordController::class, 'update'])->name('password.change.update');
});
```

## Passo 14 - Organizar o arquivo routes/web.php

Ao final, o arquivo `routes/web.php` pode ficar parecido com este:

```php
<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/testevue', function () {
    return view('testevue');
});

Auth::routes(['register' => false]);

Route::middleware('auth')->group(function () {
    Route::get('/alterar-senha', [ChangePasswordController::class, 'edit'])->name('password.change.edit');
    Route::put('/alterar-senha', [ChangePasswordController::class, 'update'])->name('password.change.update');
});

Route::middleware(['auth', 'force.password.change'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/usuarios/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');

    Route::get('/create-colaboradores', [ColaboradorController::class, 'create'])->name('colaborador.create');
    Route::get('/edit-colaborador/{id}', [ColaboradorController::class, 'edit'])->name('colaborador.edit');
    Route::put('/update-colaborador/{id}', [ColaboradorController::class, 'update'])->name('colaborador.update');
    Route::get('/detalhes-colaborador/{id}', [ColaboradorController::class, 'show'])->name('colaborador.detalhes');
    Route::delete('/excluir-colaborador/{id}', [ColaboradorController::class, 'destroy'])->name('colaborador.excluir');
    Route::get('/list-colaboradores', [ColaboradorController::class, 'index'])->name('colaborador.list');
    Route::post('/colaboradores-store', [ColaboradorController::class, 'store'])->name('colaborador.store');
});
```

## Passo 15 - Adicionar link para cadastrar usuarios no menu

No arquivo:

```text
resources/views/layouts/app.blade.php
```

Dentro do bloco `@else`, onde aparece o nome do usuario logado, voce pode adicionar um link antes do dropdown:

```blade
<li class="nav-item">
    <a class="nav-link" href="{{ route('users.create') }}">Usuarios</a>
</li>
```

Exemplo:

```blade
@else
    <li class="nav-item">
        <a class="nav-link" href="{{ route('users.create') }}">Usuarios</a>
    </li>

    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ Auth::user()->name }}
        </a>
```

Assim, apenas usuarios logados enxergam o cadastro de novos usuarios.

## Passo 16 - Testar o fluxo completo

Inicie o servidor:

```bash
php artisan serve
```

Se estiver usando Vite:

```bash
npm run dev
```

Agora teste:

1. Acesse `/register` e confirme que a rota nao existe mais.
2. Faca login com um usuario ja existente.
3. Acesse `/usuarios/create`.
4. Cadastre um novo usuario informando nome, e-mail e CPF.
5. Confira o e-mail em `storage/logs/laravel.log`, se estiver usando `MAIL_MAILER=log`.
6. Saia do sistema.
7. Entre com o e-mail do novo usuario.
8. Use o CPF como senha inicial, apenas numeros.
9. Confirme que o sistema redireciona para `/alterar-senha`.
10. Cadastre uma nova senha.
11. Confirme que o usuario agora consegue acessar `/home` e as demais telas.

## Pontos importantes para explicar no video

- `Auth::routes(['register' => false])` desabilita apenas o cadastro publico.
- O cadastro de usuarios do sistema deve ser uma funcionalidade interna.
- O formulario antigo de register pode ser reaproveitado como base visual.
- Nao precisamos pedir senha no cadastro administrativo.
- A senha inicial e gerada pelo sistema usando o CPF.
- O campo `must_change_password` controla se o usuario precisa alterar a senha.
- O middleware e responsavel por bloquear as outras paginas ate a troca da senha.
- A notificacao do Laravel facilita o envio de e-mails.
- Para teste local, `MAIL_MAILER=log` evita depender de SMTP externo.

## Melhorias futuras para comentar

Para um sistema real, voce pode evoluir esta aula com:

- Validacao completa de CPF.
- Mascara de CPF no formulario.
- Tela de listagem de usuarios.
- Edicao de usuario.
- Controle de permissao para apenas administradores cadastrarem usuarios.
- Link seguro para criar senha, sem usar CPF como senha inicial.
- Fila para envio de e-mails em segundo plano.

## Resultado esperado

Ao finalizar a implementacao, o cadastro publico do Laravel estara desativado. O sistema tera uma tela interna para cadastrar usuarios, enviara um e-mail de acesso e obrigara cada novo usuario a trocar a senha no primeiro login.

Esse fluxo deixa o projeto mais coerente para um sistema de colaboradores, porque o acesso passa a ser controlado por quem ja esta dentro do sistema.
