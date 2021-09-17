# Estetify Backend



## Requirements

- Docker
- Sail - para facilitar

## Sail

abra o arquivo de configuração do seu terminal exemplo
```nano ~/.bashrc```
e adicione no final do arquivo o alias para o sail

```alias sail='bash vendor/bin/sail')```

## Install

```
cp .env.example .env
docker-compose --env-file ./.env up -d
docker-compose exec laravel.test composer install
docker-compose down
sail up |OR| vendor/bin/sail up
sail artisan key:generate |OR| vendor/bin/sail artisan key:generate
```

## Exemplos do uso do sail

sail é um atalho para ```docker-compose exec laravel.test``` 

| command                   | short description                                     |
|---------------------------|-------------------------------------------------------|
| sail up                   | inicia a máquina do docker                            |
| sail php artisan          | executa o artisan através do php da maquina do docker |
| sail php artisan migrate  | roda o migrate na base do docker                      |



## Postman collection link

https://www.getpostman.com/collections/9544d5e53ea3cd1e6df3


## TO DO

Verificar arquivo todo.todo