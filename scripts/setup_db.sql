/* Fichero para crear la Base de Datos, y el usuario de la aplicacion 
 * Ejecutar como root en MySQL. 
 *
 */

CREATE DATABASE IF NOT EXISTS `eb_v1_0_2`;

/* crear el usuario, y darle privilegios LIMITADOS */

/*# Para MySQL, descomentar esta linea y comentar la 15
*#CREATE USER IF NOT EXISTS 'eb_admin'@'localhost' IDENTIFIED WITH mysql_native_password BY 'admin';*/


# Para MariaDB, descomentar esta linea y comentar la 11
CREATE USER IF NOT EXISTS 'eb_admin'@'localhost' IDENTIFIED BY 'admin';



GRANT SELECT, INSERT, UPDATE, DELETE, LOCK TABLES ON `eb_v1_0_2`.* TO 'eb_admin'@'localhost';
FLUSH PRIVILEGES;

