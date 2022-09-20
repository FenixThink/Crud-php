<?php
    session_start();
    if (!isset($_SESSION['usuario'])) {
        header('location: login.php');
    }
?>
<!DOCTYPE html>
<html lang="es_Co">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Este php es para validar los edits y los deletes -->
    <?php 
    $code='';
    $borrado = 0;
    $modificar = 0;
    $modificarcargo = 0;
    $borradocargo = 0;
    $modificaruser = 0;
    $borradouser=0;
        if (isset($_REQUEST['edit'])) {
            /* Si se preciona el boton de edit, (Es el del bootstrap, del modal,) haga la conexion, el echo era una prueba para ver si tomaba el codigo que era*/
            $conexion = mysqli_connect('localhost','root','','Empresa')or die('problemas con la conexion');
            $code = $_REQUEST["code"];
            echo $code;
            /* Traiga los datos del form */
            $newNombreempleado = $_REQUEST['newNombreempleado'];
            $newFechaing = $_REQUEST['newFechaing'];
            $newCorrempl = $_REQUEST['newCorrempl'];
            $newGenempl = $_REQUEST['newGenempl'];
            $newNombrecargo = $_REQUEST['newNombrecargo'];
            /* Traiga el id del cargo de acuerdo al nombre del cargo insertado en los cargos, por cierto, los cargos en ese edit, tambien van de acuerdo a los cargos creados en la tabla cargos (lo hice todo conectado xd) */
            $cargos = mysqli_query($conexion, "select idCargo
            from cargos where CarNombre='$newNombrecargo'") or
            die("Problemas en el select:" . mysqli_error($conexion));
            
            /* Estos son los updates, lo hice uno por uno porque al hacerlo en grupo generaba error */
            mysqli_query($conexion, "update empleados
                            set empNombre='$newNombreempleado'
                            where idEmpleado='$code'") or
            die("Problemas en el select:" . mysqli_error($conexion));
            mysqli_query($conexion, "update empleados
                            set empFechaingreso='$newFechaing' where idEmpleado='$code'") or
                            die("Problemas en el select:" . mysqli_error($conexion));
            mysqli_query($conexion, "update empleados
            set empCorreo='$newCorrempl' where idEmpleado='$code'") or
            die("Problemas en el select:" . mysqli_error($conexion));
            mysqli_query($conexion, "update empleados
            set empGenero='$newGenempl' where idEmpleado='$code'") or
            die("Problemas en el select:" . mysqli_error($conexion));
            /* Esto es para que al actualizar cargo, me ingrese el codigo del cargo y no el nombre como tal del cargo*/
            if ($reg12=mysqli_fetch_array($cargos)) {
                $cargoemp = $reg12['idCargo'];
                mysqli_query($conexion, "update empleados
                    set empCargo='$cargoemp' where idEmpleado='$code'") or
                    die("Problemas en el select:" . mysqli_error($conexion));
                }
                /* actualice modificar a  1*/     
                $modificar = 1;
            mysqli_close($conexion);
    }
   
    if (isset($_REQUEST['delete'])){
        /* Pida el codigo del form */
        $code = $_REQUEST['code'];
        /* Haga la conexion y traigame los datos, la tabla */
        $conexion = mysqli_connect('localhost','root','','Empresa')or die('problemas con la conexion');
        $userinfor = mysqli_query($conexion, "select idUsuario from usuarios where idUsuario='$code'") or
        die("Problemas en el select:" . mysqli_error($conexion));
        if ($info=mysqli_fetch_array($userinfor)) {
            $borrado=2;
        }else{
        $registros = mysqli_query($conexion, "select idEmpleado,Emplidentificacion,empNombre,empFechaingreso,empCorreo,empGenero from Empleados") or
            die("Problemas en el select:" . mysqli_error($conexion));
        /* Aqui pregunto si el id de la tabla es el mismo que el usuario ingreso, si si lo es, elimine */
        if ($reg= mysqli_fetch_array($registros)) {
            mysqli_query($conexion, "delete from Empleados where idEmpleado='$code'") or
            die("Problemas en el select:" . mysqli_error($conexion));
            $borrado=1;
            mysqli_close($conexion);
        }
        }
    }
    if (isset($_REQUEST['modifycargo'])){
        /* aqui modifico el cargo de la misma manera como modifique empleado */
        $conexion = mysqli_connect('localhost','root','','Empresa')or die('problemas con la conexion');
        $code = $_REQUEST['code'];
        /* el echo era para mirar que todo andara gucci(bien) */
        echo $code;
        $nombrecargo = $_REQUEST['nombrecargo'];
        $sueldocargo = $_REQUEST['sueldocargo'];
        /* traigame el cargo de acuero al id */
        $registros = mysqli_query($conexion, "select idCargo from cargos where idCargo='$code'") or
            die("Problemas en el select:" . mysqli_error($conexion));
        if ($reg= mysqli_fetch_array($registros)) {
            /* actualice si el id es el mismo */
            mysqli_query($conexion, "update cargos
                            set CarNombre='$nombrecargo'
                            where idCargo='$code'") or
            die("Problemas en el select:" . mysqli_error($conexion));
            mysqli_query($conexion, "update cargos
            set CarSueldo='$sueldocargo'
            where idCargo='$code'") or
            die("Problemas en el select:" . mysqli_error($conexion));
            mysqli_close($conexion);
            /* estas variables son para js */
            $modificarcargo = 1;
        }
    }
    if (isset($_REQUEST['deleteCargo'])){
        /* Aqui hago algo curioso xd, pido el codigo y hago la conexion */
        $code = $_REQUEST['code'];
        $conexion = mysqli_connect('localhost','root','','Empresa')or die('problemas con la conexion');
        /* Aqui pido que me traiga el codigo del cargo del empleado de acuerdo al codigo */ 
        $registros = mysqli_query($conexion, "select empCargo from empleados where empCargo = '$code'") or
            die("Problemas en el select:" . mysqli_error($conexion));
            /*                 Entonces, si encuentra algun registro con ese codigo de empleado, no haga nada, solo cambie el status de la varibale a 4, para el js */
            if ($reg= mysqli_fetch_array($registros)){
        
                $borradocargo=4;
            }
            /* si no encontro ningun campo con ese id, entones ahi si elimine el cargo */
            else  {
            mysqli_query($conexion, "delete from cargos where idCargo='$code'") or
             die("Problemas en el select:" . mysqli_error($conexion));
            $borradocargo=1;
            echo("borrar cargo");
            mysqli_close($conexion);
        }
        /* Eso lo hago para que me muestre elimine el cargo solo si ningun empleado tiene ese cargo, si ahy uno que lo tiene, entonces ni siquiera ejecute la consulta, para que no me muestre ese error todo xd en la pantalla */
    }

    if (isset($_REQUEST['ediuser'])){
        /* Este edit user si funciona, es lo mismo que los otros edits */
        $code = $_REQUEST['UserCode'];
        $newuser = $_REQUEST['newuser'];
        $newpass = $_REQUEST['newpass'];
        $conexion = mysqli_connect('localhost','root','','Empresa')or die('problemas con la conexion');
        /* Consulta */
        $registros = mysqli_query($conexion, "select idUsuario from usuarios where idUsuario='$code'") or
        die("Problemas en el select:" . mysqli_error($conexion));
        /* actualice si hay un usuario con ese id */
        if ($reg= mysqli_fetch_array($registros)) {
        mysqli_query($conexion, "update usuarios
                        set usuLogin='$newuser'
                        where idUsuario='$code'") or
        die("Problemas en el select:" . mysqli_error($conexion));
        mysqli_query($conexion, "update usuarios
        set UsuPassword='$newpass'
        where idUsuario='$code'") or
        die("Problemas en el select:" . mysqli_error($conexion));
        mysqli_close($conexion);
        /* Si se pudo actualizar cambie el status a 1 */
        $modificaruser = 1;
        }
        }
    
    if (isset($_REQUEST['deleteuser'])){
        /* deberia funcionar como los otros deletes, pero no lo hace entonces F, despues lo soluciono*/
        $code = $_REQUEST['UserCode'];
        $conexion = mysqli_connect('localhost','root','','Empresa')or die('problemas con la conexion');

        $registros = mysqli_query($conexion, "select idUsuario from usuarios where idUsuario='$code'") or
            die("Problemas en el select:" . mysqli_error($conexion));
            if ($reg= mysqli_fetch_array($registros)){
                $borradouser=3;
            }
            else if($reg= mysqli_fetch_array($registros)) {
            mysqli_query($conexion, "delete from usuarios where idUsuario='$code'") or
             die("Problemas en el select:" . mysqli_error($conexion));
             $borradouser=4;
            mysqli_close($conexion);
        }
    }
        
    
    ?>
    
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- el type lo hago para especificar que es un tipo js, creo que no es necesario hacerlo, pero por si acaso xd -->
    <script type="text/javascript">
        /* Aqui haga lo mismo que en el otro php, pregunte por el status de la variable, dependiendo de ese status, muestre un alerta diferente es el mismo codigo que los otros solo cambia el mensaje o la pregunta, si quiere el nombre de esas alertas, o sea buscar todas las alertas que tiene, que son muchas xd, busquelo como sweet alert js*/
        if ("<?php echo $borradouser; ?>" == 4) {
                Swal.fire({
                icon: 'success',
                title: 'Good job',
                text: 'You deleted a User!'    
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
        
/*  */
        if ("<?php echo $borrado; ?>" == 2) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'No puedes borrar el Empleado, Primero Elimina el Usuario que tiene ese empleado!'    
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
        if ("<?php echo $borradocargo; ?>" == 1) {
            Swal.fire({
            icon: 'success',
            title: 'Good job',
            text: 'You deleted a Cargo!'    
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
        if ("<?php echo $modificar; ?>" == 1) {
                Swal.fire({
                icon: 'success',
                title: 'Good job',
                text: 'You Modify a Empleado!'    
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
        if ("<?php echo $borradocargo; ?>" == 4) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'No puedes borrar el cargo, Primero Elimina el empleado que tiene ese cargo!'    
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
        if ("<?php echo $modificarcargo; ?>" == 1) {
                Swal.fire({
                icon: 'success',
                title: 'Good job',
                text: 'You Modify a Cargo!'    
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
        if ("<?php echo $modificaruser; ?>" == 1) {
            Swal.fire({
            icon: 'success',
            title: 'Good job',
            text: 'You Modify a User!'    
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
        if ("<?php echo $modificaruser; ?>" == 2) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Error al modificar el Usuario!'    
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