<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="./img/vota-si.png" />
    <script src="https://kit.fontawesome.com/8946387bf5.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="functions.js"></script>
    <title>Vota EJA | 2024</title>
</head>

<body id="index">
    <?php include './components/header.php'; ?>
    <?php include("./components/log.php")?>
    <div id="notificationContainer"></div>

    <?php 
        if (isset($_SESSION['justVoted'])) {
            echo "<script>showNotification('success', '¡Tu voto ha sido registrado! Regístrate para ver tus votaciones y poder crearlas.')</script>";
            //log
            escribirEnLog("[VOTE] Voto registrado");
            unset($_SESSION['justVoted']);
        } elseif (isset($_SESSION['alreadyVoted'])) {
            echo "<script>showNotification('error', 'Link inválido.')</script>";
            //log 
            escribirEnLog("[VOTE] Link inválido");
            unset($_SESSION['alreadyVoted']);
        } elseif (isset($_SESSION['pollBlocked'])) {
            echo "<script>showNotification('error', 'La encuesta ha sido bloqueada.')</script>";
            escribirEnLog("[VOTE] Encuesta bloqueada");
        }
        $_SESSION["index"] = 1;
    ?>

    <section class="firstSec flex flex-col justify-center">
        <h1>VOTA EJA</h1>
        <h3>Portal de votaciones</h3>
        <?php include './components/rail.php' ?>

        <div class="firstSecFlex flex flex-row">
            <div class="firstSecText">
                <p><strong>Vota EJA</strong> es un proyecto para lograr hacer un portal de votaciones que permita <strong>crear, distribuir y administrar</strong> votaciones en linea.
                Para nosotros <strong>la seguridad es lo primero</strong>, por eso todas las votaciones pasan por un <strong>sistema de seguridad y encriptacion</strong> riguroso 
                con tal de lograr que ninguno de los datos proporcionados por los votantes se pueda filtrar o llegar a saber su identidad.<br><br><a href="/" class="btn">¡Conoce más!</a> </p>        
            </div>
            <div class="firstSecImg">
                <img src="./img/votePrinci.svg" alt="Imagen de la primera seccion" width="100%" height="100%" class="imgFirstSec">
            </div>
        </div>
    </section>

    <?php include './components/banner.php'; ?>
    <?php include './components/footer.php'; ?>
</body>

</html>