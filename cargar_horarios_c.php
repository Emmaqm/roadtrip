<?php
session_start();
?>
<?php 
include_once 'dbconfig.php';

$dia = $_POST['dia'];

$horarios = $ciudadesClass->getHorarioByDia($dia);

?>
    <tr class="titleColumn">
        <th>Día</th>
        <th>Salida</th>
        <th>Llegada</th>
        <th>Origen</th>
        <th>Destino</th>
        <th>Elegir</th>
    </tr>

<?php 

for($row=0; $row < count($horarios); $row++){

    $nom_origen = $ciudadesClass->getNomCiudad($horarios[$row]['id_origen']);
    $nom_destino = $ciudadesClass->getNomCiudad($horarios[$row]['id_destino']);

    ?>
    <tr class="fila">
        <td><?php echo $horarios[$row]['dia'] ?></td>
        <td><?php echo $horarios[$row]['hora_sale'] ?></td>
        <td><?php echo $horarios[$row]['hora_llega'] ?></td>
        <td><?php echo $nom_origen ?></td>
        <td><?php echo $nom_destino ?></td>
        
        <td class="reservaCheck">
            <input type="radio" value="<?php echo $horarios[$row]['codigo'] ?>" id="cb<?php echo $horarios[$row]['codigo']  ?>" name="elegirHorario2"/>
            <label for="cb<?php echo $horarios[$row]['codigo']  ?>" class="check-box"></label>
        </td>
    </tr>
    <?php
}
?>