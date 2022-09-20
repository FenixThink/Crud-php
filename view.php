<!-- Esto es lo del session, si esta no esta iniciada mande al login, el user y el password estan en el login -->
<?php
    session_start();
    if (!isset($_SESSION['usuario'])) {
    header('location: ./login.php');
    }
?>
<!DOCTYPE html>
<html lang="es_Co">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Answer Crud</title>
    <!-- llamamos al boostrap para que me de estilos chidos a la tabla -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <!-- Este script es una libreria para mostar alertas -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <?php
        /* este require es para la conexion etc */
        require('Funcions.php');
        /* Estas variables son para que el javascript funcione sin problemas */
            $cargo=3;
            $user=3;
            $mostrarusuarios=0;
            $empl=3;
            $contador=0;
        /* Estos primeros if, es para saber cual fue el boton que se preciono */
        if (isset($_REQUEST['createcargo'])) {
            /* Generamos las variables, el codigo aleatorio, y los datos guardados en el form */ 
            $codigocargo= generatecode();
            $nombrecargo=$_REQUEST['nombrecargo'];
            $sueldocargo=$_REQUEST['sueldocargo'];
            /* Hacemos la conexion (Deberia tener la conexion en un php aparte, SI, yo se, no me moleste xd) */
            $conexion = mysqli_connect('localhost','root','','Empresa')or die('problemas con la conexion');
            /* Hago esta consulta para saber si en la base de datos hay datos que esten repetidos con los que se van a enviar, si los hay, retorne que cargo es 0, esto funciona para el js, pero si no hay datos repetidos, entonces guarde los datos y guarde la variable cargo en 1 para el js */
            $registros = mysqli_query($conexion, "select *
            from Cargos where idCargo='$codigocargo' or CarNombre='$nombrecargo'") or
            die("Problemas en el select:" . mysqli_error($conexion));
            if ($reg= mysqli_fetch_array($registros)) {
                $cargo=0;
            }else{
            mysqli_query($conexion, "insert into Cargos values 
            ('$codigocargo','$nombrecargo','$sueldocargo')")
            or die("Problemas en el select" . mysqli_error($conexion));
            $cargo=1;
            }
            mysqli_close($conexion);
            }
        
        
        if (isset($_REQUEST['createuser'])) {
            /* Mismo asunto, declaro variables */
                /* $codigouser= generatecode(); */
                    /* Conexion */
                $conexion = mysqli_connect('localhost','root','','Empresa')or die('problemas con la conexion');
                $UserId= $_REQUEST['UserNombre'];
                /* Que me traiga el empleado*/
                $iduser = mysqli_query($conexion, "select idEmpleado
                from empleados where empNombre='$UserId'") or
                die("Problemas en el select:" . mysqli_error($conexion));

                if ($reg51= mysqli_fetch_array($iduser)) {
                    $usercode=$reg51['idEmpleado'];
                    $nombreuser=$_REQUEST['userNombre'];
                    $passworduser=$_REQUEST['userPassword'];
                
                    /* este select para saber si hay datos repetidos */
                    $registros = mysqli_query($conexion, "select *
                    from usuarios where idUsuario='$usercode' or usuLogin='$nombreuser'") or
                    die("Problemas en el select:" . mysqli_error($conexion));
                    /* Lo mismo, si los hay, user vale 0 y termine la ejecucion, si no pues inserte y dele valor a user como 1 */
                    if ($reg= mysqli_fetch_array($registros)) {
                        $user=0;
                    }else{
                    mysqli_query($conexion, "insert into usuarios values 
                    ('$usercode','$nombreuser','$passworduser')")
                    or die("Problemas en el select" . mysqli_error($conexion));
                    $user=1;
                    }
                }
                /* oiOj5NGwPV */
                
                
                
                mysqli_close($conexion);
            }
    
        if (isset($_REQUEST['moscar'])) {
                /* Aqui vamos a mostar los cargos */
                $conexion = mysqli_connect('localhost','root','','Empresa')or die('problemas con la conexion');
                /* Haga el select de todo lo de la tabla */
                $registros = mysqli_query($conexion, "select *
                from Cargos") or
                die("Problemas en el select:" . mysqli_error($conexion));
                /* Aqui imprima la parte de la tabla que no cambia */
                echo ("
                    <table class='table caption-top w-50 mx-auto'>
                    <caption class='text-center' style='font-weight:bolder;'>Cargos</caption>
                    <thead>
                            <tr>
                            <th scope='col'>Codigo</th>
                            <th scope='col'>Nombre Cargo</th>
                            <th scope='col'>Sueldo Cargo</th>
                            </tr>
                        </thead>
                    <tbody>
                    ");
                    /* Aqui haga el ciclo, entonces mientras haya datos en la tabla, entre al while y declare esas variables de acuerdo a los datos guardados en la base de datos, el contador es porque para sacar el modal al presionar editar, para saber cual es el que quiere modificar, creo divs diferentes y cada uno lleva un codigo de acuerdo al que el usuario presiono */
                    $contador=0;
                while ($reg = mysqli_fetch_array($registros)) {
                    /* cada que haga el while (Este while va deacuerdo a la cantidad de datos en la tabla de la base de datos) , entonces cada vez que lo haga, sume uno al contador, traigame los datos del form */ 
                    $contador=$contador+1;
                    $nombre = $reg['idCargo'];
                    $cargo = $reg['CarNombre'];
                    $sueldo = $reg['CarSueldo'];
                    /* aqui imprime las filas de acuerdo a las variables, las guarde en variables para evitar errores al momento de hacer el echo, el ultimo td son los botones, el boton de edit tiene el contador para activar el modal de acuerdo al que presiono, (cada modal y cada boton el diferente del otro para que todo funcione como deberia) */
                    echo ("
                    <tr>
                    <form action='edi.php' method='post'>
                        <th scope='row'>$nombre</th>
                        <td>$cargo</td>
                        <td>$$sueldo</td>
                        <td style='display: flex;'><button type='button' name='pasarinfo' class='btn btn-outline-info' data-bs-toggle='modal' data-bs-target='#myModal$contador'>Edit</button><button type='Submit' name='deleteCargo' class='btn btn-outline-warning ms-3'>Delete</button></td>
                        </tr>
                        
                    ");
                    /* aqui imprime modales de acuerdo a la cantidad de registros en la tabla de la db, le pongo un value como para mostrar los datos actuales y que modifique lo que necesite, el value es necesario en todos los updates para que no genere error, estos son los modales de update*/
                    echo ("
                    <div class='modal fade' id='myModal$contador' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLabel'>Editar Cargos</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                            <div class='modal-body'>
                                <div class='mb-3'>
                                    <label for='codigocar' class='col-form-label'>Codigo Cargo</label>
                                    <input type='text' readonly class='form-control-plaintext' id='codigocar' name='code' value='$nombre'required>
                                </div>
                                <div class='mb-3'>
                                    <label for='Nombrecargo' class='col-form-label'>Nombre Cargo</label>
                                    <input type='text' name='nombrecargo' class='form-control' id='Nombrecargo' value='$cargo' required>
                                </div>
                                <div class='mb-3'>
                                    <label for='sueldocargo' class='col-form-label'>Sueldo Cargo</label>
                                    <input type='number' name='sueldocargo' class='form-control' id='sueldocargo' value='$sueldo' step='0.02' required>
                                </div>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                <button type='submit' class='btn btn-primary' name='modifycargo'>Editar Cargo</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>");
                  }
                  /* Cuando ya no queden datos en la tabla por mostrar, cierre la etiqueta de tabla y el a es para volver al inicio */
                  echo("
                  
                  </tbody>
                  </table>
                <a class='text-center' href='http:./register.php'>Volver</a>  
                  ");
            }

        if (isset($_REQUEST['mosuser'])) {
                /* conexion */
                $conexion = mysqli_connect('localhost','root','','Empresa')or die('problemas con la conexion');
                /* select */
                $registros = mysqli_query($conexion, "select *
                from usuarios") or
                die("Problemas en el select:" . mysqli_error($conexion));
                /* imprima la cabeza de la tabla */
                echo ("
                    <table class='table caption-top w-50 mx-auto'>
                    <caption class='text-center' style='font-weight:bolder;'>Usuarios</caption>
                    <thead>
                            <tr>
                            <th scope='col'>Codigo</th>
                            <th scope='col'>Nombre Usuario</th>
                            <th scope='col'>Contraseña Usuario</th>
                            </tr>
                        </thead>
                    <tbody>
                    ");
                    /* mismo asunto que en mostrar los cargos, seleccione los datos y guardelos en variables */
                    $contador=0;
                    /* este mostrarusuarios es para que js sepa que la seleccion fue que queria mostrar los usuarios y no otra cosa */
                    $mostrarusuarios=1;
                while ($reg = mysqli_fetch_array($registros)) {
                    /* cada vez que entre al ciclo sume uno para saber cuantos registros hay en la tabla */
                    $contador=$contador+1;
                    $id = $reg['idUsuario'];
                    $nombre = $reg['usuLogin'];
                    $password = $reg['UsuPassword'];
                    /* imprima las filas de acuerdo al numero de datos que hay en la tabla, el tr tiene un body diferente por cada fila para que el js funcione de forma mas eficaz */
                    echo ("
                    <tr id='body$contador'>
                        <form action='edi.php' method='post'> 
                            <th scope='row'>$id</th>
                            <td>$nombre</td>
                            <td> <input class='form-control' type='password' id='pass' value='$password' aria-label='readonly input example' readonly></td>
                            <td style='display: flex;'><button type='button' name='pasarinfo' class='btn btn-outline-info' data-bs-toggle='modal' data-bs-target='#userifno$contador'>Edit</button><button type='Submit' name='deleteuser' class='btn btn-outline-warning ms-3'>Delete</button></td>
                    </tr> 
                ");
                /*                 aqui tengo un problema que despues soluciono, el asunto es que al yo darle al boton de delete, no me envia al formulario, despues lo arreglo pero la teoria es que funciona como funciona el de empleados y el de cargos */
                echo ("
                            <div class='modal fade' id='userifno$contador' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='exampleModalLabel'>Modificacion de Usuarios</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>
                            
                                    <div class='modal-body'>
                                        <div class='mb-3'>
                                            <label for='UserCode' class='col-form-label'>Codigo Usuario</label>
                                            <input type='text' readonly class='form-control-plaintext' id='UserCode' name='UserCode' value='$id' required>
                                        </div> 
                                        <div class='mb-3'>
                                            <label for='UserNombre' class='col-form-label'>Nombre Usuario</label>
                                            <input type='text' name='newuser' class='form-control' id='UserNombre' value='$nombre' required>
                                        </div>
                                        <div class='mb-3'>
                                            <label for='Userpassword' class='col-form-label'>Contraseña Usuario</label>
                                            <input type='password' name='newpass' value='$password' class='form-control' id='Userpassword' required>
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                        <button type='submit' class='btn btn-primary' name='ediuser'>Editar Usuario</button>
                                    </div>
                            </form>
                        </div>
                </div>
                </div>
                                    
                        
                    ");
                  }
                  /* termine de imprimir la tabla */
                  echo("
                  
                
                  </tbody>
                  </table>
                <a class='text-center' href='http:./register.php'>Volver</a>  
                  ");
            }
        if (isset($_REQUEST['emplcreate'])) {
            /* Cree variables de acuerdo al form, y en este caso, codigo y el id, son generados automaticamente */
            $codigoempl=generatecode();
            $idempl=generatecode();
            $Nombreempleado= $_REQUEST['Nombreempleado'];
            $fechaing=$_REQUEST['fechaing'];
            $corrempl=$_REQUEST['corrempl'];
            $genempleado=$_REQUEST['Genempl'];
            $nombrecargo=$_REQUEST['nombrecargo'];
            /* conexion */
            $conexion = mysqli_connect('localhost','root','','Empresa')or die('problemas con la conexion');
            /* select para validar que no hay los mismos datos que se desean ingresar*/
            $registros = mysqli_query($conexion, "select *
            from Empleados where empCorreo='$corrempl' or idEmpleado='$codigoempl' or Emplidentificacion='$idempl'") or
            die("Problemas en el select:" . mysqli_error($conexion));
            /* Esto es para guardar el id del cargo y que el usuario solo tenga que seleccionarlo desde el select */
            $cargito=mysqli_query($conexion, "select idCargo
            from cargos where carNombre='$nombrecargo'") or
            die("Problemas en el select:" . mysqli_error($conexion));
            $cargo=0;
            if ($reg1= mysqli_fetch_array($cargito)){
                $cargo = $reg1['idCargo'];
            }
            /* Aqui si pregunta, si hay datos repetidos, empl vale 0 y muere el proceso si no, registre los datos y cambie $empl a 1 */
             if ($reg= mysqli_fetch_array($registros)) {
                $empl=0;
            }else{
             mysqli_query($conexion, "insert into Empleados values 
            ('$idempl','$codigoempl','$Nombreempleado','$fechaing','$corrempl','$genempleado','$cargo')")
              or die("Problemas en el select" . mysqli_error($conexion));
              $empl=1;
            } 
            mysqli_close($conexion);
            }
        if (isset($_REQUEST['mosemple'])) {
                /* conexion */
            $conexion = mysqli_connect('localhost','root','','Empresa')or die('problemas con la conexion');
            /* select, aqui le meti inner join pa mostrar el nombre del cargo del empleado y no el id */
            $registros = mysqli_query($conexion, "select idEmpleado,Emplidentificacion,empNombre,empFechaingreso,empCorreo,empGenero,carNombre from Empleados inner join cargos on cargos.idCargo=Empleados.empCargo") or
            die("Problemas en el select:" . mysqli_error($conexion));
           
            /* imprima el encabezado de la tabla */
            echo ("
                <table class='table caption-top w-75 mx-auto'>
                <caption class='text-center' style='font-weight:bolder;'>Empleados</caption>
                <thead>
                        <tr>
                        <th scope='col'>Codigo Empleado</th>
                        <th scope='col'>Id Empleado</th>
                        <th scope='col'>Nombre Empleado</th>
                        <th scope='col'>Fecha Ingreso Empleado</th>
                        <th scope='col'>Correo Empleado</th>
                        <th scope='col'>Genero Empleado</th>
                        <th scope='col'>Cargo Empleado</th>
                        </tr>
                        
                    </thead>
                <tbody>
                
                ");
                $contador=0;
            while ($reg = mysqli_fetch_array($registros)) {
                $cargos = mysqli_query($conexion, "select *
                from Cargos") or
                die("Problemas en el select:" . mysqli_error($conexion));
                $contador=$contador+1;
                /* declare variables de la base de datos para mostrarlos */
                $CodigoEmpleado = $reg['idEmpleado'];
                $IdEmpleado = $reg['Emplidentificacion'];
                $NombreEmpleado = $reg['empNombre'];
                $FechaIngreso = $reg['empFechaingreso'];
                $CorreoEmpleado= $reg['empCorreo'];
                $GeneroEmpleado = $reg['empGenero'];
                $CargoEmpleado = $reg['carNombre'];
                
                /* imprima lo de la tabla de la db, y el mismo asunto, imprima divs, de acuerdo a los registros, si hay 1, imprime solo 1, si hay 1000, imprime 1000, cada uno es diferente del otro  (Los values son solo para decir los datos actuales)*/
                echo ("
                <tr>
                <form action='edi.php' method='post'>
                        <th scope='row'><input type='text' name='code' readonly class='form-control-plaintext' id='floatingPlaintextInput' value='$CodigoEmpleado'></th>
                        <td>$IdEmpleado</td>
                        <td>$NombreEmpleado</td>
                        <td>$FechaIngreso</td>
                        <td>$CorreoEmpleado</td>
                        <td>$GeneroEmpleado</td>
                        <td>$CargoEmpleado</td>
                        <td style='display: flex;'><button type='button' name='pasarinfo' class='btn btn-outline-info' data-bs-toggle='modal' data-bs-target='#myModal$contador'>Edit</button><button type='Submit' name='delete' class='btn btn-outline-warning ms-3'>Delete</button></td>
                        </tr>
                        <div class='modal fade' id='myModal$contador' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog'>
                        <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLabel'>Editar Empleados</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                       
                        <div class='modal-body'>
                            <div class='mb-3'>
                            <label for='codigoempl' class='col-form-label'>Codigo Empleado</label>
                            <input type='text' readonly class='form-control-plaintext' id='codigoempl' value='$CodigoEmpleado'required>
                            </div>
                           
                                <div class='mb-3'>
                                    <label for='Nombreempleado' class='col-form-label'>Nombre Empleado</label>
                                    <input type='text' name='newNombreempleado' class='form-control' id='Nombreempleado' value='$NombreEmpleado' required>
                                </div>
                                <div class='mb-3'>
                                    <label for='fechaing' class='col-form-label'>Fecha Ingreso Empleado</label>
                                    <input type='date' name='newFechaing' class='form-control' id='fechaing' value='$FechaIngreso' required>
                                </div>
                                <div class='mb-3'>
                                    <label for='corrempl' class='col-form-label'>Correo Empleado</label>
                                    <input type='email' name='newCorrempl' class='form-control' id='corrempl'value=' $CorreoEmpleado' required>
                                </div>
                                <div class='mb-3'>
                                    <label for='Genempl' class='col-form-label'>Genero Empleado</label>
                                    <select name='newGenempl' id='Genempl' class='form-control' required>
                                        <option value='Masculino'>Masculino</option>
                                        <option value='Femenino'>Femenino</option>
                                    </select>
                                </div>
                                <div class='mb-3'>
                                    <label for='Nombrecargo' class='col-form-label'>Nombre Cargo</label>
                                    <select name='newNombrecargo' class= 'form-control' id='Nombrecargo'>
                                    ");
                                    while ($reg2 = mysqli_fetch_array($cargos)) {
                                        $cargoemp = $reg2['CarNombre'];
                                        echo ("
                                        <option value='$cargoemp'>$cargoemp</option>
                                        ");}
                                        echo ("
                                            </select>    
                                                        </div>
                                                        </div>
                                                <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                            <button type='submit' class='btn btn-primary' name='edit'>Editar Empleado</button>
                                            </div>
                                                </div>
                                            </div>
                                            </form>
                                            </div>
            ");
              
              }
              /* imprima el resto de la tabla y chau */
              echo("
              
              </tbody>
              </table>
            <a class='text-center' href='http:./register.php'>Volver</a>  
              ");
              mysqli_close($conexion);
            }
    ?>

<script type="text/javascript" type='module'>
    /* Aqui pregunta por la variable que le mencione antes, si existe en value 1, haga el if, si no, pos no haga nada */
    if ("<?php echo $mostrarusuarios; ?>" == 1) {
        /* Aqui declaro la variable contador de php y la paso a js para trabajarla desde js */
        let contador = "<?php echo $contador; ?>";
        /* Pa saber si si me cojio la variable */
        console.log(contador);
        contador1 = 0
        /* El contador de js inicia en cero, mientras que sea diferente del contador de php ejecute la funcion */
        while (contador1 != contador) {
            contador1++
            /* este es el id del tr, le hago eso para que el e.target solo se seleccione dentro del body */
            let id = 'body'+contador1;
            console.log(id);

            let num = 0;
            /* esto es lo del e.target */
            document.getElementById(id).addEventListener("click", e=>{
                console.log(e.target)
                if (num == 0){
                    /* Si num, la declaraba ahi arriba es 0, entonces cambie el type del input a text y deje num en 1 pa saber que esta en text */
                    e.target.type = 'text';
                num = 1;
            }else{
                /* Si no es 0, entonces cambiele el tipo a password */
                e.target.type = 'password';
            num = 0;
            }
            })
        }   
   } 
   /* Todo ese js de ahi arriba es para que cuando el usuario le de a mostrar usuarios, la contraseña aparezca en pass, pero si se le da click, cambie a text y asi */
      if ("<?php echo $cargo; ?>" == 1) {
                Swal.fire({
                icon: 'success',
                title: 'Good job',
                text: 'You are Registed a cargo!'    
            })
            let button
            setInterval(() => {
            button = Swal.isVisible()
            console.log(button)
            if (button == false) {
            window.location = 'register.php';
            }
            }, 100);
            }else if("<?php echo $cargo; ?>" == 0){
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'No se pudo registrar!'    
            })
            let button
            setInterval(() => {
            button = Swal.isVisible()
            console.log(button)
            if (button == false) {
                window.location = 'register.php';
            }
            }, 100);
            }else{
                console.log('F')
            }
            /* Aqui es lo mismo pero con user, si es uno, muestre que se registro, si no error */

            if ("<?php echo $user; ?>" == 1) {
                Swal.fire({
                icon: 'success',
                title: 'Good job',
                text: 'You are Registed a User!'    
            })
            let button
            setInterval(() => {
            button = Swal.isVisible()
            console.log(button)
            if (button == false) {
            window.location = 'register.php';
            }
            }, 100);
            }else if("<?php echo $user; ?>" == 0){
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Cant registed a user!'    
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
            /* Aqui es lo mismo pero con empl, si es uno, muestre que se registro, si no error */

            if ("<?php echo $empl; ?>" == 1) {
                Swal.fire({
                icon: 'success',
                title: 'Good job',
                text: 'You are Registed a User!'    
            })
            let button
            setInterval(() => {
            button = Swal.isVisible()
            console.log(button)
            if (button == false) {
            window.location = 'register.php';
            }
            }, 100);
            }else if("<?php echo $empl; ?>" == 0){
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Cant registed a user!'    
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