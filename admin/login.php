<?php
	include 'conf.php'; 
	if($_POST['user']!= ""){ // recibe usuario
		if ($_POST['recordar'] == 1) //hay cookie
		{
			setcookie("user", $_POST['user'], time()+2592000);
			$_COOKIE["user"] = $_POST['user']; 
		}
		else
		{
			setcookie("user", "",-3600);
			$_COOKIE["user"] = "";
		}
		if ( $_POST['pass']!= ""){ // recibe pass
			include 'conexionBD.php'; 
			$array = mysql_fetch_array(mysql_query("select user from users where user = '".$_POST['user']."';"), MYSQL_BOTH);
			$nombre= $array['user'];	
			$array = mysql_fetch_array(mysql_query("select pass from users where user = '".$nombre."';"), MYSQL_BOTH); 
			$pass= $array['pass'];	
			if($pass != $_POST['pass']) { echo "Password incorrecto";}
			else //pass correcto
			{
				session_start();
				$_SESSION['user']=$nombre;
				
        		$fila2 = mysql_fetch_array(mysql_query("select name from userTypes where id = (select type from users where user = '".$_POST['user']."');"));
        		$_SESSION['type'] = $fila2['name'];
        
				include 'permisos.php'; 
        		$i = 0;
        		while(!$ver[$seccion[$i]])
        			$i++;
				header('Location: '.str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']).$seccion[$i].'/V.php');
			}
		} else { echo "You must fill in the password";}
	}
?>



<html>
	<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Login Form</title>
  <link rel="stylesheet" href="css/style.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body style = "background: #006296;";>
    <section class="container">
        <div class="login">
            <p align="center"><img src="imagenes/logo.png" style = "width: 100%; height: auto"></p>
            <form method="post" action=<?="'".basename($_SERVER['SCRIPT_NAME'])."'"?>
                <p><input type="text" style = "width: 100%;"  name="user" value="" placeholder="User" required></p>
                <p><input type="password" style = "width: 100%;"  name="pass" value="" placeholder="Password" required></p>
                <p class="submit"><input type="submit" name="commit" value="Inicar Sesión"></p>
            </form>
        </div>
    </section>
</body>
</html>