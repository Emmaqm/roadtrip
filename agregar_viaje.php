<?php
session_start();
?>
<?php 
include_once 'dbconfig.php';

$origen = $_POST['origen'];
$destino = $_POST['destino'];
$day = $_POST['day'];
$salida = $_POST['salida'];
$llegada = $_POST['llegada'];
$precio = $_POST['precio'];

$id_origen = $ciudadesClass->getIdOrigen($origen);
$id_destino = $ciudadesClass->getIdOrigen($destino);

if($origen != "" and $destino != "" and $day != "" and $salida != "" and $llegada != "" and $precio != "" ){
    $ciudadesClass->insertViaje($day, $salida, $llegada, $precio, $id_origen, $id_destino);
    $success = "Se ha agregado el viaje de forma exitosa";
}else{
    $error = "Complete todos los datos";
}

if(isset($success)){
?>
<div style="margin-top:140px; width: 40%;" id="success-container">
    <p id="success"><?php echo $success; ?></p>
</div>
<?php
}else{
 ?>
<div style="margin-top:140px; width: 40%;" class="error-container">
    <p id="error"><?php echo $error; ?></p>
</div>
<?php
}
?>