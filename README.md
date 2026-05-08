# Halcón Paquetería — Sistema de Seguimiento de Pedidos

Aplicación web desarrollada como proyecto escolar para **Halcón**, una distribuidora de materiales de construcción. El sistema permite registrar, dar seguimiento y gestionar pedidos desde que se crean hasta que se entregan al cliente.

---

## ¿Qué hace esta aplicación?

El sistema cubre todo el flujo de un pedido:

1. **Ventas** registra un pedido nuevo con los datos del cliente
2. **Almacén** lo prepara y actualiza el estado
3. **Ruta** lo entrega y sube fotos como evidencia
4. **El cliente** puede consultar el estado de su pedido desde internet, sin necesidad de crear una cuenta

Los administradores tienen acceso completo: pueden gestionar usuarios, ver pedidos archivados y restaurarlos.


---

## Roles del sistema

| Rol | Qué puede hacer |
|---|---|
| **Admin** | Todo: usuarios, pedidos, archivados, restaurar |
| **Sales (Ventas)** | Crear y ver pedidos, ver productos |
| **Purchasing (Compras)** | Ver pedidos y productos |
| **Warehouse (Almacén)** | Ver pedidos, actualizar estado, items |
| **Route (Ruta)** | Ver pedidos, subir fotos de entrega |

---

## Flujo de estados de un pedido

```
Ordered → In process → In route → Delivered
(Ordenado)  (En proceso)  (En ruta)  (Entregado)
```

Solo se puede avanzar en orden, no se puede saltar estados ni regresar.

---

## Instalación local

> Requisitos: PHP 8.2, Composer, MySQL, Node.js, MAMP (o similar)

```bash
# 1. Clonar el repositorio
git clone <url-del-repo>
cd halcon-app

# 2. Instalar dependencias de PHP
composer install

# 3. Instalar dependencias de Node
npm install

# 4. Copiar el archivo de configuración
cp .env.example .env

# 5. Generar la clave de la aplicación
php artisan key:generate
```

**Configurar la base de datos en `.env`:**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=8889
DB_DATABASE=halcon_app
DB_USERNAME=root
DB_PASSWORD=root
```

```bash
# 6. Ejecutar migraciones y seeders
php artisan migrate --seed

# 7. Crear enlace de almacenamiento (para fotos)
php artisan storage:link

# 8. Compilar los assets
npm run build

# 9. Iniciar el servidor
php artisan serve
```

La app estará disponible en `http://localhost:8000`

---

## Usuario de prueba

Después de correr los seeders, puedes entrar con:

| Campo | Valor |
|---|---|
| Email | `admin@halcon.com` |
| Contraseña | `password` |
| Rol | Admin |

---

## Estructura del proyecto

```
halcon-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Lógica de cada módulo
│   │   └── Middleware/        # RoleMiddleware (control de acceso)
│   └── Models/                # Order, User, Product, Role...
├── database/
│   ├── migrations/            # Estructura de la base de datos
│   └── seeders/               # Datos iniciales (roles, admin)
├── resources/
│   ├── css/app.css            # Estilos con variables de diseño
│   └── views/                 # Plantillas Blade
│       ├── layouts/app.blade.php   # Navbar + footer compartido
│       ├── orders/            # Crear, ver, editar, archivar pedidos
│       ├── users/             # Gestión de usuarios (solo Admin)
│       └── welcome.blade.php  # Página pública de rastreo
├── routes/web.php             # Todas las rutas de la app
└── public/
    └── logo.png               # Logo de Halcón Paquetería
```

---

## Páginas principales

| URL | Descripción | Acceso |
|---|---|---|
| `/` | Rastrear pedido (pública) | Todos |
| `/login` | Iniciar sesión | Todos |
| `/dashboard` | Panel principal por rol | Usuarios activos |
| `/orders` | Lista de pedidos | Sales, Warehouse, Route, Purchasing, Admin |
| `/orders/create` | Crear pedido | Sales, Admin |
| `/users` | Gestión de usuarios | Admin |
| `/orders-archived` | Pedidos archivados | Admin |

---

## Documentación y diseño

- **Prototipo en Figma:** https://www.figma.com/design/zVmPvpwObtT3G7Bg4ZCByP/Untitled?node-id=0-1&t=e9Kq5bATkLaGVAFW-1
- **Documento del proyecto:** `docs/Learning Outcome 1.pdf`

---

## Autora

Proyecto escolar desarrollado por **Equipo 3**
