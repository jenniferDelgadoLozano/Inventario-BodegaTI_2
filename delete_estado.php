<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
?>
<?php
  $estado = find_by_id('estados',(int)$_GET['id']);
  if(!$estado){
    $session->msg("d","ID de la categoría falta.");
    redirect('estado.php');
  }
?>
<?php
  $delete_id = delete_by_id('estados',(int)$estado['id']);
  if($delete_id){
      $session->msg("s","Categoría eliminada");
      redirect('estado.php');
  } else {
      $session->msg("d","Eliminación falló");
      redirect('estado.php');
  }
?>
