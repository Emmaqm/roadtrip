<?php
session_start();
?>
<?php 
    include_once 'dbconfig.php';

    if(isset($_SESSION['tipo_usuario']) and $_SESSION['tipo_usuario'] == "empleado"){
        $ci = $_POST['ci'];
    }else{
        $ci = $_SESSION['ci'];
    }

    $cod_horario = $_POST['cod_horario'];
    $fecha_viaje = $_POST['fecha'];
    $cant_asientos = $_POST['cantAsientos'];
    $num_asientos = $_POST['numAsientos'];  

    $arrayReserva = $ciudadesClass->getReserva($ci, $cod_horario, $fecha_viaje);

    if(empty($arrayReserva)){
        if(isset($_SESSION['tipo_usuario']) and $_SESSION['tipo_usuario'] == "empleado"){   
            $ciudadesClass->reservar($ci, $cod_horario, $fecha_viaje, $cant_asientos, "1");
        }else{  
            $ciudadesClass->reservar($ci, $cod_horario, $fecha_viaje, $cant_asientos, "0");
        }

        for($i=0; $i < count($num_asientos); $i++){
            $ciudadesClass->asientos($ci, $cod_horario, $fecha_viaje, $num_asientos[$i]);
    
            if(!isset($asientosReservados))
                $asientosReservados = $num_asientos[$i];
            else{
                $asientosReservados = $asientosReservados . ", " . $num_asientos[$i];
            }
        }
        if(isset($_SESSION['tipo_usuario']) and $_SESSION['tipo_usuario'] == "empleado"){
            ?> 
                <h3>La venta ha sido realizada</h3>
                <p>La venta para el día <?php echo $fecha_viaje?> se ha realizado de forma correcta.<br> Número de asientos reservados: <?php echo $asientosReservados?></p>
                <p class="lastP">Preséntese con su Documento de Identidad en nuestro local para confirmar y abonar la reserva 24hs antes de la salida del coche.</p>
                
                <a class="atras" href="reservas.php">Realizar otra Venta</a>
                <a class="siguiente2" href="index.php">Volver al inicio</a>
            <?php    

        }else{

            if($cant_asientos > 1){
                ?> 
                <h3>Su reserva ha sido realizada</h3>
                <p>Su reserva para el día <?php echo $fecha_viaje?> se ha realizado de forma correcta.<br> Número de asientos reservados: <?php echo $asientosReservados?></p>
                <p class="lastP">Preséntese con su Documento de Identidad en nuestro local para confirmar y abonar la reserva 24hs antes de la salida del coche.</p>
                
                <a class="atras" href="reservas.php">Realizar otra reserva</a>
                <a class="siguiente2" href="index.php">Volver al inicio</a>
                <?php    
            }else{
                ?> 
                <h3>Su reserva ha sido realizada</h3>
                <p>Su reserva para el día <?php echo $fecha_viaje?> se ha realizado de forma correcta.<br> Número de asiento reservado: <?php echo $asientosReservados?></p>
                <p class="lastP">Preséntese con su Documento de Identidad en nuestro local para confirmar y abonar la reserva 24hs antes de la salida del coche.</p>
                <a class="atras" href="reservas.php">Realizar otra reserva</a>
                <a class="siguiente2" href="index.php">Volver al inicio</a>
                <?php    
            }

        }
    
        

    }else{

        if(isset($_SESSION['tipo_usuario']) and $_SESSION['tipo_usuario'] == "empleado"){
            ?> 
            <h3>Ya hay una venta realizada</h3>
            <p>Ya ha realizado una venta para este viaje con este número de documento</p>
            <br>
            <a class="atras" href="index.php">Volver al inicio</a>
            <?php    
        }else{
            ?> 
            <h3>Ya hay una reserva realizada</h3>
            <p>Ya ha realizado una reserva para este viaje a su nombre</p>
            <br>
            <a class="atras" href="index.php">Volver al inicio</a>
            <?php    
        }
    }
    


?>