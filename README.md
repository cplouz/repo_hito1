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


---- CREACIÓN DE NUEVA ENTIDAD

ENTIDAD:Examen

String  	Materia
Float   	Nota    
DateTime	Fecha


Creo la entidad con php bin/console make:entity y con >relation veo cual es la que más me conviene para la relacion con user 


Luego, actualizo la base de datos:

php bin/console make:migration 
php bin/console doctrine:migrations:migrate 

Creo un servicio "ExamenService", copio la carpeta service a src de un ejercicio anterior.


Una vez configurado el servicio "ExamenService" creo el controlador de ExamenController con el comando:

hp bin/console make:controller ExamenController

La estructura del ExamenController la saqué del ejercicio que hicimos donde teníamos NotaController

Configuración de bootstrap con AssetMapper para las plantillas de twig:

BOOTSTRAP (INFO: https://symfony.com/doc/current/frontend/asset_mapper.html)

composer require symfony/asset-mapper symfony/asset symfony/twig-pack


php bin/console importmap:require bootstrap


php bin/console importmap:install


En cuanto a las plantillas, tengo una genérica en Examen, para cuando accedes desde el login, que contiene un menu para hacer logout, crear examenes y listar examenes.

Para la validación, eligo la básica, añadiendo una constraint en la entidad de examen, pero para ello antes ejecuto e comando:
 composer require symfony/validator

 Para agregar la función de listar agrego codigo en ExamenController, ExamenService, ExamenRepository, además de añadir una plantilla de listar.

 Para el caso de eliminar agrego codigo en ExamenController, ExamenService, y paso el id del examen que quiero borrar desde la lista, donde agrego la funcion de eliminar 
 en cada examen, que es un formulario que envia el id al controlador.
 
 

