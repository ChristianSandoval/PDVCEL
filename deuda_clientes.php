<?php
include('header.php');?>

<form action="filtrar_deuda_clientes.php" method="POST">
	<div class="row">
		<div class="col-md-2">
          <div class="form-group">
            <input type="text" name="codigo" class="form-control" placeholder="Telefono" autofocus
			<?php if (isset($_SESSION['codigo'])) { echo "value='".$_SESSION['codigo']."'"; } ?>
			>
          </div>
		</div>
		<div class="col-md-2">
          <div class="form-group">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre"
			<?php if (isset($_SESSION['nombre'])) { echo "value='".$_SESSION['nombre']."'"; } ?>
			>
          </div>
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
  
					<table class="table table-bordered table-striped dataTable">
					<thead>
							<tr>
								<th>CLIENTE</th>
								<th>TOPE DEUDA</th>
								<th>DEUDA ACTUAL</th>
								<th>SUCURSAL</th>
							</tr>
						</thead>
        	<tbody>
					<?php if (isset($_SESSION['query'])) { 
          $query = $_SESSION['query'];
          $result_tasks = mysqli_query($conn, $query);    
          while($row = mysqli_fetch_assoc($result_tasks)) { ?>
          	<tr>
						<td><?php echo $row['TELEFONO']; ?>-<?php echo $row['NOMBRE']; ?></td>
						 <td><?php echo $row['TOPEDEUDA']; ?></td>
						 <td><?php echo $row['DEUDAACTUAL']; ?></td>
							<td><?php echo $row['SUCURSAL']; ?></td>
						</tr>
						<?php } 
		} session_unset();?>
					</tbody>	
      		</table>
	
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