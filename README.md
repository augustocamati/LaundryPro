# LaundryPro – Sistema de Gestão de Lavandaria (Angola)

> **Lavanderia premium, simples de usar e pronta para Angola**

## Índice
- [Visão Geral](#visão-geral)
- [Requisitos](#requisitos)
- [Instalação](#instalação)
- [Configuração da Base de Dados](#configuração-da-base-de-dados)
- [Rodando a Aplicação](#rodando-a-aplicação)
- [Rotas Principais](#rotas-principais)
- [Entidades CRUD](#entidades-crud)
- [Estrutura de Pastas](#estrutura-de-pastas)
- [Estilo & UI](#estilo--ui)
- [Licença](#licença)

---

## Visão Geral
LaundryPro é um **sistema de gestão de lavanderia** pensado para o mercado angolano.  
Ele utiliza um design moderno com cores vibrantes, **layout responsivo**, micro‑animações e segue o padrão **DAO + Model + View Controller** em PHP puro.

## Requisitos
- PHP **8.1+** (com extensão PDO MySQL)
- Composer (para instalar dependências, caso existam)
- MySQL/MariaDB
- Servidor web Apache/Nginx (ou o servidor embutido do PHP para desenvolvimento)

## Instalação
```bash
# 1️⃣ Clone o repositório
git clone https://github.com/augusto-camati/LaundryPro.git
cd LaundryPro

# 2️⃣ Instale dependências (opcional – o projeto não tem pacotes externos, mas mantém o composer.json)
composer install

# 3️⃣ Copie o exemplo de variáveis de ambiente
cp .env.example .env   # ou crie o .env manualmente
```

## Configuração da Base de Dados
1. Crie o banco **laundrypro** (ou outro nome e altere o `.env`).
```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS \`laundrypro\` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```
2. Importe o schema:
```bash
mysql -u root laundrypro < database/schema.sql
```
3. Atualize o arquivo **.env** com as credenciais corretas:
```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laundrypro
DB_USERNAME=root
DB_PASSWORD=   # <--- preencha se houver senha
DB_CHARSET=utf8mb4
APP_DEBUG=true
```

## Rodando a Aplicação
Durante o desenvolvimento pode usar o servidor embutido do PHP:
```bash
php -S localhost:8080 -t public
```
Acesse `http://localhost:8080` no navegador.

> **Dica:** se precisar de outra porta ou de escutar em todas as interfaces, altere `localhost:8080` para, por exemplo, `0.0.0.0:8000`.

## Rotas Principais
| Método | URI | Descrição |
|---|---|---|
| GET | `/` | Painel de controlo com estatísticas |
| GET | `/perfis` | Listar perfis |
| GET | `/perfis/novo` | Formulário de criação de perfil |
| POST| `/perfis` | Salvar novo perfil |
| GET | `/perfis/{id}/editar` | Formulário de edição |
| POST| `/perfis/{id}` | Atualizar perfil |
| POST| `/perfis/{id}/eliminar` | Eliminar perfil |
| … | *(mesmas convenções para `usuarios`, `funcionarios` e `clientes`)* |

## Entidades CRUD
- **Perfil** – cargos e permissões de acesso
- **Usuário** – credenciais (senha hash BCRYPT) e vínculo a perfil
- **Funcionário** – vinculado a um usuário, contém cargo, salário (AOA) e data de admissão
- **Cliente** – dados do cliente angolano (nome, **BI**, telefone, e‑mail, endereço)

## Estrutura de Pastas
```
app/
├─ Controllers/   # Controllers (Dashboard, Perfil, Usuario, Funcionario, Cliente)
├─ Core/          # Router, Controller base, Database singleton
├─ DAO/           # Data Access Objects (BaseDAO, PerfilDAO, …)
├─ Models/        # Entidades (Perfil, Usuario, Funcionario, Cliente, …)
└─ Views/         # Views PHP + partials (header/footer)
public/            # Front‑controller (index.php) + .htaccess
database/          # schema.sql e futuros migrations
.env               # variáveis de ambiente
composer.json       # autoloader PSR‑4 (App\ namespace)
```

## Estilo & UI
A UI foi desenvolvida com **CSS puro** (sem frameworks) seguindo as diretrizes de design premium:
- Palette escura com acentos azuis (`--primary`), fontes modernas (`Segoe UI` ou fallback) e sombras sutis.
- Componentes reutilizáveis: cards, botões, tabelas, badges.
- Responsividade via grid CSS – funciona em desktop e tablets.
- Animações de hover e transições leves para melhorar a experiência.

## Licença
Este projeto é distribuído sob a licença **MIT** – sinta‑se livre para usar, modificar e distribuir.

---

**⚡️ Comece já**: configure o `.env`, crie o DB, inicie o servidor e explore a interface de gestão de perfis, usuários, funcionários e clientes.
