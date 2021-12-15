/* Fichero para borrar la Base de Datos, y el usuario de nuestra instalacion,
 * y dejar el sistema limpio.
 * Ejecutar como root en MySQL. 
 *
 * --- Cuidado: Se destruiran todos los datos !!! ---
 
 */

DROP DATABASE IF EXISTS `eb_v1_0_2`;

/* borrar el usuario de la aplicacion */
DROP USER IF EXISTS 'eb_admin'@'localhost';

