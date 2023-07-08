# Helpers

Funções simples para uso em diversos projetos

## Instalação 

composer require br.silassena/helpers

## Como usar 

Para usar basta importar a classe Helper e invocar uma função:

```
<?php

require __DIR__ . '/vendor/autoload.php';

use BrSilassena\Helpers\Helper;

echo "O nome mês 3 é : " . Helper::nomeMes(3);

```

## Requisitos

- php >=7.4