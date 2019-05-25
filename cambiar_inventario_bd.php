<?php
include('db.php');
if (isset($_POST['filtrar'])) {
  $codigo = $_POST['codigo'];
  $cantidad = $_POST['cantidad'];
  $tipo = $_POST['tipo'];
  $costo = str_replace(',','',str_replace('$','',$_POST['costo']));
  $sucursalid = $_POST['sucursalid'];
  $query = "";

  if(strpos($tipo,"-")==false) $query = "UPDATE STOCKCURRENT SET UNITS=UNITS + ".$cantidad." WHERE LOCATION='".$sucursalid."' AND PRODUCT=(SELECT ID FROM PRODUCTS WHERE REFERENCE='".$codigo."')";
  else $query = "UPDATE STOCKCURRENT SET UNITS=UNITS - ".$cantidad." WHERE LOCATION='".$sucursalid."' AND PRODUCT=(SELECT ID FROM PRODUCTS WHERE REFERENCE='".$codigo."')";
  mysqli_query($conn, $query);
  
  $query = "INSERT INTO STOCKDIARY (ID, DATENEW, REASON, LOCATION, PRODUCT, UNITS, PRICE) SELECT UUID(),NOW(),".$tipo.",'".$sucursalid."',ID,".$cantidad.",".$costo." FROM PRODUCTS WHERE REFERENCE='".$codigo."'";
  mysqli_query($conn, $query);
  header('Location: inventario_actual.php');
}
?>