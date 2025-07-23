# Friendly ONG

Este proyecto es una aplicación web desarrollada en PHP para la gestión de una ONG, permitiendo la administración de proyectos, eventos, donaciones y usuarios. Incluye funcionalidades de carrito de donaciones y autenticación de usuarios con roles.

## Estructura del Proyecto

- `index.php`: Punto de entrada principal de la aplicación.
- `controllers/`: Controladores para manejar la lógica de negocio de cada entidad (proyectos, eventos, donaciones, usuarios, carrito).
- `models/`: Modelos para la interacción con la base de datos y archivos mock JSON.
- `views/`: Vistas para renderizar la interfaz de usuario, incluyendo componentes reutilizables.
- `mock/`: Archivos JSON de ejemplo para pruebas y desarrollo sin base de datos.
- `views/styles/`: Hojas de estilo CSS.
- `views/public/`: Recursos públicos como imágenes y logos.

## Instalación

1. Clona este repositorio.
2. Asegúrate de tener PHP y MySQL instalados.
3. Crea una base de datos llamada `ong_app` y configura las tablas necesarias.
4. Ajusta las credenciales de la base de datos en `models/Db.php` si es necesario.
5. Inicia el servidor local con:
   ```sh
   php -S localhost:8000
   ```
6. Accede a [http://localhost:8000](http://localhost:8000) en tu navegador.

## Funcionalidades

- Listado, creación, edición y eliminación de proyectos, eventos y donaciones.
- Carrito de donaciones y procesamiento simulado de pagos.
- Registro e inicio de sesión de usuarios con roles (usuario y administrador).
- Filtros y ordenamiento en la vista de proyectos.
- Interfaz responsiva con Tailwind CSS y componentes reutilizables.

## Créditos

Sitio desarrollado por Manuel Pérez de Arce.

Para más detalles revisa los controladores y vistas en el código fuente.

## Capturas

### Página Principal
![Página Principal](./public/image-menuPrincipal.png)

### Carrito de Compras
![Carrito de Compras](./public/image-carrito.png)

### Ingresar
![Ingresar](./public/image-ingresar.png)