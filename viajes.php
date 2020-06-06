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
<link rel="stylesheet" href="css/viajes.css">

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

        if(!isset($_GET['origen'])){
            header('Location: error.php');
        }

        $origenViaje = $_GET['origen'];
        $destinoViaje = $_GET['destino'];
        $fechaViaje = $_GET['fecha'];
        $diaViaje = $_GET['dia'];

        $origenAbreviacion = $ciudadesClass->getAbreviacion($origenViaje);
        $destinoAbreviacion = $ciudadesClass->getAbreviacion($destinoViaje);

        $id_origen = $ciudadesClass->getIdOrigen($origenViaje);
        $id_destino = $ciudadesClass->getIdOrigen($destinoViaje);

        $horariosDia = $ciudadesClass->getHorario($id_origen, $id_destino, $diaViaje);

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
        <h1><span class="inicialOrigen"><?php echo $origenAbreviacion ?></span> <img id="recorridoimg" src="img/recorrido.png"> <span class="inicialDestino"><?php echo $destinoAbreviacion ?></span></h1>
    </div>

    <div class="horario-viaje">
        <table>
            <tr>
                <td class="tableHeader" colspan="5">
                    Viajes de <span id="origenSpan"><?php echo $origenViaje ?></span> a <span class="destinoSpan"><?php echo $destinoViaje ?> </span>el <span id="fechaSpan"><?php echo $fechaViaje ?></span>
                </td>
            </tr>
            <tr class="titleColumn">
                <th>Salida</th>
                <th>Llegada</th>
                <th>Precio</th>
                <th>Asientos Disponibles</th>
                <th>Elegir</th>
            </tr>

            <?php 

                if(sizeof($horariosDia) == 0){
                    ?>
                    <tr>
                        <td class="fila" style="text-align:center;" colspan="5">No hay Viajes Disponibles.</td>
                    </tr>
                    <?php
                }
                

                for ($row = 0; $row < count($horariosDia) ; $row++) {
                    
                    $horaSV = date("H");
                    $diaSV = date("d");
                    $mesSV = date('m');

                    $diaSVmas = $diaSV + 1;

                    $fechaArray = explode('-', $fechaViaje);
                    $horaArray = explode(':', $horariosDia[$row]['hora_sale']);

                    $dia = $fechaArray[0];
                    $hora = $horaArray[0];
                    $mes = $fechaArray[1];

                    if(($horaSV >= $hora and $diaSVmas == $dia and $mesSV >= $mes) or ($diaSV <= $dia and $mesSV >= $mes)){
                        $pago = "0";

                        $cedulaReservas = $ciudadesClass->getCiReserva($horariosDia[$row]['codigo'], $fechaViaje, $pago);

                        for($i = 0; $i < count($cedulaReservas); $i++){
                            $ciudadesClass->deleteAsientos($cedulaReservas[$i],$horariosDia[$row]['codigo'], $fechaViaje);
                        }

                        $ciudadesClass->deleteReserva($horariosDia[$row]['codigo'], $fechaViaje, $pago);

                    }

                    if((($dia > $diaSVmas and $mes >= $mesSV) or ($dia == $diaSVmas and $hora >= $horaSV and $mes >= $mesSV)) or ((isset($_SESSION['tipo_usuario']) and $_SESSION['tipo_usuario'] == "empleado") and ($hora >= $horaSV and $dia >= $diaSV and $mes >= $mesSV))){
                        
                        $codigoViaje = $horariosDia[$row]['codigo'];
                    
                        $asientosReserva = $ciudadesClass->getCantAsientos($codigoViaje, $fechaViaje);
                        $cancelado = $ciudadesClass->getCancelado($codigoViaje, $fechaViaje);
        
                        $asientosReservados = 40 - array_sum($asientosReserva);

                        if($cancelado == "0"){///////////
                            ?>
                            <tr class="fila">
                                <td><?php echo $horariosDia[$row]['hora_sale'] ?></td>
                                <td><?php echo $horariosDia[$row]['hora_llega'] ?></td>
                                <td>$<?php echo $horariosDia[$row]['precio'] ?></td>
                                <td class="asientosDisponibles"><?php echo $asientosReservados ?></td>
                                
                                <td class="reservaCheck">
        
                                <?php
                                if($asientosReservados != 0){
                                ?>
                                <input type="radio" value="<?php echo $horariosDia[$row]['codigo']?>" id="cb<?php echo $horariosDia[$row]['codigo']?>" name="elegirViaje"/>
                                <label for="cb<?php echo $horariosDia[$row]['codigo'] ?>" class="check-box"></label>
                                <?php
                                }
                                ?>
                                </td>
                            </tr>
                            <?php
                        }

                    }
                }
                ?>          
            <tr>
                <td colspan="5">
                    <a class="atras" href="reservas.php"><span class="fas fa-chevron-left"></span>Volver Atrás</a>
                    <?php
                        if(!sizeof($horariosDia) == 0){
                            ?>
                            <a class="siguiente" id="seleccionar_viaje" href="lugares.php">Siguiente<span class="fas fa-chevron-right"></span></a>
                            <?php
                        }
                    ?>
                </td>
            </tr>
        </table>
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
    <script type="text/javascript" src="js/viajes.js"></script>
</body>

</html>