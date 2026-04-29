# NeusPhone Laravel

Sigue estos pasos para clonar y configurar el proyecto para que funcione correctamente en tu entorno local ya debes tener instalado en tu entorno: Git, Composer, Node.js, PHP 8.4 y MySQL.

## 1. Clonar el repositorio

Abre tu terminal donde quieras clonar el proyecto y ejecuta el siguiente comando para descargar:

git clone https://github.com/juanrico1003-glitch/NeusPhone-Laravel.git

Luego, entra en la carpeta del proyecto:

cd NeusPhone-Laravel

## 2. Instalar dependencias

Instala las dependencias de PHP (Laravel) y las de Node (Frontend):

composer install
npm install

## 3. Configurar entorno

Crea tu archivo de entorno copiando el de ejemplo:

cp .env.example .env

## 4. Generar la clave de la aplicación

Genera la clave de seguridad de Laravel:

php artisan key:generate

## 5. Base de datos y almacenamiento

Ejecuta las migraciones y llena la base de datos con los datos iniciales, y luego crea el enlace de almacenamiento:

php artisan migrate:fresh --seed
php artisan storage:link

## 6. Compilar el Frontend

Por último, construye los recursos del frontend:

npm run build

El proyecto ya debería estar configurado y listo para funcionar.
