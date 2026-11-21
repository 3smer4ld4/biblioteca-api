# Biblioteca API

API REST desarrollada con **Laravel 12** para la gestión de una biblioteca comunitaria. Implementa autenticación mediante JSON Web Tokens (JWT), protección de rutas y operaciones CRUD para administrar libros.

## Tecnologías utilizadas

- PHP
- Laravel 12
- SQLite
- Eloquent ORM
- JWT Authentication (`tymon/jwt-auth`)
- Composer

## Funcionalidades

### Autenticación y seguridad

- Registro de usuarios.
- Inicio de sesión mediante correo electrónico y contraseña.
- Contraseñas almacenadas mediante hash.
- Generación y validación de tokens JWT.
- Protección de rutas mediante middleware `auth:api`.
- Consulta del usuario autenticado.
- Cierre de sesión e invalidación del token.

## Requisitos previos

Antes de instalar el proyecto, asegúrate de tener:

- PHP 8.2 o superior.
- Composer.
- Git.
- Extensiones de PHP necesarias para Laravel y SQLite.

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/3smer4ld4/biblioteca-api
cd biblioteca-api
```

### 2. Instalar dependencias

```bash
composer install
```

### 3. Crear el archivo de entorno

En Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

### 4. Generar la clave de Laravel

```bash
php artisan key:generate
```

### 5. Configurar SQLite

En el archivo `.env`, verificar que estén configuradas estas variables:

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

Crear el archivo de base de datos si todavía no existe:

```powershell
if (!(Test-Path database\database.sqlite)) {
    New-Item -ItemType File database\database.sqlite
}
```

### 6. Generar la clave secreta JWT

```bash
php artisan jwt:secret
```

Este comando genera la variable `JWT_SECRET` en el archivo `.env`.

### 7. Ejecutar las migraciones

```bash
php artisan migrate
```

### 8. Iniciar el servidor

```bash
php artisan serve
```

La API estará disponible en servidor local:

```text
http://127.0.0.1:8000
```

## Ejemplos de uso

Las peticiones deben enviarse con el encabezado:

```http
Accept: application/json
Content-Type: application/json
```

### Registrar un usuario

**POST** `/api/auth/register`

```json
{
    "name": "Usuariou",
    "email": "usuario@ejemplo.com",
    "password": "123",
    "password_confirmation": "123"
}
```

### Iniciar sesión



**POST (en postman por ejemplo)** `/api/auth/login`

```json
{
    "email": "usuario@ejemplo.com",
    "password": "123"
}
```

### Autenticación mediante JWT

En las peticiones protegidas, agregar el encabezado:

```http
Authorization: Bearer TU_TOKEN_JWT
```

### Registrar un libro

**POST** `/api/books`

```json
{
    "titulo": "Un milenio de compañia",
    "autor": "Marcos Gabriel",
    "isbn": "123456789013456789",
    "descripcion": "Novela del escritor imaginario.",
    "cantidad": 5,
    "disponibles": 5
}
```

Los campos `titulo`, `autor`, `cantidad` y `disponibles` son obligatorios. El ISBN y la descripción son opcionales.

La cantidad de ejemplares disponibles no puede ser negativa ni superar la cantidad , tampoco decimales.

## Códigos de respuesta HTTP

| Código | Significado |
|---|---|
| 200 | Operación realizada correctamente |
| 201 | Recurso creado correctamente |
| 401 | No autenticado o credenciales incorrectas |
| 404 | Recurso no encontrado |
| 422 | Error de validación |


## Consideraciones de seguridad

- Las contraseñas no se almacenan en texto plano.
- Las rutas privadas requieren un token JWT válido.
- Las credenciales y claves secretas se configuran mediante variables de entorno.
- El archivo `.env` no debe publicarse en el repositorio.
- Cada instalación debe generar sus propias claves de aplicación y JWT.

## Autoría

Proyecto académico desarrollado como parte de la actividad:

**Implementación de Blindaje en APIs: Autenticación con JSON Web Tokens (JWT) y Gestión Segura de Credenciales.**