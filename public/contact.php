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
    <link rel="stylesheet" href="css/contact.css">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
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
            <li><a href="destinations.php">Destinos</a></li>
            <?php
            if(isset($_SESSION['tipo_usuario']) and $_SESSION['tipo_usuario'] == "empleado"){
                ?>
                <li><a href="empleados.php">Empleados</a></li>
                <?php
            }else{
                ?>
                <li><a href="contact.php"><span class="active"></span>Contacto</a></li>
                <?php
            } 
            ?>
        </ul>
        <h1>Contáctenos</h1>
    </div>

    <div class="container">
        <div class="address">
            <h3>Visítanos</h3>
            <div class="address-content">
                <p><svg enable-background="new 0 0 32 32" height="32px" id="Layer_1" version="1.1" viewBox="0 0 32 32" width="32px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><polyline fill="none" points="   649,137.999 675,137.999 675,155.999 661,155.999  " stroke="#FFFFFF" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"/><polyline fill="none" points="   653,155.999 649,155.999 649,141.999  " stroke="#FFFFFF" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"/><polyline fill="none" points="   661,156 653,162 653,156  " stroke="#FFFFFF" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"/></g><g><g><path d="M16,27c-0.23,0-0.461-0.079-0.648-0.238c-0.242-0.206-5.942-5.1-8.32-10.438c-0.225-0.504,0.002-1.096,0.507-1.32    c0.503-0.224,1.095,0.002,1.32,0.507c1.739,3.905,5.577,7.699,7.124,9.13C18.713,21.991,24,16.069,24,12.23    C24,7.692,20.411,4,16,4s-8,3.692-8,8.23c0,0.552-0.448,1-1,1s-1-0.448-1-1C6,6.589,10.486,2,16,2c5.514,0,10,4.589,10,10.23    c0,5.912-8.944,14.159-9.325,14.508C16.484,26.912,16.242,27,16,27z"/></g><g><path d="M16,16c-2.206,0-4-1.794-4-4s1.794-4,4-4c2.206,0,4,1.794,4,4S18.206,16,16,16z M16,10c-1.103,0-2,0.897-2,2s0.897,2,2,2    c1.103,0,2-0.897,2-2S17.103,10,16,10z"/></g><g><path d="M29,30H3c-0.356,0-0.686-0.189-0.865-0.498c-0.179-0.309-0.18-0.688-0.003-0.998l4-7c0.274-0.479,0.885-0.647,1.364-0.372    c0.479,0.274,0.646,0.885,0.372,1.364L4.723,28h22.553l-3.145-5.504c-0.274-0.479-0.107-1.09,0.372-1.364    c0.479-0.276,1.09-0.107,1.364,0.372l4,7c0.177,0.31,0.176,0.689-0.003,0.998C29.686,29.811,29.356,30,29,30z"/></g></g></svg>Shopping Tres Cruces, Local 27</p>
                <p><svg enable-background="new 0 0 32 32" height="32px" id="Layer_1" version="1.1" viewBox="0 0 32 32" width="32px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><polyline fill="none" points="   649,137.999 675,137.999 675,155.999 661,155.999  " stroke="#FFFFFF" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"/><polyline fill="none" points="   653,155.999 649,155.999 649,141.999  " stroke="#FFFFFF" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"/><polyline fill="none" points="   661,156 653,162 653,156  " stroke="#FFFFFF" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"/></g><g><g><path d="M14.626,18.4c-0.256,0-0.512-0.098-0.707-0.293l-4.171-4.17c-0.188-0.188-0.293-0.442-0.293-0.707s0.105-0.52,0.293-0.707    l2.434-2.433c0.76-0.76,0.76-1.997,0-2.757l-2.78-2.78c-0.737-0.736-2.021-0.737-2.758,0c-0.044,0.044-0.093,0.084-0.145,0.12    c-0.115,0.08-2.906,2.076-2.448,6.198c0.061,0.549-0.334,1.043-0.883,1.104c-0.544,0.063-1.043-0.334-1.104-0.883    C1.51,6.114,4.713,3.505,5.291,3.078c1.497-1.436,4.051-1.412,5.524,0.06l2.78,2.78c1.54,1.54,1.54,4.045,0,5.585L11.87,13.23    l3.463,3.463c0.391,0.391,0.391,1.023,0,1.414C15.138,18.303,14.882,18.4,14.626,18.4z"/></g><g><path d="M9.76,23.266c-0.256,0-0.512-0.098-0.707-0.293c-2.457-2.457-4.296-4.855-5.467-7.128    c-0.253-0.491-0.06-1.094,0.431-1.347c0.493-0.253,1.094-0.059,1.347,0.431c1.076,2.089,2.792,4.32,5.103,6.63    c0.391,0.391,0.391,1.023,0,1.414C10.271,23.169,10.016,23.266,9.76,23.266z"/></g><g><path d="M21.992,29.982c-3.937,0-8.299-2.369-12.984-7.055c-0.391-0.391-0.391-1.023,0-1.414s1.023-0.391,1.414,0    c4.539,4.54,8.778,6.762,12.284,6.436c3.09-0.292,4.588-2.445,4.603-2.468c0.035-0.052,0.075-0.101,0.12-0.145    C27.797,24.969,28,24.478,28,23.958s-0.203-1.01-0.571-1.378l-2.78-2.781c-0.368-0.368-0.858-0.57-1.38-0.57l0,0    c-0.521,0-1.01,0.202-1.377,0.57l-2.435,2.433c-0.391,0.391-1.023,0.391-1.414,0l-4.169-4.169c-0.391-0.391-0.391-1.023,0-1.414    s1.023-0.391,1.414,0l3.462,3.462l1.727-1.726c0.745-0.746,1.736-1.157,2.792-1.157l0,0c1.056,0,2.048,0.411,2.794,1.156    l2.78,2.782C29.589,21.911,30,22.903,30,23.958c0,1.026-0.389,1.993-1.097,2.731c-0.364,0.492-2.327,2.903-6.009,3.251    C22.597,29.969,22.295,29.982,21.992,29.982z"/></g></g></svg>(+598) 2901 2874</p>
                <p><svg enable-background="new 0 0 32 32" height="32px" id="Layer_1" version="1.1" viewBox="0 0 32 32" width="32px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><polyline fill="none" points="   649,137.999 675,137.999 675,155.999 661,155.999  " stroke="#FFFFFF" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"/><polyline fill="none" points="   653,155.999 649,155.999 649,141.999  " stroke="#FFFFFF" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"/><polyline fill="none" points="   661,156 653,162 653,156  " stroke="#FFFFFF" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"/></g><g><path d="M29,27H3c-0.552,0-1-0.447-1-1V10c0-0.552,0.448-1,1-1s1,0.448,1,1v15h24V7H3C2.448,7,2,6.552,2,6s0.448-1,1-1h26   c0.553,0,1,0.448,1,1v20C30,26.553,29.553,27,29,27z"/></g><g><path d="M16,19c-0.256,0-0.512-0.098-0.707-0.293l-8-8c-0.391-0.391-0.391-1.023,0-1.414s1.023-0.391,1.414,0L16,16.586   l7.293-7.293c0.391-0.391,1.023-0.391,1.414,0s0.391,1.023,0,1.414l-8,8C16.512,18.902,16.256,19,16,19z"/></g><g><path d="M24.001,23c-0.256,0-0.512-0.098-0.707-0.293l-3.002-3.002c-0.391-0.391-0.391-1.023,0-1.414s1.023-0.391,1.414,0   l3.002,3.002c0.391,0.391,0.391,1.023,0,1.414C24.513,22.902,24.257,23,24.001,23z"/></g><g><path d="M8.001,23c-0.256,0-0.512-0.098-0.707-0.293c-0.391-0.391-0.391-1.023,0-1.414l2.999-2.999   c0.391-0.391,1.023-0.391,1.414,0s0.391,1.023,0,1.414l-2.999,2.999C8.513,22.902,8.257,23,8.001,23z"/></g></svg>roadtripbuses2018@gmail.com</p>
            </div>
        </div>
        <div id="map"></div>
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
    <script type="text/javascript" src="js/contact.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4lx2nCDPxgIQmy-B5HTbBtc-mvorIYcI&callback=myMap"></script>
</body>

</html>