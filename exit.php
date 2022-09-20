<!DOCTYPE html>
<html lang="es_co">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud || Exiting</title>
</head>
<body>
  <!-- aqui que destruya la session creada -->
<?php
     session_start();
    session_destroy();
?>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
  /* para decir al usuario que se ha salido y que lo redirija al login */
Swal.fire({
  icon: 'success',
  title: 'Bye Bye',
  text: 'Now, You are logout!!',
  footer: 'Will be back soon'
  
})
let button
setInterval(() => {
 button = Swal.isVisible()
 console.log(button)
if (button == false) {
  window.location = 'login.php';
}
}, 100);
</script>
</body> 
</html>