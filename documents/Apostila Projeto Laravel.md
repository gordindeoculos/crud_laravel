# Projeto Laravel 11 com Pacote de Autenticação Laravel/UI

## Preparar Ambiente de Desenvolvimento

### Instalar e Configurar os Programas

- PHP
- Composer
- Node.js (NPM)
- MySQL Server
- Visual Studio Code (VS Code)
- BDeaver
- Git
- Criar conta no GITHUB

### Configurações no arquivo `php.ini`

#### Habilitar as extensões:

```
extension=zip
extension=fileinfo
extension=curl
extension=gd
extension=mysqli
extension=pdo_mysql
extension=pdo_pgsql
extension=pdo_sqlite
extension=pgsql
extension=sqlite3
extension=mbstring
extension=openssl
```
Sobre as extensões habilitadas:

- **extension=zip**: Esta extensão permite ao PHP trabalhar com arquivos compactados no formato ZIP. Com ela, é possível criar, extrair e manipular arquivos ZIP diretamente no código PHP.

- **extension=fileinfo**: A extensão fileinfo permite ao PHP acessar informações detalhadas sobre arquivos, como tipo MIME, codificação de caracteres e outros detalhes, sem depender apenas da extensão do arquivo ou da sua extensão de nome.

- **extension=curl**: A extensão curl é utilizada para realizar requisições HTTP, FTP, e outras, de forma fácil e eficiente. Ela permite que o PHP interaja com outros servidores, fazendo solicitações e recebendo respostas, o que é fundamental para integração com APIs web, por exemplo.

- **extension=gd**: Esta extensão permite ao PHP manipular imagens, como criar, redimensionar, cortar e aplicar efeitos em imagens. Ela é comumente usada para processamento de imagens dinâmicas em aplicações web, como gerar miniaturas de imagens, aplicar filtros ou criar gráficos.

- **extension=mysqli**: A extensão mysqli (MySQL Improved) é uma melhoria sobre a extensão mysql padrão do PHP, oferecendo uma interface orientada a objetos para interagir com bancos de dados MySQL. Ela é usada para realizar operações de consulta, inserção, atualização e exclusão de dados em bancos de dados MySQL.

- **extension=pdo_mysql**: A extensão pdo_mysql fornece uma interface uniforme para acessar diversos bancos de dados relacionais, incluindo o MySQL, através do PDO (PHP Data Objects). Isso permite que o código PHP seja mais portável entre diferentes sistemas de gerenciamento de banco de dados.

- **extension=pdo_pgsql**: Similar à extensão pdo_mysql, esta extensão pdo_pgsql permite ao PHP interagir com bancos de dados PostgreSQL através do PDO, oferecendo uma camada de abstração para operações de banco de dados.

- **extension=pdo_sqlite**: Esta extensão habilita o suporte do PDO para o SQLite, um banco de dados leve e de fácil integração com aplicações web. O PDO fornece uma maneira consistente de acessar bancos de dados, o que torna o código mais portável.

- **extension=pgsql**: Essa extensão permite ao PHP interagir diretamente com bancos de dados PostgreSQL, oferecendo funções específicas para conectar, consultar e manipular dados em um banco de dados PostgreSQL.

- **extension=sqlite3**: Similar à extensão pdo_sqlite, esta extensão permite ao PHP trabalhar diretamente com bancos de dados SQLite, oferecendo funções específicas para operações como criação de tabelas, inserção de dados, consultas, entre outras.

- **mbstring**: Essa extensão é usada para manipulação de strings multibyte, ou seja, para trabalhar com caracteres multibyte, como os utilizados em vários idiomas além do inglês, como japonês, chinês, coreano, entre outros. Ela oferece funções para lidar com a conversão de encodings de strings, como UTF-8, e manipulação de caracteres multibyte. Isso é útil especialmente quando se trabalha com conteúdo de texto em sites multilíngues.

- **openssl**: Essa extensão fornece uma interface para o OpenSSL, uma biblioteca de software usada para implementar protocolos de segurança, como HTTPS para criptografia de dados em trânsito. A extensão `openssl` permite que o PHP se comunique com servidores usando protocolos seguros, como HTTPS, e também oferece funções para criar e gerenciar chaves criptográficas, certificados SSL/TLS e realizar operações criptográficas, como criptografia e assinatura digital.

#### Habilitar a exibição de erros em tela, o tipo de erro a ser reportado e o registro de logs de erros:

```
display_errors = On
error_reporting = E_ALL
log_errors = On
error_log = /tmp/php_errors.log
```

#### Aumentar o limite de memória (em Mb), bem como o tempo de execução máximo de cada script (em segundos):

```
memory_limit = 256M
max_execution_time = 120
```

#### Permitir o upload de arquivos e aumentar os limites de upload e envio de formulários:

```
session.gc_maxlifetime = 14000
```

## Criar o Projeto Laravel 11

Para criar um projeto em Laravel, execute o comando:

```bash
composer create-project laravel/laravel:^11.0 example-app
```

Para executar o servidor web embutido do Laravel, utilize o comando:

```bash
php artisan serve
```

Com o servidor em execução, acesse pelo navegador o link  `localhost:8000` ou `127.0.0.1:8000`.

## Instalar e Configurar o pacote de Autenticação Laravel/UI

Para instalar o pacote de autenticação do Laravel/UI, execute os comandos abaixo:

```bash
composer require laravel/ui
php artisan ui vue --auth
npm install
npm run build (ou vite build –watch)
```

## Configurar o idioma em português brasileiro

### Traduzir manualmente o idioma nos arquivos:

- `resources\views\layouts\app.blade.php`
- `resources\views\auth\login.blade.php`
- `resources\views\auth\register.blade.php`
- `resources\views\auth\passwords\email.blade.php`
- `resources\views\auth\passwords\reset.blade.php`

### Traduzir mensagens de retorno do Laravel para o idioma português brasileiro

1. Fazer o download dos arquivos de tradução pt-br:
https://drive.google.com/file/d/1MCfa-WWYhQuaN6qbp3YKfTTueovZI1Vl/view?usp=sharing

2. Executar o comando: `php artisan lang:publish`;

3. Descompactar o arquivo `Laravel_pt-BR.rar`;

4. Copiar a pasta `pt-br` para a pasta `lang`;

5. Modificar no arquivo `.env` o valor das variáveis `APP_LOCALE` e `APP_FALLBACK_LOCALE` para `pt-br`: 

```
APP_LOCALE=pt-br
APP_FALLBACK_LOCALE=pt-br
```

##  Configuração do fuso horário do Brasil

Modificar no arquivo `.env` o valor da variável `APP_TIMEZONE` para `America/Sao_Paulo`: 

```
APP_TIMEZONE=America/Sao_Paulo
```

## Configurar a Redefinição de Senha do Usuário

### Instalar o **MailHog**

Para testar a configuração de redefinição de senha, iremos utilizar o **MailHog** que é uma ferramenta de desenvolvimento que permite capturar e exibir e-mails enviados por aplicativos durante o desenvolvimento local, ele simular um servidor de e-mail SMTP local.

1. Acesse o link para download do **MailHog**: https://github.com/mailhog/MailHog/releases.

2. Faça o download do arquivo binário (executável) do **MailHog** de acordo com seu Sistema Operacional.

3. Inicie o **MailHog** executando o arquivo baixado, será apresentado na tela do terminal o seguinte conteúdo (ou algo parecido):

```
2024/04/02 04:37:21 Using in-memory storage
2024/04/02 04:37:22 [SMTP] Binding to address: 0.0.0.0:1025
[HTTP] Binding to address: 0.0.0.0:8025
2024/04/02 04:37:22 Serving under http://0.0.0.0:8025/
Creating API v1 with WebPath:
Creating API v2 with WebPath:
[APIv1] KEEPALIVE /api/v1/events
[APIv1] KEEPALIVE /api/v1/events
```

4. No seu navegador e acesse `http://localhost:8025` para carregar a tela do **MailHog**, deverá constar a informação `Connected`, se não estiver constando `Connected` algo deu errado.

### Habilitar extensões no `php.ini` para utilizar a redefinição de senha do Laravel

Abra o arquivo `php.ini` e habilite as extensões `mbstring` e `openssl`:

```ini
extension=mbstring
extension=openssl
```

As extensões `mbstring` e `openssl` são dois módulos populares do PHP, veja um resumo sobre cada uma delas: 

- **mbstring**: Essa extensão é usada para manipulação de strings multibyte, ou seja, para trabalhar com caracteres multibyte, como os utilizados em vários idiomas além do inglês, como japonês, chinês, coreano, entre outros. Ela oferece funções para lidar com a conversão de encodings de strings, como UTF-8, e manipulação de caracteres multibyte. Isso é útil especialmente quando se trabalha com conteúdo de texto em sites multilíngues.

- **openssl**: Essa extensão fornece uma interface para o OpenSSL, uma biblioteca de software usada para implementar protocolos de segurança, como HTTPS para criptografia de dados em trânsito. A extensão `openssl` permite que o PHP se comunique com servidores usando protocolos seguros, como HTTPS, e também oferece funções para criar e gerenciar chaves criptográficas, certificados SSL/TLS e realizar operações criptográficas, como criptografia e assinatura digital.

Ambas as extensões são bastante úteis em diferentes contextos de desenvolvimento web, especialmente em aplicações que necessitam de suporte a idiomas múltiplos e comunicação segura via internet.

### Configurar o **DotEnv** `(arquivo .env)` para utiliar o **MailHog**

*O Laravel utiliza a biblioteca `PHP DotEnv` . Em uma nova instalação do Laravel, o diretório raiz da sua aplicação conterá um `.env.example`, arquivo que define muitas variáveis ​​de ambiente comuns. Durante o processo de instalação do Laravel, este arquivo será automaticamente copiado para `.env`.*

Faça as alterações nas variáveis de ambiente `MAIL_*` no arquivo `.env` conforme abaixo:

```ini
MAIL_MAILER=smtp
MAIL_HOST=localhost
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="meu-email@mail.com.br"
MAIL_FROM_NAME="${APP_NAME}"
```

### Testar a Redefinição de Senha com o **MailHog**

1. Execute o **MailHog** e acesse `http://localhost:8025`.

2. Acesse a pasta do projeto e execute o servidor web embutido do Laravel:

```bash
php arisan serve
```

3. Acesse `http://localhost:8000` e faça o cadastro de um usuário clicando no link **Cadastrar** ou **Register**.

4. Já com um usuário cadastrado, clique no link para fazer o `Login`, no ***formulário de login*** clique no link `Esqueceu sua senha?`, no ***formulário de solicitação de redefinição de senha***, preencha com o e-mail de um usuário já cadastrado e clique no botão `Enviar Link de Redefinição de Senha`.

5. No **MailHog** acesse a **Caixa de Entrada (Inbox)** e irá ver o e-mail com o assunto **Reset Password Notification**, abra essa mensagem e no botão **Reset Password**, você será redirecionado para o formulário **Redefinir Senha**, altere sua senha e faça o login utilizando a nova senha.

Através deste teste é possível verificar que a **Redefinição de Senha** está ativa e funcionando. Para configurar um e-mail real, será necessário alterar as configurações das variáveis de ambiente `MAIL_*` do `DotEnv (arquivo .env)` de acordo com servidor de e-mail que contratar.

### Personalizar a notificação de Redefinição de Senha

Neste tópico iremos verificar como personalizar a mensagem (notificação) enviada por e-mail ao usuário quando solicitado a redefinição de senha.

#### Opção 1: Alterar diretamente no modelo padrão de notificação para redefinição de senha do Laravel (não recomendado)

Aqui, iremos fazer a alteração diretamente no modelo padrão de notificação de redefinição de senha por e-mail do Laravel, o que
não é recomendado, pois quando atualizar o diretório `vendor` ou quando for feito o clone do projeto onde não existe o diretório `vendor` que
será criado pelo comando `composer install`, toda essa configuração se perderá.

Abra o arquivo `vendor/laravel/framework/src/Illuminate/Auth/Notifications/ResetPassword.php` e altere o método (função) `buildMailMessage($url)` conforme abaixo:

```php
protected function buildMailMessage($url)
{
    return (new MailMessage)
        ->subject(Lang::get('Notificação de Redefinição de Senha'))
        ->line(Lang::get('Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.'))
        ->action(Lang::get('Redefinir Senha'), $url)
        ->line(Lang::get('Este link de redefinição de senha expirará em :count minutos.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
        ->line(Lang::get('Se você não solicitou uma redefinição de senha, nenhuma ação adicional é necessária.'));
}
```

Abra o arquivo `vendor/laravel/framework/src/Illuminate/Notifications/resources/views/email.blade.php` e altere os trechos de código conforme abaixo:

```php
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Opá, ocorreu um erro!')
@else
# @lang('Olá!')
@endif
@endif

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Atenciosamente'),<br>
{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
    "Se você está tendo problemas para clicar no botão \":actionText\", copie e cole a URL abaixo\n".
    'em seu navegador:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
```

#### Opção 2: Criar um modelo personalizado de notificação para redefinição de senha (recomendado)

Aqui iremos criar uma notificação de redefinição de senha por e-mail e personalizá-la, sem a necessidade de alterar o modelo padrão do Laravel, o que é recomendado e o correto a se fazer.

**Passo 1:** Crie uma nova classe Notification

Execute o seguinte comando no terminal para criar uma nova classe de notificação chamada `MyResetPassword`:

```
php artisan make:notification MyResetPassword
```

Este comando criará uma nova classe de notificação no diretório `app/Notifications`.

**Passo 2:** Adicione a nova classe Notification ao seu modelo de usuário

Abra o seu modelo de usuário (geralmente localizado em `app/Models/User.php`) e adicione a seguinte linha de código no topo do arquivo:

```php
use App\Notifications\MyResetPassword;
```

**Passo 3:** Adicione um novo método ao seu modelo de usuário

Dentro do seu modelo de usuário (`app/Models/User.php`), adicione o seguinte método:

```php
public function sendPasswordResetNotification($token)
{
    $this->notify(new MyResetPassword($token));
}
```

Esse método é responsável por enviar a notificação de redefinição de senha para o usuário quando solicitado.

**Passo 4:** Publique os modelos de notificação por e-mail

Execute o seguinte comando no terminal:

```
php artisan vendor:publish --tag=laravel-notifications
```

Este comando publicará os modelos de notificação por e-mail no diretório `resources/views/vendor/notifications`.

**Passo 5:** Edite a classe Notification `MyResetPassword`

1. Abra o arquivo da classe de notificação `MyResetPassword` (localizado em `app/Notifications/MyResetPassword.php`).

2. Adicione a classe:

    ```php
    use Illuminate\Support\Facades\Lang;
    ```

3. Adicione a variável  (atribuito) `public $token;`.

    ```php
    public $token;
    ```

4. Modifique o método construtor (`construct`) definindo o atributo `$this->token = $token;` conforme abaixo:

    ```php
    public function __construct($token)
    {
        $this->token = $token;
    }
    ```

5. Edite o método `toMail()` conforme o código:

    ```php
    public function toMail($notifiable)
    {
    $url = url(config('app.url') . '/password/reset/' . $this->token . '?email=' . urlencode($notifiable->getEmailForPasswordReset()));

    return (new MailMessage)
        ->subject(Lang::get('Notificação Personalizada de Redefinição de Senha'))
        ->line(Lang::get('** Essa notificação é personalizada ** Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.'))
        ->action(Lang::get('Redefinir Senha'), $url)
        ->line(Lang::get('Este link de redefinição de senha expirará em :count minutos.', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]))
        ->line(Lang::get('Se você não solicitou uma redefinição de senha, nenhuma ação adicional é necessária.'));
    }
    ```

**Passo 6:** Edite o modelo de folha de e-mail

Abra o arquivo `resources/views/vendor/notifications/email.blade.php` e altere os trechos de código conforme abaixo:

**Greeting**:

```php
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Opá, ocorreu um erro!')
@else
# @lang('Olá!')
@endif
```

**Salutation**):

```php
{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Atenciosamente'),<br>
{{ config('app.name') }}
```

**Subcopy**:

```php
{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
    "Se você está tendo problemas para clicar no botão \":actionText\", copie e cole a URL abaixo\n".
    'em seu navegador:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
```

**Passo 7:** Edite o `.env`

Para que não ocorra erro na geração do link de redefinição de senha, inclua a `url` completa na variável de ambiente `APP_URL` do **DotEnv** `(arquivo .env)`, para teste local utilizando o servidor web embutido do Laravel deve a url é `http://localhost:8000`:

```
APP_URL=http://localhost:8000
```

**Passo 8:** Edite o arquivo `lang\pt-br\passwords.php`

Para retornar uma mensagem personalizada quando o usuário fizer várias tentativas seguidas no ***formulário de solicitação de redefinição de senha***, acrescente ou altere a chave `throttled` dentro de `return[]`:

```php
'throttled' => 'Muitas tentativas de login. Tente novamente em alguns segundos.',
```

**Passo 9:** Personalizar o Template do E-mail de Redefinição de Senha

Execute o comando:

```bash
php artisan vendor:publish --tag=laravel-mail
```

Esse comando vai copiar os arquivos de template de e-mail para:

```
resources/views/vendor/mail/
```

Agora edite os arquivos:

* `resources/views/vendor/mail/html/layout.blade.php`
  👉 Esse é o layout geral (tem o logo do Laravel no topo).

* `resources/views/vendor/mail/html/header.blade.php`
  👉 É onde está o logo. Você pode remover ou trocar a imagem por outra.

Exemplo para trocar o logo:

```blade
{{-- resources/views/vendor/mail/html/header.blade.php --}}
<tr>
    <td class="header">
        <a href="{{ config('app.url') }}" style="display: inline-block;">
            <img src="{{ asset('images/seu-logo.png') }}" class="logo" alt="Nome da sua aplicação">
        </a>
    </td>
</tr>
```

> 📁 Garanta que sua imagem `seu-logo.png` esteja dentro de `public/images/`.

---

✅ Resultado

Depois disso, todos os e-mails enviados usarão seu layout personalizado, sem o logo do Laravel, e você poderá ajustar tudo como quiser — cores, espaçamentos, fontes, etc.

Após seguir esses passos, você terá personalizado com sucesso a mensagem de redefinição de senha do Laravel. Certifique-se de testar o processo de redefinição de senha para garantir que tudo funcione conforme o esperado.

#### Referências:
- https://stackoverflow.com/questions/39327954/laravel-5-3-redefine-reset-email-blade-template
- https://chat.openai.com/share/fbd20503-1c22-43d6-be97-f1a0e9e8b690