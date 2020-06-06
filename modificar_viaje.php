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

    $codigo = $_POST['codigo'];
    $salida = $_POST['salida'];
    $llegada = $_POST['llegada'];

    $horarioViejo = $ciudadesClass->getHorarioByCod($codigo);

    $ciudadesClass->updateViaje($codigo, $salida, $llegada);

    $cedulas = $ciudadesClass->getciCodigo($codigo);

    for($i=0;$i < count($cedulas); $i++){
        if($cedulas[$i] == 0){

        }else{
        $mail2 = $ciudadesClass->getMail($cedulas[$i]);

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
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
            $mail->Body    = 'Buenos dias,<br>Su viajes para el día ' .$horarioViejo['dia']. ' ha sido modificado. <br>Hora de salida anterior: '. $horarioViejo['hora_sale'] .'<br>Horario nuevo de salida: '.$salida.'<br>Disculpe las molestias causadas, <br>El equipo de Road Trip.';
        
            $mail->send();
            $success = "Horario modificado exitosamente.";
        } catch (Exception $e) {
        }
    }
   }
?>

    <div style="margin-top:140px; width: 40%;" id="success-container">
        <p id="success"><?php echo $success; ?></p>
    </div>