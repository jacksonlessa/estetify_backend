# Estetify Backend



## Requirements

- Docker
- Sail - para facilitar

## Sail

abra o arquivo de configuração do seu terminal exemplo
```nano ~/.bashrc```
e adicione no final do arquivo o alias para o sail

```alias sail='bash vendor/bin/sail'```



## Install

```
cp .env.example .env
docker-compose --env-file ./.env up -d || docker-compose up -d
docker-compose exec app composer install
docker-compose down
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate:fresh --seed
```

## Executando testes


```
docker-compose exec app php artisan test
```

## TO DO

Verificar arquivo todo.todo
