<?php
  $page_title = 'Lista de salidas';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$sales = find_all_sale();
?>
<?php $media_files = find_all('sales');?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Todas las salidas</span>
          </strong>
          <div class="pull-right">
            <a href="add_sale.php" class="btn btn-primary">Agregar salida</a>
          </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center"> CODIGO </th>
                <th class="text-center"> FECHA </th>
                <th class="text-center"> PRODUCTO </th>
                <th class="text-center"> MODELO</th>
                <th class="text-center"> SERIE</th>
                <th class="text-center"> CANTIDAD</th>
                <th class="text-center"> TICKET</th>
                <th class="text-center"> TECNICO </th>
                <th class="text-center"> DESTINO </th>
                <th class="text-center"> COLABORADOR </th>
                <th class="text-center"> MOVIMIENTO </th>
                <th class="text-center"> ESTADO </th>
                <th class="text-center"> ACTA DE ENTREGA </th>
                <th class="text-center"> EDITAR </th>
             </tr>
            </thead>
           <tbody>
             <?php foreach ($sales as $sale):?>
             <tr>
              <td class="text-center"><?php echo remove_junk($sale['codigo']); ?></td>
              <td class="text-center"><?php echo $sale['date']; ?></td>
              <td class="text-center"><?php echo $sale['name']; ?></td>
              <td class="text-center"><?php echo $sale['modelo']; ?></td>
              <td class="text-center"><?php echo $sale['serie']; ?></td>
              <td class="text-center"><?php echo (int)$sale['qty']; ?></td>
              <td class="text-center"><?php echo $sale['ticket']; ?></td>
              <td class="text-center"><?php echo $sale['tecnico']; ?></td>
              <td class="text-center"><?php echo $sale['departamento']; ?></td>
              <td class="text-center"><?php echo $sale['colaborador']; ?></td>
              <td class="text-center"><?php echo $sale['movimiento']; ?></td>
              <td class="text-center"><?php echo $sale['estados']; ?></td>

              <td class="text-center"><a href="uploads/actas/<?php echo $sale['nombrearchivo'];?>" style="color:#42A5F5;"><?php echo $sale['nombrearchivo'];?></a></td>
              

              <td class="text-center">
                <div class="btn-group">
                  <a href="edit_sale.php?id=<?php echo (int)$sale['codigo'];?>" class="btn btn-warning btn-xs"  title="Edit" data-toggle="tooltip">
                  <span class="glyphicon glyphicon-edit"></span>
                </a>
                <a href="delete_sale.php?id=
                <?php
                echo (int)$sale['codigo'];
                ?>
                "class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                <span class="glyphicon glyphicon-trash"></span>
              </a>
              </div>
            </td>
          </tr>
          <?php endforeach;?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
<?php include_once('layouts/footer.php'); ?>
