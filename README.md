# SGC


# Sistema de Gerenciamento de Condominios

Tecnologias utilizadas:
 - Laravel 11
 - PHP 8.3
 - Banco de dados PostgreSQL 16.4

Modulos Criados ou em construção
 - Crud de Usuário
 - Crud de Moradores
 - Crud de Unidade


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