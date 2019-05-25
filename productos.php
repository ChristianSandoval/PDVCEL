<?php
include('header.php');?>

<form action="filtrar_productos.php" method="POST">
	<div class="row">
		<div class="col-md-2">
          <div class="form-group">
            <input type="text" name="codigo" class="form-control" placeholder="Codigo" autofocus
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
            <th>CODIGO</th>
            <th>PRODUCTO</th>
						<th>COSTO</th>
            <th>MENUDEO</th>
						<th>MAYOREO</th>
          </tr>
        </thead>
        <tbody>
		<?php if (isset($_SESSION['query'])) { 
					$query = $_SESSION['query'];
					echo "<script>console.log( 'Debug Objects: " . $query . "' );</script>";
          $result_tasks = mysqli_query($conn, $query);    
          while($row = mysqli_fetch_assoc($result_tasks)) { ?>
          <tr>
            <td><a href='editarproducto.php?id=<?php echo $row['CODE']; ?>'><?php echo $row['CODE']; ?></a></td>
            <td><?php echo $row['NOMBRE']; ?></td>
						<td><?php echo $row['COSTO']; ?></td>
						<td><?php echo $row['MENUDEO']; ?></td>
						<td><?php echo $row['MAYOREO']; ?></td>
		  </tr>
		<?php }session_unset(); }?>
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