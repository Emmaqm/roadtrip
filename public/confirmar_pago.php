<?php
session_start();
?>
<?php 
    include_once 'dbconfig.php';

    $ci_usuario = $_POST['ci_usuario'];
    $cod_horario = $_POST['cod_horario'];
    $fecha_viaje = $_POST['fecha_viaje'];
    $pago = "1";

    $ciudadesClass->updatePago($ci_usuario, $cod_horario, $fecha_viaje, $pago);

    $success = "La reserva se ha abonado exitosamente.";

?>

    <div id="success-container">
        <p id="success"><?php echo $success; ?></p>
    </div>