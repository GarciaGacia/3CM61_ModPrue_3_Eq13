<?php include_once('include/load.php'); ?>
<?php
$req_fields = array('username','password' );
validate_fields($req_fields);
$username = remove_junk($_POST['username']);
$password = remove_junk($_POST['password']);

  if(empty($errors)){
//tambien puede quedar asi ?
    $user = authenticate_v2($username, $password);

        if($user):
           //crear sesión con id
           $session->login($user['id']);
           //Actualizar hora de inicio de sesión
           updateLastLogIn($user['id']);
           // redirigir al usuario a la página de inicio del grupo por nivel de usuario
           if($user['user_level'] === '1'):
             $session->msg("s", "Hello ".$user['username'].", Bienbenido.");
             redirect(SITE_URL.'admin.php',false);
           elseif ($user['user_level'] === '2'):
              $session->msg("s", "Hello ".$user['username'].", Bienbenido.");
             redirect(SITE_URL.'special.php',false);
           else:
              $session->msg("s", "Hello ".$user['username'].", Bienbenido.");
             redirect(SITE_URL.'home.php',false);
           endif;

        else:
          $session->msg("d", "Lo sentimos Nombre de usuario / contraseña incorrectos.");
          redirect(SITE_URL.'index.php',false);
        endif;

  } else {

     $session->msg("d", $errors);
     redirect(SITE_URL.'login_v2.php',false);
  }

?>
