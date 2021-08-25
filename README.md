# Estetify Backend



## Requirements

- Docker
- Sail

## Install

```
cp .env.example .env
docker-compose --env-file ./.env up
docker-compose exec estetify-backend_laravel.test_1 composer install
```

## Tip

dps de instalar o projeto com o docker, adicionar o alias no no bash do terminal ou equivalente:

```
alias sail='bash vendor/bin/sail
```

depois de adicionar o comando vc pode executar todos os comandos do docker através do alias ```sail``` 

| command                   | short description                                     |
|---------------------------|-------------------------------------------------------|
| sail up                   | inicia a máquina do docker                            |
| sail php artisan          | executa o artisan através do php da maquina do docker |
| sail php artisan migrate  | roda o migrate na base do docker                      |



## Postman collection link

https://www.getpostman.com/collections/9544d5e53ea3cd1e6df3
