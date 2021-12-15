<?php
require_once(LIB_PATH_INC."config.php");

class MySqli_DB {

  private $con;
  public $query_id;

  function __construct() {
    $this->db_connect();
  }

/*--------------------------------------------------------------*/
/* Función para conexión a base de datos abierta
/*--------------------------------------------------------------*/
public function db_connect()
{
  $this->con = mysqli_connect(DB_HOST,DB_USER,DB_PASS);
  if (!$this->con) {
    die(" Database connection failed:". mysqli_connect_error());
  } 
  else {
    $select_db = $this->con->select_db(DB_NAME);
    if (!$select_db) {
      die("Failed to Select Database". " '". DB_NAME . "'".mysqli_connect_error());
    }
  }
}
/*--------------------------------------------------------------*/
/* Función para conexión a base de datos abierta
/*--------------------------------------------------------------*/

public function db_disconnect()
{
  if (isset($this->con)) {
    mysqli_close($this->con);
    unset($this->con);
  }
}
/*--------------------------------------------------------------*/
/* Función para consulta mysqli
/*--------------------------------------------------------------*/
public function query($sql)
{
  if (trim($sql != "")) {
    $this->query_id = $this->con->query($sql);
  }
  if (!$this->query_id) {
    /* error in SQL */
    return null;
  }

  return $this->query_id;
}

  /** Recupera el último error en la consulta SQL.
   *  ==============================================
   */
  public function get_last_error( ) {

    /* (new) */
    return $this->con->error;

    /* (antiguo)  */
    //return mysqli_error( $this->con );
  }

  /*--------------------------------------------------------------*/
  /* Función para el asistente de consultas
  /*--------------------------------------------------------------*/
  public function fetch_array($statement)
  {
    return mysqli_fetch_array($statement);
  }
  public function fetch_object($statement)
  {
    return mysqli_fetch_object($statement);
  }
  public function fetch_assoc($statement)
  {
    return mysqli_fetch_assoc($statement);
  }
  public function num_rows($statement)
  {
    return mysqli_num_rows($statement);
  }
  public function insert_id()
  {
    return mysqli_insert_id($this->con);
  }
  public function affected_rows()
  {
    return mysqli_affected_rows($this->con);
  }
  /*--------------------------------------------------------------*/
  /* Función para Eliminar escapes especiales
  /* caracteres en una cadena para usar en una declaración SQL
  /*--------------------------------------------------------------*/
  public function escape($str) 
  {
    return $this->con->real_escape_string($str);
  }
  /*--------------------------------------------------------------*/
  /*  Funcion para bucle while
  /*--------------------------------------------------------------*/
 
  public function while_loop($mysql_result) 
  {
    global $db;      
    $results = array();
    
    //while( $result = $this->fetch_array($mysql_result) ) {
    while ($result = $this->fetch_assoc($mysql_result)) {
      // construir un conjunto de resultados
      $results[] = $result;
    }
    return $results;
  }
}

$db = new MySqli_DB();
?>
