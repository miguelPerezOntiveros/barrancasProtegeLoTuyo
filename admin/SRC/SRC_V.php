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

        <script type = 'text/javascript'>
        	function preguntar(foo, ID_Foo)
        	{ 
            	var eliminar = confirm('You are about to delete the entry '+foo+', sure?'); 
            	if(eliminar) location.href='B.php?id='+ID_Foo;
        	}
        	function borrarTodo()
        	{
				var eliminar = confirm('You are about to delete everything, sure?'); 
            	if(eliminar)
            	{
            		location.href='B.php?todo=todo';
            	}
        	}
    	</script>
        <meta charset = 'utf-8'/> 
	</head>
	

  	<body role="document">
    	<?php include '../menuPrimarias.php'; ?>
		
    	<div class="container theme-showcase" role="main">
    		<div align = "center">
            	<!--Buscar-->
		        	<div class = 'search'> <br>
						<form  action=<?php echo basename($_SERVER['SCRIPT_NAME']); ?> method="get">
							Search: <input id='nombre' name='nombre'>
							<input type = 'image' src = '../imagenes/search1.png' alt = 'Search' align = 'top'/>
						</form>
						<font size = '1'>*Leave empty to see all entries</font>
					</div>
				<!---->
				<div>
					<!--PageNumberAndLimits-->
						<?php
							if(isset($_GET['epp']))
								$epp = $_GET['epp'];
							else 
								$epp = 20;
							if(isset($_GET['pagina']))
							{
								$pagina_actual = $_GET['pagina'];
								$limite_superior = $_GET['pagina']*$epp;
								$limite_inferior = $limite_superior - $epp;
							} 
							else
							{
								$limite_inferior = 0;
								$limite_superior = $epp;
								$pagina_actual = 1;
							}
						?>
					<!---->
					<!--QueryForTablaPrincipal-->
						<?php
							$iguales = '';
							$joins = '';
							$tablasJoin = '';
							$order = '';
							$busquedaRef = '';
							for($i = 0; $i<$campos; $i++)
								if($hereda[$i] != '' && $hereda[$i] != '*')
								{
									$joins = $joins.', t'.$i.'.'.$human[$hereda[$i]].' AS ref'.$i;
									$tablasJoin = $tablasJoin.', '.$seccion[$hereda[$i]].' AS t'.$i;
									$iguales = $iguales.'t'.$i.'.id = '.$tabla.'.'.$campo[$i].' AND ';
									$busquedaRef = $busquedaRef.'t'.$i.'.'.$human[$hereda[$i]]." like '%".$_GET['nombre']."%' or ";
								}
							$iguales = substr($iguales, 0, -4); // le quita el ultimo and
							$busquedaRef = ' or '.substr($busquedaRef, 0, -3); // le quita el ultimo or

							$baseRef = 'SELECT '.$tabla.'.*'.$joins.' FROM '.$tabla.$tablasJoin.' WHERE '.$iguales;
							$base = 'SELECT '.$tabla.'.* FROM '.$tabla;
							$limites = ' limit '.$limite_inferior.' , '.$epp.';';
							
							if(isset($_GET['order']) && isset($_GET['asc'])) $order = ' ORDER BY '.$_GET['order'].' '.$_GET['asc'];

							$forConBusqueda = '';
							for($i = 0; $i<$campos; $i++)
								$forConBusqueda = $forConBusqueda.$tabla.'.'.$campo[$i]." like '%".$_GET['nombre']."%' or ";//campo[i]
							if($joins != '')
								$forConBusqueda = ' ('.substr($forConBusqueda, 0, -3).$busquedaRef.')'; // le quita el ultimo or
							else
								$forConBusqueda = ' ('.substr($forConBusqueda, 0, -3).')'; // le quita el ultimo or

							if ($joins != '')	if(isset($_GET['nombre']))	$query = $baseRef.' AND '.$forConBusqueda.$order.$limites;
												else  						$query = $baseRef.$order.$limites;
							else 				if(isset($_GET['nombre']))	$query = $base.' WHERE'.$forConBusqueda.$order.$limites;
												else  						$query = $base.$order.$limites;
							include '../conexionBD.php';
				            if(!$rs = mysql_query($query)) echo 'Error al cargar datos'.mysql_error().'|'.$query.'|'.$joins.'|'.isset($_GET['nombre']);
				            if(isset($_GET['nombre']) && mysql_num_rows($rs) == 0) echo 'No se encontraron entradas<br>';
				       	?>
					<!---->
					<!--TablaPrincipal-->
						<div class="row">
		              		<div >
								<table class= 'table table-striped'>
									<?php
										//Column tittles
										echo "<thead><tr>";
											for($i = 0; $i<$campos; $i++)
												echo '<th>'.$mostrar[$i].	"<a href = '".basename($_SERVER['SCRIPT_NAME']).
																						'?order='.$campo[$i].
																						'&asc=asc'.
																						(isset($_GET['epp'])?'&epp='.$_GET['epp']:'').
																						(isset($_GET['nombre'])?'&nombre='.$_GET['nombre']:'').
																						"'>▲</a>".
																			"<a href = '".basename($_SERVER['SCRIPT_NAME']).
																						'?order='.$campo[$i].
																						'&asc=desc'.
																						(isset($_GET['epp'])?'&epp='.$_GET['epp']:'').
																						(isset($_GET['nombre'])?'&nombre='.$_GET['nombre']:'').
																						"'>▼</a></th>";
												echo $thExtra; // por si se quieren campos adicionales
											if($bajas[$tabla])
												echo '<th>Options</th>'; 
										echo '</tr></thead>';

										//RowContents
										echo "<tbody>";
											while($fila= mysql_fetch_array($rs))
						 					{ 

						 						echo '<tr>';
															 		for($i = 0; $i<$campos; $i++)
																		if($hereda[$i] == '*')			echo '<td><a href = '.$fila[$campo[$i]]."><img HEIGHT=30 WIDTH=40 src='".$fila[$campo[$i]]."' alt = '".$fila[$campo[$i]]."'></td>";
																		else if(file_exists('override_'.$campo[$i].'.php')) 
																		{
																			$plano = $fila[$campo[$i]];
																			include 'override_'.$campo[$i].'.php';// por si se quiere overridear el comportamiento normal de una columna
														 				}
														 				else if($hereda[$i] == '')		echo '<td>'.$fila[$campo[$i]].'</td>';
																		else echo '<td>'.$fila['ref'.$i].'</td>';

																	if(file_exists('tbExtra.php')) 
																		include 'tbExtra.php'; // por si se quieren campos adicionales
																	if($bajas[$tabla]) 
																	{echo 		
																		'<td><a href = C.php?id='.$fila['id']."><img src='../imagenes/modificar.jpg' alt = 'Modificar'></a> &nbsp;".
																		"<a onclick='jsfunction' href = \"javascript:preguntar('".($hereda[0] == ''?$fila[$campo[0]]:$fila['ref0'])."', '".$fila['id']."')\"><img src='../imagenes/eliminar.jpg' alt = 'Eliminar'></a></td>";
																	}
												echo'</tr>';
											}
										echo "</tbody>";
									?>
								</table>
							</div>
		            	</div>
					<!---->
					<!--NumeroDeEntradasYDePaginas() -->
						<?php
							//entradas
							$numero = 0;
							if ($joins != '')	if(isset($_GET['nombre']))	$query = $baseRef.' AND '.$forConBusqueda.$order;
												else  						$query = $baseRef.$order;
							else 				if(isset($_GET['nombre']))	$query = $base.' WHERE'.$forConBusqueda.$order;
												else  						$query = $base.$order;
							if(!$rs_numero = mysql_query($query)) echo 'Error al acceder a la base de datos'.$query;
							else 
							$numero = mysql_num_rows($rs_numero);
							//páginas
							$numero_paginas = 1;
							if($numero%$epp == 0) 	{$numero_paginas = $numero/$epp;}
							else 					{$numero_paginas += (int)($numero/$epp);}

							
						?>
					<!---->
					<!--LinksParaOtrasPáginas-->
						<div align= 'right'>
							<?php	
								//epp
								echo '<form action= '.basename($_SERVER['SCRIPT_NAME'])." method = 'get'>";
									//drop down box
									echo "view: <select name='epp'>";
										echo '<option value =20>20</option>';
										echo '<option value =50>50</option>';
										echo '<option value =100>100</option>';
										echo '<option value =200>200</option>';
									echo '</select>';
									echo "<input type='submit' value = 'Go'/>    ";
									//Anterior
									if($pagina_actual != 1)
									{
										echo '<a href = '.basename($_SERVER['SCRIPT_NAME']).'?pagina='.($pagina_actual-1).(isset($_GET['epp'])?'&epp='.$_GET['epp']:'').(isset($_GET['nombre'])?'&nombre='.$_GET['nombre']:'')."><img src='../imagenes/flecha.jpg' alt = 'Anterior'></a> &nbsp;";
									}
									else echo "<img src='../imagenes/flecha.jpg' alt = 'Anterior'>";
									//Numeritos
									for($i = 1; $i <= $numero_paginas; $i++)
									{
										if($i != $pagina_actual)
										{
											echo '<a href = '.basename($_SERVER['SCRIPT_NAME']).'?pagina='.$i.(isset($_GET['epp'])?'&epp='.$_GET['epp']:'').(isset($_GET['nombre'])?'&nombre='.$_GET['nombre']:'').'>'.$i.'</a> &nbsp;';
										}else echo $i.'&nbsp';
									}
									//Siguiente
									if($pagina_actual < $numero_paginas)
									{ 
										echo '<a href = '.basename($_SERVER['SCRIPT_NAME']).'?pagina='.($pagina_actual+1).(isset($_GET['epp'])?"&epp=".$_GET['epp']:"").(isset($_GET['nombre'])?'&nombre='.$_GET['nombre']:'')."><img src='../imagenes/flechaSiguiente.jpg' alt = 'Siguiente'></a> &nbsp;";
									}
									else echo "<img src='../imagenes/flechaSiguiente.jpg' alt = 'Siguiente'>";
								echo '</form>';
							?>
						</div>
					<!---->
				</div>
				<!--Agregar-->
					<div class='contenido' align='left' style=' padding-left:100pt'>
						<?php 
							if($altas[$tabla])
								echo "<button type='button' onClick=\"location.href= 'A.php'\">Add</button>&nbsp;";
							
							if($bajas[$tabla])
								echo "<button type='button' onClick='borrarTodo();'>Erase All</button><br><br>";
						?>
					</div>
				<!---->
				<?php include '../foot.php'; ?>
        	</div>
    	</div>

	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	    <script src="../js/bootstrap.min.js"></script>
	    <script src="../js/docs.min.js"></script>
	    <script src="../js/ie10-viewport-bug-workaround.js"></script>
  	</body>
</html>