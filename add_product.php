<?php
  $page_title = 'Agregar producto';
  require_once('includes/load.php');
  // Checkin ¿Qué nivel de usuario tiene permiso para ver esta página?
  page_require_level(2);
  $all_categories = find_all('categories');
  $all_ubicaciones = find_all('ubicaciones');
  $all_photo = find_all('media');
  $all_estados = find_all('estados');
?>
<?php

if(isset($_POST['add_product'])){
  // echo ("entra"); die;
  $req_fields = array('product-codigo','product-factura','product-title','product-categorie','product-quantity','product-modelo','product-serie','product-ubicacion','product-estados','product-usuario' );
  validate_fields($req_fields);
  if(empty($errors)){
     $p_codigo  = remove_junk($db->escape($_POST['product-codigo']));
     $p_fac     = remove_junk($db->escape($_POST['product-factura']));
     $p_name    = remove_junk($db->escape($_POST['product-title']));
     $p_cat     = remove_junk($db->escape($_POST['product-categorie']));
     $p_qty     = remove_junk($db->escape($_POST['product-quantity']));
     $p_mod     = remove_junk($db->escape($_POST['product-modelo']));
     $p_ser     = remove_junk($db->escape($_POST['product-serie']));
     $p_ubi     = remove_junk($db->escape($_POST['product-ubicacion']));
     $p_estados = remove_junk($db->escape($_POST['product-estados']));
     $p_usuario = remove_junk($db->escape($_POST['product-usuario']));
     if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
      $media_id = '0';
    } else {
      $media_id = remove_junk($db->escape($_POST['product-photo']));
    }

    $query  = "SELECT COUNT(*) AS Cuenta FROM products WHERE name = '$p_name'";
    $result = find_by_sql($query);
    $total= ($result[0]['Cuenta']);

    if($total > 0){
      $session->msg('d',"Producto existente, Consulte el ID ");
      redirect('add_product.php', false);
    }

    $var = "ENT";
    $date    = make_date();
    
    // if($db->query($query)){
      //   $session->msg('s',"Producto agregado exitosamente. ");
      //   redirect('add_product.php', false);
      // } else {
        //   $session->msg('d',' Lo siento, registro falló.');
        //   redirect('product.php', false);
        // }
        
        $query  = "INSERT INTO products (";
        $query .=" codigo,factura,name,quantity,categorie_id,modelo,serie,ubicacion_id,estados,media_id,date,entrada,movimiento,estado,usuario ";
        $query .=") VALUES (";
        $query .=" '{$p_codigo}', '{$p_fac}', '{$p_name}', '{$p_qty}', '{$p_cat}', '{$p_mod}', '{$p_ser}', '{$p_ubi}', '{$p_estados}', '{$media_id}', '{$date}', '{$p_qty}', '$var  $p_fac', 1,'$p_usuario' ";
        $query .=")";
        $query  = "INSERT INTO kardex (codigo,date,name,movimiento,entrada,salida,stock) VALUES ('{$p_codigo}', '{$date}', '{$p_name}', '$var  $p_fac', '{$p_qty}', '-', '{$p_qty}')";
    
    if($db->query($query)){
      $session->msg('s',"Producto agregado exitosamente. ");
      redirect('add_product.php', false);
    } else {
      $session->msg('d',' Lo siento, registro falló.');
      redirect('product.php', false);
    }
    
  } else{
    $session->msg("d", $errors);
    redirect('add_product.php',false);
  }
}

$producto = agregar();
?>
<!-- <body> -->
<body class="login">
    <div class="loading"></div> 
    ...
</div>
  <?php include_once('layouts/header.php'); ?>
  <div class="row">
    <div class="col-md-12">
      <?php echo display_msg($msg); ?>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <form method="POST" action="" autocomplete="off" id="sug-form">
        <div class="input-container">
          <input type="search" id="search" class="form-busqueda" placeholder=" Buscar id" />
        </div>
        <div class="errors-container" style="display: none;"><p></p>
        </div>
        <div class="resultado-container"></div>
      </form>
    </div>
  </div>
  <div class="row">
    <div class="col-md-9">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Agregar entrada</span>
          </strong>
        </div>
      </div>
    </div>
  </div>
</body>

<div class="col-md-1">
  <div class="panel-body" style="display: none;" id="resultadoContainer">
    <table class="table table-bordered table-striped" id="resultado">
      <thead>
        <tr>
          <th class="text-center"> Codigo </th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($producto as $prodto):?>
        </div>
        <tr>
          <td class="text-center" name="product-codigo"><?php echo remove_junk($prodto['codigo']); ?></td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
    <div>
    <a href="actualizar.php" class="btn btn-success">Actualizar producto</a>
   </div>
  </div>
  <script src="script2.js" defer></script>
</div></br></br></br>

<!-- _________________________________________________________________________________________________________________________________________________________________ -->
<body class="login">
    <div class="loading"></div>
<div class="panel-body">
  <div class="col-md-12">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <form id="form1" method="POST" action="add_product.php" class="clearfix">
      <div class="row">

        <div class="col-md-4">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-arrow-right"></i>
              </span>
              <?php $numero_aleatorio = rand(1,10000); ?>
              <input type="text" class="form-control" name="product-codigo" id="product-codigo1" value="<?php echo $numero_aleatorio ?>" readonly>
              <span class="input-group-addon">.</span>
            </div>
          </div>
        </div></br></br></br>
        
        <div class="col-md-4">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-list-alt"></i>
              </span>
              <input type="text" class="form-control" name="product-factura" id="product-factura1" placeholder="Factura" required>
              <span class="input-group-addon">.</span>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-th-large"></i>
              </span>
              <input type="text" class="form-control" name="product-title" id="product-title1" placeholder="Producto" required>
              <span class="input-group-addon">.</span>
            </div>
          </div>
        </div></br></br></br>

        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-search"></i>
            </span>
            <select class="form-control" name="product-categorie" id="product-categorie1" required>
              <option value="">Selecciona una categoría</option>
              <?php  foreach ($all_categories as $cat): ?>
                <option value="<?php echo (int)$cat['id'] ?>">
                 <?php echo $cat['name'] ?>
                </option>
              <?php endforeach; ?>
            </select>
            <span class="input-group-addon">.</span>
          </div>
        </div>

        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-search"></i>
            </span>
            <select class="form-control" name="product-photo" id="product-photo1">
              <option value="">Selecciona una imagen</option>
              <?php  foreach ($all_photo as $photo): ?>
                <option value="<?php echo (int)$photo['id'] ?>">
                 <?php echo $photo['file_name'] ?>
                </option>
              <?php endforeach; ?>
            </select>
            <span class="input-group-addon">.</span>
          </div>
        </div></br></br></br>
        
        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-shopping-cart"></i>
            </span>
            <input type="number" class="form-control" name="product-quantity" id="product-quantity1" placeholder="Cantidad" required>
            <span class="input-group-addon">.</span>
          </div>
        </div>

        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-list-alt"></i>
            </span>
            <input type="text" class="form-control" name="product-modelo" id="product-modelo1" placeholder="Modelo">
            <span class="input-group-addon">.</span>
          </div>
        </div></br></br></br>

        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-barcode"></i>
            </span>
            <input type="text" class="form-control" name="product-serie" id="product-serie1" placeholder="Serie">
            <span class="input-group-addon">.</span>
          </div>
        </div>

        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-search"></i>
            </span>
            <select class="form-control" name="product-ubicacion" id="product-ubicacion1" required>
              <option value="">Ubicación</option>
              <?php  foreach ($all_ubicaciones as $ubi): ?>
                <option value="<?php echo (int)$ubi['id'] ?>">
                 <?php echo $ubi['name'] ?>
                </option>
              <?php endforeach; ?>
            </select>
            <span class="input-group-addon">.</span>
          </div>
        </div></br></br></br>

        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-search"></i>
            </span>
            <select class="form-control" name="product-estados" id="product-estados1" required>
              <option value="">Estado</option>
              <?php  foreach ($all_estados as $estadodos): ?>
                <option value="<?php echo $estadodos['name'] ?>">
                 <?php echo $estadodos['name'] ?>
                </option>
              <?php endforeach; ?>
            </select>
            <span class="input-group-addon">.</span>
          </div>
        </div>

        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-user"></i>
            </span>
            <input type="text" class="form-control" name="product-usuario" id="product-usuario1" value="<?php echo remove_junk(ucfirst($user['name'])); ?>" readonly>
            <span class="input-group-addon">.</span>
          </div>
        </div></br></br></br>

        <div class="col-md-4">
          <div class="input-group-btn">
            <td><button type="button" class="btn btn-danger" id="adicionar">+</button></td>
          <div id="dinamic"></div>
        </div></br></br>

        <div class="col-md-4">
          <div class="input-group">
            <!-- <button type="submit" name="add_product" class="btn btn-primary" id="enviaDatos">Agregar entrada</button> -->
            <!-- <button name="add_product" class="Send" id="enviaDatos">Agregar entrada</button> -->
            <input value="Agregar entrada" onclick="enviaDatos()" type="button" class="btn btn-primary">
          </div>
        </div>

      </div>
    </form>
  </div>
</div>

<!-- <script src="libs/js/main.js"></script> -->
<?php include_once('layouts/footer.php'); ?>
<!-- _________________________________________________________________________________________________________________________________________________________________ -->
<script>
  
const contenedor = document.querySelector('#dinamic');
const btnAgregar = document.querySelector('#adicionar');

let total = 1;
var cantidad = 2;

btnAgregar.addEventListener('click', e => {
  let div = document.createElement('div');
  let aleatorio = Math.floor(Math.random() * (10000 - 1) + 1);
  div.innerHTML = `<label style="color: #800080;">${total++}</label> - 
  <div class="row" class="col-sm-14">
  <form id="form2" method="POST" action="add_product.php" class="clearfix">
    <div class="col-md-10">
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-arrow-right"></i>
            </span>
            <input type="text" class="form-control" name="product-codigo" id="product-codigo` + cantidad +`" value="${aleatorio}" readonly>
          <span class="input-group-addon">.</span>
        </div>
      </div>
    </div>
    
    <div class="col-md-10">
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-list-alt"></i>
          </span>
          <input type="text" class="form-control" name="product-factura1" id="product-factura` + cantidad +`" placeholder="Factura" >
          <span class="input-group-addon">.</span>
        </div>
      </div>
    </div><br><br><br>

    <div class="col-md-10">
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-th-large"></i>
          </span>
          <input type="text" class="form-control" name="product-title1" id="product-title` + cantidad +`" placeholder="Producto" >
          <span class="input-group-addon">.</span>
        </div>
      </div>
    </div>

    <div class="col-md-10">
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-search"></i>
          </span>
          <select class="form-control" name="product-categorie1" id="product-categorie` + cantidad + `" >
            <option value="">Selecciona una categoría</option>
              <?php  foreach ($all_categories as $cat): ?>
                <option value="<?php echo (int)$cat['id'] ?>">
                  <?php echo $cat['name'] ?>
                </option>
              <?php endforeach; ?>
          </select>
          <span class="input-group-addon">.</span>
        </div>
      </div>
    </div><br><br><br>

    <div class="col-md-10">
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-search"></i>
          </span>
          <select class="form-control" name="product-photo1" id="product-photo` + cantidad + `">
            <option value="">Selecciona una imagen</option>
            <?php  foreach ($all_photo as $photo): ?>
              <option value="<?php echo (int)$photo['id'] ?>">
                <?php echo $photo['file_name'] ?>
              </option>
            <?php endforeach; ?>
          </select>
          <span class="input-group-addon">.</span>
       </div>
     </div>
    </div>

    <div class="col-md-10">
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-shopping-cart"></i>
          </span>
          <input type="number" class="form-control" name="product-quantity1" id="product-quantity` + cantidad + `" placeholder="Cantidad" >
          <span class="input-group-addon">.</span>
       </div>
      </div>
    </div><br><br><br>

    <div class="col-md-10">
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-list-alt"></i>
          </span>
          <input type="text" class="form-control" name="product-modelo1" id="product-modelo` + cantidad + `" placeholder="Modelo">
          <span class="input-group-addon">.</span>
        </div>
      </div>
    </div>

    <div class="col-md-10">
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-barcode"></i>
          </span>
          <input type="text" class="form-control" name="product-serie1" id="product-serie` + cantidad + `" placeholder="Serie">
          <span class="input-group-addon">.</span>
        </div>
      </div>
    </div><br><br><br>

    <div class="col-md-10">
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-search"></i>
          </span>
          <select class="form-control" name="product-ubicacion1" id="product-ubicacion` + cantidad + `" >
            <option value="">Ubicación</option>
            <?php  foreach ($all_ubicaciones as $ubi): ?>
              <option value="<?php echo (int)$ubi['id'] ?>">
                <?php echo $ubi['name'] ?>
              </option>
            <?php endforeach; ?>
          </select>
          <span class="input-group-addon">.</span>
        </div>
      </div>
    </div>

    <div class="col-md-10">
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-user"></i>
          </span>
          <input type="text" class="form-control" name="product-usuario1" id="product-usuario` + cantidad + `" value="<?php echo remove_junk(ucfirst($user['name'])); ?>" readonly>
          <span class="input-group-addon">.</span>
        </div>
      </div>
    </div><br><br><br>

    <div class="col-md-10">
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-search"></i>
          </span>
          <select class="form-control" name="product-estados1" id="product-estados` + cantidad + `">
            <option value="">Estado</option>
            <?php  foreach ($all_estados as $estadodos): ?>
              <option value="<?php echo (int)$estadodos['name'] ?>">
                <?php echo $estadodos['name'] ?>
              </option>
            <?php endforeach; ?>
          </select>
          <span class="input-group-addon">.</span>
        </div>
      <div>
    </div>
    </form>
  </div>

  <button class="btn btn-danger" onclick="eliminar(this)">-</button>`;
  contenedor.appendChild(div);
  cantidad +=1;
})

// metodo para eliminar el div del contador del input @param {this} e

const eliminar = (e) => {
    const divPadre = e.parentNode;
    contenedor.removeChild(divPadre);
    actualizarContador();
    cantidad -=1;
};

//metodo para actualizar el contador de los elementos agregados

const actualizarContador = () => {
    let divs = contenedor.children;
    total = 1;
    for (let i = 0; i < divs.length; i++) {
        divs[i].children[0].innerHTML = total++;
    }
};

function enviaDatos(){
  let codigosErr = "";
  let codigosExitosos = "";
  let mensaje;
  let p_codigo,p_factura,p_title,p_categorie,p_quantity,p_modelo,p_serie,p_ubicacion,p_estados,p_usuario,p_photo;
  for(let i = 1; i < cantidad; i++){
      p_codigo = document.getElementById("product-codigo"+i).value;
      p_factura = document.getElementById("product-factura"+i).value;
      p_title = document.getElementById("product-title"+i).value;
      p_categorie = document.getElementById("product-categorie"+i).value;
      p_quantity = document.getElementById("product-quantity"+i).value;
      p_modelo = document.getElementById("product-modelo"+i).value;
      p_serie = document.getElementById("product-serie"+i).value;
      p_ubicacion = document.getElementById("product-ubicacion"+i).value;
      p_estados = document.getElementById("product-estados"+i).value;
      p_usuario = document.getElementById("product-usuario"+i).value;
      p_photo = document.getElementById("product-photo"+i).value;
      // console.log("#enviaDatos")
      
      if(!document.getElementById("product-codigo"+i).value){
        return;
      }

      var formData = {
        'p_codigo': p_codigo,
        'p_factura': p_factura,
        'p_title': p_title,
        'p_categorie': p_categorie,
        'p_quantity': p_quantity,
        'p_modelo': p_modelo,
        'p_serie': p_serie,
        'p_ubicacion': p_ubicacion,
        'p_estados': p_estados,
        'p_usuario': p_usuario,
        'p_photo':p_photo
        
      };
      console.log(formData)
    $.ajax({
        type        : 'POST',
        url         : 'ajax_add_producto.php',
        data        : formData,
        dataType    : 'json',
        encode      : true
    })
      .done(function(data) {
        console.log(data);
        if(data.includes("Error")){
          codigosErr += p_codigo + ","
        }else{
          codigosExitosos += p_codigo + ",";
        }
        if(codigosErr != ""){
          mensaje = "¡Atenciòn!\n✘ Hubo un error al momento de guardar los siguientes productos\n •" + data + " " + codigosErr + " por favor verifique\n\n" 
          if(codigosExitosos != ""){
            mensaje = "✔ Los productos " + codigosExitosos + " se han ingresado Correctamente";
          }
        }else{
          mensaje = "✔ Productos ingresados Exitosamente";
        }
        if(i == cantidad-1){
          alert(mensaje);
          location.href="http://localhost/oswa-inventario/add_product.php";
        }
      })
      .fail(function(e) {
        console.log("Error")
        console.log(e);
      });
    }
}

  $(window).load(function () {
             $(".loading").fadeOut("slow");
   });
</script>

<script>

// $(function() {
//   $("#enviaDatos").click(function(event) {
//     // /*Evita que se recargue la página*/
//     event.preventDefault();
//     // /* Serializamos en una sola variable ambos formularios*/
//     // var allData = $("#form1, #form2").serialize();
//     // /*Prueba*/
//     // console.log(allData);
//     // /*Podemos usar allData para enviarlo por Ajax o lo que sea*/
//     alert("entra")
//     for(let i = 1; i <= cantidad; i++){
//       console.log(document.getElementById("product-codigo"+i).value)
//     }
//   });
// });
</script>