<?php
  $page_title = 'Agregar producto';
  require_once('includes/load.php');
  // Checkin ¿Qué nivel de usuario tiene permiso para ver esta página?
  page_require_level(2);
  $all_categories = find_all('categories');
  $all_ubicaciones = find_all('ubicaciones');
  $all_photo = find_all('media');
?>
<?php

if(isset($_POST['add_product'])){
  $req_fields = array('product-codigo','product-factura','product-title','product-categorie','product-quantity','product-modelo','product-serie','product-ubicacion' );
  validate_fields($req_fields);
  if(empty($errors)){
    $p_codigo = remove_junk($db->escape($_POST['product-codigo']));
    $p_fac    = remove_junk($db->escape($_POST['product-factura']));
     $p_name   = remove_junk($db->escape($_POST['product-title']));
     $p_cat    = remove_junk($db->escape($_POST['product-categorie']));
     $p_qty    = remove_junk($db->escape($_POST['product-quantity']));
     $p_mod    = remove_junk($db->escape($_POST['product-modelo']));
     $p_ser    = remove_junk($db->escape($_POST['product-serie']));
     $p_ubi    = remove_junk($db->escape($_POST['product-ubicacion']));
     if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
      $media_id = '0';
    } else {
      $media_id = remove_junk($db->escape($_POST['product-photo']));
    }

    $query  = "SELECT COUNT(*) AS Cuenta FROM products WHERE name = '$p_name'";
    $result = find_by_sql($query);
    $total= ($result[0]['Cuenta']);

    if($total > 0){
      $session->msg('d',"Producto existente, Consulte el ID ");
      redirect('add_product.php', false);
    }

    $var = "ENT";
    $date    = make_date();
    $query  = "INSERT INTO kardex (codigo,date,name,movimiento,entrada,salida,stock) VALUES ('{$p_codigo}', '{$date}', '{$p_name}', '$var  $p_fac', '{$p_qty}', '-', '{$p_qty}')";

    if($db->query($query)){
      $session->msg('s',"Producto agregado exitosamente. ");      
    } else {
      $session->msg('d',' Lo siento, registro falló.');
      redirect('product.php', false);
    }

    $query  = "INSERT INTO products (";
    $query .=" codigo,factura,name,quantity,categorie_id,modelo,serie,ubicacion_id,media_id,date,entrada,movimiento,estado ";
    $query .=") VALUES (";
    $query .=" '{$p_codigo}', '{$p_fac}', '{$p_name}', '{$p_qty}', '{$p_cat}', '{$p_mod}', '{$p_ser}', '{$p_ubi}', '{$media_id}', '{$date}', '{$p_qty}', '$var  $p_fac', 1 ";
    $query .=")";
    
    if($db->query($query)){
      $session->msg('s',"Producto agregado exitosamente. ");
      redirect('add_product.php', false);
    } else {
      $session->msg('d',' Lo siento, registro falló.');
      redirect('product.php', false);
    }
    
  } else{
    $session->msg("d", $errors);
    redirect('add_product.php',false);
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
  <div class="col-md-6">
    <form method="POST" action="" autocomplete="off" id="sug-form">
      <div class="input-container">
        <input type="search" id="search" class="form-busqueda" placeholder=" Buscar id" />
      </div>
      <div class="errors-container" style="display: none;">
        <p></p>
      </div>
      <div class="resultado-container">
    </form>
  </div>
</div>
  <div class="row">
    <div class="col-md-9">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Agregar entrada</span>
          </strong>
        </div>
      </div>
    </div>
  </div>
</body>

<div class="col-md-1">
  <div class="panel-body" style="display: none;" id="resultadoContainer">
    <table class="table table-bordered table-striped" id="resultado">
      <thead>
        <tr>
          <th class="text-center"> Codigo </th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($producto as $prodto):?>
        </div>
        <tr>
          <td class="text-center" name="product-codigo"><?php echo remove_junk($prodto['codigo']); ?></td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
    <div>
    <a href="actualizar.php" class="btn btn-success">Actualizar producto</a>
  </div>
  </div>
  <script src="script2.js" defer></script>
</div></br></br></br>

<div class="panel-body">
  <div class="col-md-12">
    <form method="post" action="add_product.php" class="clearfix">
    <div class="col-md-4">
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-arrow-right"></i>
          </span>
          <?php $numero_aleatorio = rand(1,10000); ?>
          <input type="text" class="form-control" name="product-codigo" value="<?php echo $numero_aleatorio ?>">
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
        <button type="submit" name="add_product" class="btn btn-danger">Agregar entrada</button>
      </div>
    </div></br></br></br>
  </form>
</div>
</div>

<?php include_once('layouts/footer.php'); ?>