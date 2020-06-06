<?php
session_start();
?>
<?php 
    include_once 'dbconfig.php';

    $cedula = $_POST['cedula'];

    $reservas = $ciudadesClass->getReservaByci($cedula, "0");
?>
    <tr class="titleColumn">
        <th>Fecha</th>
        <th>Origen</th>
        <th>Destino</th>
        <th>Salida</th>
        <th>Cantidad Asientos</th>
        <th>Elegir</th>
    </tr>

    <?php 

        if(sizeof($reservas) == 0){
            ?>
            <tr>
                <td class="fila" style="text-align:center;" colspan="6">No hay Reservas Realizadas.</td>
            </tr>
            <?php
        }
       
    
        for ($row = 0; $row < count($reservas) ; $row++) {
           $horario = $ciudadesClass->getHorarioByCod($reservas[$row]['cod_horario']);

           $id_origen = $ciudadesClass->getNomCiudad($horario['id_origen']);
           $id_destino = $ciudadesClass->getNomCiudad($horario['id_destino']);

           $stringReserva = $cedula . "/" . $reservas[$row]['cod_horario'] . "/" . $reservas[$row]['fecha_viaje'];

           $horaSV = date("H");
           $diaSV = date("d");
           $diaSVmas = $diaSV + 1;
           $mesSV = date("m");

           $fechaArray = explode('-', $reservas[$row]['fecha_viaje']);
           $horaArray = explode(':', $horario['hora_sale']);

           $dia = $fechaArray[0];
           $hora = $horaArray[0];
           $mes = $fechaArray[1];

           
           if($mes < $mesSV and $horaSV >= $hora and $diaSVmas == $dia){ //viaje dia despues, depende de que hora si se muestra o no
           
            }else if($diaSVmas > $dia and $mes < $mesSV){ //viaje mismo dia y anteriores, nunca se muestran

           }else if($reservas[$row]['cancelado'] == "1"){

           }else{ 
               ?>
               <tr class="fila">
                   <td><?php echo $reservas[$row]['fecha_viaje'] ?></td>
                   <td><?php echo $id_origen ?></td>
                   <td><?php echo $id_destino ?></td>
                   <td><?php echo $horario['hora_sale'] ?></td>
                   <td><?php echo $reservas[$row]['cant_asientos'] ?></td>
                   
                   <td class="reservaCheck">
                       <input type="radio" value="<?php echo $stringReserva ?>" id="cb<?php echo $row ?>" name="elegirViaje"/>
                       <label for="cb<?php echo $row ?>" class="check-box"></label>
                   </td>
               </tr>
               <?php

           }
        }
        ?> 
    <tr>
        <td colspan="6">
            <?php
                if(!sizeof($reservas) == 0){
                    ?>
                    <a class="siguiente" onclick="selectReserva();" id="seleccionar_viaje" href="javascript:void(0)">Confirmar Pago<span class="fas fa-chevron-right"></span></a>
                    <?php
                }
            ?>
        </td>
    </tr>