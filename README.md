# NeusPhone Laravel

Plataforma de comercio electrónico para venta de dispositivos electrónicos (celulares, laptops, tablets, componentes PC, accesorios) con sistema de servicio técnico, chatbot IA y pasarela de pagos Wompi.

## Requisitos

- PHP 8.4+
- Composer
- Node.js 20+
- MySQL 8+
- Git

## Instalación

```bash
# 1. Clonar
git clone https://github.com/juanrico1003-glitch/NeusPhone-Laravel.git
cd NeusPhone-Laravel

# 2. Dependencias
composer install
npm install

# 3. Entorno
cp .env.example .env
# Edita .env con tus credenciales de base de datos y servicios

# 4. Generar clave
php artisan key:generate

# 5. Base de datos
php artisan migrate:fresh --seed
php artisan storage:link

# 6. Frontend
npm run build

# 7. Iniciar servidor
php artisan serve
```

## Funcionalidades

### Tienda
- Catálogo de productos con filtros por categoría, marca, precio, tipo (nuevo/usado)
- Vista detalle con selector de variantes (color, RAM, almacenamiento, procesador, GPU)
- Productos recomendados y testimonios
- Búsqueda por nombre, marca y descripción
- Paginación (20 productos por página)

### Carrito y Checkout
- Carrito basado en sesión
- Formulario de envío con departamentos/municipios de Colombia
- Cupones de descuento (porcentaje o fijo)
- Integración con Wompi (pagos en COP)
- Modo simulación para desarrollo

### Pedidos
- Estados: pendiente → pagado → enviado → entregado / cancelado
- Restauración automática de stock al cancelar
- Notificaciones por email al cambiar estado
- Descarga de factura PDF
- Historial de pedidos por cliente

### Panel Administrativo
- Dashboard con estadísticas: ventas, productos, pedidos, usuarios
- CRUD de productos con imágenes y campos dinámicos por categoría
- Gestión de pedidos (cambiar estado, ver detalle)
- Gestión de solicitudes de servicio técnico
- Administración de usuarios (roles, activar/desactivar)
- Cupones de descuento (CRUD)
- Moderación de testimonios/reseñas

### Clientes
- Dashboard personal con perfil, pedidos, servicios y reseñas
- Actualización de perfil y contraseña
- Solicitud de eliminación de cuenta (30 días de recuperación)

### Automatización
- `php artisan app:check-low-stock` — Alerta diaria de stock crítico a administradores
- `php artisan app:purge-deleted-accounts` — Eliminación permanente de cuentas vencidas

### Chatbot IA
- Integración con Ollama (Llama 3.2:3b) vía n8n
- Recomendaciones personalizadas de productos
- Consultas de stock, precios y disponibilidad

### Seguridad
- Throttling de inicio de sesión (5 intentos máximos)
- Validación de tipos de archivo en imágenes subidas
- Soft delete de cuentas con período de gracia
- Middleware de administrador
- Protección CSRF en formularios

## Variables de entorno importantes

| Variable | Descripción |
|----------|-------------|
| `DB_*` | Conexión a base de datos MySQL |
| `MAIL_*` | Configuración SMTP para correos |
| `WOMPI_*` | Credenciales de Wompi (pagos) |
| `N8N_*` | Webhooks de n8n (chatbot, bienvenida) |
| `GOOGLE_*` | Credenciales OAuth de Google |

## Acceso desde dispositivos móviles en red local

Para ver la app desde tu teléfono en la misma red:

**Terminal 1 - Servidor Laravel:**
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

**Terminal 2 - Túnel LocalTunnel:**
```bash
npm install -g localtunnel  # Solo la primera vez
lt --port 8000
```

Luego abre en el navegador del teléfono la URL que aparece:
```
https://[subdomain-aleatorio].loca.lt
```

### Notas
- Los assets (CSS/JS) se sirven con rutas relativas `/build/...` y funcionan desde cualquier dominio
- La sesión se comparte entre acceso local y túnel (misma base de datos)
- Para desarrollo local sin túnel: `http://127.0.0.1:8000` o `http://localhost:8000`

## Programación de tareas

Configura el scheduler de Laravel en tu servidor:

```
* * * * * cd /ruta/proyecto && php artisan schedule:run >> /dev/null 2>&1
```

## Stack tecnológico

- **Backend:** Laravel 12, MySQL
- **Frontend:** Tailwind CSS 3, Alpine.js, GSAP, Vite
- **Pagos:** Wompi (sandbox/producción)
- **IA:** Ollama + n8n (chatbot)
- **Autenticación:** Laravel Breeze + Socialite (Google)
- **PDF:** barryvdh/laravel-dompdf
