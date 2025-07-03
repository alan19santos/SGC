# SGC


# Sistema de Gerenciamento de Condominios

Tecnologias utilizadas:
 - Laravel 10
 - PHP 8.3
 - Banco de dados PostgreSQL 16.4
 - Dockerfile e Docker-compose

Modulos Criados ou em construção:
 - Crud de Usuário
 - Crud de Moradores
 - Crud de Unidade
 - Crud de Reserva
 - Crud de Ocorrências
 - Crud de Visitantes
 - Crud de Prestador de Serviços
 ......

Comandos:
- composer install
- php artisan storage:link

Criação de Testes Unitário
  - Comandos de Teste:
    - php artisan test / php artisan test --filter NomeDoTeste / php artisan test tests/Unit/NomeDoTeste.php

Comandos PHPUnit Exemplos: 
- Exemplo para Feature:
  - php artisan make:test UserTest
- Exemplo para teste unit
  - php artisan make:test UserTest --unit

- Criação de migrations
# Rodar migrate especifica
- php artisan migrate --path=/database/migrations/selected/


# Rodando o Docker:
- docker-compose up -d --build
- docker exec -it sgc bash
- docker compose down

# Rodar as migrate no servidor
- composer install
- php artisan key:generate
- php artisan migrate

# Rodar a seeders para logar no sistema
- php artisan db:seed --class=UserAdmSeeder
- php artisan db:seed --class=ProfileSeeder
- php artisan db:seed --class=UserProfileSeeder


# PhpStan (Analise de código)
- php vendor/phpstan/phpstan/phpstan analyse app --memory-limit=512M
