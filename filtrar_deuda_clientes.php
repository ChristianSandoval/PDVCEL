<?php
include('db.php');
if (isset($_POST['filtrar'])) {
  $codigo = $_POST['codigo'];
  $nombre = $_POST['nombre'];
  $sucursales = $_POST['sucursales'];
  $query = "SELECT CUSTOMERS.SEARCHKEY AS TELEFONO,CUSTOMERS.NAME AS NOMBRE, "
  ."CONCAT('$',FORMAT(CUSTOMERS.MAXDEBT,2)) AS TOPEDEUDA, CONCAT('$',FORMAT(IFNULL(CUSTOMERS.CURDEBT,0),2)) AS DEUDAACTUAL, "
  ."LOCATIONS.NAME AS SUCURSAL FROM CUSTOMERS INNER JOIN LOCATIONS ON LOCATIONS.ID=CUSTOMERS.CARD"
  ." WHERE 1=1 ";
  
  if($codigo!='')
  {
	    $query .= " AND CUSTOMERS.SEARCHKEY = '".$codigo."'";
  }
  if($nombre!='')
  {
	    $query .= " AND CUSTOMERS.NAME LIKE '%".$nombre."%'";
  }
  if($sucursales!='-1')
  {
	  $query .= " AND LOCATIONS.ID = '".$sucursales."'";
  }
  $query .= " ORDER BY CUSTOMERS.CURDEBT DESC";
  $_SESSION['query'] = $query;
  $_SESSION['codigo'] = $codigo;
  $_SESSION['nombre'] = $nombre;
  $_SESSION['sucursales'] = $sucursales;
  //echo $query;
  header('Location: deuda_clientes.php');
}
?>