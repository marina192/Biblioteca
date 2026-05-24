<div align="center">

# 📚 Edda — Sistema de Gestión de Biblioteca

Sistema web para la gestión de préstamos, libros y usuarios de una biblioteca, desarrollado con Laravel 10.

</div>

---

## Requisitos del Sistema

| Herramienta | Versión mínima |
|-------------|---------------|
| PHP | 8.2+ |
| Composer | 2.x |
| MySQL | 8.0+ |
| Node.js | 18+ |
| NPM | 9+ |

---

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/tu-usuario/edda.git
cd edda
```

### 2. Instalar dependencias PHP

```bash
composer install
```

### 3. Instalar dependencias de frontend

```bash
npm install
```

### 4. Configurar el entorno

```bash
cp .env.example .env
php artisan key:generate
```

Edita el archivo `.env` con tus datos (ver sección [Variables de Entorno](#variables-de-entorno)).

### 5. Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```

Esto crea todas las tablas y ejecuta el `DatabaseSeeder`, que incluye roles, usuarios de prueba, categorías, libros, ejemplares y préstamos de muestra.

### 6. Iniciar la aplicación

**Opción A — Desarrollo con hot reload (requiere dos terminales):**

```bash
# Terminal 1 — Vite
npm run dev

# Terminal 2 — Laravel
php artisan serve
```

**Opción B — Solo ver el proyecto funcionando:**

```bash
npm run build
php artisan serve
```

> Si no se ejecuta alguno de estos comandos, la aplicación cargará sin estilos.

La aplicación estará disponible en `http://localhost:8000`.

> **Colas (opcional):** Si deseas que los correos se envíen en segundo plano, ejecuta en una terminal aparte:
> ```bash
> php artisan queue:work
> ```

---

## Variables de Entorno

Estas son las variables que debes ajustar en tu archivo `.env`:

### Aplicación

```env
APP_KEY=        # Se genera automáticamente con php artisan key:generate
APP_URL=http://localhost:8000
```

### Base de datos

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=biblioteca   # Crea esta base de datos en MySQL antes de migrar
DB_USERNAME=             # Tu usuario de MySQL
DB_PASSWORD=             # Tu contraseña de MySQL
```

### Correo electrónico

El proyecto usa Gmail como servidor de correo. Necesitas una **contraseña de aplicación** de Google (no tu contraseña normal):

1. Ve a tu cuenta de Google → Seguridad → [Contraseñas de aplicación](https://myaccount.google.com/apppasswords)
2. Crea una contraseña para "Correo" y cópiala

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=2525
MAIL_USERNAME=           # Tu correo de Gmail
MAIL_PASSWORD=           # La contraseña de aplicación generada
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=       # El mismo correo de Gmail
```

### Colas

```env
QUEUE_CONNECTION=database
```

---

## Usuarios de Prueba

El seeder crea dos usuarios listos para usar:

| Rol | Nombre | Correo | Contraseña |
|-----|--------|--------|------------|
| Administrador | Administrador | admin@gmail.com | 12345678 |
| Lector | Lector | lector@gmail.com | 12345678 |

> El dashboard de cada usuario se accede haciendo clic en **Edda** (el nombre de la aplicación) en la barra de navegación.

---

## Dependencias Principales

| Paquete | Uso |
|---------|-----|
| `laravel/sanctum` | Autenticación de la API mediante tokens |
| `spatie/laravel-permission` | Control de roles (`admin`, `lector`) |
| `barryvdh/laravel-dompdf` | Generación de reportes en PDF |
| `livewire/livewire` | Componentes reactivos en el frontend |

---

## API Reference

La base URL de la API es `/api`. Las respuestas son siempre en formato JSON.

---

### Autenticación

#### `POST /api/login`

Inicia sesión y devuelve un token de acceso para usar en los demás endpoints.

**No requiere autenticación.**

**Body (JSON):**

```json
{
  "email": "lector@gmail.com",
  "password": "12345678"
}
```

**Respuestas:**

| Código | Descripción |
|--------|-------------|
| `200 OK` | Login exitoso, devuelve el token |
| `401 Unauthorized` | Credenciales incorrectas |
| `422 Unprocessable` | Campos faltantes o inválidos |

**Ejemplo de respuesta `200`:**

```json
{
  "token": "1|abc123xyz..."
}
```

Usa este token en todos los endpoints protegidos agregando el header:

```
Authorization: Bearer {token}
```

---

#### `POST /api/logout`

Cierra la sesión y revoca el token actual.

**Requiere autenticación.**

**Respuesta `200`:**

```json
{
  "message": "Sesión cerrada"
}
```

---

### Libros

#### `GET /api/libros`

Devuelve la lista completa de libros registrados en el sistema, incluyendo sus categorías.

**Requiere autenticación.**

**Respuesta `200`:**

```json
[
  {
    "id": 1,
    "titulo": "Cien años de soledad",
    "autor": "Gabriel García Márquez",
    "isbn": "9780307474728",
    "categorias": [
      { "id": 2, "nombre": "Literatura latinoamericana" }
    ]
  }
]
```

---

#### `GET /api/libros/{id}`

Devuelve la información detallada de un libro específico.

**Requiere autenticación.**

**Parámetros de ruta:**

| Parámetro | Tipo | Descripción |
|-----------|------|-------------|
| `id` | integer | ID del libro |

**Respuestas:**

| Código | Descripción |
|--------|-------------|
| `200 OK` | Libro encontrado |
| `404 Not Found` | El libro no existe |

**Ejemplo de respuesta `404`:**

```json
{
  "error": "El libro que buscas no existe"
}
```

---

### Préstamos

#### `POST /api/prestamos`

Registra un nuevo préstamo de un ejemplar disponible del libro solicitado. Solo disponible para usuarios con rol **lector**.

**Requiere autenticación.**

**Body (JSON):**

```json
{
  "libro_id": 1
}
```

**Reglas de negocio:**

- El usuario autenticado no puede tener rol `admin`.
- El libro debe existir.
- El usuario no puede tener préstamos bloqueados (`prestamos_blocked`).
- Debe haber al menos un ejemplar con estado `disponible`.
- El plazo de devolución se establece automáticamente en **15 días** a partir de la fecha del préstamo.

**Respuestas:**

| Código | Descripción |
|--------|-------------|
| `201 Created` | Préstamo registrado correctamente |
| `403 Forbidden` | Usuario administrador o bloqueado por devoluciones tardías |
| `404 Not Found` | El libro no existe |
| `422 Unprocessable` | No hay ejemplares disponibles |

**Ejemplo de respuesta `201`:**

```json
{
  "id": 12,
  "ejemplar_id": 5,
  "user_id": 3,
  "fecha_prestamo": "2026-05-24",
  "fecha_devolucion_esperada": "2026-06-08",
  "created_at": "2026-05-24T15:30:00.000000Z",
  "updated_at": "2026-05-24T15:30:00.000000Z"
}
```

**Ejemplo de respuesta `403` (usuario bloqueado):**

```json
{
  "error": "No puedes solicitar préstamos debido a bloqueos anteriores por no devolver los libros a tiempo. Por favor, contacta con el personal de la biblioteca para más información."
}
```

---

## Resumen de Endpoints

| Método | Endpoint | Auth | Roles permitidos |
|--------|----------|------|-----------------|
| `POST` | `/api/login` | No | — |
| `POST` | `/api/logout` | Sí | admin, lector |
| `GET` | `/api/libros` | Sí | admin, lector |
| `GET` | `/api/libros/{id}` | Sí | admin, lector |
| `POST` | `/api/prestamos` | Sí | lector |
