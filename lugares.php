<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Road Trip Buses</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

<link rel="stylesheet" href="css/common_style.css">
<link rel="stylesheet" href="css/lugares.css">
<link href="dist/helloweek.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

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

        if(!isset($_GET['codViaje'])){
            header('Location: error.php');
        }
    ?>
    <div id="loginR">
        <div id="login-content">
            <div>
                <h3 id="tituloLogin">Ingresar</h3>
                <span id="closeModal">&times;</span>
            </div>
            <form class="login-form" id="loginForm" method="post">
                <label for="email">Dirección de Correo</label>
                <input id="email" class="type-text" type="email" name="emailLogin" autocomplete="off" /> 
    
                <label for="pass">Contraseña</label>
                <input id="pass" class="type-pass" type="password" name="passwordLogin" autocomplete="off" />
                      
                <?php if(isset($errorL)){ ?>
                    <script>
                        loginR.style.display = "initial";
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
    
    <?php
        if(!isset($_SESSION['loggedin'])){
            ?> 
            <script>
            loginR.style.display = "initial";
            closeModal.style.display = "none";
            tituloLogin.innerText = "Para Continuar Inicie Sesión";
            </script>
            <?php
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
                <li><a href="reservas.php"><span class="active"></span>Venta de Pasajes</a></li>
                <?php
            }else{
                ?>
                <li><a href="reservas.php"><span class="active"></span>Reservas</a></li>
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
                <li><a href="contact.php">Contacto</a></li>
                <?php
            }
            
            ?>
        </ul>
        <h1>Elija su Asiento</h1>
    </div>

    <div class="lugares-content">
        <div class="lugares-table">
            <?php
            if(isset($_SESSION['tipo_usuario']) and $_SESSION['tipo_usuario'] == "empleado"){
                ?>
                <table class="lugares">
                <tr class="row">
                    <td id="1" class="empty" onclick="venderAsiento(this)">1</td>
                    <td id="2" class="empty" onclick="venderAsiento(this)">2</td>
                    <td class="pasillo"></td>
                    <td id="3" class="empty" onclick="venderAsiento(this)">3</td>
                    <td id="4" class="empty" onclick="venderAsiento(this)">4</td>
                </tr>
                <tr class="row">
                    <td id="5" class="empty" onclick="venderAsiento(this)">5</td>
                    <td id="6" class="empty" onclick="venderAsiento(this)">6</td>
                    <td class="pasillo"></td>
                    <td id="7" class="empty" onclick="venderAsiento(this)">7</td>
                    <td id="8" class="empty" onclick="venderAsiento(this)">8</td>
                </tr>
                <tr class="row">
                    <td id="9" class="empty" onclick="venderAsiento(this)">9</td>
                    <td id="10" class="empty" onclick="venderAsiento(this)">10</td>
                    <td class="pasillo"></td>
                    <td id="11" class="empty" onclick="venderAsiento(this)">11</td>
                    <td id="12" class="empty" onclick="venderAsiento(this)">12</td>
                </tr>
                <tr class="row">
                    <td id="13" class="empty" onclick="venderAsiento(this)">13</td>
                    <td id="14" class="empty" onclick="venderAsiento(this)">14</td>
                    <td class="pasillo"></td>
                    <td id="15" class="empty" onclick="venderAsiento(this)">15</td>
                    <td id="16" class="empty" onclick="venderAsiento(this)">16</td>
                </tr>
                <tr class="row">
                    <td id="17" class="empty" onclick="venderAsiento(this)">17</td>
                    <td id="18" class="empty" onclick="venderAsiento(this)">18</td>
                    <td class="pasillo"></td>
                    <td id="19" class="empty" onclick="venderAsiento(this)">19</td>
                    <td id="20" class="empty" onclick="venderAsiento(this)">20</td>
                </tr>
                <tr class="row">
                    <td id="21" class="empty" onclick="venderAsiento(this)">21</td>
                    <td id="22" class="empty" onclick="venderAsiento(this)">22</td>
                    <td class="pasillo"></td>
                    <td id="23" class="empty" onclick="venderAsiento(this)">23</td>
                    <td id="24" class="empty" onclick="venderAsiento(this)">24</td>
                </tr>
                <tr class="row">
                    <td id="25" class="empty" onclick="venderAsiento(this)">25</td>
                    <td id="26" class="empty" onclick="venderAsiento(this)">26</td>
                    <td class="pasillo"></td>
                    <td id="27" class="empty" onclick="venderAsiento(this)">27</td>
                    <td id="28" class="empty" onclick="venderAsiento(this)">28</td>
                </tr>
                <tr class="row">
                    <td id="29" class="empty" onclick="venderAsiento(this)">29</td>
                    <td id="30" class="empty" onclick="venderAsiento(this)">30</td>
                    <td class="pasillo"></td>
                    <td id="31" class="empty" onclick="venderAsiento(this)">31</td>
                    <td id="32" class="empty" onclick="venderAsiento(this)">32</td>
                </tr>
                <tr class="row">
                    <td id="33" class="empty" onclick="venderAsiento(this)">33</td>
                    <td id="34" class="empty" onclick="venderAsiento(this)">34</td>
                    <td class="pasillo"></td>
                    <td id="35" class="empty" onclick="venderAsiento(this)">35</td>
                    <td id="36" class="empty" onclick="venderAsiento(this)">36</td>
                </tr>
                <tr class="row">
                    <td id="37" class="empty" onclick="venderAsiento(this)">37</td>
                    <td id="38" class="empty" onclick="venderAsiento(this)">38</td>
                    <td class="pasillo"></td>
                    <td id="39" class="empty" onclick="venderAsiento(this)">39</td>
                    <td id="40" class="empty" onclick="venderAsiento(this)">40</td>
                </tr>
            </table>
                <?php
            }else{
                ?>
                <table class="lugares">
                <tr class="row">
                    <td id="1" class="empty" onclick="selectAsiento(this)">1</td>
                    <td id="2" class="empty" onclick="selectAsiento(this)">2</td>
                    <td class="pasillo"></td>
                    <td id="3" class="empty" onclick="selectAsiento(this)">3</td>
                    <td id="4" class="empty" onclick="selectAsiento(this)">4</td>
                </tr>
                <tr class="row">
                    <td id="5" class="empty" onclick="selectAsiento(this)">5</td>
                    <td id="6" class="empty" onclick="selectAsiento(this)">6</td>
                    <td class="pasillo"></td>
                    <td id="7" class="empty" onclick="selectAsiento(this)">7</td>
                    <td id="8" class="empty" onclick="selectAsiento(this)">8</td>
                </tr>
                <tr class="row">
                    <td id="9" class="empty" onclick="selectAsiento(this)">9</td>
                    <td id="10" class="empty" onclick="selectAsiento(this)">10</td>
                    <td class="pasillo"></td>
                    <td id="11" class="empty" onclick="selectAsiento(this)">11</td>
                    <td id="12" class="empty" onclick="selectAsiento(this)">12</td>
                </tr>
                <tr class="row">
                    <td id="13" class="empty" onclick="selectAsiento(this)">13</td>
                    <td id="14" class="empty" onclick="selectAsiento(this)">14</td>
                    <td class="pasillo"></td>
                    <td id="15" class="empty" onclick="selectAsiento(this)">15</td>
                    <td id="16" class="empty" onclick="selectAsiento(this)">16</td>
                </tr>
                <tr class="row">
                    <td id="17" class="empty" onclick="selectAsiento(this)">17</td>
                    <td id="18" class="empty" onclick="selectAsiento(this)">18</td>
                    <td class="pasillo"></td>
                    <td id="19" class="empty" onclick="selectAsiento(this)">19</td>
                    <td id="20" class="empty" onclick="selectAsiento(this)">20</td>
                </tr>
                <tr class="row">
                    <td id="21" class="empty" onclick="selectAsiento(this)">21</td>
                    <td id="22" class="empty" onclick="selectAsiento(this)">22</td>
                    <td class="pasillo"></td>
                    <td id="23" class="empty" onclick="selectAsiento(this)">23</td>
                    <td id="24" class="empty" onclick="selectAsiento(this)">24</td>
                </tr>
                <tr class="row">
                    <td id="25" class="empty" onclick="selectAsiento(this)">25</td>
                    <td id="26" class="empty" onclick="selectAsiento(this)">26</td>
                    <td class="pasillo"></td>
                    <td id="27" class="empty" onclick="selectAsiento(this)">27</td>
                    <td id="28" class="empty" onclick="selectAsiento(this)">28</td>
                </tr>
                <tr class="row">
                    <td id="29" class="empty" onclick="selectAsiento(this)">29</td>
                    <td id="30" class="empty" onclick="selectAsiento(this)">30</td>
                    <td class="pasillo"></td>
                    <td id="31" class="empty" onclick="selectAsiento(this)">31</td>
                    <td id="32" class="empty" onclick="selectAsiento(this)">32</td>
                </tr>
                <tr class="row">
                    <td id="33" class="empty" onclick="selectAsiento(this)">33</td>
                    <td id="34" class="empty" onclick="selectAsiento(this)">34</td>
                    <td class="pasillo"></td>
                    <td id="35" class="empty" onclick="selectAsiento(this)">35</td>
                    <td id="36" class="empty" onclick="selectAsiento(this)">36</td>
                </tr>
                <tr class="row">
                    <td id="37" class="empty" onclick="selectAsiento(this)">37</td>
                    <td id="38" class="empty" onclick="selectAsiento(this)">38</td>
                    <td class="pasillo"></td>
                    <td id="39" class="empty" onclick="selectAsiento(this)">39</td>
                    <td id="40" class="empty" onclick="selectAsiento(this)">40</td>
                </tr>
            </table>
                <?php
            }
            
            ?>
            
        </div>

        <?php
            $fecha_viaje = $_GET['fecha'];
            $cod_horario = $_GET['codViaje'];

            $asientosReservados = $ciudadesClass->getAsientosReservados($cod_horario, $fecha_viaje);

            for($i=0;$i < count($asientosReservados); $i++){
        ?>
                <script>
                $('#<?php echo $asientosReservados[$i]?>').removeClass('empty').addClass('reserved2');
                </script>
        <?php
            }

            $cipagados = $ciudadesClass->getciVendidos($cod_horario, $fecha_viaje);

            $asientosVendidos = array();

            if(!empty($cipagados)){
                if(count($cipagados) > 1){
                    for($y=0 ; $y < count($cipagados); $y++){
                        $vendidos = $ciudadesClass->getAsientosVendidos($cipagados[$y], $cod_horario, $fecha_viaje);
                        $asientosVendidos = array_merge($vendidos, $asientosVendidos);
                    }
                }else{
                    $asientosVendidos = $ciudadesClass->getAsientosVendidos($cipagados[0], $cod_horario, $fecha_viaje);
                }

            }

        for($i=0;$i < count($asientosReservados); $i++){
        ?>
                <script>
                $('#<?php echo $asientosReservados[$i]?>').removeClass('empty').addClass('reserved2');
                </script>
        <?php
            }
        
        for($i=0;$i < count($asientosVendidos); $i++){
        ?>
                <script>
                $('#<?php echo $asientosVendidos[$i]?>').removeClass('reserved2').addClass('buyed');
                </script>
        <?php
            } 
        ?>
        
        <div class="side-container">
            <div class="square-container">
                <span class="square-disponible"></span>
                <p class="square-text"> Asientos Disponibles</p>
            </div>
            <div class="square-container">
                <span class="square-reservado"></span>
                <p class="square-text"> Asientos Reservados</p>
            </div>
            <div class="square-container">
                <span class="square-vendido"></span>
                <p class="square-text"> Asientos Vendidos</p>
            </div>
            <hr style="margin-bottom:30px;">

            <?php
            if(isset($_SESSION['tipo_usuario']) and $_SESSION['tipo_usuario'] == "empleado"){
                ?>
                <label id="label" for="ciInput">Documento del Comprador</label>
                <input style="background-color:transparent;" id="ciInput" class="type-text" type="text" name="name" autocomplete="off" />
                <a class="siguiente" onclick="venderPasaje();" href="javascript:void(0)">Vender<span class="fas fa-chevron-right"></span></a>
                <?php
            }else{
                if(isset($_SESSION['loggedin'])){
                    ?>
                    <a class="siguiente" onclick="reservarPasaje();" href="javascript:void(0)">Reservar<span class="fas fa-chevron-right"></span></a>
                    <?php
                }
            }
            
            ?>
        </div>
    </div>

    <div class="paymentP">
        <p>El pago del pasaje reservado debe efectuarse de forma presencial 24hs antes de la salida del coche, de lo contrario se cancelará la reserva automáticamente.</p>
    </div>

    <div id="popupReserva">
        <div id="popupReserva-content">
            

            <div id="reservaRealizada"></div>

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
    <script type="text/javascript" src="js/login.js"></script>
    <script type="text/javascript" src="js/lugares.js"></script>
    <script type="text/javascript" src="js/empleados.js"></script>
</body>

</html>