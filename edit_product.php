
<?php
  $page_title = 'Editar producto';
  require_once('include/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $product = find_by_id('products', (int)$_GET['id']);
  $all_categories = find_all('categories');
  $all_photo = find_all('media');
  if (!$product) {
    $session->msg("d", "Error: No se encontró id de producto.");
    redirect(SITE_URL.'products.php');
  }
?>

<?php
  if (isset($_POST['update-product'])) {
		$req_fields = array('product-name','partNo','category','product-image-id','quantity',
      'buy-price', 'sale-price', 'location' );
    validate_fields($req_fields);

    if(empty($errors)){
      $p_name  = remove_junk($db->escape($_POST['product-name']));
      $p_partNo = remove_junk($db->escape($_POST['partNo'])); 
      $p_cat   = (int)$_POST['category'];
      $p_qty   = remove_junk($db->escape($_POST['quantity']));
      $p_buy   = remove_junk($db->escape($_POST['buy-price']));
      $p_sale  = remove_junk($db->escape($_POST['sale-price']));

      $p_loc   = remove_junk($db->escape($_POST['location']));
      if (is_null($_POST['product-image-id']) || $_POST['product-image-id'] === "") {
       $media_id = '0';
      } else {
       $media_id = remove_junk($db->escape($_POST['product-image-id']));
      }
      $query   = "UPDATE products SET";
      $query  .=" name ='{$p_name}', ";
      $query  .=" partNo ='{$p_partNo}', ";
      $query  .=" categorie_id ='{$p_cat}', ";
      $query  .=" quantity ='{$p_qty}',";
      $query  .=" buy_price ='{$p_buy}',";
      $query  .=" sale_price ='{$p_sale}',";
      $query  .=" location ='{$p_loc}',";
      $query  .=" media_id='{$media_id}'";
      $query  .=" WHERE id ='{$product['id']}'";

      $result = $db->query($query);
			if( $result ) {
				if( $db->affected_rows() === 1 ) {
					$session->msg('s', "Producto ha sido actualizado.");
				} else {
					/*no se cambió ninguna fila */
					$session->msg('w', "No se cambió información." );
				}
				
        redirect(SITE_URL.'edit_product.php?id='.$product['id'], false);
     	}
			else {
				/* Error de consulta SQL */
    		$session->msg('d',"Lo siento, actualización falló." 
       	. "Message: " . $db->get_last_error( ) 
       	);
       	redirect(SITE_URL.'edit_product.php?id='.$product['id'], false);
      }
   } else{
      $session->msg("d", $errors);
     	redirect(SITE_URL.'edit_product.php?id='.$product['id'], false);
   }
  }
?>

<?php include_once('layouts/header.php'); ?>

<link rel="stylesheet" href="lib/css/carousel.css">
<link rel="stylesheet" href="lib/css/edit_product.css">

<div class="row">
  <div class="col-md-9">
    <?php echo display_msg($msg); ?>
  </div>

<div class="col-md-9">
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>
        <i class="glyphicon glyphicon-pencil"></i>
        <span>Editar Producto</span>
     </strong>
    </div>
    <div class="panel-body">
      <div class="col-md-12">
        <form method="post" action="edit_product.php?id=<?php echo (int)$product['id'] ?>">
          <div class="form-group">
          	<!-- nombre del producto-->
            <label for="" class="control-label">Nombre</label>
            <input type="text" class="form-control form-control-primary rounded" name="product-name" value="<?php echo remove_junk($product['name']);?>" autofocus>
          </div>
          
					<div class="form-group">
						<div class="row">
							<!-- No. de parte -->
              <div class="col-md-6">
								<label for="partNo" class="control-label">COD/Part No.</label>
						 		<input type="text" class="form-control rounded" name="partNo"  value="<?php echo remove_junk($product['partNo']);?>">
							</div>
							
							<!-- Categoría -->
							<div class="col-md-6">
								<label for="category" class="control-label">Categor&iacute;a</label>
                <select class="form-control rounded" name="category">
                	<option value="">Selecciona una categoría</option>
                  <?php  foreach ($all_categories as $cat): ?>
                    <option value="<?php echo (int)$cat['id']; ?>" <?php if($product['categorie_id'] === $cat['id']): echo "selected"; endif; ?> >
                    <?php echo remove_junk($cat['name']); ?></option>
                  <?php endforeach; ?>
             		</select>
              </div>
          	</div>
					</div>
          
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <span id="display-carousel" class="pull-left" style="display: block"><a href="#!">Cambiar</a></span>
              </div>
            </div>
            <div class="row">
              
              <div class="product-slider col-md-12">
              <!--<div class="clearfix">-->
                <div id="thumbcarousel" class="carousel slide" data-interval="false" style="display:none">
                 

                  <div class="carousel-inner">
                    <div class="item active">
                      <?php for($i=0; $i<4 && $i < count($all_photo); $i++): 
                        $photo = $all_photo[$i]; ?>
                        <div data-target="#carousel" data-slide-to="<?php echo $i?>" class="thumb">
                          <img id="<?php printf("img_id_%d", $photo['id']);?>" src="uploads/products/<?php echo $photo['file_name'];?>" class="img-thumbnail img-fluid rounded" data-target="#product-image">
                        </div>
                      <?php endfor;?>
                    </div>
                    <div class="item">
                      <?php for($i=4; $i < count($all_photo); $i++): 
                        $photo = $all_photo[$i]; ?>
                        <div data-target="#carousel" data-slide-to="<?php echo $i?>" class="thumb">
                          <img id="<?php printf("img_id_%d", $photo['id']);?>" src="uploads/products/<?php echo $photo['file_name'];?>" class="img-thumbnail img-fluid rounded" data-target="#product-image">
                        </div>
                      <?php endfor;?>
                    </div>
                  </div>
                  <!-- navegación / control -->
                  <a class="carousel-control left" href="#thumbcarousel" role="button" data-slide="prev">
                    <span class="carousel-control-icon vertical-center" aria-hidden="true">
                      <!--<i class="fa fa-chevron-left"></i>-->
                      <i class="glyphicon glyphicon-chevron-left"></i>
                    </span>
                  </a>
                  <a class="carousel-control right" href="#thumbcarousel" role="button" data-slide="next">
                    <span class="carousel-control-icon" aria-hidden="true">
                      <!--<i class="fa fa-chevron-right"></i>-->
                      <i class="glyphicon glyphicon-chevron-right"></i>
                    </span>
                  </a>
                </div>
              <!--</div>-->
              </div>


              <!-- Imagen del producto -->
              <div class="col-md-6">
                <?php if($product['media_id'] === 0): ?>
                  <img class="img-thumbnail" id="product-image" src="uploads/products/no_image.jpg" alt="" data-toggle="tooltip" data-placement="right" title="doble clic para cambiar">
                  <input type="hidden" name="product_image_id" id="product_image_id" value="0">
                <?php else: 
                  foreach ($all_photo as $photo) {
                    if ($product['media_id'] === $photo['id']) {
                      printf("<img class=\"img-thumbnail\" id=\"product-image\" src=\"uploads/products/{$photo['file_name']}\" alt=\"{$photo['file_name']}\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"doble clic para cambiar\">");
                      printf("
                <input type=\"hidden\" name=\"product-image-id\" id=\"product-image-id\" value=\"{$photo['id']}\">");
                    }
                  }
                endif;?>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <!-- Precio de compra -->
              <div class="col-md-4">
                <label for="buy-price" class="control-label">Precio Compra</label>
                <input type="text" class="form-control rounded text-right" name="buy-price" placeholder="0"
                  value="<?php echo remove_junk($product['buy_price']); ?>">
              </div>

              <!--separador-->
              <div class="col-md-2"></div>

              <!-- Precio de venta -->
              <div class="col-md-4">
                <label for="sale-price" class="control-label">Precio Venta</label>
                <input type="text" class="form-control rounded text-right" name="sale-price" placeholder="0"
                 value="<?php echo remove_junk($product['sale_price']); ?>">
              </div>
						</div>
         	</div>
           
				  <div class="form-group">
          	<div class="row">
              <!-- Cantidad -->
              <div class="col-md-4">
                <label for="product-quantity" class="control-label">Cantidad</label>
                <input type="number" class="form-control rounded text-left" id="quantity" name="quantity" placeholder="<?php echo remove_junk($product['quantity']); ?>" value="<?php echo remove_junk($product['quantity']); ?>">
              </div>

              <!--separador-->
              <div class="col-md-2"></div>

  						<!-- Ubicación -->               	
  						<div class="col-md-4">
  							<label for="location" class="control-label">Ubicaci&oacute;n</label>
                <!-- no es necesario un complemento aquí
                <div class="input-group" style="border: 1px dashed gray;">-->
                  <input type="text" class="form-control rounded" name="location" value="<?php echo remove_junk($product['location']);?>">
                  <!-- no es necesario un complemento aquí
                  <span class="input-group-addon"></span>
                </div>-->
  						</div>
  					</div>
				  </div>
					
  				<div class="form-group">
          	<div class="row" style="margin-top: 2em;">
              <div class="col-md-12">
                <a href="products.php"><button type="button" class="btn btn-success pull-left"><i class="glyphicon glyphicon-arrow-left"></i></button></a>
                <button type="submit" name="update-product" class="btn btn-primary pull-left" style="width: 6.5em">Actualizar
                </button>
              </div>
  					</div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Este es el fondo de jQuery para esta página.e -->
<script type="text/javascript" src="lib/js/edit_product.js"></script>
<?php include_once('layouts/footer.php'); ?>
