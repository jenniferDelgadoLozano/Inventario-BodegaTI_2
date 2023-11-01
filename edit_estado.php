<?php
  $page_title = 'Editar Estado';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
?>
<?php
  //Display all catgories.
  $estado = find_by_id('estados',(int)$_GET['id']);
  if(!$estado){
    $session->msg("d","Missing estado id.");
    redirect('estado.php');
  }
?>

<?php
if(isset($_POST['edit_estado'])){
  $req_field = array('estado-name');
  validate_fields($req_field);
  $cat_name = remove_junk($db->escape($_POST['estado-name']));
  if(empty($errors)){
        $sql = "UPDATE estados SET name='{$cat_name}'";
       $sql .= " WHERE id='{$estado['id']}'";
     $result = $db->query($sql);
     if($result && $db->affected_rows() === 1) {
       $session->msg("s", "Estados actualizados con éxito.");
       redirect('estado.php',false);
     } else {
       $session->msg("d", "Lo siento, actualización falló.");
       redirect('estado.php',false);
     }
  } else {
    $session->msg("d", $errors);
    redirect('estado.php',false);
  }
}
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
   <div class="col-md-5">
     <div class="panel panel-default">
       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Editando <?php echo remove_junk(ucfirst($estado['name']));?></span>
        </strong>
       </div>
       <div class="panel-body">
         <form method="post" action="edit_estado.php?id=<?php echo (int)$estado['id'];?>">
           <div class="form-group">
               <input type="text" class="form-control" name="estado-name" value="<?php echo remove_junk(ucfirst($estado['name']));?>">
           </div>
           <button type="submit" name="edit_estado" class="btn btn-primary">Actualizar Estado</button>
       </form>
       </div>
     </div>
   </div>
</div>



<?php include_once('layouts/footer.php'); ?>
