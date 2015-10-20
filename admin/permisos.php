<?php
	switch ($_SESSION['type'])
	{
		case 'System Administrator':
			arboles(true, true, true);
			contenido(true, true, true);
			galeria(true, true, true);
			userTypes(false, false, false);
			users(true, true, true);
			break;

		default:
			arboles(false, false, true);
			contenido(false, false, true);
			galeria(false, false, true);
			userTypes(false, false, false);
			users(false, false, false);
			break;
	}
?>