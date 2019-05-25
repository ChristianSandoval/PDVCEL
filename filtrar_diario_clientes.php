<?php
include('db.php');
if (isset($_POST['filtrar'])) {
  $codigo = $_POST['codigo'];
  $nombre = $_POST['nombre'];
  $sucursales = $_POST['sucursales'];
  
  $fechaInicial = $_POST['fechaInicial'];
  $fechaFinal = $_POST['fechaFinal'];

  $query = "SELECT DATE_FORMAT(DATE_SUB(RECEIPTS.DATENEW, INTERVAL 5 HOUR),'%d/%m %H:%i') AS FECHA, CASE WHEN PAYMENTS.PAYMENT='debt' THEN 'DEUDA' WHEN PAYMENTS.PAYMENT='debtpaid' THEN 'PAGO' END AS TIPO, CONCAT('$',FORMAT(PAYMENTS.TOTAL,2)) as TOTAL, CUSTOMERS.SEARCHKEY AS TELEFONO, CUSTOMERS.NAME AS NOMBRE "
  ."FROM RECEIPTS, TICKETS, CUSTOMERS, PAYMENTS WHERE RECEIPTS.ID = TICKETS.ID AND RECEIPTS.ID = PAYMENTS.RECEIPT " 
  ."AND TICKETS.CUSTOMER = CUSTOMERS.ID AND (PAYMENTS.PAYMENT = 'debt' OR PAYMENTS.PAYMENT = 'debtpaid') ";
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
	  $query .= " AND CUSTOMERS.CARD = '".$sucursales."'";
  }
  if($fechaInicial!='')
  {
    $query .= " AND DATE_SUB(RECEIPTS.DATENEW, INTERVAL 5 HOUR) >= '".$fechaInicial."' ";
    if($fechaFinal!='')
    $query .= " AND DATE_SUB(RECEIPTS.DATENEW, INTERVAL 5 HOUR) <= '".$fechaFinal." 23:59:59'";;
  }
  $query .= " ORDER BY CUSTOMERS.NAME";
  $_SESSION['query'] = $query;
  $_SESSION['codigo'] = $codigo;
  $_SESSION['nombre'] = $nombre;
  $_SESSION['sucursales'] = $sucursales;
  
  $_SESSION['fechaInicial'] = $fechaInicial;
  $_SESSION['fechaFinal'] = $fechaFinal;
  //echo $query;
  header('Location: diario_clientes.php');
}
?>