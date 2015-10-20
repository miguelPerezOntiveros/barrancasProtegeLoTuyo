<?php
	include 'conf.php';
	if(!isset($_SESSION['user'])) 
	{
		header('Location: login.php');
		exit();
	}
	else
	{
		include 'permisos.php'; 
		$i = 0;
		while(!$ver[$seccion[$i]])
			$i++;
		header('Location: '.$seccion[$i].'/V.php');
	}
?>