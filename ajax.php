<?php
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php
 // Auto suggetion
    $html = '';
   if(isset($_POST['product_name']) && strlen($_POST['product_name']))
   {
     $products = find_product_by_title($_POST['product_name']);
     if($products){
        foreach ($products as $product):
            $cod = $product['codigo'];
           $html .= "<li class=\"list-group-item\"> <a id=\"a_$cod\"   onClick=\"respuesta(this)\">";
           $html .= $product['codigo'];
           $html .= "-";
           $html .= $product['name'];
           $html .= "</a></li>";
         endforeach;
      } else {

        $html .= '<li onClick=\"fill(\''.addslashes().'\')\" class=\"list-group-item\">';
        $html .= 'No encontrado';
        $html .= "</li>";

      }

      echo json_encode($html);
   }
 ?>
 <?php
 $all_estado = find_all('estados');
 ?>
 <?php
 // find all product
  if(isset($_POST['p_name']) && strlen($_POST['p_name']))
  {
    $product_title = remove_junk($db->escape($_POST['p_name']));
    if($results = find_all_product_info_by_title($product_title)){
        foreach ($results as $result) {

          $html .= "<tr>";

          $html .= "<td id=\"s_name\">".$result['codigo']."</td>";
          $html .= "<input type=\"hidden\" name=\"codigo\" value=\"{$result['codigo']}\">";

          $html .= "<td id=\"s_name\">".$result['name']."</td>";
          $html .= "<input type=\"hidden\" name=\"s_codigo\" value=\"{$result['codigo']}\">";
          
          $html  .= "<td>";
          $html  .= "<input type=\"text\" class=\"form-control\" name=\"modelo\" value=\"\">";
          $html  .= "</td>";

          $html  .= "<td>";
          $html  .= "<input type=\"text\" class=\"form-control\" name=\"serie\" value=\"\">";
          $html  .= "</td>";

          $html  .= "<td>";
          $html .= "<input type=\"text\" class=\"form-control\" name=\"quantity\" value=\"1\">";
          $html  .= "</td>";

          $html  .= "<td>";
          $html  .= "<input type=\"text\" class=\"form-control\" name=\"ticket\" value=\"\">";
          $html  .= "</td>";

          $html  .= "<td>";
          $html  .= "<input type=\"text\" class=\"form-control\" name=\"tecnico\" value=\"\">";
          $html  .= "</td>";

          $html  .= "<td>";
          $html  .= "<input type=\"text\" class=\"form-control\" name=\"departamento\" value=\"\">";
          $html  .= "</td>";

          $html  .= "<td>";
          $html  .= "<input type=\"text\" class=\"form-control\" name=\"colaborador\" value=\"\">";
          $html  .= "</td>";

          $numero_aleatorio = rand(1,10000);
          // echo $numero_aleatorio;

          $html  .= "<td>";
          $html  .= "<input type=\"text\" class=\"form-control\" name=\"movimiento\" value=\"SAL$numero_aleatorio\" readonly>";
          $html  .= "</td>";

          $html  .= "<td>";
          $html  .= "<select class=\"form-control\" name=\"estados\">";
          // $html  .= "<option value=\"\"></option>";
          foreach ($all_estado as $estado)
          $html  .= "<option value=\"{$estado['name']}\">{$estado['name']}</option>";
        // endforeach;
          $html  .= "</select>";
          $html  .= "</td>";

          $html  .= "<td>";
          $html  .= "<input type=\"date\" class=\"form-control datePicker\" name=\"date\" data-date data-date-format=\"yyyy-mm-dd\">";
          $html  .= "</td>";
          
          $html  .= "<td>";
          $html  .= "<input type=\"file\" name=\"file_upload\" multiple=\"multiple\" value=\"\">";
          $html  .= "</td>";
          
          $html  .= "<td>";
          $html  .= "<button type=\"submit\" name=\"add_sale\" class=\"btn btn-primary\">Agregar</button>";
          $html  .= "</td>";

          $html  .= "</tr>";

        }
    } else {
        $html ='<tr><td>El producto no se encuentra registrado en la base de datos</td></tr>';
    }

    echo json_encode($html);
  }
?>

