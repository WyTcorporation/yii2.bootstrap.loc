Перед миграцией закоментировать

    common/config/params.php
    
    'languages' => get_languages(),

Создаем роли для пользователей

php yii migrate --migrationPath=@yii/rbac/migrations

php yii migrate

Создать 3 пользователя 

    1 суперАдмин
    
    2 админ
    
    3 модератор

php yii rbac-start/init

admin pass 123456789
moder pass 123456789