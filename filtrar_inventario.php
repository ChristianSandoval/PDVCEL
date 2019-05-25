<?php
include('db.php');
if (isset($_POST['filtrar'])) {
  $codigo = $_POST['codigo'];
  $nombre = $_POST['nombre'];
  $sucursales = $_POST['sucursales'];
  $categorias = $_POST['categorias'];
  $query = "SELECT CATEGORIES.NAME AS NAME,PRODUCTS.CODE, PRODUCTS.NAME AS NOMBRE, STOCKCURRENT.UNITS AS UNIDADES, PRODUCTS.PRICEBUY AS PRICEBUY, LOCATIONS.NAME AS SUCURSAL FROM PRODUCTS INNER JOIN CATEGORIES ON PRODUCTS.CATEGORY = CATEGORIES.ID INNER JOIN STOCKCURRENT ON STOCKCURRENT.PRODUCT=PRODUCTS.ID INNER JOIN LOCATIONS ON LOCATIONS.ID=STOCKCURRENT.LOCATION "
  ." WHERE 1=1";
  
  if($codigo!='')
  {
	    $query .= " AND PRODUCTS.CODE = '".$codigo."'";
  }
  if($nombre!='')
  {
	    $query .= " AND PRODUCTS.NAME LIKE '%".$nombre."%'";
  }
  if($sucursales!='-1')
  {
	  $query .= " AND LOCATIONS.ID = '".$sucursales."'";
  }
  if ($categorias!='0')
  {
	  $query .= " AND PRODUCTS.CATEGORY='".$categorias."'";
  }
  $query .= " ORDER BY PRODUCTS.NAME";
  $_SESSION['query'] = $query;
  $_SESSION['codigo'] = $codigo;
  $_SESSION['nombre'] = $nombre;
  $_SESSION['sucursales'] = $sucursales;
  $_SESSION['categorias'] = $categorias;
  header('Location: inventario_actual.php');
}
?>