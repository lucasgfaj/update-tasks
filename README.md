# Update Tasks

Este guia descreve as etapas necessárias para configurar e atualizar o projeto Laravel - Update Tasks.

Banco de Dados do Projeto:

[Update Tasks no Notion](https://weak-airedale-459.notion.site/UpdateTasks-16079011507780a3948fea67621a0acb)

---

## Passos para Configuração

### 1. Renomear `.env.example` para `.env`

Renomeie o arquivo `.env.example` para `.env`:

```bash
cp .env.example .env
```

### 2. Ajustar o Arquivo `.env`

Abra o arquivo .env e ajuste as configurações do banco de dados conforme o seu ambiente:

```bash
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nome_do_banco
DB_USERNAME=usuario
DB_PASSWORD=senha
```

Substitua nome_do_banco, usuario e senha pelas credenciais do seu banco de dados PostgreSQL.

### 3. Instalar o PHP para PostgreSQL

Certifique-se de que o driver PHP para PostgreSQL (pdo_pgsql) está instalado.

No Ubuntu/Debian:

```bash
sudo apt-get install php-pgsql
sudo systemctl restart apache2
```

### 4. Gerar a Chave da Aplicação

Execute o seguinte comando para gerar a chave da aplicação:

```bash
php artisan key:generate
```

### Executando o Projeto

Depois de concluir as etapas acima, inicie o servidor de desenvolvimento:

```bash
php artisan serve
```




