<?php
include('db.php');
if (isset($_POST['filtrar'])) {
  $codigo = $_POST['codigo'];
  $nombre = $_POST['nombre'];
  $costo = str_replace(',','',str_replace('$','',$_POST['costo']));
  $menudeo = str_replace(',','',str_replace('$','',$_POST['menudeo']));
  $mayoreo = str_replace(',','',str_replace('$','',$_POST['mayoreo']));
  $categoria = $_POST['categorias'];
  $query = "UPDATE PRODUCTS SET NAME='".$nombre."', PRICEBUY='".$costo."', PRICESELL='".$menudeo."', PRICESELL1='".$mayoreo."', CATEGORY='".$categoria."' WHERE CODE='".$codigo."'";
  mysqli_query($conn, $query);
  header('Location: productos.php');
}
?>