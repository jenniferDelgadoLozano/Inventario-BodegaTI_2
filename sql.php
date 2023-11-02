<?php
  require_once('includes/load.php');

/*--------------------------------------------------------------*/
/* Function for find all database table rows by table name
/*--------------------------------------------------------------*/
function find_all($table) {
   global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table));
   }
}

/*--------------------------------------------------------------*/
/* Function for Perform queries
/*--------------------------------------------------------------*/
function find_by_sql($sql)
{
  global $db;
  $result = $db->query($sql);
  $result_set = $db->while_loop($result);
 return $result_set;
}
/*--------------------------------------------------------------*/
/*  Function for Find data from table by id
/*--------------------------------------------------------------*/
function find_by_id($table,$id)
{
  global $db;
  $id = (int)$id;
    if(tableExists($table)){
          $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}
/*--------------------------------------------------------------*/
/* Function for Delete data from table by id
/*--------------------------------------------------------------*/
function delete_by_id($table,$id)
{
  global $db;
  if(tableExists($table))
   {
    $sql = "DELETE FROM ".$db->escape($table);
    $sql .= " WHERE id=". $db->escape($id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
   }
}
/*--------------------------------------------------------------*/
/* Function for Count id  By table name
/*--------------------------------------------------------------*/

function count_by_id($table){
  global $db;
  if(tableExists($table))
  {
    $sql    = "SELECT COUNT(id) AS total FROM ".$db->escape($table);
    $result = $db->query($sql);
     return($db->fetch_assoc($result));
  }
}
/*--------------------------------------------------------------*/
/* Determine if database table exists
/*--------------------------------------------------------------*/
function tableExists($table){
  global $db;
  $table_exit = $db->query('SHOW TABLES FROM '.DB_NAME.' LIKE "'.$db->escape($table).'"');
      if($table_exit) {
        if($db->num_rows($table_exit) > 0)
              return true;
         else
              return false;
      }
  }
 /*--------------------------------------------------------------*/
 /* Login with the data provided in $_POST,
 /* coming from the login form.
/*--------------------------------------------------------------*/
  function authenticate($username='', $password='') {
    global $db;
    $username = $db->escape($username);
    $password = $db->escape($password);
    $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
    $result = $db->query($sql);
    if($db->num_rows($result)){
      $user = $db->fetch_assoc($result);
      $password_request = sha1($password);
      if($password_request === $user['password'] ){
        return $user['id'];
      }
    }
   return false;
  }
  /*--------------------------------------------------------------*/
  /* Login with the data provided in $_POST,
  /* coming from the login_v2.php form.
  /* If you used this method then remove authenticate function.
 /*--------------------------------------------------------------*/
   function authenticate_v2($username='', $password='') {
     global $db;
     $username = $db->escape($username);
     $password = $db->escape($password);
     $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
     $result = $db->query($sql);
     if($db->num_rows($result)){
       $user = $db->fetch_assoc($result);
       $password_request = sha1($password);
       if($password_request === $user['password'] ){
         return $user;
       }
     }
    return false;
   }


  /*--------------------------------------------------------------*/
  /* Find current log in user by session id
  /*--------------------------------------------------------------*/
  function current_user(){
      static $current_user;
      global $db;
      if(!$current_user){
         if(isset($_SESSION['user_id'])):
             $user_id = intval($_SESSION['user_id']);
             $current_user = find_by_id('users',$user_id);
        endif;
      }
    return $current_user;
  }
  /*--------------------------------------------------------------*/
  /* Find all user by
  /* Joining users table and user gropus table
  /*--------------------------------------------------------------*/
  function find_all_user(){
      global $db;
      $results = array();
      $sql = "SELECT u.id,u.name,u.username,u.user_level,u.status,u.last_login,";
      $sql .="g.group_name ";
      $sql .="FROM users u ";
      $sql .="LEFT JOIN user_groups g ";
      $sql .="ON g.group_level=u.user_level ORDER BY u.name ASC";
      $result = find_by_sql($sql);
      return $result;
  }
  /*--------------------------------------------------------------*/
  /* Function to update the last log in of a user
  /*--------------------------------------------------------------*/
 function updateLastLogIn($user_id)
	{
		global $db;
    $date = make_date();
    $sql = "UPDATE users SET last_login='{$date}' WHERE id ='{$user_id}' LIMIT 1";
    $result = $db->query($sql);
    return ($result && $db->affected_rows() === 1 ? true : false);
	}

  /*--------------------------------------------------------------*/
  /* Find all Group name
  /*--------------------------------------------------------------*/
  function find_by_groupName($val)
  {
    global $db;
    $sql = "SELECT group_name FROM user_groups WHERE group_name = '{$db->escape($val)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }
  /*--------------------------------------------------------------*/
  /* Find group level
  /*--------------------------------------------------------------*/
  function find_by_groupLevel($level)
  {
    global $db;
    $sql = "SELECT group_level FROM user_groups WHERE group_level = '{$db->escape($level)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }
  /*--------------------------------------------------------------*/
  /* Function for cheaking which user level has access to page
  /*--------------------------------------------------------------*/
   function page_require_level($require_level){
     global $session;
     $current_user = current_user();
     $login_level = find_by_groupLevel($current_user['user_level']);
     //Si el usuario no inicia sesión
     if (!$session->isUserLoggedIn(true)):
            $session->msg('d','Por favor Iniciar sesión...');
            redirect('index.php', false);
      //si Estado del grupo Desactivado
     elseif($login_level['group_status'] === '0'):
           $session->msg('d','Este nivel de usaurio esta inactivo!');
           redirect('home.php',false);
      //el registro de registro en el nivel de usuario y el nivel requerido es menor o igual que
     elseif($current_user['user_level'] <= (int)$require_level):
              return true;
      else:
            $session->msg("d", "¡Lo siento!  no tienes permiso para ver la página.");
            redirect('home.php', false);
        endif;

     }
   /*--------------------------------------------------------------*/
   /* Función para encontrar todos los nombres de productos
   /* JOIN con la tabla de base de datos de categorías y medios
   /*--------------------------------------------------------------*/
  function join_product_table(){
    global $db;
    $sql  =" SELECT p.codigo,p.name,p.quantity,p.modelo,p.serie,p.media_id,p.movimiento,p.usuario,p.estados,p.date,p.name,c.name,u.name ";
    $sql  .=" AS categorie_id,m.file_name AS image";
    $sql  .=" FROM products p";
    $sql  .=" INNER JOIN ubicaciones u ON p.ubicacion_id = u.id";
    $sql  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
    $sql  .=" LEFT JOIN media m ON m.id = p.media_id";
    $sql  .=" ORDER BY p.id ASC";
    return find_by_sql($sql);
  
  }

  function join_entrada_table(){
    global $db;
    $sql  =" SELECT p.codigo,p.name,p.quantity,p.modelo,p.serie,p.media_id,p.movimiento,p.date,p.name,c.name,u.name ";
    $sql  .=" AS categorie_id,m.file_name AS image";
    $sql  .=" FROM products p";
    $sql  .=" INNER JOIN ubicaciones u ON p.ubicacion_id = u.id";
    $sql  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
    $sql  .=" LEFT JOIN media m ON m.id = p.media_id";
    $sql  .=" ORDER BY p.id ASC";
    return find_by_sql($sql);
  
  }

  /*--------------------------------------------------------------*/
  /* Function for Finding all product name
  /* Request coming from ajax.php for auto suggest
  /*--------------------------------------------------------------*/

   function find_product_by_title($name){
     global $db;
    //  $p_codigo = remove_junk($db->escape($codigo));
    //  $sql = "SELECT codigo FROM products WHERE codigo like '%$codigo%' LIMIT 50";
     $sql = "SELECT codigo,name,categorie_id FROM products WHERE name LIKE '%$name%'";
     $result = find_by_sql($sql);
     return $result;
   }

   function find_kardex_by_title($codigo){
    global $db;
    $p_codigo = remove_junk($db->escape($codigo));
    $sql = "SELECT codigo FROM products WHERE codigo like '%$p_codigo%' LIMIT 50";
    $result = find_by_sql($sql);
    return $result;
  }
  /*--------------------------------------------------------------*/
  /* Function for Finding all product info by product title
  /* Request coming from ajax.php
  /*--------------------------------------------------------------*/
  function find_all_product_info_by_title($codigo){
    global $db;
    $sql  = "SELECT * FROM products ";
    $sql .= " WHERE codigo ='{$codigo}'";
    $sql .=" LIMIT 1";
    return find_by_sql($sql);
  }

  function find_all_product_info_by_title2($title){
    global $db;
    $sql  = "SELECT * FROM products ";
    $sql .= " WHERE codigo ='{$title}'";
    $sql .=" LIMIT 1";
    return find_by_sql($sql);
  }

  function find_all_estados_info_by_title($name){
    global $db;
    $sql  = "SELECT * FROM estados ";
    $sql .= " WHERE name ='{$name}'";
    $sql .=" LIMIT 1";
    return find_by_sql($sql);
  }

  function suma(){
    global $db;
    $sql  = "SELECT SUM( quantity ) + SUM( 10 )";
    $sql  = "FROM products";
    $sql  = "WHERE 'codigo' = '$codigo'";
    $sql  = "ORDER BY 'id' DESC LIMIT 1";
    return find_by_sql($sql);
  }

  // function busqueda($title){
  //   global $db;
  //   $sql  = "SELECT * FROM products ";
  //   $sql .= " WHERE id ='{$title}'";
  //   $sql .=" LIMIT 1";
  //   return find_by_sql($sql);
  // }
  /*--------------------------------------------------------------*/
  /* Function for Update product quantity
  /*--------------------------------------------------------------*/
  function update_product_qty($qty,$p_codigo){
    global $db;
    $qty = (int) $qty;
    $codigo  = (int)$p_codigo;
    $sql = "UPDATE products SET stock=quantity -'{$qty}', quantity=quantity -'{$qty}' WHERE codigo = '{$codigo}'";
    $result = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);
    
  }

  /*--------------------------------------------------------------*/
  /* Function for Display Recent product Added
  /*--------------------------------------------------------------*/
 function find_recent_product_added($limit){
   global $db;
   $sql   = " SELECT p.id,p.name,p.media_id,c.name AS categorie,";
   $sql  .= "m.file_name AS image FROM products p";
   $sql  .= " LEFT JOIN categories c ON c.id = p.categorie_id";
   $sql  .= " LEFT JOIN ubicaciones u ON u.id = p.ubicacion_id";
   $sql  .= " LEFT JOIN media m ON m.id = p.media_id";
   $sql  .= " ORDER BY p.id DESC LIMIT ".$db->escape((int)$limit);
   return find_by_sql($sql);

 }

 /*--------------------------------------------------------------*/
 /* Function for Find Highest saleing Product
 /*--------------------------------------------------------------*/
 function find_higest_saleing_product($limit){
   global $db;
   $sql  = "SELECT p.name, COUNT(s.codigo) AS totalSold, SUM(s.qty) AS totalQty";
   $sql .= " FROM sales s";
   $sql .= " LEFT JOIN products p ON p.codigo = s.codigo ";
   $sql .= " GROUP BY s.id";
   $sql .= " ORDER BY SUM(s.qty) DESC LIMIT ".$db->escape((int)$limit);
   return $db->query($sql);
 }

 /*--------------------------------------------------------------*/
 /* Function for find all sales
 /*--------------------------------------------------------------*/
 function find_all_sale(){
  global $db;
  $sql  = "SELECT s.codigo,s.qty,s.date,s.tecnico,s.ticket,s.departamento,s.colaborador,s.serie,s.modelo,s.movimiento,a.nombrearchivo,s.estados,p.name";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.codigo = p.codigo";
  $sql  .=" LEFT JOIN actas a ON a.ticket = s.ticket";
  $sql .= " ORDER BY s.date DESC";
  return find_by_sql($sql);
}

///////////////////////////////////////////////////////////////////////////////////////////
function stockreal($qty,$p_codigo){
  global $db;
  // $codigo  = (int)$p_codigo;
  $sql  = "SELECT MAX(p.quantity) - '{$qty}' AS cant_real FROM products p LEFT JOIN sales s ON s.codigo = p.codigo WHERE s.codigo = '{$p_codigo}' ORDER BY s.codigo ASC";
  return find_by_sql($sql);

}

// function update_sales_qty($cant_sal,$p_codigo){
//   global $db;
//   $cant_sal = (int) $qty;
//   $codigo  = (int)$p_codigo;
//   $sql = "UPDATE sales SET estado=stock - '{$cant_sal}' WHERE codigo = '{$codigo}'";
//   $result = $db->query($sql);
//   return($db->affected_rows() === 1 ? true : false);
  
// }
///////////////////////////////////////////////////////////////////////////////////////////
 /*--------------------------------------------------------------*/
 /* Function for Display Recent sale
 /*--------------------------------------------------------------*/
function find_recent_sale_added($limit){
  global $db;
  $sql  = "SELECT s.codigo,s.qty,s.date,p.name";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.codigo = p.codigo";
  $sql .= " ORDER BY s.date DESC LIMIT ".$db->escape((int)$limit);
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Función para generar informe de ventas por dos fechas
/*--------------------------------------------------------------*/
function find_sale_by_dates($start_date,$end_date){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));

  $sql  = "SELECT s.date, s.ticket, p.name, s.modelo, s.serie, s.qty, s.tecnico, s.departamento, s.colaborador,";
  // $sql .= "SUM(s.modelo * s.qty) AS modelo, ";
  // $sql .= "SUM(s.serie * s.qty) AS serie, ";
  // $sql .= "SUM(s.qty) AS total_sales,";
  // $sql .= "COUNT(s.tecnico) AS total_records,";
  // $sql .= "COUNT(s.departamento) AS total_records,";
  // $sql .= "SUM(p.name * s.qty) AS total_saleing_price,";
  $sql .= "COUNT(s.colaborador) AS total_records ";
  $sql .= "FROM sales s ";
  $sql .= "LEFT JOIN products p ON s.codigo = p.codigo";
  $sql .= " WHERE s.date BETWEEN '{$start_date}' AND '{$end_date}'";
  $sql .= " GROUP BY DATE(s.date),s.ticket,p.name,s.modelo,s.serie,s.qty,s.tecnico,s.departamento,s.colaborador";
  $sql .= " ORDER BY DATE(s.date) DESC";
  return $db->query($sql);
}

function find_entrar_by_dates($start_date,$end_date){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT p.codigo, p.factura, p.name, p.entrada, p.categorie_id, p.modelo, p.serie, p.date,";
  $sql .= "COUNT(s.colaborador) AS total_records ";
  $sql .= "FROM products p ";
  $sql .= "LEFT JOIN sales s ON p.codigo = s.codigo";
  $sql .= " WHERE p.date BETWEEN '{$start_date}' AND '{$end_date}'";
  $sql .= " GROUP BY DATE(s.date),p.codigo, p.factura, p.name, p.entrada, p.categorie_id, p.modelo, p.serie, p.date";
  $sql .= " ORDER BY DATE(s.date) DESC";
  return $db->query($sql);
  }

/*--------------------------------------------------------------*/
/* Función para generar informe de ventas diarias
/*--------------------------------------------------------------*/
function  dailySales($year,$month){
  global $db;
  $sql  = "SELECT s.date, s.ticket, p.name, s.modelo, s.serie, s.qty, s.tecnico, s.departamento, s.colaborador,";
  $sql .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.name,";
  // $sql .= "SUM(s.modelo * s.qty) AS modelo, ";
  // $sql .= "SUM(s.serie * s.qty) AS serie, ";
  // $sql .= "SUM(s.qty) AS total_sales,";
  // $sql .= "COUNT(s.tecnico) AS total_records,";
  // $sql .= "COUNT(s.departamento) AS total_records,";
  // $sql .= "SUM(p.name * s.qty) AS total_saleing_price,";
  $sql .= "COUNT(s.colaborador) AS total_records ";
  $sql .= "FROM sales s ";
  $sql .= "LEFT JOIN products p ON s.codigo = p.codigo";
  $sql .= " WHERE DATE_FORMAT(s.date, '%Y-%m' ) = '{$year}-{$month}'";
  $sql .= " GROUP BY DATE(s.date),s.ticket,p.name,s.modelo,s.serie,s.qty,s.tecnico,s.departamento,s.colaborador";
  $sql .= " ORDER BY DATE(s.date) DESC";
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Función para generar informe de ventas mensual
/*--------------------------------------------------------------*/
function  monthlySales($year){
  global $db;
  $sql  = "SELECT s.date, s.ticket, p.name, s.modelo, s.serie, s.qty, s.tecnico, s.departamento, s.colaborador,";
  $sql .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.name,";
  // $sql .= "SUM(s.modelo * s.qty) AS modelo, ";
  // $sql .= "SUM(s.serie * s.qty) AS serie, ";
  $sql .= "SUM(s.qty) AS total_sales,";
  $sql .= "COUNT(s.tecnico) AS total_records,";
  $sql .= "COUNT(s.departamento) AS total_records,";
  $sql .= "SUM(p.name * s.qty) AS total_saleing_price,";
  $sql .= "COUNT(s.colaborador) AS total_records ";
  $sql .= "FROM sales s ";
  $sql .= "LEFT JOIN products p ON s.codigo = p.codigo";
  $sql .= " WHERE DATE_FORMAT(s.date, '%Y' ) = '{$year}'";
  $sql .= " GROUP BY DATE(s.date),s.ticket,p.name,s.modelo,s.serie,s.qty,s.tecnico,s.departamento,s.colaborador";
  $sql .= " ORDER BY DATE(s.date) DESC";
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Función para generar informe de Kardex
/*--------------------------------------------------------------*/
// function kardex(){
//   global $db;
//   $results = array();
//   $sql  = "SELECT K.codigo, K.date, P.name, K.movimiento, k.estados, k.ubicacion, K.entrada, K.salida, K.stock ";
//   $sql .="FROM kardex k ";
//   $sql .="INNER JOIN products p ON p.codigo = k.codigo ";
//   $sql .=" ORDER BY k.date, k.codigo, name DESC";

//   $result = find_by_sql($sql);
//   return $result;
// }

function agregar(){
  global $db;
  $results = array();
  $sql = "SELECT p.codigo FROM products P WHERE 1 GROUP BY codigo ";
  $result = find_by_sql($sql);
  return $result;
}

/*--------------------------------------------------------------*/
/* Función para busqueda en Kardex
/*--------------------------------------------------------------*/
function search(){
  global $db;
  $results = array();
  $sql = "SELECT codigo FROM products WHERE codigo LIKE '%$codigo%' ";
  $sql .="UNION ";
  $sql .="SELECT codigo FROM sales WHERE codigo LIKE '%$codigo%' ";

  $result = find_by_sql($sql);
  return $result;
}

function search2(){
  global $db;
  $results = array();
  $sql = "SELECT codigo FROM products WHERE name LIKE '%$name%' ";

  $result = find_by_sql($sql);
  return $result;
}

function cantidad($p_name){
  global $db;
  $results = array();
  $sql = "SELECT * FROM products WHERE name = '{$p_name}' AND estado = 1 ORDER BY id DESC";
  $result = find_by_sql($sql);
  return $result;
}
?>



