<?php
include('header.php');
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
	$qry = "SELECT PRODUCTS.CODE as CODIGO,PRODUCTS.CATEGORY as CATEGORIA, PRODUCTS.NAME AS PRODUCTO, CONCAT('$',FORMAT(PRODUCTS.PRICEBUY,2)) AS COSTO, CONCAT('$',FORMAT(PRODUCTS.PRICESELL,2)) AS MENUDEO, CONCAT('$',FORMAT(PRODUCTS.PRICESELL1,2)) AS MAYOREO FROM PRODUCTS WHERE PRODUCTS.CODE='".$_GET["id"]."'";
	$result_tasks = mysqli_query($conn, $qry);    
  while($row = mysqli_fetch_assoc($result_tasks)) {
		$codigo = $row['CODIGO'];
		$producto = $row['PRODUCTO'];
		$costo = $row['COSTO'];
		$menudeo = $row['MENUDEO'];
		$mayoreo = $row['MAYOREO'];
		$categoria = $row['CATEGORIA'];
	}
}
?>
<form action="cambiar_producto_bd.php" method="POST">
	<div class="row">
		<div class="col-md-3">
          <div class="form-group">
					<label>Código</label>
					<input type="text" name="codigo" class="form-control w3-input" <?php echo "value='".$codigo."'"; ?>>
            <input type="text" disabled class="form-control" <?php echo "value='".$codigo."'"; ?>>
          </div>
		</div>
		<div class="col-md-3">
          <div class="form-group">
					<label>Nombre</label>
            <input type="text" name="nombre" class="form-control" <?php echo "value='".$producto."'"; ?>>
          </div>
		</div>
		<div class="col-md-3">
          <div class="form-group">
					<label>Costo</label>
            <input type="text" name="costo" class="form-control" <?php echo "value='".$costo."'"; ?>>
          </div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
          <div class="form-group">
					<label>Menudeo</label>
            <input type="text" name="menudeo" class="form-control" <?php echo "value='".$menudeo."'"; ?>>
          </div>
		</div>
		<div class="col-md-3">
          <div class="form-group">
					<label>Mayoreo</label>
            <input type="text" name="mayoreo" class="form-control" <?php echo "value='".$mayoreo."'"; ?>>
          </div>
		</div>
		<div class="col-md-3">
		  <div class="form-group">
			<label>Categoria</label>
		  <select name="categorias" class="form-control">
		  <?php $q2 = "SELECT ID, NAME FROM CATEGORIES ORDER BY NAME";
        $result_tasks = mysqli_query($conn, $q2);    
          while($row = mysqli_fetch_assoc($result_tasks)) { 
		     echo '<option value="'.$row['ID'].'"';
			 if($categoria==$row['ID']) echo ' selected';
			 echo '>'.$row['NAME'].'</option>';
		  }
		  ?>
			</select>
          </div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2">
			<div class="form-group">
				<input type="submit" name="filtrar" class="btn btn-secondary" value="Actualizar">
			</div>
		  </div>
		</div>
	</div>  
	</div>  
</form>
<?php
include('footer.php');?>