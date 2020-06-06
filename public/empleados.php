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
<link rel="stylesheet" href="css/empleados.css">
<link rel="stylesheet" href="css/index.css">

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

        if(isset($_SESSION['tipo_usuario']) and $_SESSION['tipo_usuario'] == "empleado"){ 
        }else{
            header('Location: error.php');
        }

    ?>
    <div class="header-index">
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
                <li><a href="empleados.php"><span class="active"></span>Empleados</a></li>
                <?php
            }else{
                ?>
                <li><a href="contact.php">Contacto</a></li>
                <?php
            }
            ?>
        </ul>
        </div>
        <div class="wrapper">
            <ul class="sidenav">
                <li><a id="pagarR" onclick="showPagoR();" href="javascript:void(0)">Pago de Pasajes con Reserva</a></li>
                <li><a id="agregar" onclick="showAgregar();" href="javascript:void(0)">Agregar Viajes</a></li>
                <li><a id="modificar" onclick="showModificar();" href="javascript:void(0)">Modificar Viajes</a></li>
                <li><a id="cancelar" onclick="showCancelar();" href="javascript:void(0)">Cancelar Viajes</a></li>
            </ul>
            <div class="content">
                <div id="pagoPasajeReserva">
                    <h2>Pago de Pasaje con Reserva</h2>

                    <label id="label" for="ciInput">Documento del Cliente</label>
                    <input onkeyup="cargarReservas();" style="background-color:transparent; width:30%;" id="ciInput" class="type-text" type="text" name="name" autocomplete="off" />
                    <table id="listaReservas">
                        
                    </table>
                </div>
                <div id="agregarViaje">
                    <h2>Agregar Viajes</h2>
                    <div class="select-viaje">
                    <div class="origen">
                        <p id="placeholderO" class="select"><span id="textOrigen">Origen</span><span id="openOrigenesBtn" class="fas fa-chevron-down arrow"></span></p>
                        <ul id="origenes">
                            <?php
                                $arrayOrigen = $ciudadesClass->getOrigenes();
                                $arrayCiudades = $ciudadesClass->getCiudades();

                                for($i=0; $i < count($arrayOrigen); $i++){
                                    ?><li onclick="addOrigen(this)"><?php echo $arrayCiudades[$arrayOrigen[$i]]; ?></li><hr> 
                                    <?php
                                }
                            ?>
                        </ul>
                    </div>

                    <div class="destino">
                        <p id="placeholderD" class="select"><span id="textDestino">Destino</span> <span id="openDestinosBtn" class="fas fa-chevron-down arrow"></span></p>
                        <ul id="destinos">
                        </ul>
                    </div>
                            
                    <select class="combo" id="dayCombo">
                        <option>Seleccione un día de la semana</option>
                        <option value="Lunes">Lunes</option>
                        <option value="Martes">Martes</option>
                        <option value="Miércoles">Miércoles</option>
                        <option value="Jueves">Jueves</option>
                        <option value="Viernes">Viernes</option>
                        <option value="Sábado">Sábado</option>
                        <option value="Domingo">Domingo</option>
                    </select>
                    </br>
                    </div>

                    <div class="inputss">
                        
                        <label id="salidaL" for="salida">Hora de Salida (ej.:11:00)</label>
                        <input style="background-color:transparent; ;display:inline-block" id="salida" class="type-text" type="text" name="salidaNS" autocomplete="off" />

                        <label id="llegadaL" for="llegada">Hora de Llegada (ej.:16:29)</label>
                        <input style="background-color:transparent; ;display:inline-block" id="llegada" class="type-text" type="text" name="llegadaN" autocomplete="off" />

                        <label id="precioL" for="precio">Precio</label>
                        <input style="background-color:transparent; width:15%;display:inline-block" id="precio" class="type-text" type="text" name="precioN" autocomplete="off" />

                    </div>

                    <a class="siguiente" onclick="agregar_viaje();" style="float:left; margin-top:30px;" id="agregar-Viaje" href="javascript:void(0)">Agregar Viaje<span class="fas fa-chevron-right"></span></a>
                    
                    <div id="aviso"></div>
                
                </div>
                <div id="cancelarViaje">
                    <h2>Cancelar Viajes</h2>
                        <select style="margin:0; margin-bottom:50px;" onchange="cargar_horarios();" class="combo" id="dayComboM">
                            <option>Seleccione un día de la semana</option>
                            <option value="Lunes">Lunes</option>
                            <option value="Martes">Martes</option>
                            <option value="Miércoles">Miércoles</option>
                            <option value="Jueves">Jueves</option>
                            <option value="Viernes">Viernes</option>
                            <option value="Sábado">Sábado</option>
                            <option value="Domingo">Domingo</option>
                        </select>
                             <br>
                        <label id="fechaL" for="fechaI">Día y Mes del Viaje (ej.: 03-08-2018)</label>
                        <input style="background-color:transparent;" id="fechaI" class="type-text" type="text" name="fechaInput" autocomplete="off" />

                        <br>
                        <table style="margin:0;" id="modificarHorario">

                        </table>
                                
                        <a class="siguiente" onclick="cancelar_viaje();" style="float:left; margin-top:30px;" id="cancelar-Viaje" href="javascript:void(0)">Cancelar Viaje<span class="fas fa-chevron-right"></span></a>
                                
                        <div id="avisoC"></div>
                    </div>  
                <div id="modificarViaje">
                    <h2>Modificar Viajes</h2>
                    <select style="margin:0; margin-bottom:50px;" onchange="cargar_horarios2();" class="combo" id="dayComboMV">
                            <option>Seleccione un día de la semana</option>
                            <option value="Lunes">Lunes</option>
                            <option value="Martes">Martes</option>
                            <option value="Miércoles">Miércoles</option>
                            <option value="Jueves">Jueves</option>
                            <option value="Viernes">Viernes</option>
                            <option value="Sábado">Sábado</option>
                            <option value="Domingo">Domingo</option>
                    </select>

                    <table style="margin:0;margin-bottom:50px;" id="modificarHorario2">

                    </table>
                               
                    <label id="salidaML" for="salidaM">Nueva Hora de Salida (ej.: 10:35)</label>
                    <input style="background-color:transparent;" id="salidaM" class="modificar" type="text" name="salidaMinput" autocomplete="off" />

                    <label id="llegadaML" for="llegadaM">Nueva Hora de Llegada (ej.: 13:00)</label>
                    <input style="background-color:transparent;" id="llegadaM" class="modificar" type="text" name="salidaMinput" autocomplete="off" />

                    <a class="siguiente" onclick="modificar_viaje();" style="float:left; margin-top:30px;" id="modificar-Viaje" href="javascript:void(0)">Modificar Viaje<span class="fas fa-chevron-right"></span></a>
                
                    <div id="avisoM"></div>
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
    <script type="text/javascript" src="js/empleados.js"></script>
    <script type="text/javascript" src="js/horarios.js"></script>
</body>

</html>