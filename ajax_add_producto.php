<?php
  $page_title = 'Agregar producto';
  require_once('includes/load.php');
  // Checkin ¿Qué nivel de usuario tiene permiso para ver esta página?
  // page_require_level(2);
  $all_categories = find_all('categories');
  $all_ubicaciones = find_all('ubicaciones');
  $all_photo = find_all('media');
  $all_estados = find_all('estados');
?>
<?php
if(isset($_POST['p_codigo'])){
     $respuesta  = "";
     $p_codigo = remove_junk($db->escape($_POST['p_codigo']));
     $p_fac    = remove_junk($db->escape($_POST['p_factura']));
     $p_name   = remove_junk($db->escape($_POST['p_title']));
    //  echo  $p_name;die;
     $p_cat    = remove_junk($db->escape($_POST['p_categorie']));
      $p_qty    = remove_junk($db->escape($_POST['p_quantity']));
      $p_mod    = remove_junk($db->escape($_POST['p_modelo']));
      $p_ser    = remove_junk($db->escape($_POST['p_serie']));
      $p_ubi    = remove_junk($db->escape($_POST['p_ubicacion']));
      $p_estados = remove_junk($db->escape($_POST['p_estados']));
      $p_usuario = remove_junk($db->escape($_POST['p_usuario']));
      $p_photo = remove_junk($db->escape($_POST['p_photo']));
      // if (is_null($p_photo ) || $p_photo  === "") {
      //   echo json_encode("Error - Valide la foto seleccionada");
      //   die;
      // } else {
      //   $media_id =  $p_photo;
      // }
      $media_id =  $p_photo;

      $query  = "SELECT COUNT(*) AS Cuenta FROM products WHERE name = '$p_name '";
      $result = find_by_sql($query);
      $total= ($result[0]['Cuenta']);

      if($total > 0){
        $session->msg('d',"Producto existente, Consulte el ID ");
        echo json_encode("Error - Producto existente, Consulte el ID");
        die;
      }
      $var = "ENT";
      $date    = make_date();
      $query  = "INSERT INTO kardex (codigo,date,name,movimiento,entrada,salida,stock,estados) VALUES ('{$p_codigo}', '{$date}', '{$p_name}', '$var  $p_fac', '{$p_qty}', '-', '{$p_qty}','{$p_estados}')";
      
      if($db->query($query)){
        $session->msg('s',"Producto agregado exitosamente. ");      
      } else {
        $session->msg('d',' Lo siento, registro falló.');
        redirect('product.php', false);
      }
      // $var = "ENT";
      // $date    = make_date();
      $query  = "INSERT INTO products (";
      $query .=" codigo,factura,name,quantity,categorie_id,modelo,serie,ubicacion_id,estados,media_id,date,entrada,movimiento,estado,usuario ";
      $query .=") VALUES (";
      $query .=" '{$p_codigo}', '{$p_fac}', '{$p_name}', '{$p_qty}', '{$p_cat}', '{$p_mod}', '{$p_ser}', '{$p_ubi}', '{$p_estados}', '{$media_id}', '{$date}', '{$p_qty}', '$var  $p_fac', 1,'$p_usuario' ";
      $query .=")";
      
      if($db->query($query)){
        // $session->msg('s',"Producto agregado exitosamente. ");
        // redirect('add_product.php', false);
        $session->msg('s',"Producto agregado exitosamente. ");
        echo json_encode("Producto agregado exitosamente.");
        // redirect('add_product.php', false);
        // die;
      } else {
        $session->msg('d',' Lo siento, registro falló.');
        echo json_encode("Error - Lo siento, registro falló");
        // redirect('product.php', false);
        die;
        // $session->msg('d',' Lo siento, registro falló.');
        // redirect('product.php', false);
      }
}
// if(isset($_POST['add_product'])){
//   echo ("entra"); die;
//   $req_fields = array('product-codigo','product-factura','product-title','product-categorie','product-quantity','product-modelo','product-serie','product-ubicacion','product-estados','product-usuario' );
//   validate_fields($req_fields);
//   // if(empty($errors)){
//     $p_codigo = remove_junk($db->escape($_POST['product-codigo']));
//      $p_fac    = remove_junk($db->escape($_POST['product-factura']));
//      $p_name   = remove_junk($db->escape($_POST['product-title']));
//      $p_cat    = remove_junk($db->escape($_POST['product-categorie']));
//      $p_qty    = remove_junk($db->escape($_POST['product-quantity']));
//      $p_mod    = remove_junk($db->escape($_POST['product-modelo']));
//      $p_ser    = remove_junk($db->escape($_POST['product-serie']));
//      $p_ubi    = remove_junk($db->escape($_POST['product-ubicacion']));
//      $p_estados = remove_junk($db->escape($_POST['product-estados']));
//      $p_usuario = remove_junk($db->escape($_POST['product-usuario']));
//      if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
//       $media_id = '0';
//     } else {
//       $media_id = remove_junk($db->escape($_POST['product-photo']));
//     }

//     $query  = "SELECT COUNT(*) AS Cuenta FROM products WHERE name = '$p_name '";
//     $result = find_by_sql($query);
//     $total= ($result[0]['Cuenta']);

//     if($total > 0){
//       $session->msg('d',"Producto existente, Consulte el ID ");
//       redirect('add_product.php', false);
//     }


//     $query  = "INSERT INTO products (";
//     $query .=" codigo,factura,name,quantity,categorie_id,modelo,serie,ubicacion_id,estados,media_id,date,entrada,movimiento,estado,usuario ";
//     $query .=") VALUES (";
//     $query .=" '{$p_codigo}', '{$p_fac}', '{$p_name}', '{$p_qty}', '{$p_cat}', '{$p_mod}', '{$p_ser}', '{$p_ubi}', '{$p_estados}', '{$media_id}', '{$date}', '{$p_qty}', '$var  $p_fac', 1,'$p_usuario' ";
//     $query .=")";
    
//     if($db->query($query)){
//       $session->msg('s',"Producto agregado exitosamente. ");
//       redirect('add_product.php', false);
//     } else {
//       $session->msg('d',' Lo siento, registro falló.');
//       redirect('product.php', false);
//     }
    
//   // } else{
//   //   $session->msg("d", $errors);
//   //   redirect('add_product.php',false);
//   // }
// }