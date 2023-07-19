# Importação de Clientes | csv-imp

Este é um aplicativo demonstrativo que importa arquivos com registros de clientes em formato CSV para uma base de dados em MySQL e apresenta ao usuário, uma listagem de todos os clientes já importados junto com um breve gráfico relacionado a qualidade das informações registradas.

Para fins de performance, as inserções são feitas com bulk insert e carregados de forma assíncrona via JQuery.

## Começando
As próximas instruções te darão uma cópia do projeto para rodá-lo em sua máquina local com o propósito de desenvolvimento e testes.

### Pré Requisitos
O que você precisa para instalar?

* Git.
* PHP.
* Composer.
* Laravel.
* Docker.

### Instalação
Clone o repositório git em sua máquina local

```$ git clone https://github.com/Sedrez/csv-imp.git```

Após clonar a aplicação, você precisa instalar as dependências, rodando o seguinte script na pasta raiz do projeto.

```
$ ./csv-imp.sh
```

### Subindo os Containers

- Execute o seguinte comando de dentro da pasta raiz do projeto
```
$ ./vendor/bin/sail up
```

#### Criação da Base de dados e tabelas

- Com o usuário e senha configurados no .env, crie a base de dados dentro do container do Mysql
```
$ docker exec -it csv-imp-mysql-1 bash
```
```
$ mysql -u sail -p -h localhost -e "CREATE DATABASE csv_imp;"
```


- Execute o Migrate para criação das tabelas de dentro do container da aplicação
```
$ docker exec -it csv-imp-laravel.test-1 bash
```
```
$ php artisan migrate
```

#### Acesso a aplicação
- Em qualquer navegador atualizado, acesse
```
localhost/customers
```

