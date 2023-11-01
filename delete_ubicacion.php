<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
?>
<?php
  $ubicacion = find_by_id('ubicaciones',(int)$_GET['id']);
  if(!$ubicacion){
    $session->msg("d","ID de la ubicacion falta.");
    redirect('ubicacion.php');
  }
?>
<?php
  $delete_id = delete_by_id('ubicaciones',(int)$ubicacion['id']);
  if($delete_id){
      $session->msg("s","Bodega eliminada");
      redirect('ubicacion.php');
  } else {
      $session->msg("d","Eliminación falló");
      redirect('ubicacion.php');
  }
?>
