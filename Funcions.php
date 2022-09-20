<?php
/* Hace la conexion, solo para tener un excusa para usar el require */
function conexion(){
    $conexion = mysqli_connect('localhost','root','','Empresa')or die('problemas con la conexion');
    return $conexion;
}
/* Este era simplemente para hacer mas limpio del register(index) */
function loadmain(){
     /* Conexion a la base de datos y hacer el select a la tabla cargos */
     $conexion = mysqli_connect('localhost','root','','Empresa')or die('problemas con la conexion');

     $registros = mysqli_query($conexion, "select *
     from Cargos") or
     die("Problemas en el select:" . mysqli_error($conexion));

     $empleados = mysqli_query($conexion, "select idEmpleado,empNombre
     from empleados") or
     die("Problemas en el select:" . mysqli_error($conexion));

     /* imprimir el modal de bootstrap para empleados, esto se hace para que los cargos que el ususario pueda escojer, vayan de acuerdo a los cargos creados en la base de datos*/
     echo ("
         <div class='modal fade' id='Empleados' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
         <div class='modal-dialog'>
         <div class='modal-content'>
         <div class='modal-header'>
             <h5 class='modal-title' id='exampleModalLabel'>Creacion de Empleados</h5>
             <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
         </div>
         <form action='View.php' method='post'>
             <div class='modal-body'>
                 <div class='mb-3'>
                     <label for='Nombreempleado' class='col-form-label'>Nombre Empleado</label>
                     <input type='text' name='Nombreempleado' class='form-control' id='Nombreempleado' required>
                 </div>
                 <div class='mb-3'>
                     <label for='fechaing' class='col-form-label'>Fecha Ingreso Empleado</label>
                     <input type='date' name='fechaing' class='form-control' id='fechaing' step='0.02' required>
                 </div>
                 <div class='mb-3'>
                     <label for='corrempl' class='col-form-label'>Correo Empleado</label>
                     <input type='email' name='corrempl' class='form-control' id='corrempl' step='0.02' required>
                 </div>
                 <div class='mb-3'>
                     <label for='Genempl' class='col-form-label'>Genero Empleado</label>
                     <select name='Genempl' id='Genempl' class='form-control' required>
                         <option value='Masculino'>Masculino</option>
                         <option value='Femenino'>Femenino</option>
                     </select>
                 </div>
                 <div class='mb-3'>
                     <label for='Nombrecargo' class='col-form-label'>Nombre Cargo</label>
                     <select name='nombrecargo' class= 'form-control' id='Nombrecargo'>
                 ");
     /*                     aca hago el while, guardo lo que este en $registros en la variable reg, y con esa variable saco el nombre del cargo y lo imprimo en el option del select */
         while ($reg = mysqli_fetch_array($registros)) {
         $cargo = $reg['CarNombre'];
         echo ("
         <option value='$cargo'>$cargo</option>
         ");
         }
         /* termina de imprimir el modal */
     echo ("
         </select>    
                     </div>
                     </div>
             <div class='modal-footer'>
         <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
         <button type='submit' class='btn btn-primary' name='emplcreate'>Crear Empleado</button>
         </div>
             </form>
             </div>
         </div>
         </div>
         ");
     /* Aqui es para imprimir en crear usuario, el select, como todo esta conectado, para crear un usuario, necesito un empleado, entonces en el select me muestra los empleados para asignarles un user */
         echo ("
         <div class='modal fade' id='example' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
     <div class='modal-dialog'>
     <div class='modal-content'>
     <div class='modal-header'>
         <h5 class='modal-title' id='exampleModalLabel'>Creacion de Usuarios</h5>
         <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
     </div>
     <form action='View.php' method='post'>  
         <div class='modal-body'>
             <div class='mb-3'>
             <label for='UserNombre' class='col-form-label'>Nombre Empleado</label>
             <select name='UserNombre' class= 'form-control' id='UserNombre'>
         
         ");
         /* este while es para imprimir en el select */
         while ($reg1 = mysqli_fetch_array($empleados)) {
             $empl = $reg1['empNombre'];
             echo ("
             <option value='$empl'>$empl</option>
             ");}
         
        /* termina de imprimir el div de boostrap */
             echo ("
             </select>
             </div>
         <div class='mb-3'>
                 <label for='UserNombre' class='col-form-label'>Nombre Usuario</label>
                 <input type='text' name='userNombre' class='form-control' id='UserNombre' required>
             </div>
             <div class='mb-3'>
                 <label for='Userpassword' class='col-form-label'>Sueldo Usuario</label>
                 <input type='password' name='userPassword' class='form-control' id='Userpassword' step='0.02' required>
             </div>
         </div>
         <div class='modal-footer'>
             <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
             <button type='submit' class='btn btn-primary' name='createuser'>Crear Usuario</button>
         </div>
     </form>
     </div>
         </div>
     </div>
     ");

    }
/* esta funcion me genera un codigo aleatorio cada vez que la llamo */
function generatecode(){                                                                                       
    $strength = 10;
    $input = '01213456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
    $input_lengt = strlen($input);
    $random_string = '';
    for ($i=0; $i < $strength; $i++) { 
     $random_character = $input[mt_rand(0, $input_lengt - 1)];
     $random_string .= $random_character;
    }
    return $random_string;

}