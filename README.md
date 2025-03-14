Crear proyecto symfony:
composer create-project symfony/skeleton:"7.2.x" HITO_1

(en realidad descargamos en proyecto del repo de clase e hicimos composer install y lo subimos al repo propio de github)

Para actualizar datos en el proyecto de GitHub:

git push origin main

Conexión base de datos en el archivo .env:
DATABASE_URL="mysql://root@127.0.0.1:3306/cpanelouz?serverVersion=10.4.28-MariaDB&charset=utf8mb4"
(creo una conexion para una bbdd con el nombre de mi usuario)

Creo la bbdd con:
php bin/console doctrine:database:create

Creo HelloController con el comando:

php bin/console make:controller HelloController

A continuación sigo los pasos del siguiente link hasta la sección JSON Login:

https://symfony.com/doc/current/security.html 

Después de seguir los pasos del enlace previo y comprobar que puedo registrar un usuario, hago la redirección del login a hello editando el fichero security.yaml (info:chatgpt):

 form_login:
                login_path: app_login
                check_path: app_login
                default_target_path: app_hello
                enable_csrf: true
