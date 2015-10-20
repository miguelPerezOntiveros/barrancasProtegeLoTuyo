<?php

	$iSecc = 0;
	$proy = 'barrancas';
	$msgfoot = 'barrancasprotegelotuyo.com';

	function arboles($alta, $baja, $ver) {$GLOBALS['altas']['arboles'] = $alta; $GLOBALS['bajas']['arboles'] = $baja; $GLOBALS['ver']['arboles'] = $ver;}
	function contenido($alta, $baja, $ver) {$GLOBALS['altas']['contenido'] = $alta; $GLOBALS['bajas']['contenido'] = $baja; $GLOBALS['ver']['contenido'] = $ver;}
	function galeria($alta, $baja, $ver) {$GLOBALS['altas']['galeria'] = $alta; $GLOBALS['bajas']['galeria'] = $baja; $GLOBALS['ver']['galeria'] = $ver;}
	function userTypes($alta, $baja, $ver) {$GLOBALS['altas']['userTypes'] = $alta; $GLOBALS['bajas']['userTypes'] = $baja; $GLOBALS['ver']['userTypes'] = $ver;}
	function users($alta, $baja, $ver) {$GLOBALS['altas']['users'] = $alta; $GLOBALS['bajas']['users'] = $baja; $GLOBALS['ver']['users'] = $ver;}
	$seccion[$iSecc] = 'arboles';	$Seccion[$iSecc] = 'Arboles';	$human[$iSecc++] = 'nombre';
	$seccion[$iSecc] = 'contenido';	$Seccion[$iSecc] = 'Contenido';	$human[$iSecc++] = 'tipo';
	$seccion[$iSecc] = 'galeria';	$Seccion[$iSecc] = 'Galeria';	$human[$iSecc++] = 'nombre';
	$seccion[$iSecc] = 'userTypes';	$Seccion[$iSecc] = 'User Types';	$human[$iSecc++] = 'name';
	$seccion[$iSecc] = 'users';	$Seccion[$iSecc] = 'Users';	$human[$iSecc++] = 'user';

	$sections = $iSecc;
	session_start();
	include 'permisos.php';
	$campos = 0;
	$iSecc = 0;

	switch ($tabla)
	{

		case 'arboles':
			$campo[$campos] = 'nombre';	$mostrar[$campos] = 'Nombre';	$hereda[$campos] = '';	$type[$campos] = 'text';	$length[$campos++] = '';
			$campo[$campos] = 'longitud';	$mostrar[$campos] = 'Longitud';	$hereda[$campos] = '';	$type[$campos] = 'text';	$length[$campos++] = '';
			$campo[$campos] = 'latitud';	$mostrar[$campos] = 'Latitud';	$hereda[$campos] = '';	$type[$campos] = 'text';	$length[$campos++] = '';
			$campo[$campos] = 'foto';	$mostrar[$campos] = 'Foto';	$hereda[$campos] = '*';	$type[$campos] = 'text';	$length[$campos++] = '';
			$campo[$campos] = 'fecha';	$mostrar[$campos] = 'Fecha';	$hereda[$campos] = '';	$type[$campos] = 'date';	$length[$campos++] = '';
			$campo[$campos] = 'revisado';	$mostrar[$campos] = 'Revisado';	$hereda[$campos] = '';	$type[$campos] = 'int';	$length[$campos++] = '';
			$campo[$campos] = 'notas';	$mostrar[$campos] = 'Notas';	$hereda[$campos] = '';	$type[$campos] = '';	$length[$campos++] = '1023';
		break;

		case 'contenido':
			$campo[$campos] = 'tipo';	$mostrar[$campos] = 'Tipo';	$hereda[$campos] = '';	$type[$campos] = 'text';	$length[$campos++] = '';
			$campo[$campos] = 'contenido';	$mostrar[$campos] = 'Contenido';	$hereda[$campos] = '';	$type[$campos] = 'text';	$length[$campos++] = '';
		break;

		case 'galeria':
			$campo[$campos] = 'nombre';	$mostrar[$campos] = 'Nombre';	$hereda[$campos] = '';	$type[$campos] = 'text';	$length[$campos++] = '';
			$campo[$campos] = 'foto';	$mostrar[$campos] = 'Foto';	$hereda[$campos] = '*';	$type[$campos] = 'text';	$length[$campos++] = '';
		break;

		case 'userTypes':
			$campo[$campos] = 'name';	$mostrar[$campos] = 'Name';	$hereda[$campos] = '';	$type[$campos] = 'text';	$length[$campos++] = '';
		break;

		case 'users':
			$campo[$campos] = 'user';	$mostrar[$campos] = 'User';	$hereda[$campos] = '';	$type[$campos] = 'text';	$length[$campos++] = '';
			$campo[$campos] = 'pass';	$mostrar[$campos] = 'Pass';	$hereda[$campos] = '';	$type[$campos] = 'text';	$length[$campos++] = '';
			$campo[$campos] = 'type';	$mostrar[$campos] = 'Type';	$hereda[$campos] = '3';	$type[$campos] = 'text';	$length[$campos++] = '';
		break;
	}
?>
