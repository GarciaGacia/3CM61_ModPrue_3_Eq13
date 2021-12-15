<?php $user = current_user(); ?>
<!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8">

      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <meta name="keywords" content="" />

      <!-- favicon -->
      <link rel="shortcut icon" href="assets/img/Punto_rojo.png" type="image/png" />

      <title>
        <?php if (!empty($page_title))
        echo remove_junk($page_title);
        elseif(!empty($user))
        echo ucfirst($user['name']);
        else echo "Sistema de Inventario - El asistente virtual para tu negocio .";?>
      </title>
  
      <!-- cached version -->
      <link rel="stylesheet" href="lib/css/bootstrap2.min.css" />
      <!--<link rel="stylesheet" href="lib/css/styles-sb-ui-kit.css" />-->
      <link rel="stylesheet" href="lib/css/datepicker3.min.css" />
      <!-- DataTables -->
      <link rel="stylesheet" type="text/css" href="lib/DataTables/datatables.min.css"/>

      <script type="text/javascript" src="lib/js/jquery-3.5.1.js"></script>

      <!-- CUSTOM STYLES -->
      <!-- main -->
      <link rel="stylesheet" href="lib/css/main.css" />
      <!-- panels, cards, forms -->
      <link rel="stylesheet" href="lib/css/panel.css"/>

    </head>
    <body>
      <?php if ($session->isUserLoggedIn(true)): ?>
        <header id="header">

         <!-- Nombre de la pagina -->
          <div class="logo pull-left"> TSJ </div>
          <div class="header-content">
          <div class="header-date pull-left">
            <!-- Nombre de la pagina o del sistema  -->
            <strong>
              El asistente virtual para tu negocio. By Diego. &nbsp;&nbsp;
              <?php echo date("d/m/Y  g:i a");?>
            </strong>
          </div>
          <div class="pull-right clearfix">
            <ul class="info-menu list-inline list-unstyled">
              <li class="profile">
                <a href="#" data-toggle="dropdown" class="toggle" aria-expanded="false">
                  <img src="uploads/users/<?php echo $user['image'];?>" alt="user-image" class="img-circle img-inline">
                  <span><?php echo remove_junk(ucfirst($user['name'])); ?> <i class="caret"></i></span>
                </a>
                <ul class="dropdown-menu">
                  <li>
                      <a href="profile.php?id=<?php echo (int)$user['id'];?>">
                          <i class="glyphicon glyphicon-user"></i>
                          Perfil
                      </a>
                  </li>
                 <li>
                     <a href="edit_account.php" title="edit account">
                         <i class="glyphicon glyphicon-cog"></i>
                         Configuración
                     </a>
                 </li>
                 <li class="last">
                     <a href="logout.php">
                       <!-- boton cerrar secion aqui -->
                         <i class="glyphicon glyphicon-log-out"></i>
                         cerrar secion 
                     </a>
                 </li>
               </ul>
              </li>
            </ul>
          </div>
         </div>
        </header>
        <div class="sidebar">
          <?php if($user['user_level'] === '1'): ?>
            <!-- admin__ menu -->
          <?php include_once('admin_menu.php');?>

          <?php elseif($user['user_level'] === '2'): ?>
            <!-- Special user -->
          <?php include_once('special_menu.php');?>

          <?php elseif($user['user_level'] >= '3'): ?>
            <!-- User menu -->
          <?php include_once('user_menu.php');?>

          <?php endif;?>
       </div>
      <?php endif;?>

      <div class="page">
        <div class="container-fluid">