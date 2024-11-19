# Sistema de Gerenciamento de Tarefas

![Laravel](https://img.shields.io/badge/Laravel-11-blue) ![Vue.js](https://img.shields.io/badge/Vue.js-3-green) ![Status](https://img.shields.io/badge/Status-Concluído-brightgreen)

Este é um sistema simples de gerenciamento de tarefas desenvolvido com **Laravel** e **Vue.js**, projetado para gerenciar tarefas de usuários com níveis de permissão diferenciados (usuário comum e admin).

---

## Funcionalidades

### Cadastro de Usuário
- Usuários podem se cadastrar e fazer login no sistema.

#### Tela de Cadastro
![Tela de Cadastro](https://github.com/user-attachments/assets/12ae2a88-f134-4203-81f9-2f91aa4a1490)

#### Tela de Login
![Tela de Login](https://github.com/user-attachments/assets/04c77458-011b-4d60-aca2-da53a160965a)

---

### CRUD de Tarefas
- Criar, visualizar, editar e excluir suas próprias tarefas.
- Filtrar por status e ordenar por data de criação ou atualização.
- Usuários comuns só podem gerenciar suas próprias tarefas.

#### Tela de Tarefas
![image](https://github.com/user-attachments/assets/627ccbd9-d486-4f09-9230-f6b2fc8c7c22)

---

### Gerenciamento de Usuários (Admin)
- Administradores podem:
  - Editar e excluir usuários.
  - Criar, visualizar, editar e excluir tarefas de qualquer usuário.
  - Filtrar por status e ordenar tarefas por data.

#### Dashboard (Admin)
![Dashboard Admin](https://github.com/user-attachments/assets/562955ce-44bd-4c32-b2af-385fb1569df0)

#### Listagem de Usuários
![Listagem de Usuários](https://github.com/user-attachments/assets/9d7e4c0c-b25d-467b-9274-1dc2984147e0)

#### Listagem de Tarefas de um Usuário
![Tarefas do Usuário](https://github.com/user-attachments/assets/c549d3bb-6f55-4f93-84dc-09e5e5edaa73)

---

## Tecnologias Utilizadas
- **Framework Back-end:** Laravel 11
- **Framework Front-end:** Vue.js (via Inertia.js)
- **Banco de Dados:** MySQL
- **Estilo:** TailwindCSS
- **Testes:** Pest PHP
- **Bibliotecas Extras:**
  - SweetAlert para confirmações visuais.

---

## Como Rodar o Projeto

### Pré-requisitos
- PHP 8.2 ou superior
- Composer
- Node.js & npm
- MySQL

### Passos
1. Clone o repositório:
   ```bash
   git clone https://github.com/seu-usuario/nome-do-repositorio.git
   cd nome-do-repositorio
   ```

2. Instale as dependências PHP:
   ```bash
   composer install
   ```
   
3. Instale as dependências JavaScript:
   ```bash
   npm install
   ```

4. Configure as variáveis de ambiente:
   ```bash
   cp .env.example .env
   ```
   Configure o banco de dados no arquivo .env.

5. Execute as migrações e seeders::
   ```bash
   php artisan migrate --seed
   ```
6. Compile os assets front-end::
   ```bash
   npm run dev
   ```

7. Inicie o servidor em outro terminal:
   ```bash
   php artisan serve
   ```
8. Acesse a aplicação em: http://localhost:8000

9. Para rodar os testes:
    ```bash
    npm run dev
    ```

## Usuários de teste:
- Admin
  email: admin@admin.com
  senha: password

- Usuário
  email: user@email.com
  senha: password

