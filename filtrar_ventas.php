<?php
include('db.php');
if (isset($_POST['filtrar'])) {
  $codigo = $_POST['codigo'];
  $nombre = $_POST['nombre'];
  $sucursales = $_POST['sucursales'];
  $categorias = $_POST['categorias'];
  
  $fechaInicial = $_POST['fechaInicial'];
  $fechaFinal = $_POST['fechaFinal'];
  $query = "SELECT PRODUCTS.CODE AS CODIGO, PRODUCTS.NAME AS PRODUCTO, "
  ."SUM(TICKETLINES.PRICE) AS PRECIO, SUM(TICKETLINES.UNITS) AS CANTIDAD, CONCAT('$',FORMAT(SUM(TICKETLINES.UNITS*TICKETLINES.PRICE), 2)) AS IMPORTE, "
  ."LOCATIONS.NAME AS SUCURSAL FROM TICKETLINES INNER JOIN TICKETS ON TICKETLINES.TICKET=TICKETS.ID INNER JOIN RECEIPTS ON RECEIPTS.ID=TICKETS.ID INNER JOIN PRODUCTS ON PRODUCTS.ID=TICKETLINES.PRODUCT INNER JOIN LOCATIONS ON LOCATIONS.ID=TICKETS.STATUS "
  ."WHERE 1=1";
  
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
  if($fechaInicial!='')
  {
    $query .= " AND DATE_SUB(RECEIPTS.DATENEW, INTERVAL 5 HOUR) >= '".$fechaInicial."' ";
    if($fechaFinal!='')
    $query .= " AND DATE_SUB(RECEIPTS.DATENEW, INTERVAL 5 HOUR) <= '".$fechaFinal." 23:59:59'";;
  }
  $query .= " GROUP BY PRODUCTS.CODE, PRODUCTS.NAME,LOCATIONS.NAME ORDER BY PRODUCTS.CODE, LOCATIONS.ID";
  $_SESSION['query'] = $query;
  $_SESSION['codigo'] = $codigo;
  $_SESSION['nombre'] = $nombre;
  $_SESSION['sucursales'] = $sucursales;
  $_SESSION['categorias'] = $categorias;
  
  $_SESSION['fechaInicial'] = $fechaInicial;
  $_SESSION['fechaFinal'] = $fechaFinal;
  header('Location: ventas.php');
}
?>