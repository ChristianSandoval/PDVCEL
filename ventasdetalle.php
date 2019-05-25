<?php
include('header.php');?>

<form action="filtrar_ventasdetalle.php" method="POST">
	<div class="row">
		<div class="col-md-2">
          <div class="form-group">
            <input type="text" name="codigo" class="form-control" placeholder="Codigo producto" autofocus
			<?php if (isset($_SESSION['codigo'])) { echo "value='".$_SESSION['codigo']."'"; } ?>
			>
          </div>
		</div>
		<div class="col-md-2">
          <div class="form-group">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre producto"
			<?php if (isset($_SESSION['nombre'])) { echo "value='".$_SESSION['nombre']."'"; } ?>
			>
          </div>
		</div>

		<div class="col-md-2">
          <div class="form-group">
            <input type="text" name="codigoCliente" class="form-control" placeholder="Codigo cliente"
			<?php if (isset($_SESSION['codigoCliente'])) { echo "value='".$_SESSION['codigoCliente']."'"; } ?>
			>
          </div>
		</div>
		<div class="col-md-2">
          <div class="form-group">
            <input type="text" name="nombreCliente" class="form-control" placeholder="Nombre cliente"
			<?php if (isset($_SESSION['nombreCliente'])) { echo "value='".$_SESSION['nombreCliente']."'"; } ?>
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
		<div class="col-md-4">
		  <div class="form-group">
		  <select name="categorias" class="form-control">
		  <option value="0">TODAS LAS CATEGORIAS</option>
		  <?php $q2 = "SELECT ID, NAME FROM CATEGORIES ORDER BY NAME";
        $result_tasks = mysqli_query($conn, $q2);    
          while($row = mysqli_fetch_assoc($result_tasks)) { 
		     echo '<option value="'.$row['ID'].'"';
			 if (isset($_SESSION['categorias'])) { 
			 if($_SESSION['categorias']==$row['ID']) echo ' selected';
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
								<th>TKT</th>
								<th>CODIGO</th>
								<th>PRODUCTO</th>
								<th>PRECIO</th>
								<th>CANT</th>
								<th>IMPORTE</th>
								<th>FECHA</th>
								<th>SUCURSAL</th>
								<th>CLIENTE</th>
								<th>USUARIO</th>
							</tr>
						</thead>
        	<tbody>
					<?php if (isset($_SESSION['query'])) { 
          $query = $_SESSION['query'];
          $result_tasks = mysqli_query($conn, $query);    
          while($row = mysqli_fetch_assoc($result_tasks)) { ?>
          	<tr>
						<td><?php echo $row['ID']; ?>(<?php echo $row['TIPO']; ?>)</td>
						 <td><?php echo $row['CODIGO']; ?></td>
						 <td><?php echo $row['PRODUCTO']; ?></td>
							<td><?php echo $row['PRECIO']; ?></td>
							<td><?php echo $row['CANTIDAD'];?></td>
							<td><?php echo $row['IMPORTE']; ?></td>
							<td><?php echo $row['FECHA']; ?></td>
							<td><?php echo $row['SUCURSAL']; ?></td>
							<td><?php echo $row['CLIENTEID']; ?>-<?php echo $row['CLIENTE']; ?></td>
							<td><?php echo $row['USUARIO']; ?></td>
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