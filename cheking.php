<!DOCTYPE html>
<html lang="es_Co">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cheking</title>
</head>
<body>
    <?php
    /* estas variables para el js */
    $statusRegister = 10000;
    $loginStatus = 10000000;
        require('Funcions.php');
        if (isset($_REQUEST['login'])){
            /* ejecuta la conexion */
            $conexion = conexion();
            /* pide los dato ingresados en el login */
            $user = $_REQUEST['usuario'];
            $pass = $_REQUEST['contra'];

            /* que seleccione todo de la tabla, se que no esta bien el asterisco pero tuve problemas con mysql asi que xd(todo funciona bien por el momento) */
            $validar = mysqli_query($conexion,"select * from administradores where nombreAdmin = '$user' and contraseña='$pass'") or die ("Problemas en el select:" . mysqli_error($conexion));
            /* si se pudo encontrar los datos ingresados en la base de datos, inicie la session y cambie el status a 1 */
            if ($validado = mysqli_fetch_array($validar)) {
                $loginStatus = 1;
                session_start();
                $_SESSION['usuario'] = $user;
                $_SESSION['clave'] = $pass;
            }else{
                /* si no, el status 0 */
                $loginStatus = 0;
            }
        }
        if (isset($_REQUEST['register'])){
            /* todos los datos necesarios */
            $conexion = conexion();
            $id = generatecode();
            $nombreusuario= $_REQUEST['user'];
            $Mailusuario= $_REQUEST['email'];
            $Passwordusuario= $_REQUEST['pass'];
            echo $id;
            /* select */
            $adminscode = mysqli_query($conexion, "select idAdmin
            from administradores where idAdmin='$id'") or
            die("Problemas en el select:" . mysqli_error($conexion));
            if ($ad= mysqli_fetch_array($adminscode)) {
                /* si hay algun dato con ese id, pase status a cero */
                $statusRegister = 0;
            }else{
                $adminsname = mysqli_query($conexion, "select nombreAdmin
                from administradores where nombreAdmin='$nombreusuario'") or die ("Problemas en el select:" . mysqli_error($conexion));
                if ($adn= mysqli_fetch_array($adminsname)) {
                    si no tienen el mismo codigo, pero el usuario es el mismo, entonces register vale 1
                    $statusRegister = 1;
                }else{
                    $adminsmail = mysqli_query($conexion, "select emailAdmin
                    from administradores where emailAdmin='$Mailusuario'") or die ("Problemas en el select:" . mysqli_error($conexion));
                    if ($adm= mysqli_fetch_array($adminsmail)) {
                        /* si no la ultima pregunta es decir si el mail es el mismo, si asi lo es, entonces error, si no pues cambie el status a 3 y diga que todo esta bien, todo esto es solo para mostrar en el alert en que fue en que el usuario se equivoco */
                        $statusRegister = 2;
                    }else{
                         mysqli_query($conexion, "insert into administradores values('$id','$nombreusuario','$Mailusuario','$Passwordusuario')")or die ("Problemas en el select:" . mysqli_error($conexion)); 
                         $statusRegister = 3;
                    }
            }
            }
        }
        mysqli_close($conexion);
    ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        /* todos estos js son para mostrar diferentes alerts */
        if ("<?php echo $statusRegister; ?>" == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Tu Id ya fue generado, lo sentimos, Vuelve a registrarte!'    
            })
            let button
            setInterval(() => {
            button = Swal.isVisible()
            console.log(button)
            if (button == false) {
            window.location = 'Regis.php';
            }
            }, 100);
            }
        if ("<?php echo $statusRegister; ?>" == 1) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Tu Nombre ya fue usado, lo sentimos, Vuelve a intentarlo con otro nombre!'    
            })
            let button
            setInterval(() => {
            button = Swal.isVisible()
            console.log(button)
            if (button == false) {
            window.location = 'Regis.php';
            }
            }, 100);
            }
        if ("<?php echo $statusRegister; ?>" == 2) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Tu email ya fue usado, lo sentimos, Vuelve a intentarlo con otro Email!'    
            })
            let button
            setInterval(() => {
            button = Swal.isVisible()
            console.log(button)
            if (button == false) {
            window.location = 'Regis.php';
            }
            }, 100);
            }
        if ("<?php echo $statusRegister; ?>" == 3) {
            Swal.fire({
                icon: 'success',
                title: 'Good job',
                text: 'You are Registed!'    
            })
            let button
            setInterval(() => {
            button = Swal.isVisible()
            console.log(button)
            if (button == false) {
            window.location = 'register.php';
            }
            }, 100);
            }
        if ("<?php echo $loginStatus; ?>" == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Tu nombre de usuario o contraseña son incorrectos!'    
            })
            let button
            setInterval(() => {
            button = Swal.isVisible()
            console.log(button)
            if (button == false) {
            window.location = 'login.php';
            }
            }, 100);
            }
        if ("<?php echo $loginStatus; ?>" == 1) {
            Swal.fire({
                icon: 'success',
                title: 'Good job',
                text: 'Tu estas logeado!'    
            })
            let button
            setInterval(() => {
            button = Swal.isVisible()
            console.log(button)
            if (button == false) {
            window.location = 'register.php';
            }
            }, 100);
            }
   </script>
</body>
</html>