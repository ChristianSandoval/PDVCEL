<?php
include('db.php');
if (isset($_POST['filtrar'])) {
  $codigo = $_POST['codigo'];
  $fechaInicial = $_POST['fechaInicial'];
  $fechaFinal = $_POST['fechaFinal'];
  $sucursales = $_POST['sucursales'];
  $query = "SELECT LOCATIONS.NAME AS SUCURSAL, " .
  "CLOSEDCASH.HOSTSEQUENCE, " .
  "DATE_FORMAT(DATE_SUB(CLOSEDCASH.DATESTART, INTERVAL 5 HOUR),'%d/%m %H:%i') AS DATESTART, " .
  "IFNULL(DATE_FORMAT(DATE_SUB(CLOSEDCASH.DATEEND, INTERVAL 5 HOUR),'%d/%m %H:%i'),'') AS DATEEND, " .
  "CASE WHEN PAYMENTS.PAYMENT='cash' THEN 'EFECTIVO' WHEN PAYMENTS.PAYMENT='magcard' THEN 'TARJETA' " .
  " WHEN PAYMENTS.PAYMENT='cheque' THEN 'DEPOSITO' WHEN PAYMENTS.PAYMENT='debt' THEN 'CREDITO' " .
  " WHEN PAYMENTS.PAYMENT='debtpaid' THEN 'PAGOCREDITO' WHEN PAYMENTS.PAYMENT='cashin' THEN '(ENTRADA)EFE' " .
  " WHEN PAYMENTS.PAYMENT='cashout' THEN '(SALIDA)EFE' ".
  " WHEN PAYMENTS.PAYMENT='cashrefund' THEN 'DEVOLUCION' ".
  " ELSE '' END AS PAYMENT, " .
  "CONCAT('$',FORMAT(SUM(PAYMENTS.TOTAL),2)) AS TOTAL " .
  "FROM CLOSEDCASH, PAYMENTS, RECEIPTS, LOCATIONS " .
  "WHERE CLOSEDCASH.MONEY = RECEIPTS.MONEY AND PAYMENTS.RECEIPT = RECEIPTS.ID AND LOCATIONS.ID=CLOSEDCASH.ACTIVECASH ";
  if($codigo!='')
  {
	    $query .= " AND CLOSEDCASH.HOSTSEQUENCE = '".$codigo."'";
  }
  if($sucursales!='-1')
  {
	  $query .= " AND LOCATIONS.ID = '".$sucursales."'";
  }
  if($fechaInicial!='')
  {
    $query .= " AND DATE_SUB(RECEIPTS.DATENEW, INTERVAL 5 HOUR) >= '".$fechaInicial."' ";
    if($fechaFinal!='')
    $query .= " AND DATE_SUB(RECEIPTS.DATENEW, INTERVAL 5 HOUR) <= '".$fechaFinal." 23:59:59'";;
  }
  $query .= " GROUP BY CLOSEDCASH.HOST, CLOSEDCASH.HOSTSEQUENCE, CLOSEDCASH.MONEY, CLOSEDCASH.DATESTART, CLOSEDCASH.DATEEND, PAYMENTS.PAYMENT ";
  $query .= " ORDER BY CLOSEDCASH.HOST, CLOSEDCASH.HOSTSEQUENCE";
  
  $_SESSION['query'] = $query;
  $_SESSION['codigo'] = $codigo;
  $_SESSION['sucursales'] = $sucursales;
  $_SESSION['fechaInicial'] = $fechaInicial;
  $_SESSION['fechaFinal'] = $fechaFinal;
  //echo $query;
  header('Location: cortes_caja.php');
}
?>