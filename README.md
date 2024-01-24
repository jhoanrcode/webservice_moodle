Prueba Tecnica - Jhoan Avila - Web Service
=========================

Este plugin retorna por medio de un Web Service un listado de cursos paginados de acuerdo el numero de paginas y la cantidad de cursos por pagina que se le indique. Para consumir este servicio tenga en cuenta las siguientes recomendaciones:


Configuración
-------------
1. Instale el plugin en Moodle 4.1.
2. Consulte en los Servicios Externos (Administration > Site Administration > Plugins > Web services > External Services) se encuentre registrado el servicio "token_test" correspondiente al plugin.
3. Cree un token (Administration > Site Administration > Plugins > Web services > Manage tokens) seleccionando el servicio "token_test" y el usuario deseado para autorizar la peticion.


Requirimientos
------------
- Moodle 4.1 (build 2022060100 or later)


Consumir API
------------
1. Consulte en Administration > Site Administration > Plugins > Web services > Manage tokens el token creado.
2. Consurmir API así: 
http://yoursite/webservice/rest/server.php?wstoken=####&wsfunction=local_prueba_jhoan_get_courses_by_pagination&moodlewsrestformat=json&page=1&per_page=3

URL   : http://yoursite/webservice/rest/server.php
wstoken  : #### (Copiar token de paso #1)
wsfunction  : local_prueba_jhoan_get_courses_by_pagination
moodlewsrestformat : json
page  : 1 (PARAM1 Numero de paginacion)
per_page  : 3 (PARAM2 Cursos por pagina)


Autor
------
Jhoan Avila Gutierrez (joria94@hotmail.edu) - 3203645490.
