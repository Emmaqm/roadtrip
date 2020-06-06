<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Road Trip Buses</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">

<link rel="stylesheet" href="css/common_style.css">
<link rel="stylesheet" href="css/index.css">

<script type="text/javascript" src="js/errors.js"></script>

<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

</head>
<body>
    <?php
        include_once 'dbconfig.php';
        include_once 'login.php';
        

        if(isset($_POST['send']))
        {
            $ci = $_POST['ci'];
            $email = $_POST['emailR'];
            $nombre = $_POST['name'];
            $apellido = $_POST['lastName'];
            $pass = $_POST['passwordR'];
            $passR = $_POST['passwordRepeat'];
            $telefono = $_POST['phone'];
            $tipo_usuario = "cliente";


            if(empty($nombre) or !preg_match('/^[\p{L}-]*$/u', $nombre)){
                $error = "Nombre vacio o incorrecto.";
            }else if(empty($apellido) or !preg_match('/^[\p{L}-]*$/u', $apellido)){
                $error = "Apellido vacio o incorrecto.";
            }else if(empty($email) or !preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)){
                $error = "Email vacio o inválido.";
            }else if(strlen($pass) < 8){
                $error = "La contraseña debe contener mas de 8 caracteres.";
            }else if($pass != $passR){
                $error = "Las contraseñas no coinciden.";
            }else if(empty($ci) or strlen($ci) != 8 or !is_numeric($ci)){
                $error = "Documento Incorecto.";
            }else if(empty($telefono) or !is_numeric($telefono)){
                $error = "Teléfono vacio o incorrecto.";
            }else{

                $ciR = $crud->getCI($ci);
                $emailR = $crud->getEmail($email);

                if(empty($ciR) and empty($emailR)){
                    $pass = password_hash($pass, PASSWORD_DEFAULT);
                    $crud->create($ci, $email, $nombre, $apellido, $pass, $telefono, $tipo_usuario);
                    $success = "El Usuario se creó correctamente.";
                }else{
                    $error = "Ya existe el usuario.";
                }
                
            }
           
        }

        function logout() {
            session_unset();
            session_destroy();
            header('Location: index.php');
        }
        
        if (isset($_GET['logout'])) {
            logout();
        }
    ?>

    <div class="header-index">
        <img class="logo" src="img/logo_blanco.png" alt="logo">
        <?php
            if(isset($_SESSION['loggedin']) and $_SESSION['loggedin'] == true){
            ?>
                <ul class="signed">
                <?php
                    if(isset($_SESSION['tipo_usuario']) and $_SESSION['tipo_usuario'] == "empleado"){
                        ?>
                        <li><a id="user_btn" href="empleados.php"><?php echo $_SESSION['username']?></a></li>
                        <?php
                    }else{
                        ?>
                        <li><a id="user_btn" href="#"><?php echo $_SESSION['username']?></a></li>
                        <?php
                    }
                    ?>
                    |
                    <li><a id="close_sesion" href="index.php?logout=true">Cerrar Sesión</a></li>
                </ul>
        <?php    
            }else{
        ?>
            <ul class="sign">
                <li><a id="login_btn" onclick="openModal();" href="javascript:void(0)">Ingresar</a></li>
                |
                <li><a id="register_btn" href="register.php">Registrarse</a></li>
            </ul>
        <?php
        }
        ?>
        <ul class="menu">
            <li><a href="index.php">Inicio</a></li>            
            <?php
            if(isset($_SESSION['tipo_usuario']) and $_SESSION['tipo_usuario'] == "empleado"){
                ?>
                <li><a href="reservas.php">Venta de Pasajes</a></li>
                <?php
            }else{
                ?>
                <li><a href="reservas.php">Reservas</a></li>
                <?php
            } 
            ?>  
            <li><a href="horarios.php">Horarios</a></li> 
            <li><a href="destinations.php">Destinos</a></li>
            <?php
            if(isset($_SESSION['tipo_usuario']) and $_SESSION['tipo_usuario'] == "empleado"){
                ?>
                <li><a href="empleados.php">Empleados</a></li>
                <?php
            }else{
                ?>
                <li><a href="contact.php">Contacto</a></li>
                <?php
            }
            
            ?>
        </ul>
    </div>

    <div id="register-content">
        <h3>Registrarse</h3>
        
        <form class="register-form" id="registerForm" method="post">
            <?php if(isset($error)){ ?>

            <div class="error-container">
                <p id="error2"><?php echo $error; ?></p>
            </div>

            <?php }else if(isset($success)){
            ?>

            <div id="success-container">
                <p id="success"><?php echo $success; ?></p>
            </div>

            <?php }?>

            <label for="name">Nombre</label>
            <input id="name" class="type-text" type="text" name="name" autocomplete="off" required/>     

            <label for="lastName">Apellido</label>
            <input id="lastName" class="type-text" type="text" name="lastName" autocomplete="off" required/>  

            <label for="emailR">Dirección de Correo</label>
            <input id="emailR" class="type-text" type="email" name="emailR" autocomplete="off" required/> 

            <label for="passR">Contraseña (más de 8 caracteres)</label>
            <input id="passR" class="type-pass" type="password" name="passwordR" autocomplete="off" required/>

            <label for="passRepeat">Repetir Contraseña</label>
            <input id="passRepeat" class="type-pass" type="password" name="passwordRepeat" autocomplete="off" required/>

            <label for="ci">Documento (sin guiones ni puntos, Ej: 12345678)</label>
            <input id="ci" class="type-text" type="text" name="ci" autocomplete="off" required/>   

            <label for="phone">Teléfono</label>
            <input id="phone" class="type-text" type="text" name="phone" autocomplete="off" required/>  

            <p class="requiredC">Todos los campos son requeridos.</p>
            <input class="type-submit" type="submit" name="send" value="Registrarse"/>
            
        </form>
    </div>

    <div id="login">
        <div id="login-content">
            <div>
                <h3>Ingresar</h3>
                <span id="closeModal">&times;</span>
            </div>
            <form class="login-form" id="loginForm" method="post">
                <label for="email">Dirección de Correo</label>
                <input id="email" class="type-text" type="email" name="emailLogin" autocomplete="off" /> 
    
                <label for="pass">Contraseña</label>
                <input id="pass" class="type-pass" type="password" name="passwordLogin" autocomplete="off" />
        
                <?php if(isset($errorL)){ ?>
                    <script>
                        login.style.display = "initial";
                    </script>
                <div class="error-container">
                    <p id="error"><?php echo $errorL; ?></p>
                </div>

                <?php } ?>

                <input class="type-submit" type="submit" name="submitLogin" value="Ingresar"/>
                <a class="secondary_btn" id="notRegistered" href="register.php"> ¿Aún no estás registrado?</a>
            </form>
        </div>
    </div>

    <div class="footer">
            <img src="img/logo.png" alt="logo">
            <ul class="footer-menu">
                <li><a href="index.php">Inicio</a></li>            
                <li><a href="reservas.php">Reservas</a></li>
                <li><a href="horarios.php">Horarios</a></li> 
                <li><a href="destinations.php">Destinos</a></li>
                <li><a href="contact.php">Contacto</a></li>
            </ul>
            <ul>
                <li><a href="https://facebook.com/" target="_blank" class="fab fa-facebook"></a></li>
                <li><a href="https://twitter.com/" target="_blank" class="fab fa-twitter"></a></li>
                <li><a href="https://instagram.com/" target="_blank" class="fab fa-instagram"></a></li>
            </ul>
            <p>Copyright © 2010 - 2018 Road Trip - All Rights Reserved</p>
    </div>
    <script type="text/javascript" src="js/login.js"></script>
</body>

</html>