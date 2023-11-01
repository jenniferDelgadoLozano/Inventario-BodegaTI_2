<?php
$page_title = 'Busqueda';
require_once('includes/load.php');
$criterio_busqueda = $_POST['criterio_busqueda'];

$sql = "SELECT p.codigo FROM products P WHERE name LIKE '%".$criterio_busqueda."%' ";
$sql .= " ORDER BY date ASC";

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