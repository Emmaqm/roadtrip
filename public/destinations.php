<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Road Trip Buses</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link rel="stylesheet" href="css/common_style.css">
<link rel="stylesheet" href="css/destinations.css">

<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat:600" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

</head>
<body>
    <?php
        include_once 'dbconfig.php';
        include_once 'login.php';

        function logout() {
            session_unset();
            session_destroy();
            header('Location: index.php');
        }
        
        if (isset($_GET['logout'])) {
            logout();
        }
    ?>
    <div class="header">
        <img class="logo" src="img/logo_blanco.png" alt="logo">
        <?php
            if(isset($_SESSION['loggedin']) and $_SESSION['loggedin'] == true){
            ?>
                <ul class="signed">
                <?php
                    if(isset($_SESSION['tipo_usuario']) and $_SESSION['tipo_usuario'] == "empleado"){
                        ?>
                        <li><a id="user_btn" href="empleados.php"><?php echo $_SESSION['username']?></a></li>
                        <?php
                    }else{
                        ?>
                        <li><a id="user_btn" href="#"><?php echo $_SESSION['username']?></a></li>
                        <?php
                    }
                    ?>
                    |
                    <li><a id="register_btn" href="index.php?logout=true">Cerrar Sesión</a></li>
                </ul>
        <?php    
            }else{
        ?>
            <ul class="sign">
                <li><a id="login_btn" onclick="openModal();" href="javascript:void(0)">Ingresar</a></li>
                |
                <li><a id="register_btn" href="register.php">Registrarse</a></li>
            </ul>
        <?php
        }
        ?>
        <ul class="menu">
            <li><a href="index.php">Inicio</a></li>            
            <?php
            if(isset($_SESSION['tipo_usuario']) and $_SESSION['tipo_usuario'] == "empleado"){
                ?>
                <li><a href="reservas.php">Venta de Pasajes</a></li>
                <?php
            }else{
                ?>
                <li><a href="reservas.php">Reservas</a></li>
                <?php
            } 
            ?>  
            <li><a href="horarios.php">Horarios</a></li> 
            <li><a href="destinations.php"><span class="active"></span>Destinos</a></li>
            <?php
            if(isset($_SESSION['tipo_usuario']) and $_SESSION['tipo_usuario'] == "empleado"){
                ?>
                <li><a href="empleados.php">Empleados</a></li>
                <?php
            }else{
                ?>
                <li><a href="contact.php">Contacto</a></li>
                <?php
            }
            
            ?>
        </ul>
        <h1>Destinos</h1>
    </div>

    <div class="gallery">
        <div class="row"> 
            <div class="column">
                <a href="http://www.maldonado.gub.uy/" target="_blank"><div class="imgc"><img src="img/piriapolis.jpg" style="width:100%"><div class="overlay">Maldonado</div></div></a>
                <p class="margin"></p>
                <a href="http://turismorocha.gub.uy/" target="_blank"><div class="imgc"><img src="img/rocha.jpg" style="width:100%"><div class="overlay">Rocha</div></div></a>
            </div>
            <div class="column">
                <a href="http://www.lavalleja.gub.uy/" target="_blank"><div class="imgc"><img src="img/lavalleja.jpg" style="width:100%"><div class="overlay">Lavalleja</div></div></a>
                <p class="margin"></p>
                <a href="http://turismo.salto.gub.uy/" target="_blank"><div class="imgc"><img src="img/salto.jpg" style="width:100%"><div class="overlay">Salto</div></div></a>
            </div>  
            <div class="column">
                <a href="http://www.coloniauy.com/" target="_blank"> <div class="imgc"><img src="img/colonia.jpg" style="width:100%"><div class="overlay">Colonia</div></div></a>
                <p class="margin"></p>
                <a href="https://www.rionegro.gub.uy/" target="_blank"><div class="imgc"><img src="img/rionegro.jpg" style="width:100%"><div class="overlay">Río Negro</div></div></a>
            </div>  
        </div>
    </div>

    <div class="footer">
        <img src="img/logo.png" alt="logo">
        <ul class="footer-menu">
                <li><a href="index.php">Inicio</a></li>            
                <li><a href="reservas.php">Reservas</a></li>
                <li><a href="horarios.php">Horarios</a></li> 
                <li><a href="destinations.php">Destinos</a></li>
                <li><a href="contact.php">Contacto</a></li>
        </ul>
        <ul>
            <li><a href="https://facebook.com/" target="_blank" class="fab fa-facebook"></a></li>
            <li><a href="https://twitter.com/" target="_blank" class="fab fa-twitter"></a></li>
            <li><a href="https://instagram.com/" target="_blank" class="fab fa-instagram"></a></li>
        </ul>
        <p>Copyright © 2010 - 2018 Road Trip - All Rights Reserved</p>
    </div>

    <div id="login">
        <div id="login-content">
            <div>
                <h3>Ingresar</h3>
                <span id="closeModal">&times;</span>
            </div>
            <form class="login-form" id="loginForm" method="post">
                <label for="email">Dirección de Correo</label>
                <input id="email" class="type-text" type="email" name="emailLogin" autocomplete="off" /> 
    
                <label for="pass">Contraseña</label>
                <input id="pass" class="type-pass" type="password" name="passwordLogin" autocomplete="off" />
        
                <?php if(isset($errorL)){ ?>
                    <script>
                        login.style.display = "initial";
                    </script>
                <div class="error-container">
                    <p id="error"><?php echo $errorL; ?></p>
                </div>

                <?php } ?>

                <input class="type-submit" type="submit" name="submitLogin" value="Ingresar"/>
                <a class="secondary_btn" id="notRegistered" href="register.php"> ¿Aún no estás registrado?</a>
            </form>
        </div>
    </div>

<script type="text/javascript" src="js/login.js"></script>
</body>

</html>