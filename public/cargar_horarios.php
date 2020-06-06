<?php
session_start();
?>
<?php 
include_once 'dbconfig.php';

$origen = $_GET['origen'];
$destino = $_GET['destino'];
$dia = $_GET['dia'];

$id_origen = $ciudadesClass->getIdOrigen($origen);
$id_destino = $ciudadesClass->getIdOrigen($destino);

$arrayHorarios = $ciudadesClass->getHorario($id_origen, $id_destino, $dia);
    ?>
    <tr class="titleColumn">
        <th>Día</th>
        <th>Salida</th>
        <th>Llegada</th>
        <th>Precio</th>
    </tr>
<?php
if(sizeof($arrayHorarios) == 0){
    ?>
    <tr>
        <td class="fila" style="text-align:center;" colspan="4">No hay Viajes para este día.</td>
    </tr>
    <?php
}

for ($row = 0; $row < count($arrayHorarios) ; $row++) {
    ?>
    <tr class="fila">
        <td><?php echo $arrayHorarios[$row]['dia'] ?></td>
        <td><?php echo $arrayHorarios[$row]['hora_sale'] ?></td>
        <td><?php echo $arrayHorarios[$row]['hora_llega'] ?></td>
        <td>$<?php echo $arrayHorarios[$row]['precio'] ?></td>
    </tr>
    <?php
} 
?>