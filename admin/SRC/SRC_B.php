<?php 
 	$tabla = basename(getcwd(), '.php');
	include '../conf.php';
	include '../checklogin.php'; 
?>

<html>
	<head>
		<link rel="icon" href="../imagenes/icono.png">
		
		<title><?php echo $tabla; ?> | Baja</title>
		 <script type = 'text/javascript'>
        	function alertar(m)
        	{ 
        		alert(m);
        	}
    	</script>
	</head>
	<body>
		<?php
			include '../conexionBD.php';
				
			if($_GET['todo'] == 'todo')
			{
				if(!$rs = mysql_query("delete from ".$tabla))
				{	
					echo "<script>alertar('Error al eliminar todo".$mysql_error()."');</script>";	
				exit();
				}
				else
					header('Location: V.php');
			}

			if($_GET['id'] != '')
			{
				for($i = 0; $i< $campos; $i++)
					if($hereda[$i] == '*') //Por si tiene archivo
					{
						$query = 'SELECT '.$campo[$i].' from '.$tabla.' where id = '.$_GET['id'].';';
						if (!$rs = mysql_query($query))
							echo "<script>alertar('Error while deleting image file');</script>";
						else
						{
							if(strlen($fila[$campo[$i]]) != 11)
							{
								$fila = mysql_fetch_array($rs);
								if(unlink($fila[$campo[$i]]))
									header('Location: V.php');
								else 
									echo "<script>alertar(".strlen($fila[$campo[$i]])."Error when unlinking the image ".$fila[$campo[$i]]." campo:".$campo[$i]." query:".$query."');</script>";
							}
						}
					}
				//eliminar entrada
				if (!mysql_query('delete from '.$tabla.' where id = '.$_GET['id'].';'))
				{
					if(strpos(mysql_error(), 'constraint'))
					{
						 echo "<script>alertar('The entry is being used in another table. It cannot be deleted.');</script>";
						 //if(strpos(mysql_error(), "`entregas`.`visitas`")) { echo "<b>Visitas</b>."; } //dependencia FALTA ELIMINARLAS
					}
					else echo "<script>alertar('Error while deleting entry.');</script>";
				}
				header('Location: V.php');
			}
			else 
				header('Location: V.php');

				
		?>
	</body>
</html>