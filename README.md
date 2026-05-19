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

---

## Funcionalidades adicionales

- **Automatización con n8n:**
    - Se integró n8n para automatizar el envío de correos de bienvenida cada vez que un nuevo usuario se registra.
    - El envío de correos utiliza SMTP con una cuenta de Gmail diferente a la principal del sistema.

- **Chatbot inteligente:**
    - El chatbot ahora utiliza una instancia local de IA (Ollama Llama 3.2:3b) conectada mediante n8n.
    - El chatbot puede leer la base de datos y hacer recomendaciones personalizadas a los clientes.
    - Ejemplo: Si el usuario pregunta por productos Samsung, el chatbot consulta el stock disponible, muestra el precio en COP, colores, nombre y si el producto es nuevo o usado.
    - El chatbot también informa sobre redes sociales y métodos de contacto disponibles.
