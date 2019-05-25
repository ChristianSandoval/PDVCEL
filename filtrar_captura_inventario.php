<?php
include('db.php');
if (isset($_POST['filtrar'])) {
  $codigo = $_POST['codigo'];
  $nombre = $_POST['nombre'];
  $fechaInicial = $_POST['fechaInicial'];
  $fechaFinal = $_POST['fechaFinal'];
  $sucursales = $_POST['sucursales'];
  $categorias = $_POST['categorias'];
  $tipo = $_POST['tipo'];
  $query = "SELECT PRODUCTS.CODE AS CODE,PRODUCTS.NAME AS NAME, STOCKDIARY.UNITS AS UNIDADES, "
  ." CASE WHEN REASON='1' THEN '+compra' WHEN REASON='2' THEN '+devolucion' WHEN REASON='3' THEN '+traspaso' WHEN REASON='4' THEN '+traspaso'"
  ." WHEN REASON='-1' THEN '-venta' WHEN REASON='-2' THEN '-devolucion' WHEN REASON='-3' THEN '-salida' WHEN REASON='-4' THEN '-traspaso' ELSE ''"
  ." END AS REASON, DATE_FORMAT(DATE_SUB(STOCKDIARY.DATENEW,INTERVAL 5 HOUR),'%d/%m %H:%i') AS FECHA, LOCATIONS.NAME AS SUCURSAL FROM"
  ." PRODUCTS INNER JOIN STOCKDIARY ON STOCKDIARY.PRODUCT = PRODUCTS.ID INNER JOIN LOCATIONS ON LOCATIONS.ID=STOCKDIARY.LOCATION WHERE 1=1"; 
  
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
  if ($tipo!='0')
  {
    if($tipo=='1')
      $query .= " AND STOCKDIARY.REASON >= 1";
    if($tipo=='2')
	    $query .= " AND STOCKDIARY.REASON < 0";
  }
  if($fechaInicial!='')
  {
    $query .= " AND STOCKDIARY.DATENEW >= '".$fechaInicial."' ";
    if($fechaFinal!='')
    $query .= " AND STOCKDIARY.DATENEW <= '".$fechaFinal." 23:59:59'";;
  }
  $query .= " ORDER BY STOCKDIARY.DATENEW";
  $_SESSION['query'] = $query;
  $_SESSION['codigo'] = $codigo;
  $_SESSION['nombre'] = $nombre;
  $_SESSION['sucursales'] = $sucursales;
  $_SESSION['tipo'] = $tipo;
  $_SESSION['categorias'] = $categorias;
  $_SESSION['fechaInicial'] = $fechaInicial;
  $_SESSION['fechaFinal'] = $fechaFinal;
  header('Location: captura_inventario.php');
}
?>