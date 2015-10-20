 <div id="navBar">
                
<nav class="navbar navbar-default navbar-fixed-top">
    <table style = "width: 100%;"><tr>
        <td>&nbsp;&nbsp;&nbsp;<img WIDTH=70 HEIGHT=50 src="../imagenes/logo.png"></td>
            <td>        
                <div class="container" >
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="navbar-collapse collapse">

                        <table style = "width: 100%;"><tr>

                        <td>
                            <ul class="nav navbar-nav">
                                <?php
                                    $tabs = 0;
                                    for ($i = 0; $i < $sections; $i++) //Botones
                                        if($ver[$seccion[$i]])
                                        {
                                            $tabs++;
                                            if($tabs==6)
                                            {
                                                $cerrarDropDownMenu = true;
                                                ?>
                                                    <li class="dropdown">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Más<span class="caret"></span></a>
                                                    <ul class="dropdown-menu" role="menu">
                                                <?php
                                            }

                                                $active=""; if($tabla==$seccion[$i]) { $active = "class='active' "; $actual = $i;}
                                                echo "<li ".$active."><a href='../".$seccion[$i]."/V.php'>".$Seccion[$i]."</a></li>"; 
                                        }

                                    if($cerrarDropDownMenu)
                                        echo "</ul></li>";
                                ?>

                            </ul>
                        </td>
                        <td align = "right">
                            <?php echo $_SESSION['user'].'<br><font size = 1>'.$_SESSION['type'].'</font>';?>
                            <a href="../logout.php"><img WIDTH=20 HEIGHT=20 src="../imagenes/logout.png"></a>
                        </td>
                    </tr></table>
                    </div><!--/.nav-collapse -->
                </div>
            </td>


    </tr></table>
</nav>
</div>


     


       
<br><br><br>
<div class="container theme-showcase" role="main">
    <div align = "center">
        <div class="page-header">
            <h2><?=$Seccion[$actual]?></h2>
        </div>
    </div>
</div>

<div>
    <div style="margin-left: auto; width: 90%;">
    <?php
        for($i = 0;!$ver[$seccion[$i]];$i++);

        $crumb = "<a href= '../".$seccion[$i]."/V.php'>Home</a>";                        
    ?>

    <?php
        for ($i = 0; $i < $sections; $i++) //para aterrizar
            if($tabla == $seccion[$i] ) 
                $crumb .= "><a href='V.php'>".$Seccion[$i]."</a>";

        include '../conexionBD.php';
        switch (basename($_SERVER['SCRIPT_NAME'])) //para el cielo
        {
            case 'A.php': $crumb .=  "><a href='".basename($_SERVER['SCRIPT_NAME'])."'>Create</a>"; break;
            case 'C.php': 
                $query = "select ".$human[$actual]." from ".$seccion[$actual]." where id = ".$_GET['id'].";";
                if(!$rs = mysql_query($query)) echo "Error. ".$query.". Actual:".$actual;
                $fila = mysql_fetch_array($rs); 
                $link = basename($_SERVER['SCRIPT_NAME'])."?id=".$_GET['id']; 
                $nombre = "Update '".$fila[$human[$actual]]."'";
                $crumb .=  "><a href= $link >$nombre</a>";
            break;
        }     
        echo $crumb; 
        echo "</div>";
    ?> 
</div>