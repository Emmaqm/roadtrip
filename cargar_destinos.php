<?php
session_start();
?>
<?php 
include_once 'dbconfig.php';

$origen = $_GET['origen'];

$idOrigen = $ciudadesClass->getIdOrigen($origen);
$arrayDestino = $ciudadesClass->getDestinos($idOrigen);
$arrayCiudades = $ciudadesClass->getCiudades();

for($i=0; $i < count($arrayDestino); $i++){
    ?><li onclick="addDestino(this)"><?php echo $arrayCiudades[$arrayDestino[$i]]; ?></li><hr> 
    <?php
}

?>  