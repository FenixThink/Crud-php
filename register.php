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
    <title>Crud</title>
    <!-- Llamar bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Los botones que llaman los modales que muestran los formularios, el modal se activa de acuerdo a data-bs-target, si el id del div es el mismo. -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap">Crear Cargos</button>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Empleados" data-bs-whatever="@getbootstrap">Crear Empleados</button>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#example" data-bs-whatever="@getbootstrap">Crear Usuarios</button>

    <!-- modal de para mostrar la creacion de cargos -->
    <div class="modal fade" id="exampleModal" tabindex="-1"         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Creacion de Cargos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="View.php" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="Nombrecargo" class="col-form-label">Nombre Cargo</label>
                        <input type="text" name='nombrecargo' class="form-control" id="Nombrecargo" required>
                    </div>
                    <div class="mb-3">
                        <label for="sueldocargo" class="col-form-label">Sueldo Cargo</label>
                        <input type="number" name='sueldocargo' class="form-control" id="sueldocargo" step='0.02' required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" name='createcargo'>Crear Cargo</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    <?php
    require('Funcions.php');
    /* pa llamar la funcion que me carga los boostrap, como dije, para que sea todo mas limpio */
    loadmain();
    ?>

         
<!--     Todos los botones activan diferentes funciones en view.php de acuerdo al name que tengan -->

    <form action="view.php" method="post">
        <button type="submit" class="btn btn-info" name='moscar'>Mostrar Cargos</button>
    </form>
    <form action="view.php" method="post">
        <button type="submit" class="btn btn-info" name='mosemple'>Mostar Empleados</button>
    </form>
    <form action="view.php" method="post">
        <button type="submit" class="btn btn-info" name='mosuser'>Mostrar Usuarios</button>
    </form>
    <form action="exit.php" method="post">
        <button type="submit" class="btn btn-info" name='mosuser'>Salir de la seccion</button>
    </form>
    
    


</body>
</html>

</body>
</html>