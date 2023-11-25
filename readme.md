# Taller N°2 - Intro. al desarrollo web/móvil
## Pasos a seguir:

### Instalacion del servidor

- [Instalar MySQL Server y MySQL workbench.](https://dev.mysql.com/downloads/installer/) 

- Entrar a la base de datos creada mediante mysql workbench con las credenciales ingresadas en la instalacion o entrar mediante una terminal con el comando mysql -u root -p (en caso de que este no funcione se debe añadir la carpeta "C:\Program Files\MySQL\MySQL Server 5.5\bin\" a las variables de entorno)
- Crear un nuevo schema: ejecutar create database taller-2;

### Dependencias

- [Instalar Composer.](https://getcomposer.org)

- [Instalar Node.js.](https://nodejs.org/en)

#### Backend:
    Abrir una terminal dentro de la carpeta raíz del proyecto
    - cd .\backend\ 
    - copy .env.example .env 
    - Dentro de este archivo configurar el puerto, nombre, usuario y contraseña de la base de datos creada previamente.

    Luego, ejecutar los siguientes comandos:

    composer install
    php artisan key:generate
    php artisan migrate:fresh
    php artisan db:seed
    php artisan serve


#### Frontend:
    Luego, abrir otra terminal en la raiz del proyecto y ejecutar:

    cd .\frontend\
    npm install
    npm run start

