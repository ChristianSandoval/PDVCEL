<?php

include('db.php');

if (isset($_POST['filtrar'])) {

  $codigo = $_POST['codigo'];

  $nombre = $_POST['nombre'];

  $categorias = $_POST['categorias'];

  $query = "SELECT PRODUCTS.CODE, PRODUCTS.NAME AS NOMBRE, CONCAT('$',FORMAT(PRODUCTS.PRICEBUY,2)) AS COSTO, CONCAT('$',FORMAT(PRODUCTS.PRICESELL,2)) AS MENUDEO, CONCAT('$',FORMAT(PRODUCTS.PRICESELL1,2)) AS MAYOREO FROM PRODUCTS WHERE PRODUCTS.CODE<>'' and 1=1";

  

  if($codigo!='')

  {

	    $query .= " AND PRODUCTS.CODE LIKE '%".$codigo."%'";

  }

  if($nombre!='')

  {

	    $query .= " AND PRODUCTS.NAME LIKE '%".$nombre."%'";

  }

  if ($categorias!='0')

  {

	  $query .= " AND PRODUCTS.CATEGORY='".$categorias."'";

  }

  $query .= " ORDER BY PRODUCTS.NAME";

  $_SESSION['query'] = $query;

  $_SESSION['codigo'] = $codigo;

  $_SESSION['nombre'] = $nombre;

  $_SESSION['categorias'] = $categorias;

  header('Location: productos.php');

}

?>