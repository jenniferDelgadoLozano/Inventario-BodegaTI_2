<?php
  $page_title = 'Lista de productos';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $products = join_product_table();
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
         <div class="pull-right">
           <a href="add_product.php" class="btn btn-primary">Agregar producto</a>
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center"> CODIGO </th>
                <th class="text-center"> IMAGEN</th>
                <th class="text-center"> PRODUCTO </th>
                <th class="text-center"> STOCK </th>
                <th class="text-center"> MODELO </th>
                <th class="text-center"> SERIE </th>
                <th class="text-center"> UBICACION </th>
                <th class="text-center"> MOVIMIENTO </th>
                <th class="text-center"> ESTADO </th>
                <th class="text-center"> TECNICO </th>
                <th class="text-center"> FECHA DE MOVIMIENTO </th>
                <th class="text-center"> EDITAR </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product):?>
              <tr>
                <td class="text-center"> <?php echo remove_junk($product['codigo']); ?></td>
                <td class="text-center"><a href="uploads/products/<?php echo $product['image'];?>" style="color:#42A5F5;"><?php echo $product['image'];?></a></td>
                <td class="text-center"> <?php echo remove_junk($product['name']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['quantity']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['modelo']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['serie']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['categorie_id']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['movimiento']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['estados']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['usuario']); ?></td>
                <td class="text-center"> <?php echo read_date($product['date']); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_product.php?id=<?php echo (int)$product['codigo'];?>" class="btn btn-info btn-xs"  title="Editar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                     <a href="delete_product.php?id=
                     <?php 
                     echo (int)$product['codigo'];
                     ?>
                     "class="btn btn-danger btn-xs"  title="Eliminar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
