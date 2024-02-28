<?php
    session_start();
    include './components/log.php';
    if (!isset($_SESSION['UserID'])) {
        include('./errors/error403.php');
    } else {
        if(isset($_POST['closeSession'])){
            session_destroy();
            escribirEnLog("[logout] El usuario ".$_SESSION["UserID"]." ha cerrado sesion");
            header("Location:./index.php");
        }
        if(isset($_POST['returnToDashboard'])){
            header("Location:./dashboard.php");
        }
?><!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="./img/vota-si.png" />
    <script src="https://kit.fontawesome.com/8946387bf5.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="functions.js"></script>
    <title>Cerrar sesion</title>
</head>
<body>
    <?php include './components/header.php'; ?>
    <div class="closeSession">
        <h1>¿Quieres salir y cerrar tu sesion?<h1>
        <form method="POST">
            <button id="closeSession" name="closeSession">Salir</button>
            <button id="returnToDashboard" name="returnToDashboard">Volver</button>
        </form>
    </div>

    <?php include './components/banner.php'; ?>
    <?php include './components/footer.php'; ?>
</body>
</html>
<?php
    }
?>