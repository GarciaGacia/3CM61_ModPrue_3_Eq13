<?php
  require_once('../include/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect(SITE_URL.'index.php', false);}
?>

<?php
  $results = array();
  $html = '';

  if( isset($_POST['partNo']) && strlen($_POST['partNo']) )
  {
    
   
    //echo display_msg( array('info', "Buscando " . $_POST['product_name'] ) );
    if ( isset($_POST['match']) && strtolower($_POST['match']) === "full" ) {
      
      /* devuelve la información completa del producto */
      $results = find_product_by_partNo( $_POST['partNo'], 0 );

      /* agregar  category_name and media_name */
      $results['category_name'] = '';        /* defecto */
      if( isset($results['categorie_id']) ) {
        $category = find_by_id( 'categories', $results['categorie_id'] );
        if ( isset( $category['name'] ) )
          $results['category_name'] = $category['name'];
      }

      $results['media_name'] = '';        /* defecto */
      if( isset($results['media_id']) ) {
        $media = find_by_id( 'media', $results['media_id'] );
        if ( isset( $media['file_name'] ) )
          $results['media_name'] = $media['file_name'];
      }
    }
    else {
      /* coincidencia parcial: busca coincidencias para la partNo */
      $items = find_product_by_partNo( $_POST['partNo'], 1 );
      if ( $items ) {
        foreach( $items as $item ) {
          $results[] = $item['partNo'];
        }
      }
    }
    //
    //print_r( $results );
    if( !$results ) {
      $results[] = "(no encontrado)";
    }
    echo json_encode( $results );
   }

  /* Consulta por product_name (nombre de producto parcial) */
  if(isset($_POST['product_name']) && strlen($_POST['product_name']))
  {
    

    //echo display_msg( array('info', "Buscando " . $_POST['product_name'] ) );

    $products = find_product_by_title($_POST['product_name']);
    if($products){
      $i=0;
      foreach ($products as $product):
        $i++;

      
        $results[] = $product['name'];
      endforeach;
    } else {
      // ... WFT ?
     
      $results[] = "(no encontrado)";
    }

    echo json_encode( $results );
   }
 ?>

 <?php
  /* Consulta por p_name (nombre completo del producto) */
  if(isset($_POST['p_name']) && strlen($_POST['p_name']))
  {
    $product_title = remove_junk($db->escape($_POST['p_name']));

    //print_r( find_product_by_partNo( 'TOR_HEX_001' ) );

    if($results = find_all_product_info_by_title($product_title)){

      if ( sizeof($results) > 0 ) $results = $results[0];

      $results['category_name'] = '';        /* defecto */
      if( isset($results['categorie_id']) ) {
        $category = find_by_id( 'categories', $results['categorie_id'] );
        if ( isset( $category['name'] ) )
          $results['category_name'] = $category['name'];
      }

      $results['media_name'] = '';        /* defecto */
      if( isset($results['media_id']) ) {
        $media = find_by_id( 'media', $results['media_id'] );
        if ( isset( $media['file_name'] ) )
          $results['media_name'] = $media['file_name'];
      }

      
    } else {

      //$html ='<tr><td>El producto no se encuentra registrado en la base de datos</td></tr>';
      $results = array( );
    }

    /* Deprecated --> changed to JSON */
    //echo json_encode($html);
    //echo $html;

    print( json_encode($results) );
  }
?>
