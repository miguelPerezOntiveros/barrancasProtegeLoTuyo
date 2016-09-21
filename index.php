<?php
  $link = mysqli_connect('xxxx','xxxx','xxxx','xxxx');
       
    if(!$rs = mysqli_query($link, "select tipo, contenido from contenido"))
        echo "Error al obtener datos";
    else
        while($fila = mysqli_fetch_array($rs))
            $datos[$fila['tipo']] = $fila['contenido'];  

?>

<!doctype html>
<!--[if IE 7 ]>    <html lang="en-gb" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en-gb" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en-gb" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en-gb" class="no-js">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!--[if lt IE 9]> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <title>Protege lo tuyo - Cuernavaca</title>
    <meta name="description" content="">
    <meta name="author" content="WebThemez">
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!--[if lte IE 8]>
		<script type="text/javascript" src="http://explorercanvas.googlecode.com/svn/trunk/excanvas.js"></script>
	<![endif]-->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/isotope.css" media="screen" />
    <link rel="stylesheet" href="js/fancybox/jquery.fancybox.css" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/da-slider.css" />
    <!-- Owl Carousel Assets -->
    <link href="js/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css" />
    <!-- Font Awesome -->
    <link href="font/css/font-awesome.min.css" rel="stylesheet">

    <!-- Librerias usadas para hacer la toma de imagen... -->
    <script type="text/javascript" charset="utf-8" src="js/jquery.js"></script>
    <script type="text/javascript" charset="utf-8" src="js/quantize.js"></script>
    <script type="text/javascript" charset="utf-8" src="js/color-thief.js"></script>

    <!-- Función al cargar lapágina -->
    <script>
        window.onerror = function (errorMsg, url, lineNumber) {
            alert('Error: ' + errorMsg + ' Script: ' + url + ' Line: ' + lineNumber);
        }
        window.onload = function(){
            getLocation();
        };

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else { 
            }
        };

        function showPosition(position) {
            document.getElementById('x').value = position.coords.latitude; 
            document.getElementById('y').value = position.coords.longitude; 
        };

        var desiredWidth;
        $(document).ready(function() {
            console.log('onReady');
            $("#takePictureField").on("change",gotPic);
            $("#yourimage").load(getSwatches);
            desiredWidth = window.innerWidth;
            
            if(!("url" in window) && ("webkitURL" in window)) {
                window.URL = window.webkitURL;   
            }
            
        });
        function getSwatches(){
            var colorArr = createPalette($("#yourimage"), 5);
            for (var i = 0; i < Math.min(5, colorArr.length); i++) {
                $("#swatch"+i).css("background-color","rgb("+colorArr[i][0]+","+colorArr[i][1]+","+colorArr[i][2]+")");
                console.log($("#swatch"+i).css("background-color"));
            }
        }   
        
        //Credit: https://www.youtube.com/watch?v=EPYnGFEcis4&feature=youtube_gdata_player
        function gotPic(event) {
            if(event.target.files.length == 1 && 
               event.target.files[0].type.indexOf("image/") == 0) {
                $("#yourimage").attr("src",URL.createObjectURL(event.target.files[0]));
            }
        }
    
    </script>
                
</head>

<body>
    <header class="header" style =  <?= "'background: #".$datos['color']."'" ?>  >
        <div class="container">
            <nav class="navbar navbar-inverse" role="navigation">
                <div class="navbar-header">
                    <button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <!--/.navbar-header-->
                <div id="main-nav" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav" id="mainNav">
                        <li class="active"><a href="#home" class="scroll-link">Inicio</a></li>
                        <li><a href="#aboutUs" class="scroll-link">Árboles</a></li>
                        <li><a href="#experience" class="scroll-link">Impacto</a></li>
                        <li><a href="#sube" class="scroll-link">Sube</a></li>
                    </ul>
                </div>
                <!--/.navbar-collapse-->
            </nav>
            <!--/.navbar-->
        </div>
        <!--/.container-->
    </header>
    <!--/.header-->
    <div id="#top"></div>
    <section id="home">
        <div class="banner-container">
            <?php
                if(!$rs = mysqli_query($link, "select foto from galeria where nombre = 'banner'"))
                    echo "Error al obtener datos";
                else
                    while($fila = mysqli_fetch_array($rs))
                        $banner = $fila['foto'];     
            ?>

            <img src= <?= "'admin/galeria/".$banner."'" ?> alt="banner" />
            <div class="container banner-content">
                <div id="da-slider" class="da-slider">

                    <?php
                        echo "<div class='da-slide'><h2>".$datos['tituloCarrusel1']."</h2><p>".$datos['cuerpoCarrusel1']."</p><div class='da-img'></div></div>";
                        echo "<div class='da-slide'><h2>".$datos['tituloCarrusel2']."</h2><p>".$datos['cuerpoCarrusel2']."</p><div class='da-img'></div></div>";
                        echo "<div class='da-slide'><h2>".$datos['tituloCarrusel3']."</h2><p>".$datos['cuerpoCarrusel3']."</p><div class='da-img'></div></div>";
                    ?>
				<!--  <nav class="da-arrows">
                        <span class="da-arrows-prev"></span>
                        <span class="da-arrows-next"></span>
                    </nav> -->
                </div>
            </div>
        </div>
    </section>
    <section id="introText">
        <div class="container">
            <div class="text-center">
            <h1><?= $datos['tituloPieCarrusel'] ?></h1>
              <p><?= $datos['cuerpoPieCarrusel'] ?></p>
            </div>
        </div>

    </section>
    <!--About-->
    <section id="aboutUs" class="secPad">
        <div class="container">
            <div class="heading text-center">
                <!-- Heading -->
                <h2><?= $datos['tituloArboles'] ?></h2>
                <p><?= $datos['cuerpoArboles'] ?></p>
            </div>
            <div class="row">

                <div class="col-md-4 text-center tileBox">
                   <div class="txtHead">
                    <h3><?= $datos['tituloArbol1'] ?></h3></div>
                    <p><?= $datos['cuerpoArbol1'] ?></p>
                </div>
                <div class="col-md-4 text-center tileBox">
                   <div class="txtHead">
                    <h3><?= $datos['tituloArbol2'] ?></h3></div>
                    <p><?= $datos['cuerpoArbol2'] ?></p>
                </div>
                <div class="col-md-4 text-center tileBox">
                   <div class="txtHead">
                    <h3><?= $datos['tituloArbol3'] ?></h3></div>
                    <p><?= $datos['cuerpoArbol3'] ?></p>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-md-4 text-center tileBox">
                   <div class="txtHead">
                    <h3><?= $datos['tituloArbol4'] ?></h3></div>
                    <p><?= $datos['cuerpoArbol4'] ?></p>
                </div>
                <div class="col-md-4 text-center tileBox">
                   <div class="txtHead">
                    <h3><?= $datos['tituloArbol5'] ?></h3></div>
                    <p><?= $datos['cuerpoArbol5'] ?></p>
                </div>
                <div class="col-md-4 text-center tileBox">
                   <div class="txtHead">
                    <h3><?= $datos['tituloArbol6'] ?></h3></div>
                    <p><?= $datos['cuerpoArbol6'] ?></p>
                </div>
                

            </div>
        </div>
    </section>
    <!--Quote-->
    <section id="quote" class="bg-parlex">
        <div class="parlex-back">
            <div class="container secPad text-center">
				<h2><?= $datos['quote'] ?></h2><h3><?= $datos['persona'] ?></h3>
            </div>
            <!--/.container-->
        </div>
    </section>
    
    <!--Skills-->
    <section id="skills" class="secPad white">
    	<div class="container">
        <div class="heading text-center">
                <!-- Heading -->
                <h2>Árboles donados</h2>
            </div>

            <div class="row">
                    <p class="mrgBtm20"> <?= $datos['cuerpoArbolesDonados'] ?> </p>
            </div>
        	
            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-md-2 skilltitle"><?= $datos['tituloArbol1'] ?></div>
                        <div class="col-md-8">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style = <?= "'background-color: #".$datos['color']."; width: ".$datos['valor1']."%;'" ?> >
                                    <span class="sr-only">90% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 skilltitle"><?= $datos['tituloArbol2'] ?></div>
                        <div class="col-md-8">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style = <?= "'background-color: #".$datos['color']."; width: ".$datos['valor2']."%;'" ?> >
                                    <span class="sr-only">90% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 skilltitle"><?= $datos['tituloArbol3'] ?></div>
                        <div class="col-md-8">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style = <?= "'background-color: #".$datos['color']."; width: ".$datos['valor3']."%;'" ?> >
                                    <span class="sr-only">80% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-sm-6">
                    
                    <div class="row">
                        <div class="col-md-2 skilltitle"><?= $datos['tituloArbol4'] ?></div>
                        <div class="col-md-8">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style = <?= "'background-color: #".$datos['color']."; width: ".$datos['valor4']."%;'" ?> >
                                    <span class="sr-only">90% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 skilltitle"><?= $datos['tituloArbol5'] ?></div>
                        <div class="col-md-8">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style = <?= "'background-color: #".$datos['color']."; width: ".$datos['valor5']."%;'" ?> >
                                    <span class="sr-only">80% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 skilltitle"><?= $datos['tituloArbol6'] ?></div>
                        <div class="col-md-8">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style = <?= "'background-color: #".$datos['color']."; width: ".$datos['valor6']."%;'" ?> >                                
                                    <span class="sr-only">75% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>        
    </section>
    
    <!--Experience-->
    <section id="experience" class="secPad">
    	<div class="container">     
           <div class="heading text-center">
                <!-- Heading -->
                <h2>Impacto</h2>
                <p><?= $datos['cuerpoImpacto'] ?></p>
            </div>
       
            <div>
                <div id="map_wrapper" style = "height:400px;">
                    <div id="map_canvas" class="mapping" style = "width: 100%; height:100%"></div>
                </div>
            </div>

        </div>

        
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

        <script>
        jQuery(function($) {
    // Asynchronously Load the map API 
    var script = document.createElement('script');
    script.src = "http://maps.googleapis.com/maps/api/js?sensor=false&callback=initialize";
    document.body.appendChild(script);
    //Agregar los marcadores...

});

function initialize() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap'
    };
                    
    // Display a map on the page
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    map.setTilt(45);
        
    // Multiple Markers
    <?php
        //$link = mysqli_connect('barrancasprotegelotuyo.com','mike','Notgreenm1.','barrancas');
        $rs = mysqli_query($link,"select nombre,latitud,longitud,foto,notas from arboles where revisado > 0 and (foto like '%.jpg' or foto like '%.png');");
        $fotos = array();
        $notas = array();
        $nombres = array();
    ?>

    var markers = [
        <?php
            $first = 0;
            while($row = mysqli_fetch_array($rs)){
                if($first)
                    echo ",\n\t";
                $first++;
                echo "['".$row['nombre']."', ".$row['longitud'].",".$row['latitud']."]";
                array_push($fotos, "admin/arboles/".$row['foto']);
                array_push($notas, $row['notas']);
                array_push($nombres, $row['nombre']);
            }
        ?>

    ];
                        
    // Info Window Content
    var infoWindowContent = [
        <?php
            $first = 0;
            for ($i = 0; $i< count($fotos);$i++){
                if($first)
                    echo ",\n\t";
                $first++;
                echo "['<div class=\"info_content\">' +
        '<h3>$nombres[$i]</h3>' +
        '<p>$notas[$i]</p>' +
        '<p><img src=\"$fotos[$i]\" width=\"150\"></p>'+
        '</div>']";
            }
        ?>
    ];
        
    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Loop through our array of markers & place each one on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0]
        });
        
        // Allow each marker to have an info window    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Automatically center the map fitting all markers on the screen
        map.fitBounds(bounds);
    }

    // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(14);
        google.maps.event.removeListener(boundsListener);
    });
    
}
        </script>
    </section>

    

    <!--Formulario -->
    <section id="sube" class="secPad">
        <div class="container">

            <div class="row">
                <div class="heading text-center">
                    <!-- Heading -->
                    <h2 >¿Tienes un árbol?</h2>
                    <p><?= $datos['cuerpoSubelo'] ?></p>
                </div>
            </div>

            <div class="row mrgn30">

                <form method="post" enctype="multipart/form-data" action="" id="contactfrm" role="form">
                    <div class="col-sm-6" align = "center">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" title="Please enter your name (at least 2 characters)">
                            <input type="hidden" value="0" id="x" name="latitud">
                            <input type="hidden" value="0" id="y" name="longitud">
                        </div>
                        <div class="form-group">
                            <label for="comments">Comments</label>
                            <textarea name="comment" class="form-control" id="comments" cols="3" rows="5" placeholder="Enter your message…" title="Please enter your message (at least 10 characters)"></textarea>
                        </div>
                        
                    </div>
                    <div class="col-sm-6" align = "center">
                        <div class="form-group">
                            <label for="comments">Foto</label>
                            <input type="file" capture="camera" placeholder ="Subir foto" accept="image/*" id="takePictureField" name = "foto" />
                        </div>

                        <button name="submit" type="submit" style =  <?= "'background: #".$datos['color']."'" ?>  class="btn btn-lg btn-primary" id="submit">Submit</button>
                        <div class="result"></div>
                    </div>
                </form>
            </div>
        </div>
        <!--/.container-->
    </section>
  
   <!--Portfolio-->
    <section id="portfolio" class="section appear clearfix secPad">
        <div class="container">

            <div class="heading text-center">
                <!-- Heading -->
                <h2>Galería</h2>
                    <p><?= $datos['cuerpoGaleria'] ?></p>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="portfolio-items">

                            <?php
                                if(!$rs = mysqli_query($link, "select nombre, foto from galeria"))
                                    echo "Error al obtener datos";
                                else
                                    while($fila = mysqli_fetch_array($rs))
                                    {
                                        if($fila['nombre'] != 'banner')
                                        {
                                            ?>
                                                <article class="col-sm-4">
                                                    <div class="portfolio-item">
                                                        <img src= <?= "'admin/galeria/".$fila['foto']."'" ?> alt="" />
                                                        <div class="portfolio-desc align-center">
                                                            <div class="folio-info">
                                                                <a href= <?= "'admin/galeria/".$fila['foto']."'" ?> class="fancybox">
                                                                    <h5><?= $fila['nombre'] ?></h5>
                                                                    <i class="fa fa-arrows-alt fa-2x"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            <?php
                                        }
                                    }
                            ?>

                        </div>


                    </div>
                </div>
            </div>

        </div>
    </section>

    <footer>
        <div class="container">
            <div class="social text-center">
                <a href= <?= "'".$datos['ligaTwitter']."'" ?> ><i class="fa fa-twitter"></i></a>
                <a href= <?= "'".$datos['ligaFacebook']."'" ?>><i class="fa fa-facebook"></i></a>
            </div>

            <div class="clear"></div>
            <!--CLEAR FLOATS-->
        </div>
    </footer>
    <!--/.page-section-->
    <section class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <?= $datos['pieFinal'] ?>
                </div>
            </div>
            <!-- / .row -->
        </div>
    </section>
    <a href="#top" class="topHome"  style =  <?= "'background: #".$datos['color']."'" ?> ><i class="fa fa-chevron-up fa-2x"  style =  <?= "'background: #".$datos['color']."'" ?>></i></a>

    <!--[if lte IE 8]><script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script><![endif]-->
    <script src="js/modernizr-latest.js"></script>
    <script src="js/jquery-1.8.2.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/jquery.isotope.min.js" type="text/javascript"></script>
    <script src="js/fancybox/jquery.fancybox.pack.js" type="text/javascript"></script>
    <script src="js/jquery.nav.js" type="text/javascript"></script>
    <script src="js/jquery.cslider.js" type="text/javascript"></script>
    <script src="js/custom.js" type="text/javascript"></script>
    <script src="js/owl-carousel/owl.carousel.js"></script>
    <?php
        if (isset($_POST['name'])){

            $fecha = date('Y-m-d');
            //Nombre
            $nombre  = $_POST['name'];
            //latitud
            $latitud = $_POST['latitud'];
            //Longitud
            $longitud = $_POST['longitud'];
            //Comentarios
            $notas = $_POST['comment'];

            //Opción 2 para subir la foto...
            $foto = "";
            $uDirectory = $_SERVER['DOCUMENT_ROOT'] . $currentDirectory;
            $currentDirectory = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
            $target_dir = $_SERVER['DOCUMENT_ROOT'] . $currentDirectory."admin/arboles/";
            $nuevo_nombre = time(). str_replace(' ','_',basename($_FILES["foto"]["name"]));
            $target_file = $target_dir .$nuevo_nombre;
            $liga = "admin/arboles/".$nuevo_nombre;
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                $foto =  $nuevo_nombre;
            } else {
                echo "<script>alert('No se pudo subir tu foto');</script>";
            }

            $query = "insert into arboles(nombre,longitud,latitud,foto,fecha,revisado,notas) values('$nombre','$latitud','$longitud','$foto','$fecha',0,'$notas');";
            //$link = mysqli_connect('barrancasprotegelotuyo.com','mike','Notgreenm1.','barrancas');
            if (!mysqli_query($link,$query))
                echo "<script>alert('No se pudo registrar el arbol: ".mysqli_error($link)."');</script>";
            mysqli_close($link);
        };
    ?>
</body>
</html>
