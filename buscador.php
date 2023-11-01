<?php
  $page_title = 'Agregar producto';
  require_once('includes/load.php');
  // Checkin ¿Qué nivel de usuario tiene permiso para ver esta página?
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
    </head>
    <body>
    <form action="" method="GET">
        <input type="text" name="busqueda">
        <input type="submit" name="enviar" value="Buscar">
    </form>

    <br><br><br>

    <?php
    // if(isset($_GET['enviar'])) {
    // if(isset($_GET['enviar']) && ($_GET['name'])) {
    //     $busqueda = $_GET['busqueda'];

    //     $consulta = $con->query("SELECT * FROM products WHERE name LIKE '%$name%'");
        
    //     $query  = "SELECT * FROM products WHERE name LIKE '%$busqueda%'";

    //     while ($row = $consulta->fetch_array(MYSQLI_ASSOC)) {
    //     echo $row['name'].'<br>';
    //     }
    // }
    ?>
<!-- _____________________________________________________________________________________________________________________________ -->

    <form method="POST" action="">
        <input type="text" id="sug_input" class="form-control" name="busqueda" placeholder="Buscar...">
        <button type="submit" class="btn btn-primary">Búsqueda</button>
    </form>
    
    <?php
     global $db;
     $busqueda = $_GET['busqueda'];
     $sql = "SELECT * FROM products WHERE name like '%$busqueda%'";
     $result = find_by_sql($sql);
     var_dump($result);
    //  return $result;

    echo '<script>
    console.log("'.$result.'");
    </script>';

    foreach ($sql as $key){
    
    }

   ?>

</body>
</html>