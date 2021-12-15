<?php

class Session {

  public $msg;
  private $user_is_logged_in = FALSE;

  function __construct(){
    $this->flash_msg();
    $this->userLoginSetup();
  }

  public function isUserLoggedIn() {
    return $this->user_is_logged_in;
  }

  public function login($user_id) {
    $_SESSION['user_id'] = $user_id;
  }

  private function userLoginSetup() {
    if( isset($_SESSION['user_id']) ) {
      $this->user_is_logged_in = TRUE;
    } else {
      $this->user_is_logged_in = FALSE;
    }
  }

  public function logout() {
    unset($_SESSION['user_id']);
  }

  /** Establece el mensaje de la sesión, para el tipo dado, en el valor dado.
  * Esta función edita el campo 'msg' en la supervariable $ _SESSION.
  * @type Los valores permitidos son: 'd', 'i', 'w', 's'
   * 'd': peligro
    * 'yo': información
    * 'w': advertencia
    * 's': éxito
    * @msg El texto del mensaje para configurar. Si está vacío, la función devuelve
    * el mensaje actual ya establecido en el objeto.
 */
  public function msg($type='', $msg='') {
    if( !empty($msg) ){
       if( strlen(trim($type)) == 1 ){
          $type = str_replace( array('d', 'i', 'w','s'), array('danger', 'info', 'warning','success'), $type );
          $_SESSION['msg'][$type] = $msg;
       }
    } else {
      return $this->msg;
    }
  }

  /** En la creación del objeto, esta función sirve para recuperar el valor actual
  * del mensaje de la supervariable $ _SESSION.
  */
  private function flash_msg() {
    if( isset($_SESSION['msg']) ) {
      $this->msg = $_SESSION['msg'];
      unset($_SESSION['msg']);
    } else {
      $this->msg;
    }
  }


  public function __destruct() {
    session_write_close();
  }
}


if ( session_status( ) !== PHP_SESSION_ACTIVE ) {
  session_start();
}

/* cargando una sesión de objeto, desde la sesión PHP actual */
$session = new Session();
$msg = $session->msg();

?>