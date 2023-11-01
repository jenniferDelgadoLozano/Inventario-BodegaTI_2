<!-- 
<?php
  $page_title = 'Subir PDF';
  require_once('includes/load.php');
?>

<html>
  <head>
    <meta charset="UTF-8">
  </head>
  <body>
    <table>
      <tr>
        <td>Titulo</td>
        <td>Descripcion</td>
        <td>Tamaño</td>
        <td>Tipo</td>
        <td>Nombre</td>
    </tr>
    <?php
        $query = "SELECT * FROM actas";
        while ($datos=$db->fetch_row($query) { ?>
          <tr>
          <td><?php echo $datos['titulo'];?></td>
          <td><?php echo $datos['descripcion'];?></td>
          <td><?php echo $datos['tamanio'];?></td>
          <td><?php echo $datos['tipo'];?></td>
          <td><a href="lista.php"><?php echo $datos['nombrearchivo'];?></a></td>
          </tr>
       <?php } ?>
    
    </table>
    </body>
    </html> -->
