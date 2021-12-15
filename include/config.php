<?php

define( 'DB_HOST', 'localhost' );    // Establecer base de datos host
define( 'DB_NAME', 'eb_v1_0_2' );    // Establecer base de datos name
define( 'DB_USER', 'eb_admin' );     // Establecer base de datos user
define( 'DB_PASS', 'admin' );        // Establecer base de datos password

/* Zona horaria */
date_default_timezone_set("America/Mexico_City");

session_write_close( );
session_start();
?>
