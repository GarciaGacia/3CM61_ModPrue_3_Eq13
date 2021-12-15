<?php
$errors = array();

 /*--------------------------------------------------------------*/
 /* Función para Eliminar escapes especiales
 /* caracteres en una cadena para usar en una declaración SQL
 /*--------------------------------------------------------------*/
function real_escape($str)
{
  global $con;
  $escape = mysqli_real_escape_string($con,$str);
  return $escape;
}
/*--------------------------------------------------------------*/
/* Función para eliminar caracteres html
/*--------------------------------------------------------------*/
function remove_junk($str)
{
  $str = nl2br($str);
  $str = htmlspecialchars(strip_tags($str, ENT_QUOTES));
  return $str;
}
/*--------------------------------------------------------------*/
/* Función para el primer carácter en mayúsculas
/*--------------------------------------------------------------*/
function first_character($str)
{
  $val = str_replace('-'," ",$str);
  $val = ucfirst($val);
  return $val;
}

function verb_mode() 
{
  if (isset($_GET) && isset($_GET['verb'])) {
    if ( strtoupper($_GET['verb']) === "TRUE" || $_GET['verb'] === "" )
      return TRUE;
  }
  return FALSE;
}

/*--------------------------------------------------------------*/
/* Función para comprobar los campos de entrada que no están vacíos
/*--------------------------------------------------------------*/
function validate_fields($var)
{
  global $errors;
  foreach ($var as $field) {
    if ( isset( $_POST[$field] ) ) {         
      $val = remove_junk($_POST[$field]);
      if(isset($val) && $val==''){
        $errors = "'$field'" ." No puede estar en blanco.";
        return FALSE;
      }
    }
    else
      return FALSE;
  }

  return TRUE;
}
/*--------------------------------------------------------------*/
/*Función para mostrar mensaje de sesión
   Ex echo displayt_msg($message);
/*--------------------------------------------------------------*/
function display_msg($msg =array()) 
{
  $output = "";
  if(!empty($msg)) {
    foreach ($msg as $key => $value) {
      $output  = "<div class=\"alert alert-{$key}\">";
      $output .= "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>";
      $output .= remove_junk(first_character($value));
      $output .= "</div>";
    }
    return $output;
  } 
  else {
    return "" ;
  }
}
/*--------------------------------------------------------------*/
/* Función para redireccionar
/*--------------------------------------------------------------*/
function redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
      header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}
/*--------------------------------------------------------------*/
/* Función para averiguar el precio de venta total, el precio de compra y el beneficio.
/*--------------------------------------------------------------*/
function total_price($totals)
{
   $sum = 0;
   $sub = 0;
   foreach($totals as $total ){
     $sum += $total['total_saleing_price'];
     $sub += $total['total_buying_price'];
     $profit = $sum - $sub;
   }
   return array($sum,$profit);
}
/*--------------------------------------------------------------*/
/* Función para fecha y hora legibles
/*--------------------------------------------------------------*/
function read_date($str)
{
  if ($str)
    return date('Y/m/d g:i:s a', strtotime($str));
  else
    return null;
}
/*--------------------------------------------------------------*/
/* Función para hacer fecha y hora legibles
/*--------------------------------------------------------------*/
function make_date()
{
  return strftime("%Y-%m-%d %H:%M:%S", time());
}
/*--------------------------------------------------------------*/
/* Función para fecha y hora legibles
/*--------------------------------------------------------------*/
function count_id(){
  static $count = 1;
  return $count++;
}
/*--------------------------------------------------------------*/
/* Función para crear cadenas aleatorias
/*--------------------------------------------------------------*/
function randString($length = 5)
{
  $str='';
  $cha = "0123456789abcdefghijklmnopqrstuvwxyz";

  for($x=0; $x<$length; $x++)
   $str .= $cha[mt_rand(0,strlen($cha))];
  return $str;
}

?>
