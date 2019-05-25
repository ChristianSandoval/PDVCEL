<?php
include('header.php');
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
	$qry = "SELECT PRODUCTS.CODE,CONCAT('$',FORMAT(PRODUCTS.PRICEBUY,2)) AS COSTO, PRODUCTS.NAME AS NOMBRE, STOCKCURRENT.UNITS AS UNIDADES, LOCATIONS.NAME AS SUCURSAL, LOCATIONS.ID AS SUCURSALID FROM PRODUCTS INNER JOIN STOCKCURRENT ON STOCKCURRENT.PRODUCT=PRODUCTS.ID INNER JOIN LOCATIONS ON LOCATIONS.ID=STOCKCURRENT.LOCATION WHERE LOCATIONS.NAME='".$_GET["suc"]."' AND PRODUCTS.CODE='".$_GET["id"]."'";
	
	$result_tasks = mysqli_query($conn, $qry);    
  while($row = mysqli_fetch_assoc($result_tasks)) {
		$codigo = $row['CODE'];
		$costo = $row['COSTO'];
		$producto = $row['NOMBRE'];
		$unidadesActuales = $row['UNIDADES'];
		$sucursal = $row['SUCURSAL'];
		$sucursalid = $row['SUCURSALID'];
	}
}
?>
<form action="cambiar_inventario_bd.php" method="POST">
	<div class="row">
		<div class="col-md-3">
          <div class="form-group">
					<label>Código</label>
					<input type="text" name="codigo" class="form-control w3-input" <?php echo "value='".$codigo."'"; ?>>
					<input type="text" name="sucursalid" class="form-control w3-input" <?php echo "value='".$sucursalid."'"; ?>>
            <input type="text" disabled class="form-control" <?php echo "value='".$codigo."'"; ?>>
          </div>
		</div>
		<div class="col-md-3">
          <div class="form-group">
					<label>Nombre</label>
            <input type="text" disabled class="form-control" <?php echo "value='".$producto."'"; ?>>
          </div>
		</div>
		<div class="col-md-3">
          <div class="form-group">
					<label>Sucursal</label>
            <input type="text" disabled class="form-control" <?php echo "value='".$sucursal."'"; ?>>
          </div>
		</div>
		<div class="col-md-3">
          <div class="form-group">
					<label>Existencia</label>
            <input type="text" disabled class="form-control" <?php echo "value='".$unidadesActuales."'"; ?>>
          </div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
          <div class="form-group">
					<label>Costo</label>
            <input type="text" name="costo" class="form-control" <?php echo "value='".$costo."'"; ?>>
          </div>
		</div>
		<div class="col-md-3">
          <div class="form-group">
					<label>Cantidad</label>
            <input type="number" name="cantidad" class="form-control">
          </div>
		</div>
		<div class="col-md-3">
		  <div class="form-group">
			<label>Razón</label>
		  <select name="tipo" class="form-control">
		     <option value="1">Entrada (compra)</option>
				 <option value="2">Entrada (devolución)</option>
				 <option value="-2">Salida (devolución)</option>
				 <option value="-3">Salida (rotura)</option>
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