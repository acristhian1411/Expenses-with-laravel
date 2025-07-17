# API de Registro de Ingresos y Gastos orientado a pymes desarrollado con Laravel

Este es un proyecto de API desarrollado con Laravel para el registro de ingresos y gastos.
Proporciona endpoints para la creación, consulta, actualización y eliminación de registros de gastos, ademas de todo lo relacionado
como registro de clientes, proveedores, productos. etc.

## Requisitos

-   PHP 8.3 o superior
-   Composer
-   Laravel 11
-   Postgresql

## Instalación

1. Clona el repositorio: `git clone https://github.com/acristhian1411/Contalink.git`
2. Accede al directorio del proyecto: `cd Contalink`
3. Instala las dependencias: `composer install`
4. Copia el archivo de configuración: `cp .env.example .env`
5. Configura la base de datos en el archivo `.env`
6. Genera la clave de la aplicación: `php artisan key:generate`
7. Ejecuta las migraciones: `php artisan migrate`
7. Inserta los datos iniciales: `php artisan db:seed`
8. Lanza la aplicación: `php artisan serve`
9. Ve a la documentación de la api en: [http://localhost:8000/swagger/documentation]

## Imagenes relacionadas

![Documentación](public/img/swagger.png)
