<?php
  $page_title = 'Kardex';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$salidas = kardex();
?>
<?php include_once('layouts/header.php'); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="Libreria-1\jquery.dataTables.min.css">
  <script src="Libreria-1\jquery-3.6.1.min.js"></script>
  <script src="Libreria-1\jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="script.js"></script>
</head>
<body>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="panel-heading clearfix">
  <div class="pull-right">
    <a href="add_product.php" class="btn btn-success">Agregar entrada</a>
    <a href="add_sale.php" class="btn btn-danger">Agregar salida </a>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
    <form method="POST" action="" autocomplete="off" id="sug-form">
      <!-- <div class="input-container">
        <input type="search" id="search" class="form-busqueda" placeholder="Buscar..." />
      </div> -->
      <div class="errors-container" style="display: none;">
       <p></p>
      </div>
      <div class="resultado-container">
      </form>
    </div>
  </div>
  
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Kardex</span>
          </strong>
        </div>
        <div class="panel-body" style="display: none;" id="resultadoContainer">
          <table class="table table-bordered table-striped" id="resultado">
            <thead>
              <tr>
                <th class="text-center"> CODIGO </th>
                <th class="text-center"> FECHA </th>
                <th class="text-center"> PRODUCTO</th>
                <th class="text-center"> MOVIMIENTO </th>
                <th class="text-center"> ESTADO </th>
                <th class="text-center"> ENTRADA</th>
                <th class="text-center"> SALIDA</th>
                <th class="text-center"> STOCK </th>
                <th class="text-center"> UBICACION </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($salidas as $salid):?>
              </div>
              <tr>
                <td class="text-center"><?php echo remove_junk($salid['codigo']); ?></td>
                <td class="text-center"><?php echo $salid['date']; ?></td>
                <td class="text-center"><?php echo remove_junk($salid['name']); ?></td>
                <td class="text-center"><?php echo remove_junk($salid['movimiento']);?></td>
                <td class="text-center"><?php echo $salid['estados'];?></td>
                <td class="text-center"><?php echo $salid['entrada']; ?></td>
                <td class="text-center"><?php echo $salid['salida']; ?></td>
                <td class="text-center"><?php echo $salid['stock']; ?></td>
                <td class="text-center"><?php echo $salid['ubicacion'];?></td>
              </tr>
              <?php endforeach;?>
            </tbody>
          </table>
        </div>
      </main>
      <script src="script.js" defer></script>
    </div>
  </div>
</div>
</div>
<script>
$('#resultado').DataTable({
          "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
          },
          "aLengthMenu": [20,50,100]
        });
        </script>
</body>
<?php include_once('layouts/footer.php'); ?>
<!-- $sql = "UPDATE sales SET stock = $nuevostock WHERE date = (SELECT MAX(date) from sales) "; -->
