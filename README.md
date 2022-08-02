# Blog IpGlobal
## Requisitos:
•	PHP 7.4 ó 8.0 	 
•	Composer y estructura PSR-4 en el proyecto  
•	La última versión estable de Symfony/Laravel  
•	Testing unitario  
•	La API debe devolver y consumir los datos en formato JSON
•	Programar en el idioma inglés

## Opcionales:
•	Uso de herramientas de análisis estático (por ejemplo PHPStan en modo máximo) y de estilo de código (por ejemplo PHP CS Fixer en modo @Symfony)

•	Uso de SCSS y Webpack, ya sea usando Webpack directamente o mediante Symfony Encore / Laravel Mix o similar.

•	Ofrecer un Swagger/OpenAPI para la parte de la API 


## Pasos:
### Creación del proyecto:
- Se ha creado un proyecto nuevo con la última version de Symfony (Symfony 6.1).
- Se ha instalado el PHP correspondiente a la versión de Symfony

Nota: en los requisitos se especificaba php 8.0 o 7.4, pero la version 6.1 no admite 8.0, se procedió a mantener esta versión e instalar la mas reciente de PHP. 8.1.6
### Estructura del proyecto:
- Se ha estructurado el proyecto de la siguiente forma.

#### Pantalla principal 

La pantalla principal mostrará los posts del blog que tengamos en BBDD persistidos.
Encontramos el listado y dos botones: Crear nuevo Post o Cargar post a la BBDD.

Crear Nuevo Post: Redirige al formulario para crear un nuevo POST.

Cargar Post a la BBDD: realizando una llamada a la api para recoger todos los posts y actualizarlo en la BBDD, si se le diera una vez cargado, lo que realiza es un update.

Nota: Se ha creado un servicio para almacenar todas las llamadas a la api.

Nota2: Para agilizar el proceso, se ha creado un choiceType con los autores que están creados actualmente en BBDD, y solo se podrá seleccionar uno ya creado (Para posteriormente a traves de la ID del autor obtener los datos para el datasheet del autor).


#### Formulario "nuevo Post"

Formulario simple de la entidad Blog, que al darle a "Crear" creará un nuevo POST en la BBDD.


## Herramientas utilizadas
* Boostrap 5.2
* Symfony 6.1
* PHP 8.1.6
* IDLE: Visual Studio
* Composer
* XAMPP para la gestión de BBDD.
* SCSS y Webpack para todo lo relacionado con CSS utilizando Symfony Encore.
* Curl para la API
* POSTMAN para las pruebas de las integraciones.
