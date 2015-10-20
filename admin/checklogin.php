<?php
	if(!isset($_SESSION['user'])) 
	{
		header('Location: ../login.php');
		exit();
	}
	if( 
		!$altas[$tabla]  && basename($_SERVER['SCRIPT_NAME']) == 'A.php' || 
		!$bajas[$tabla]  && basename($_SERVER['SCRIPT_NAME']) == 'B.php' 	
	)
		header('Location: V.php');
	
	if($_SESSION['type'] != 'System Administrator' && $tabla == 'users')
		header('Location: ../logout.php');
?>