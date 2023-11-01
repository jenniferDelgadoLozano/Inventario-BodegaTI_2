<?php
  $page_title = 'Agregar Salida';
  require_once('includes/load.php');
  // Checkin ¿Qué nivel de usuario tiene permiso para ver esta página?
   page_require_level(2);
  $all_estado = find_all('estados');
?>
<?php
if(isset($_POST['add_sale'])) {
  $photo = new Media();
  $photo->upload($_FILES['file_upload']);
  if($photo->process_acta()){
    $session->msg('s','Imagen subida al servidor.');
  } else{
    $session->msg('d',join($photo->errors));
  }
}
?>
<?php
if( isset($_POST['add_sale']) ){
  $req_fields = array('codigo', 'modelo','serie','quantity','ticket','tecnico','departamento','colaborador','movimiento','date','estados','usuario' );
  validate_fields($req_fields);
  if(empty($errors)){
    $p_codigo  = $db->escape((int)$_POST['codigo']);
    $s_modelo       = $db->escape($_POST['modelo']);
    $s_serie        = $db->escape($_POST['serie']);
    $s_qty          = $db->escape((int)$_POST['quantity']);
    $s_cantidad     = $db->escape((int)$_POST['quantity']);
    $s_ticket       = $db->escape($_POST['ticket']);
    $s_tecnico      = $db->escape($_POST['tecnico']);
    $s_departamento = $db->escape($_POST['departamento']);
    $s_colaborador  = $db->escape($_POST['colaborador']);
    $s_movimiento   = $db->escape($_POST['movimiento']);
    $s_usuario      = remove_junk($db->escape($_POST['usuario']));
    $s_estados      = remove_junk($db->escape($_POST['estados']));
    $date           = $db->escape($_POST['date']);
    $s_date         = make_date();
    if (is_null($_POST['file_upload']) || $_POST['file_upload'] === "") {
      $nombrearchivo = '0';
    } else {
      $nombrearchivo = remove_junk($db->escape($_POST['file_upload']));
    }

    $producto = stockreal($s_qty,$p_codigo);
    foreach ($producto as $resultado) {
      $resta = $resultado['cant_real'];
    }

      $sql  = "INSERT INTO kardex (codigo,date,name,movimiento,entrada,salida,stock,estados) VALUES ('{$p_codigo}', '{$s_date}', '', '{$s_movimiento}', '-', '{$s_cantidad}','{$resta}','{$s_estados}')";
      if($db->query($sql)){
        $session->msg('s',"Salida agregada ");
      } else {
        $session->msg('d','Lo siento, registro falló.');
        redirect('add_sale.php', false);
      }
      
      $sql  = "INSERT INTO actas (titulo,ticket,nombrearchivo) VALUES ('{$s_ticket}','{$s_ticket}','{$_FILES['file_upload']['full_path']}')";
      if($db->query($sql)){
        $session->msg('s',"Salida agregada ");
      } else {
        $session->msg('d','Lo siento, registro falló.');
        redirect('add_sale.php', false);
      }
           
      $sql  = "INSERT INTO sales (";
      $sql .= " codigo,modelo,serie,qty,ticket,tecnico,departamento,colaborador,movimiento,cant_sal,date,nombrearchivo,estados";
      $sql .= ") VALUES (";
      $sql .= "'{$p_codigo}','{$s_modelo}','{$s_serie}','{$s_qty}','{$s_ticket}','{$s_tecnico}','{$s_departamento}','{$s_colaborador}',";
      $sql .= "'{$s_movimiento}','{$s_qty}','{$s_date}','{$_FILES['file_upload']['full_path']}','{$s_estados}'";
      $sql .= ")";
      if($db->query($sql)){
        update_product_qty($s_qty,$p_codigo);
        $session->msg('s',"Salida agregada ");
        redirect('add_sale.php', false);
      } else {
        $session->msg('d','Lo siento, registro falló.');
        redirect('add_sale.php', false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('add_sale.php',false);
  }
}
?>
<?php $all_estado = find_all('estados'); ?>
<?php include_once('layouts/header.php'); ?>
<body class="login">
    <div class="loading">...</div> 
    
</div>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-btn">
            <button class="btn btn-primary" onclick="buscar()">Búsqueda</button>
          </span>
          <input type="text" id="input_busqueda" class="form-control" name="title" placeholder="Buscar por Codigo">
        </div>
        <div id="result" name="result" class="list-group"></div>
      </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Editar salida</span>
       </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="add_sale.php" enctype="multipart/form-data">
          <table class="table table-bordered">
            <thead>
              <th> CODIGO </th>
              <th> PRODUCTO </th>
              <th> MODELO </th>
              <th> SERIE </th>
              <th> CANTIDAD </th>
              <th> TICKET </th>
              <th> TECNICO </th>
              <th> DESTINO </th>
              <th> COLABORADOR </th>
              <th> MOVIMIENTO </th>
              <th> ESTADOS </th>
              <th> AGREGADO </th>
              <th> ACTA DE ENTREGA </th>
              <th> ACCIONES </th>
            </thead>
            <tbody  id="product_info"></tbody>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
<?php include_once('layouts/footer.php'); ?>
<script>
$(window).load(function () {
  $(".loading").fadeOut("slow");
});
</script>