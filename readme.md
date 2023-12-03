# Taller N°2 - Sistema Dumbo
![GitHub last commit](https://img.shields.io/github/last-commit/nico-alv/taller2-webmovil/main)

[![Image from Gyazo](https://i.gyazo.com/d583f9515331b027cf7b3ff47b8bfe70.gif)](https://gyazo.com/d583f9515331b027cf7b3ff47b8bfe70)

Solución para el segundo taller de la asignatura de introducción al desarrollo web móvil en la cual se pide realizar un CRUD de usuarios y un inicio de sesión de administradores con JSON Web Tokens.

----

### Dependencias

1. [XAMPP](https://sourceforge.net/projects/xampp/)

2. [Composer](https://getcomposer.org)

3. [Node.js](https://nodejs.org/en)

4. [Git](https://git-scm.com/downloads)

> Se debe tener cuidado de instalar composer después de XAMPP ya que este último es responsable de la instalación de PHP.

### Levantando el proyecto
- Clona el repositorio a tu máquina local.
- Iniciar Apache y MySQL en el panel de control de XAMPP.
- Abrir http://localhost/phpmyadmin/ y crear nueva base de datos.
- Abrir una terminal dentro de la carpeta raíz del proyecto. 

### Backend

Entra al directorio del backend, copia el archivo .env.example.
```
cd .\backend\ 
```
```
copy .env.example .env 
```
Dentro de este archivo configurar el puerto, nombre, usuario y contraseña de la base de datos creada previamente.
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taller2
DB_USERNAME=root
DB_PASSWORD=
```
Instalar las dependencias de composer.json.
```
composer install
```
```
php artisan key:generate
```
Generar la llave con la que se cifrarán los tokens.
```
php artisan jwt:secret
```
Ejecutar migraciones y seeders.
```
php artisan migrate:fresh --seed
```
Arrancar el backend.
```
php artisan serve
```

#### Frontend
Luego, abrir otra terminal en la raiz del proyecto y ejecutar:
```
cd .\frontend\
```
Instalar dependencias guardadas en package.json.
```
npm install
```
Arrancar el frontend.
```
npm run start
```

----

#### Uso
- Para entrar al frontend accede a http://localhost:3000.
- Para probar la API separadamente, puedes utilizar Postman o herramientas similares.

#### Notas
- Se implementó una documentación de la API con swagger, para acceder a esta, se debe ingresar al siguiente endpoint:
http://127.0.0.1:8000/api/documentation
