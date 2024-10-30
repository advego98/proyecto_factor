# Proyecto Yii2 para Stack Exchange API

Este proyecto en Yii2 se conecta con la API de Stack Exchange para buscar preguntas en Stack Overflow y almacenarlas en una base de datos MySQL. 


## Requisitos

- PHP >= 7.4
- Composer
- Yii2 (framework)
- MySQL
- cURL (para acceder a la API de Stack Exchange)



## Instalación

1. Clona el repositorio:

   ```bash
   git clone https://github.com/advego98/proyecto_factor.git
   cd proyecto_factor

2. Composer
    ```bash
    composer install


## Inicialización del proyecto
```bash
php yii serve


## Consulta al endpoint

1. URL del endpoint
    http://localhost:8080/stack-exchange/recent-questions

2. Parametros
    · tagged (obligatorio): Etiqueta para filtrar las preguntas.
    · fromdate (opcional): Fecha de inicio en formato UNIX timestamp.
    · todate (opcional): Fecha de fin en formato UNIX timestamp.

3. Ejemplo
    http://localhost:8080/stack-exchange/recent-questions?tagged=php&fromdate=1609459200&todate=1612137600


## Base de Datos (proyecto_factor)

1. Diagrama 

    Table preguntas {
        question_id          int       [pk, not null]    // ID único de la pregunta
        title                varchar   [not null, note: "Título de la pregunta"]
        creation_date        datetime  [not null, note: "Fecha de creación"]
        last_activity_date   datetime  [note: "Fecha de la última actividad"]
        score                int       [note: "Puntuación"]
        view_count           int       [note: "Número de vistas"]
        answer_count         int       [note: "Número de respuestas"]
        is_answered          boolean   [note: "Indica si está respondida"]
        tags                 varchar   [note: "Etiquetas separadas por comas"]
        owner_user_id        int       [note: "ID del propietario"]
        owner_display_name   varchar   [note: "Nombre del propietario"]
        link                 text      [note: "Enlace a la pregunta"]
    }

2. Query creación de la tablas 

    CREATE TABLE preguntas (
        question_id INT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        creation_date DATETIME NOT NULL,
        last_activity_date DATETIME,
        score INT,
        view_count INT,
        answer_count INT,
        is_answered BOOLEAN,
        tags VARCHAR(255),
        owner_user_id INT,
        owner_display_name VARCHAR(100),
        link TEXT
    );


