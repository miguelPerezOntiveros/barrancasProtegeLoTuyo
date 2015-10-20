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
						$csv = $csv.$campo[$i].', ';
					$csv = substr($csv, 0, -2); // le quita la ultima coma

					for($i = 0; $i< $campos; $i++)
						if($hereda[$i] == '*')
						{
							$currentDirectory = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']); 
						    $uDirectory = $_SERVER['DOCUMENT_ROOT'] . $currentDirectory;
						    $name =  str_replace(' ', '', $_FILES[$campo[$i]]['name']);
						    for($now = time(); file_exists($uFilename = $uDirectory.$now.'-'.$name); $now++) ;
							
						    if  (
						            isset($_POST['submit']) && 
						            $_FILES[$campo[$i]]['error'] == 0 && 
						            @is_uploaded_file($_FILES[$campo[$i]]['tmp_name']) && 
						            @move_uploaded_file($_FILES[$campo[$i]]['tmp_name'], $uFilename)
						        ) ;
					        else 
						        echo "Error uploading file";

							$values = $values."'".$now.'-'.$name."', ";
						}
						else
							$values = $values."'".$_POST[$campo[$i]]."', ";
					$values = substr($values, 0, -2); // le quita la ultima coma
					
					if (!$resultado = mysql_query('INSERT INTO '.$tabla.' ('.$csv.') values ('.$values.');'))
					{
						echo 'Error al registrar la entrada. <br>'.mysql_error();
						if(strpos(mysql_error(), 'UNIQUE') || strpos(mysql_error(), 'uplicate') ) echo 'Entrada duplicada.';
						header('Refresh: 4; URL= '.basename($_SERVER['SCRIPT_NAME']) );  
					}
					else { header('Location: V.php'); }
				}
			?>
		<!---->

		<div class="container theme-showcase" role="main">
			<!--Forma -->
				<br><br>
				<div class = 'contenido'>
					<form action= <?php echo basename($_SERVER['SCRIPT_NAME']); ?> method = 'post' align = 'left' enctype="multipart/form-data">
		            	
		            	<?php
		            		include '../conexionBD.php';		
		            		for($i = 0; $i < $campos; $i++)
		            		{
		            			if($hereda[$i] == '*') //MAX_FILE_SIZE = "1073741824"
		            			{ 
							        echo $mostrar[$i].": &nbsp;&nbsp; <input type='file' name='".$campo[$i]."'>";
		            			}
		            			else if($hereda[$i] != '')
								{
									$ddbId = null;
									$ddbHuman = null;
									//recolectar datos
									if(!isset($queryDdb[$campo[$i]])) $queryDdb[$campo[$i]] = 'select * from '.$seccion[$hereda[$i]].';';
									if (!$rs = mysql_query($queryDdb[$campo[$i]]))
										echo 'Error al cargar datos.';
									else
										for($k = 0; $fila = mysql_fetch_array($rs); $k++)
										{
											$ddbId[$k] = $fila['id'];
											$ddbHuman[$k] = $fila[$human[$hereda[$i]]];
										}
									//drop down box
									echo $mostrar[$i].": &nbsp;&nbsp; <select name='".$campo[$i]."' required>";
									for($j = 0; $j < count($ddbId); $j++)
										echo '<option value ='.$ddbId[$j].'>'.$ddbHuman[$j].'</option>';
									
									echo '</select><br>';
								}
								else 
									if($length[$i]>400) 	echo $mostrar[$i].": &nbsp;&nbsp; <textarea rows='4' cols='50' name='".$campo[$i]."'></textarea><br>";
									else 					echo $mostrar[$i].": &nbsp;&nbsp; <input type='".$type[$i]."' name='".$campo[$i]."' required><br>";
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