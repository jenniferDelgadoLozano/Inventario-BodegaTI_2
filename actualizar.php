<?php
  $page_title = 'Agregar producto';
  require_once('includes/load.php');
  page_require_level(2);
  // Checkin ¿Qué nivel de usuario tiene permiso para ver esta página?
  // page_require_level(2);
  $all_categories = find_all('categories');
  $all_ubicaciones = find_all('ubicaciones');
  $all_photo = find_all('media');
?>
<?php
 if(isset($_POST['add_product'])){
   $req_fields = array('product-codigo','product-factura','product-title','product-categorie','product-quantity','product-modelo','product-serie','product-ubicacion' );
   validate_fields($req_fields);
   if(empty($errors)){
     $p_cod   = remove_junk($db->escape($_POST['product-codigo']));
     $p_fac   = remove_junk($db->escape($_POST['product-factura']));
     $p_name  = remove_junk($db->escape($_POST['product-title']));
     $p_cat   = remove_junk($db->escape($_POST['product-categorie']));
     $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
     $p_mod   = remove_junk($db->escape($_POST['product-modelo']));
     $p_ser   = remove_junk($db->escape($_POST['product-serie']));
     $p_ubi   = remove_junk($db->escape($_POST['product-ubicacion']));
     if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
      $media_id = '0';
    } else {
      $media_id = remove_junk($db->escape($_POST['product-photo']));
    }

    // 1)SE CAMBIA EL ESTADO DE LA ULTIMA INSERCION:
    $suma = 0;
    $producto = cantidad($p_name);
    foreach ($producto as $resultado) {
      $suma = $resultado['quantity'];
    }

    // 2) SE SUMA LA CANTIDAD AL ULTIMO DATO SEGUN EL ESTADO 1:
    $query = "UPDATE products SET estado = 0 WHERE codigo = '{$p_cod}' AND estado = 1 ";  

    if($db->query($query)){}

    $var = "ACT";
    $date = make_date();

    $query  = "INSERT INTO kardex (codigo,date,name,movimiento,entrada,salida,stock) VALUES ('{$p_cod}', '{$date}', '{$p_name}', '$var  $p_fac', '{$p_qty}', '-', '{$p_qty}')";

    if($db->query($query)){
      $session->msg('s',"Producto agregado exitosamente. ");      
    } else {
      $session->msg('d',' Lo siento, registro falló.');
      redirect('product.php', false);
    }


    $query = "INSERT INTO products (codigo, factura, name, quantity, categorie_id, modelo, serie, ubicacion_id, media_id, date, entrada, movimiento, estado)";
    $query .=" VALUES ('{$p_cod}', '{$p_fac}', '{$p_name}', '{$suma}'+'{$p_qty}', '{$p_cat}', '{$p_mod}', '{$p_ser}', '{$p_ubi}', '{$media_id}', '{$date}', '{$p_qty}', '$var  $p_fac', 1)";
    
    if($db->query($query)){
      $session->msg('s',"Producto agregado exitosamente. ");
      redirect('actualizar.php', false);
    } else {
      $session->msg('d',' Lo siento, registro falló.');
      redirect('product.php', false);
    }

  } else{
    $session->msg("d", $errors);
    redirect('actualizar.php',false);
  }
}

$producto = agregar();
?>
<body>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
    <div class="col-md-9">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Actualizar producto</span>
          </strong>
        </div>
      </div>
    </div>
  </div>
</body>

<div class="panel-body">
  <div class="col-md-12">
    <form method="post" action="actualizar.php" class="clearfix">

    <div class="col-md-4">
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-list-alt"></i>
          </span>
          <input type="text" class="form-control" name="product-codigo" placeholder="Id">
          <span class="input-group-addon">.</span>
        </div>
      </div>
    </div></br></br></br>
    <div class="col-md-4">
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-list-alt"></i>
          </span>
          <input type="text" class="form-control" name="product-factura" placeholder="Factura">
          <span class="input-group-addon">.</span>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-th-large"></i>
          </span>
          <input type="text" class="form-control" name="product-title" placeholder="Producto">
          <span class="input-group-addon">.</span>
        </div>
      </div>
    </div></br></br></br>
    <div class="col-md-4">
      <div class="input-group">
        <span class="input-group-addon">
          <i class="glyphicon glyphicon-search"></i>
        </span>
        <select class="form-control" name="product-categorie">
          <option value="">Selecciona una categoría</option>
          <?php  foreach ($all_categories as $cat): ?>
            <option value="<?php echo (int)$cat['id'] ?>">
            <?php echo $cat['name'] ?>
          </option>
          <?php endforeach; ?>
        </select>
        <span class="input-group-addon">.</span>
      </div>
    </div>
    <div class="col-md-4">
      <div class="input-group">
        <span class="input-group-addon">
          <i class="glyphicon glyphicon-search"></i>
        </span>
        <select class="form-control" name="product-photo">
          <option value="">Selecciona una imagen</option>
          <?php  foreach ($all_photo as $photo): ?>
            <option value="<?php echo (int)$photo['id'] ?>">
            <?php echo $photo['file_name'] ?>
          </option>
          <?php endforeach; ?>
        </select>
        <span class="input-group-addon">.</span>
      </div>
    </div></br></br></br>
    <div class="col-md-4">
      <div class="input-group">
        <span class="input-group-addon">
          <i class="glyphicon glyphicon-shopping-cart"></i>
        </span>
        <input type="number" class="form-control" name="product-quantity" placeholder="Cantidad">
        <span class="input-group-addon">.</span>
      </div>
    </div>
    <div class="col-md-4">
      <div class="input-group">
        <span class="input-group-addon">
          <i class="glyphicon glyphicon-list-alt"></i>
        </span>
        <input type="text" class="form-control" name="product-modelo" placeholder="Modelo">
        <span class="input-group-addon">.</span>
      </div>
    </div></br></br></br>
    <div class="col-md-4">
      <div class="input-group">
        <span class="input-group-addon">
          <i class="glyphicon glyphicon-barcode"></i>
        </span>
        <input type="text" class="form-control" name="product-serie" placeholder="Serie">
        <span class="input-group-addon">.</span>
      </div>
    </div>
    <div class="col-md-4">
      <div class="input-group">
        <span class="input-group-addon">
          <i class="glyphicon glyphicon-search"></i>
        </span>
        <select class="form-control" name="product-ubicacion">
          <option value="">Ubicación</option>
          <?php  foreach ($all_ubicaciones as $ubi): ?>
            <option value="<?php echo (int)$ubi['id'] ?>">
            <?php echo $ubi['name'] ?>
          </option>
          <?php endforeach; ?>
        </select>
        <span class="input-group-addon">.</span>
      </div>
    </div></br></br></br>
    <div class="col-md-4">
      <div class="input-group">
        <button type="submit" name="add_product" class="btn btn-danger">Agregar producto</button>
      </div>
    </div></br></br></br>
  </form>
</div>
</div>

<?php include_once('layouts/footer.php'); ?>