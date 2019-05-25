<?php
include('db.php');
if (isset($_POST['filtrar'])) {
  $codigo = $_POST['codigo'];
  $nombre = $_POST['nombre'];
  $sucursales = $_POST['sucursales'];
  $categorias = $_POST['categorias'];
  $query = "SELECT PRODUCTS.CODE, PRODUCTS.NAME AS NOMBRE, STOCKLEVEL.STOCKSECURITY AS MINIMO, STOCKLEVEL.STOCKMAXIMUM AS MAXIMO, STOCKCURRENT.UNITS AS ACTUALES, LOCATIONS.NAME AS SUCURSAL "
  ." FROM PRODUCTS INNER JOIN STOCKCURRENT ON PRODUCTS.ID = STOCKCURRENT.PRODUCT INNER JOIN STOCKLEVEL ON STOCKLEVEL.PRODUCT=PRODUCTS.ID INNER JOIN LOCATIONS ON LOCATIONS.ID=STOCKCURRENT.LOCATION AND LOCATIONS.ID=STOCKLEVEL.LOCATION"
  ." WHERE STOCKCURRENT.UNITS<STOCKLEVEL.STOCKSECURITY AND 1=1";
  
  if($codigo!='')
  {
	    $query .= " AND PRODUCTS.CODE = '".$codigo."'";
  }
  if($nombre!='')
  {
	    $query .= " AND PRODUCTS.NAME LIKE '%".$nombre."%'";
  }
  if ($categorias!='0')
  {
	  $query .= " AND PRODUCTS.CATEGORY='".$categorias."'";
  }  
  if($sucursales!='-1')
  {
	  $query .= " AND LOCATIONS.ID = '".$sucursales."'";
  }
  $query .= " ORDER BY PRODUCTS.NAME";
  $_SESSION['query'] = $query;
  $_SESSION['codigo'] = $codigo;
  $_SESSION['nombre'] = $nombre;
  $_SESSION['sucursales'] = $sucursales;
  $_SESSION['categorias'] = $categorias;
  header('Location: inventario_min.php');
}
?>