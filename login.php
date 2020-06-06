<?php

if(isset($_POST['submitLogin'])){
    $email = $_POST['emailLogin'];
    $pass = $_POST['passwordLogin'];


    $arrayUser = $crud->getUser($email);
    $emailR = $arrayUser['email']; 
    $hpass = $arrayUser['pass']; 

    if(empty($emailR)){
        $errorL = "Dirección de correo incorrecta.";
    }else{
        if(password_verify($pass, $hpass)){
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $arrayUser['email'];
            $_SESSION['username'] = $arrayUser['nombre'];
            $_SESSION['ci'] = $arrayUser['ci'];
            $_SESSION['tipo_usuario'] = $arrayUser['tipo_usuario'];
            $_SESSION['start'] = time();

            if(basename($_SERVER['PHP_SELF']) == "register.php"){
                header('Location: index.php');
            }
            
        }else{
            $errorL = "Contraseña incorrecta.";
        }
    }
}
?>