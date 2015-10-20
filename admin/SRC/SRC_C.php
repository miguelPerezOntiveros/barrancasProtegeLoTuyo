<?php 
	error_reporting( error_reporting() & ~E_NOTICE );
	$tabla = basename(getcwd(), '.php');
	include '../conf.php'; 
	include '../checklogin.php'; 
?>
<html lang="en">
	<head>
		<link rel="icon" href="../imagenes/icono.png">

		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">

	    <link href="../css/bootstrap.min.css" rel="stylesheet">
	    <link href="../css/bootstrap-theme.min.css" rel="stylesheet">
	    <link href="../theme.css" rel="stylesheet">
	    <script src="../js/ie-emulation-modes-warning.js"></script>

		<title><?php echo $tabla; ?> | Vista</title>		
		<script src = 'http://code.jquery.com/ui/1.10.2/jquery-ui.js'></script>
    	<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
		
		<meta charset = 'utf-8'/> 
	</head>

	<body role="document">
    	<?php include '../menuPrimarias.php'; ?>
		
		<!--posibleModificacion-->
			<?php
				$deboHacerCambios = true;
				for($i = 0; $i < $campos; $i++)
					if($_POST[$campo[$i]] == '' && $hereda[$i] != '*') $deboHacerCambios = false; 
				
				if($deboHacerCambios)
				{
					include '../conexionBD.php';
					
					for($i = 0; $i< $campos; $i++)
						if($hereda[$i] == '*')
						{
							if($_FILES[$campo[$i]]['name'] != '')
							{
								$currentDirectory = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']); 
							    $uDirectory = $_SERVER['DOCUMENT_ROOT'] . $currentDirectory; 
							    for($now = time(); file_exists($uFilename = $uDirectory.$now.'-'.$_FILES[$campo[$i]]['name']); $now++);
								
							    if  (
							            isset($_POST['submit']) && 
							            $_FILES[$campo[$i]]['error'] == 0 && 
							            @is_uploaded_file($_FILES[$campo[$i]]['tmp_name']) && 
							            @move_uploaded_file($_FILES[$campo[$i]]['tmp_name'], $uFilename)
							        ) ;
						        else 
							        echo "Error uploading file";
							    //eliminar la vieja
								$query = 'SELECT '.$campo[$i].' from '.$tabla.' where id = '.$_GET['id'].';';
								if (!$rs = mysql_query($query))
									echo 'Error while deleting image';
								else
								{
									$fila = mysql_fetch_array($rs);
									unlink($fila[$campo[$i]]);
								}

								$sentencia_sql = $sentencia_sql.$campo[$i]." = '".$now.'-'.$_FILES[$campo[$i]]['name']."', ";
							}
						}
						else
							$sentencia_sql = $sentencia_sql.$campo[$i]." = '".$_POST[$campo[$i]]."', ";
					$sentencia_sql = substr($sentencia_sql, 0, -2); // le quita la ultima coma

					$sentencia_sql = 'UPDATE '.$tabla.' set '.$sentencia_sql.' where id = '.$_GET['id'].';';		
					
					if (!$resultado = mysql_query($sentencia_sql))
					{
						echo 'Error al modificar datos'.mysql_error().$sentencia_sql;
						header('Refresh: 4; URL= '.basename($_SERVER['SCRIPT_NAME']).'?id='.$GET['id'] ); 
					}
					else{ header('Location: V.php'); }
				}		
			?>
		<!---->

		<div class="container theme-showcase" role="main">
			<!--Forma -->
				<br><br>
		        <div class = 'contenido'>
		        	<?php //obtiene la info del sujeto
						include '../conexionBD.php';
						$query = 'SELECT '.$tabla.'.* from '.$tabla.' where id = '.$_GET['id'].';';
						$rs = mysql_query($query);
		                if(!$rs){ echo 'Error al cargar datos'.mysql_error().$query; }
		                else $filaI= mysql_fetch_array($rs);
		         	?>
		         	
					<form action= <?php echo basename($_SERVER['SCRIPT_NAME']).'?id='.$_GET['id']; ?> method = 'post' align = 'left' id = 'formulario' enctype="multipart/form-data">
						<input type = 'hidden' name = 'id' value = "<?php echo $_GET['id'] ?>" ;>
						 
						<?php
							include '../conexionBD.php';		
		            		for($i = 0; $i < $campos; $i++)
		            		{
		            			if($hereda[$i] == '*')
		            			{
		            				echo $mostrar[$i].":<br>";
		            				echo "&nbsp;&nbsp;&nbsp;&nbsp;<img HEIGHT=30 WIDTH=40 src='".$filaI[$campo[$i]]."' alt = '".$filaI[$campo[$i]]."'><br>";
		            				echo "&nbsp;&nbsp;&nbsp;&nbsp;Change file?  <input type='file' name='".$campo[$i]."'><br>";
		            			}
		            			else if($hereda[$i] != '')
								{
									$ddbId = null;
									$ddbHuman = null;
									//recolectar datos
									if(!isset($queryDdb[$campo[$i]])) $queryDdb[$campo[$i]] = 'select * from '.$seccion[$hereda[$i]].';';
									if (!$rs = mysql_query($queryDdb[$campo[$i]]))
										echo 'Error al cargar datos';
									else
										for($k = 0; $fila = mysql_fetch_array($rs); $k++)
										{
											$ddbId[$k] = $fila['id'];
											$ddbHuman[$k] = $fila[$human[$hereda[$i]]];
										}
									//drop down box
									echo $mostrar[$i].": &nbsp;&nbsp; <select name='".$campo[$i]."' required>";
									for($j = 0; $j < count($ddbId); $j++)
										if($ddbId[$j] == $filaI[$campo[$i]]) 	echo '<option value ='.$ddbId[$j].' selected>'.$ddbHuman[$j].'</option>';
										else 									echo '<option value ='.$ddbId[$j].'>'.$ddbHuman[$j].'</option>';
									echo '</select><br>';
								}
								else 
									if($length[$i]>400) 	echo $mostrar[$i].": &nbsp;&nbsp; <textarea rows='4' cols='50' name='".$campo[$i]."'>".$filaI[$campo[$i]]."</textarea><br>";
									else 					echo $mostrar[$i].": &nbsp;&nbsp; <input type='".$type[$i]."' name='".$campo[$i]."' value='".$filaI[$campo[$i]]."' required><br>";
		            		}
		            	?> 

						<input type='submit' name = 'submit'/>
					</form>
					<br><br><br><br>
				</div>
			<!---->
			<div align = "center">
				<?php include '../foot.php'; ?>
			</div>
	    </div>

    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	    <script src="../js/bootstrap.min.js"></script>
	    <script src="../js/docs.min.js"></script>
	    <script src="../js/ie10-viewport-bug-workaround.js"></script>
	</body>
</html>