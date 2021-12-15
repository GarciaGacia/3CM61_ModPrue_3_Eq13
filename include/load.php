<?php

// -----------------------------------------------------------------------
// DEFINIR ALIAS DE SEPARADOR
// -----------------------------------------------------------------------
define("URL_SEPARATOR", '/');
define("DS", DIRECTORY_SEPARATOR);

// -----------------------------------------------------------------------
// DEFINIR CAMINOS
// -----------------------------------------------------------------------
/* Definiendo SITE_ROOT correctamente
   Esto es muy importante, por seguridad */

if ( !defined('SITE_ROOT') ) {
	// la ruta de inclusión (por ejemplo, ../include)
	$INC_PATH = dirname(__FILE__);
	// SITE_ROOT se basa en $ INC_PATH
    // SITE_ROOT es la ruta completa del sitio en la máquina host.
   // Es útil, por ejemplo, require_once () o include_once ()
    // frases.
	define( "SITE_ROOT", realpath($INC_PATH.'/..') );
}

define("SITE_URL", "");


defined("INC_ROOT")? null: define("INC_ROOT", realpath(dirname(__FILE__)));
define("LIB_PATH_INC", INC_ROOT.DS);

require_once(LIB_PATH_INC.'config.php');
require_once(LIB_PATH_INC.'functions.php');
require_once(LIB_PATH_INC.'session.php');
require_once(LIB_PATH_INC.'upload.php');
require_once(LIB_PATH_INC.'database.php');
require_once(LIB_PATH_INC.'sql.php');
?>