<?php
  $page_title = 'Salidas diarias';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>

<?php
 $year  = date('Y');
 $month = date('m');
 $sales = dailySales($year,$month);
?>
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
            <span>Salidas diarias</span>
          </strong>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center">ITEM</th>
                <th class="text-center"> FECHA </th>
                <th class="text-center"> TICKET </th>
                <th class="text-center"> PRODUCTO </th>
                <th class="text-center"> MODELO </th>
                <th class="text-center"> SERIE </th>
                <th class="text-center"> CANTIDAD </th>
                <th class="text-center"> TECNICO </th>
                <th class="text-center"> DEPARTAMENTO </th>
                <th class="text-center"> COLABORADOR </th>
             </tr>
            </thead>
           <tbody>
             <?php foreach ($sales as $sale):?>
             <tr>
              <td class="text-center"><?php echo count_id();?></td>
              <td class="text-center"><?php echo date("d/m/Y", strtotime ($sale['date'])); ?></td>
              <td class="text-center"><?php echo remove_junk($sale['ticket']); ?></td>
              <td class="text-center"><?php echo remove_junk($sale['name']); ?></td>
              <td class="text-center"><?php echo remove_junk($sale['modelo']); ?></td>
              <td class="text-center"><?php echo remove_junk($sale['serie']); ?></td>
              <td class="text-center"><?php echo (int)$sale['qty']; ?></td>
              <td class="text-center"><?php echo remove_junk($sale['tecnico']); ?></td>
              <td class="text-center"><?php echo remove_junk($sale['departamento']); ?></td>
              <td class="text-center"><?php echo remove_junk($sale['colaborador']); ?></td>
             </tr>
             <?php endforeach;?>
           </tbody>
         </table>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
