<?php
include('db.php');
if (isset($_POST['filtrar'])) {
  $codigo = $_POST['codigo'];
  $nombre = $_POST['nombre'];
  $codigoCliente = $_POST['codigoCliente'];
  $nombreCliente = $_POST['nombreCliente'];
  $sucursales = $_POST['sucursales'];
  $categorias = $_POST['categorias'];
  
  $fechaInicial = $_POST['fechaInicial'];
  $fechaFinal = $_POST['fechaFinal'];

  $query = "SELECT TICKETS.TICKETID AS ID,CASE WHEN TICKETS.TICKETTYPE='0' THEN 'VTA' WHEN TICKETS.TICKETTYPE='1' THEN 'DEV' ELSE '' END AS TIPO, "
  ."DATE_FORMAT(DATE_SUB(RECEIPTS.DATENEW, INTERVAL 5 HOUR),'%d/%m %H:%i') AS FECHA,PRODUCTS.CODE AS CODIGO, PRODUCTS.NAME AS PRODUCTO, "
  ."IFNULL(CUSTOMERS.SEARCHKEY,'') AS CLIENTEID, IFNULL(CUSTOMERS.NAME,'') AS CLIENTE,"
  ."CONCAT('$',FORMAT(TICKETLINES.PRICE, 2)) AS PRECIO, "
  ."TICKETLINES.UNITS AS CANTIDAD, CONCAT('$',FORMAT(TICKETLINES.UNITS*TICKETLINES.PRICE,2)) AS IMPORTE, "
  ."LOCATIONS.NAME AS SUCURSAL, PEOPLE.NAME AS USUARIO "
  ."FROM TICKETLINES INNER JOIN TICKETS ON TICKETLINES.TICKET=TICKETS.ID INNER JOIN RECEIPTS ON RECEIPTS.ID=TICKETS.ID INNER JOIN PRODUCTS ON PRODUCTS.ID=TICKETLINES.PRODUCT INNER JOIN LOCATIONS ON LOCATIONS.ID=TICKETS.STATUS LEFT JOIN CUSTOMERS ON CUSTOMERS.ID=TICKETS.CUSTOMER INNER JOIN PEOPLE ON TICKETS.PERSON=PEOPLE.ID "
  ."WHERE 1=1 ";
  if($codigo!='')
  {
	    $query .= " AND PRODUCTS.CODE = '".$codigo."'";
  }
  if($nombre!='')
  {
	    $query .= " AND PRODUCTS.NAME LIKE '%".$nombre."%'";
  }
  if($codigoCliente!='')
  {
	    $query .= " AND CUSTOMERS.SEARCHKEY = '".$codigoCliente."'";
  }
  if($nombreCliente!='')
  {
	    $query .= " AND CUSTOMERS.NAME LIKE '%".$nombreCliente."%'";
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
  $query .= " ORDER BY RECEIPTS.DATENEW";
  $_SESSION['query'] = $query;
  $_SESSION['codigo'] = $codigo;
  $_SESSION['nombre'] = $nombre;
  $_SESSION['codigoCliente'] = $codigoCliente;
  $_SESSION['nombreCliente'] = $nombreCliente;
  $_SESSION['sucursales'] = $sucursales;
  $_SESSION['categorias'] = $categorias;
  $_SESSION['fechaInicial'] = $fechaInicial;
  $_SESSION['fechaFinal'] = $fechaFinal;
  header('Location: ventasdetalle.php');
}
?>