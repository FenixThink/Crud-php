<!-- si hay una session creada, ingrese directamente -->
<?php
    session_start();
    if (isset($_SESSION['usuario'])) {
        header('location: register.php');
    }
?>
<!DOCTYPE html>
<html lang="es_Co">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon"
        href="https://images.pexels.com/photos/7672276/pexels-photo-7672276.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
        type="image/x-icon">
        <title>Crud || Login</title>
        <link rel="stylesheet" href="./CSS/Login.css">
</head>
<body>
    <div class="main">
        <div class="form">
            <form action="cheking.php" method="post">
                <div class="imgsuper">
                    <h1 class="title">Login</h1>
                    <img src="https://images.pexels.com/photos/7672276/pexels-photo-7672276.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="">
                </div>
                <div class="inputs">
                    <label for="user">Ingrese su Usuario</label>
                    <input type="text" name="usuario" id="user">
                    <label for="pass">Ingrese su Contraseña</label>
                    <input type="password" name="contra" id="pass">
                </div>
                <div class="footer">
                    <button type="submit" class="btn-3" name='login'>Login</button>
                    <a href="./Regis.php" class="Create">Create acount</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>