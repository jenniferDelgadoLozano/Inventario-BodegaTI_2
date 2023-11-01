<?php
$page_title = 'Busqueda';
require_once('includes/load.php');
$criterio_busqueda = $_POST['criterio_busqueda'];

$sql  = "SELECT K.codigo, K.date, P.name, K.movimiento, k.estados, k.ubicacion, K.entrada, K.salida, K.stock ";
$sql .="FROM kardex k ";
$sql .="INNER JOIN products p ON p.codigo = k.codigo ";
$sql .="WHERE k.codigo LIKE '%".$criterio_busqueda."%' ";
$sql .=" ORDER BY date, codigo, name DESC";

$products = [];
$errors =['data' => false];

$getProducts = $db->query($sql);
if($getProducts->num_rows > 0) {
    while($data = $getProducts->fetch_assoc()){
        $products[] = $data;
    }
    echo json_encode($products);
}else{
    echo json_encode($errors);
}

?>