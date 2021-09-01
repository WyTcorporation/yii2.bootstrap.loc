.htaccess надо разкометировать api

в common/config/bootstrap.php
разкоментировать api

в  api/config/main.php 
разкоментировать api

  'aliases' => [
        //'@api' => dirname(dirname(__DIR__)) . '/api',
    ]
    
Минус в том что каждый раз нужно создавать новый модуль, импортировать нельзя ( 