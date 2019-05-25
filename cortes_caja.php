<?php
include('header.php');?>
<form action="filtrar_cortes_caja.php" method="POST">
	<div class="row">
		<div class="col-md-2">
          <div class="form-group">
            <input type="text" name="codigo" class="form-control" placeholder="#Corte" autofocus
			<?php if (isset($_SESSION['codigo'])) { echo "value='".$_SESSION['codigo']."'"; } ?>
			>
          </div>
		</div>
		
		<div class="col-md-2">
    <input id="fechaInicial" name="fechaInicial" class="form-control" type="date" <?php if (isset($_SESSION['fechaInicial'])) { echo "value='".$_SESSION['fechaInicial']."'"; } ?>/>
		</div>
		<div class="col-md-2">
    <input id="fechaFinal" name="fechaFinal" class="form-control" type="date" <?php if (isset($_SESSION['fechaFinal'])) { echo "value='".$_SESSION['fechaFinal']."'"; } ?>/>
		</div>

		<div class="col-md-2">
		  <div class="form-group">
		  <select name="sucursales" class="form-control">
		  <option value="-1">TODAS LAS SUCURSALES</option>
		  <?php $q1 = "SELECT ID, NAME FROM LOCATIONS ORDER BY NAME";
        $result_tasks = mysqli_query($conn, $q1);    
          while($row = mysqli_fetch_assoc($result_tasks)) { 
		     echo '<option value="'.$row['ID'].'"';
			 if (isset($_SESSION['sucursales'])) { 
			 if($_SESSION['sucursales']==$row['ID']) echo ' selected';
			 }
			 echo '>'.$row['NAME'].'</option>';
		  }
		  ?>
			</select>
          </div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<input type="submit" name="filtrar" class="btn btn-secondary" value="Buscar">
			</div>
		  </div>
		</div>
	</div>  
</form>
<div class="row">
  <div class="col-md-12 table-responsive">
  <?php if (isset($_SESSION['query'])) { ?>
		<table class="table table-bordered table-striped dataTable">
        <thead>
          <tr>
            <th>SUCURSAL</th>
						<th>PAGO/TOTAL</th>
						<th>FECHAS</th>
          </tr>
        </thead>
        <tbody>
        <?php  $query = $_SESSION['query'];
          $result_tasks = mysqli_query($conn, $query);    
          while($row = mysqli_fetch_assoc($result_tasks)) { ?>
          <tr>
            <td><?php echo $row['SUCURSAL']; ?> #<?php echo $row['HOSTSEQUENCE']; ?></td>
						<td><?php echo $row['PAYMENT']; ?> <?php echo $row['TOTAL']; ?></td>
						<td><?php echo $row['DATESTART']; ?> - <?php echo $row['DATEEND']; ?></td>
					</tr>
					<?php }?>
					</tbody>
      </table>
			<?php session_unset(); }?>
    </div>
  </div>
<!-- Llamar a los complementos javascript-->
<script src="jquery-1.12.4.min.js"></script>
<script src="FileSaver.min.js"></script>
<script src="Blob.min.js"></script>
<script src="xls.core.min.js"></script>
<script src="dist/js/tableexport.js"></script>
<script>
$("table").tableExport({
	formats: ["xlsx"], //Tipo de archivos a exportar ("xlsx","txt", "csv", "xls")
	position: 'top',  // Posicion que se muestran los botones puedes ser: (top, bottom)
	bootstrap: false,//Usar lo estilos de css de bootstrap para los botones (true, false)
	fileName: "Reporte",    //Nombre del archivo 
});
</script>
<?php
include('footer.php');?>