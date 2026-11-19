# GestorOS

Sistema web para gestão de ordens de serviço, clientes e equipes técnicas.

O projeto centraliza o ciclo de atendimento em um único lugar: cadastro do cliente, abertura da OS, definição de prioridade, atribuição de responsável, acompanhamento de status e histórico das movimentações.

## Principais recursos

- Dashboard operacional com indicadores de ordens abertas, em andamento, concluídas e urgentes.
- Cadastro, edição, busca e histórico de clientes.
- Criação e edição de ordens de serviço.
- Status de atendimento: aberta, em andamento, aguardando peça, concluída e cancelada.
- Prioridades baixa, normal, alta e urgente.
- Atribuição de técnico responsável.
- Valores estimado e final do atendimento.
- Agendamento da execução do serviço.
- Histórico de alterações e observações da ordem.
- Interface responsiva com Tailwind CSS.
- Rotas do sistema protegidas pelo middleware `auth`.

## Autenticação

A autenticação usa Laravel Fortify e possui telas para:

- Login.
- Cadastro de usuário.
- Recuperação e redefinição de senha.
- Confirmação de senha.
- Desafio de autenticação em dois fatores.

Também estão habilitados no Fortify o suporte de 2FA e passkeys no modelo `User`. As telas e callbacks ficam em:

- `app/Providers/FortifyServiceProvider.php`
- `resources/views/layouts/auth.blade.php`
- `resources/views/auth/`
- `config/fortify.php`

As rotas de login, cadastro e recuperação são fornecidas pelo Fortify. As rotas do dashboard, clientes e ordens de serviço estão agrupadas com `Route::middleware('auth')` em `routes/web.php`.

## Requisitos

- PHP 8.3 ou superior.
- Composer.
- Node.js e npm.
- SQLite, MySQL ou outro banco suportado pelo Laravel.
- Extensão PHP `pdo_sqlite` para executar os testes padrão, que usam SQLite em memória.

## Instalação

Clone o projeto e entre na pasta:

```bash
git clone <url-do-repositorio> GestorOS
cd GestorOS
```

Instale as dependências PHP e JavaScript:

```bash
composer install
npm install
```

Crie o arquivo de ambiente e gere a chave da aplicação:

```bash
cp .env.example .env
php artisan key:generate
```

### Banco SQLite

O `.env.example` usa SQLite. Caso o arquivo ainda não exista, crie-o:

```bash
touch database/database.sqlite
```

Confirme no `.env`:

```env
DB_CONNECTION=sqlite
```

Execute as migrações e os dados demonstrativos:

```bash
php artisan migrate --seed
```

### Banco MySQL

Se preferir MySQL, configure no `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=GestorOS
DB_USERNAME=root
DB_PASSWORD=
```

Depois execute:

```bash
php artisan migrate --seed
```

## Executando localmente

Para iniciar o ambiente completo:

```bash
composer run dev
```

Alternativamente, execute os processos separadamente:

```bash
php artisan serve
npm run dev
```

Para gerar os assets de produção:

```bash
npm run build
```

## Usuários demonstrativos

O `DatabaseSeeder` cria usuários para desenvolvimento local. Todos usam a senha padrão:

```text
password
```

Usuários criados:

- `ana@gestoros.test`
- `carlos@gestoros.test`
- `marina@gestoros.test`
- `gestor@gestoros.test`

Essas credenciais são apenas para ambiente local e não devem ser usadas em produção.

## Rotas principais

| Método | Rota | Descrição |
| --- | --- | --- |
| `GET` | `/login` | Tela de login do Fortify |
| `GET` | `/register` | Tela de cadastro |
| `GET` | `/forgot-password` | Recuperação de senha |
| `GET` | `/` | Dashboard autenticado |
| `GET` | `/service-orders` | Lista de ordens de serviço |
| `GET` | `/service-orders/create` | Nova ordem de serviço |
| `GET` | `/customers` | Lista de clientes |
| `GET` | `/customers/create` | Novo cliente |

As rotas de negócio exigem autenticação. Usuários visitantes são redirecionados para `/login`.

## Estrutura do projeto

```text
app/
├── Actions/Fortify/       # Ações de cadastro, senha e perfil
├── Http/Controllers/      # Dashboard, clientes e ordens de serviço
├── Http/Requests/         # Validação dos formulários
├── Models/                # User, Customer, ServiceOrder e histórico
└── Providers/             # Configuração da aplicação e do Fortify

database/
├── factories/             # Dados para testes e seeders
├── migrations/            # Usuários, clientes, OS, 2FA e passkeys
└── seeders/               # Dados demonstrativos

resources/views/
├── auth/                  # Telas de autenticação Fortify
├── customers/             # Telas de clientes
├── service-orders/        # Telas de ordens de serviço
├── components/            # Badges reutilizáveis
└── layouts/               # Layouts principal e de autenticação
```

## Testes e qualidade

Execute a suíte completa com:

```bash
php artisan test --compact
```

Ou usando o script do Composer:

```bash
composer test
```

Para formatar os arquivos PHP modificados:

```bash
vendor/bin/pint --dirty --format agent
```

Os testes de feature usam SQLite em memória. Em máquinas sem `pdo_sqlite`, instale/habilite essa extensão antes de executar a suíte.

## Configuração de e-mail

Por padrão, o projeto usa o mailer `log`, adequado para desenvolvimento. Links de recuperação de senha podem ser consultados nos logs da aplicação:

```bash
tail -f storage/logs/laravel.log
```

Para produção, configure um provedor SMTP ou uma integração de e-mail no `.env`.

## Próximas evoluções

O núcleo de atendimento está pronto para receber novos módulos, como:

- Permissões por perfil e equipe.
- Anexos e fotos da execução.
- Estoque e peças utilizadas.
- Orçamentos e aprovação do cliente.
- Faturamento e formas de pagamento.
- Notificações por e-mail ou WhatsApp.
- Relatórios de produtividade e SLA.

## Licença

Este projeto utiliza a licença MIT.
