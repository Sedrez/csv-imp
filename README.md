# Importação de Clientes | csv-imp

Este é um aplicativo demonstrativo que importa arquivos com registros de clientes em formato CSV para uma base de dados em MySQL e apresenta ao usuário, uma listagem de todos os clientes já importados junto com um breve gráfico relacionado à qualidade das informações registradas.

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

Após clonar a aplicação, você precisa instalar as dependências.

```
$ cd cvs-imp
```
```
$ ./csv-imp.sh
```

###Para WSL (Linux no Windows)
```
$ cd ..
$ php ./artisan sail:install --with=mysql
$ cd cvs-imp
$ php ./artisan sail:install --with=mysql
```
Parece loucura essa parte do WSL, se alguém conhecer o motivo, mande um oi. Tenho print pra provar.

### Subindo os Serviços

- Execute a aplicação
```
./vendor/bin/sail up
```

- Execute o Migrate para criação da base de dados
```
$ docker exec -it csv-imp_laravel.test_1 bash php artisan migrate
```

- Acesse no nacegador
```
localhost/customers
```
  
