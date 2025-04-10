# API de Gerenciamento de Tarefas (Back-End) - Teste

Este projeto implementa autenticação usando [Laravel Passport](https://laravel.com/docs/12.x/passport) com Laravel 12 e banco de dados MySQL.

## Requisitos

-   PHP 8.1+
-   Composer
-   MySQL
-   Laravel 12

---

## Passos para configurar

### 1. Instalação do Passport

```bash
composer require laravel/passport
php artisan migrate
php artisan passport:install
```

### 2. Ajustes no `.env`

Configure corretamente os detalhes do banco e autenticação. Por padrão está configurado.:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=8889
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=root

PASSPORT_CLIENT_ID=2
PASSPORT_CLIENT_SECRET=xNVvTozRKntKz7nCX9PWtWct6Wo00Qi0p9hXGqhS
```

## Autenticação

### Login de Usuário [/api/login]

#### Efetuar login [POST]

-   Request (application/json)

          {
              "email": "rodrigo@velhobit.com.br",
              "password": "root"
          }

-   Response 200 (application/json)

          {
              "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...",
              "token_type": "Bearer",
              "user": {
                  "id": 1,
                  "name": "Root",
                  "role": "root",
                  ...
              }
          }

## Tarefas

### Criar Tarefa [/api/tasks]

#### Criar nova tarefa (login obrigatório) [POST]

-   Request (application/json)

    -   Headers

              Authorization: Bearer {token}

    -   Body

              {
                  "title": "Reunião com cliente",
                  "description": "Discutir escopo do novo projeto e cronograma de entregas",
                  "date": "2025-04-12",
                  "time": "14:30",
                  "color": "#ff5733",
                  "user_id": 1
              }

-   Response 201 (application/json)

          {
              "title": "Reunião com cliente",
              "description": "Discutir escopo do novo projeto e cronograma de entregas",
              "date": "2025-04-12",
              "time": "14:30",
              "color": "#ff5733",
              "uuid": "dd8209ee-74c2-4dcf-9148-d3ed12304049",
              ...
          }

### Atualizar Tarefa [/api/tasks/{uuid}]

-   Parameters
    -   uuid: ddd3baf2-31f0-47e1-8e0e-77699c2eb90f (string) - UUID da tarefa

#### Atualizar horário da tarefa (usuário dono ou root) [PUT]

-   Request (application/json)

    -   Headers

              Authorization: Bearer {token}

    -   Body

              {
                  "time": "19:30"
              }

-   Response 200 (application/json)

          {
              "uuid": "ddd3baf2-31f0-47e1-8e0e-77699c2eb90f",
              "title": "Reunião com cliente",
              ...
          }

### Deletar Tarefa [/api/tasks/{uuid}]

-   Parameters
    -   uuid: ddd3baf2-31f0-47e1-8e0e-77699c2eb90f (string)

#### Deletar tarefa (usuário dono ou root) [DELETE]

-   Request

    -   Headers

              Authorization: Bearer {token}

-   Response 200 (application/json)

          {
              "message": "Task deleted"
          }

### Listar Todas as Tarefas [/api/tasks]

#### Apenas visível para root [GET]

-   Request

    -   Headers

              Authorization: Bearer {token}

-   Response 200 (application/json)

          [
              {
                  "uuid": "dd8209ee-74c2-4dcf-9148-d3ed12304049",
                  "title": "Reunião com cliente",
                  ...
              }
          ]

### Listar Minhas Tarefas [/api/my-tasks]

#### Apenas as tarefas do usuário autenticado [GET]

-   Request

    -   Headers

              Authorization: Bearer {token}

-   Response 200 (application/json)

          [
              {
                  "uuid": "dd8209ee-74c2-4dcf-9148-d3ed12304049",
                  "title": "Reunião com cliente",
                  ...
              }
          ]

## Usuários

### Listar Usuários [/api/users]

#### Apenas visível para root [GET]

-   Request

    -   Headers

              Authorization: Bearer {token}

-   Response 200 (application/json)

          [
              {
                  "id": 1,
                  "name": "Root",
                  "role": "root",
                  ...
              }
          ]
