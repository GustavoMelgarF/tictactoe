
TRES EN RAYA

Aplicación web con backend php y fronted html/javascript con uso de base de datos mysql.

Implementación del juego de 3 en raya en el que 2 jugadores, uno con fichas X y otro con fichas 0,
intentan colocar 3 fichas seguidas horizontal, vertical o diagonalmente.

La aplicación permite jugar a 2 personas, turnándose para colocar fichas, o una persona contra la
máquina.


1) Pre-requisitos

Es necesario disponer de un servidor web
Es necesario disponer de un servidor PHP con versión >=5.6
Es necesario disponer de un servidor MySQL/MariaDB con versión >= 5.7/10
Navegador web Chrome 60+ / Firefox 55+
No es necesario disponer de conexión a internet


La aplicación se ha probado usando los servidores wamp3 y xampp3, usando como navegadores web Chrome y Firefox en sus  versiones recientes.


2) Instalación

a) Copiar contenido de la carpeta 3_en_raya en el servidor web en un directorio.
b) Ejecutar query "ddbb_tres_en_raya.sql" en servidor bbdd para crear base de datos y tabla necesaria para la aplicación.
c) Modificar fichero ubicado en ruta "3_en_raya/php/config/config.php" indicando parámetros de conexión del usuario de bbdd cn permisos  en las constantes:

define("SERVIDOR", "localhost");
define("USUARIO", "root");
define("PASSWORD", "");
define("DDBB", "tres_en_raya");

d) Acceso a la aplicación desde el directorio donde se ha ubicado la aplicación. Se cargará el fichero inicial "index.html"

Relación de ficheros que componenen la aplicación:
3_en_raya\ddbb_tres_en_raya.sql
3_en_raya\index.html
3_en_raya\readme.md
3_en_raya\php\webservice.php
3_en_raya\php\bbdd\conexion.php
3_en_raya\php\config\config.php
3_en_raya\php\logica\acciones.php
3_en_raya\php\logica\logica.php


3) Mecánica

El juego se basa en comprobar que un jugador ha conseguido colocar 3 fichas suyas.
Si la cuadrícula de casillas del juego es:
1 2 3
4 5 6
7 8 9
, la aplicación comprueba si hay 3 fichas iguales en las filas (compuesta por las casillas) 123, 456, 789, 147, 258, 369, 159 y 357.
Si es así, declara ganador a ese jugador.

En la modalidad de Persona contra Máquina, el algoritmo que decide los movimientos de la máquina es:
a) compruebo si la persona tiene 2 fichas en alguna fila. Si es así, lo bloqueo.
b) compruebo si yo(máquina) tengo 2 fichas en fila y la 3ra casilla libre. si es así, coloco ficha para ganar.
c) compruebo si yo(máquina) tengo 1 ficha en alguna fila y las 2 restantes sin bloquear. si es así, coloco ficha.
d) selecciono la primera fila libre y coloco ficha en cualquiera de las 3 casillas.

Se siguen los pasos anteriores secuencialmente y si alguno es correcto se usa.


4) Herramientas usadas

No se ha usado ningún framework ni librerías, ni para la parte frontend ni para la parte backend.


5) Versión

1.0 Inicial (06-08-2019)

