<!DOCTYPE html>
<html lang="es">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="functions.js"></script>
    <link rel="icon" href="./img/vota-si.png" />
    <script src="https://kit.fontawesome.com/8946387bf5.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Iniciar sesión | Vota EJA</title>
</head>
<body>
<?php include './components/header.php'; ?>
<?php include './components/log.php'; ?>
    <div id="notificationContainer"></div>
    <section class="loginSection">

        <h1>¡Bienvenido de nuevo!</h1>
        <div class="loginForm">
            <div class="circleLoginForm">
                <h3>Inicia sesión</h3>
                <p>Introduce tus datos</p>
                <form method="POST">
                    <input type="email" name="userEmail" placeholder="Email">
                    <input type="password" name="pwd" placeholder="Contrasenya">
                    <button type="submit" class="btnForm">Entrar</button>
                </form>
                <p class="forgotPassword"><a href="forgot_password.php">¿Olvidaste tu contraseña?</a></p>
            </div>
        </div>


        <div class="loginImg">
            <img src="./img/login.svg">
        </div>
    </section>
    <?php include './components/banner.php'; ?>
    <?php include './components/footer.php'; ?>
    <?php
        if(isset($_POST['userEmail']) && isset($_POST['pwd'])){
            include("config.php");
            try {
                $pwd = $_POST['pwd'];
                $userEmail = $_POST['userEmail'];
                $dsn = "mysql:host=localhost;dbname=project_vota";
                $pdo = new PDO($dsn, $dbUser, $dbPass);
                
                $query = $pdo->prepare("SELECT * FROM Users WHERE password = SHA2(?, 512) AND Email = ? AND IsAuthenticated = 1");
                $query->bindParam(1, $pwd);
                $query->bindParam(2, $userEmail);
                $query->execute();
                
                $row = $query->fetch();
                $correct = false;
                if ($row) {
                    $_SESSION["login"] = "correcto";
                    $_SESSION["UserID"] = $row["ID"];
                    $_SESSION["Username"] = $row["Username"];
                    $_SESSION["isAuthenticated"] = $row["IsAuthenticated"];
                    header("Location:dashboard.php");
                    if ($row["IsAuthenticated"] == 1) {
                        $correct = true;
                        $_SESSION["login"] = "correcto";
                        if (isset($_SESSION["redirectTo"])) {
                            $_SESSION["userPassword"] = $pwd;
                            if ($_SESSION["redirectTo"] == "login") {
                                header("Location:./votePoll.php");
                            } else if ($_SESSION["redirectTo"] == "listVotes") {
                                header("Location:./listVotes.php");
                            }
                        } else {
                            header("Location:./dashboard.php");
                        }
                    }
                }
                if (!$correct) {
                    echo "<script>showNotification('error', 'Credenciales incorrectos');</script>";
                    // log
                    escribirEnLog("[LOGIN] Credenciales incorrectos");
                }

            } catch (PDOException $e){
                echo $e->getMessage();
                escribirEnLog("[LOGIN] ".$e);
            }
        }
    ?>

</body>
</html>