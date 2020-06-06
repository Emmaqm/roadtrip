<?php
session_start();
?>
<?php 
include_once 'dbconfig.php';

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



if(isset($_POST['cod_horario'])){

    $fecha_viaje = $_POST['fecha'];
    $cod_horario = $_POST['cod_horario'];
    $cancelado = "1";
    $ciauto = "0";
    $cant_asientos = "0";

    if($fecha_viaje != "" and $cod_horario != ""){
        $ciudadesClass->insertCancel($ciauto, $cod_horario, $fecha_viaje,$cant_asientos);

        $ciudadesClass->updateCancelado($cod_horario, $fecha_viaje, $cancelado);

        
        $cedulas = $ciudadesClass->getCiMail($cod_horario, $fecha_viaje);

        for($i=0;$i < count($cedulas); $i++){
            if($cedulas[$i] == 0){

            }else{
            $mail2 = $ciudadesClass->getMail($cedulas[$i]);

            $mail = new PHPMailer(true);  
            
            try {
                //Server settings                               // Enable verbose debug output
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'roadtripbuses2018@gmail.com';                 // SMTP username
                $mail->Password = 'roadtripta1';       
                $mail->SMTPSecure = 'ssl';                    // SMTP password
                $mail->Port = 465;                                    // TCP port to connect to
                
            
                //Recipients
                $mail->setFrom('roadtripbuses2018@gmail.com', 'Road Trip');
                $mail->addAddress($mail2);               // Name is optional
                $mail->addReplyTo('roadtripbuses2018@gmail.com', 'Road Trip');
    
                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Cancelacion de Reserva';
                $mail->Body    = 'Buenos dias,<br>La reserva para el día '. $fecha_viaje . ' ha sido cancelada. <br>Disculpe las molestias causadas, <br>El equipo de Road Trip.';
            
                $mail->send();
                $success = "Se ha cancelado la reserva con exito.";
            } catch (Exception $e) {
            }
         }
        }
    }else{
        $error = "Complete todos los datos";
    }
    
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