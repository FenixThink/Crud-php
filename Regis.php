<!-- un register con css puro, nada del otro mundo, y este seccion es para que si ya esta logeado, pues que vaya al main y no al register -->
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
    <title>Crud || Register</title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="./CSS/register.css">
</head>

<body>
    <div class="main">
        <div class="form">
            <form action="cheking.php" method="post">
                <div class="imgsuper">
                    <h1 class="title">Registrer</h1>
                    <img src="https://images.pexels.com/photos/7672276/pexels-photo-7672276.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="">
                </div>
                <div class="inputs">
                    <label for="user">Ingrese su Nombre</label>
                    <input type="text" name="user" id="user">
                    <label for="email">Ingrese su Email</label>
                    <input type="email" name="email" id="email">
                    <label for="pass">Ingrese su Contraseña</label>
                    <input type="password" name="pass" id="pass">
                </div>
                <div class="footer">
                    <button type="submit" class="btn-3" name = 'register'>Register</button>
                    <a href="./login.php" class="Create">Login with your acount</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>