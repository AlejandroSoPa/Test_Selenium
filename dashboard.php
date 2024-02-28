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
    <title>Dashboard | Vota EJA</title>
</head>

<?php
    session_start();
    include("config.php");
    include './components/log.php';
    if (!isset($_SESSION['UserID'])) {
        if (isset($_GET['validToken'])) {
            $receivedToken = $_GET['validToken'];

            $dsn = "mysql:host=localhost;dbname=project_vota";
            $pdo = new PDO($dsn, $dbUser, $dbPass);

            $validationQuery = $pdo->prepare('SELECT * FROM Users WHERE ValidationToken = :Token');

            $validationQuery->bindParam(':Token', $receivedToken);
            $validationQuery->execute();

            $userRow = $validationQuery->fetch();

            if ($userRow) {
                $_SESSION["isAuthenticated"] = $userRow["IsAuthenticated"];

                if ($_SESSION["isAuthenticated"] != 1) {

                    ?>  
                    <div class="authValidation">
                        <div class="authCheck">
                            <div class="returnHome">
                                <a href="index.php"><i class="fas fa-home"></i></a>
                            </div>
                            <h2>Debes aceptar los términos de uso para acceder a esta página</h2>
                            <form method="POST">
                                <input type="checkbox" name="authCheck" id="authCheck" required >
                                <label for="scales">Aceptar términos de uso</label>
                                <input type="submit" value="Aceptar">
                            </form>
                        </div>
                    </div>
                    <?php

                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['authCheck'])) {
                        try {
                            $dsn = "mysql:host=localhost;dbname=project_vota";
                            $pdo = new PDO($dsn, $dbUser, $dbPass);
                            
                            $updateQuery = $pdo->prepare('UPDATE Users SET IsAuthenticated = 1 WHERE ID = :UserID');
                            $updateQuery->bindParam(':UserID', $userRow['ID']);
                            $updateQuery->execute();
        
                            $_SESSION["UserID"] = $userRow['ID'];
                            $_SESSION["Username"] = $userRow["Username"];
                            
                            header("Location:./dashboard.php");
                            echo "<script>showNotification('success', 'Términos de uso aceptados correctamente');</script>";
                            //log
                            escribirEnLog("[DASHBOARD] Términos de uso aceptados correctamente");
                        } catch (PDOException $e) {
                            echo "<script>showNotification('error', 'Vaya, parece que algo ha salido mal al actualizar la base de datos');</script>";
                            escribirEnLog("[DASHBOARD] ".$e);
                        }
                    }
                } else {
                    $_SESSION["UserID"] = $userRow['ID'];
                    $_SESSION["Username"] = $userRow["Username"];
                    header("Location:./dashboard.php");
                }
            } else {
                echo "<script>showNotification('error', 'Token de validación inválido');</script>";
                escribirEnLog("[DASHBOARD] Token de validación inválido");
            }
        } else {
            include('./errors/error403.php');
        }
    } else {


?>

<body>
    <?php include './components/header.php'; ?>
    
    <div id="notificationContainer"></div>
    <section class="dashboard">
        <div class="pageDashboard">
            <div class="userInfo">
            <?php
                include('config.php');
                try {
                    $dsn = "mysql:host=localhost;dbname=project_vota";
                    $pdo = new PDO($dsn, $dbUser, $dbPass);
                    
                    $query = $pdo->prepare('SELECT * FROM Users WHERE ID = :UserID');
                    $query->bindParam(':UserID', $_SESSION['UserID']);
                    $query->execute();
                    
                    $row = $query->fetch();
                    $correct = false;
                    while ($row) {
                        echo "<h2> Nombre: ".$row["Username"]."</h2>";
                        echo "<h4> Email: ".$row["Email"]."</h4>";
                        echo "<h4> Telefono: ".$row["Phone"]."</h4>";
                        echo "<h4> Pais: ".$row["Country"]."</h4>";
                        echo "<h4> Ciudad: ".$row["City"]."</h4>";
                        echo "<br><br><a href='changePassword.php' id='changePassword'>Cambiar contraseña</a>";
                        //echo "<h4>".$row["Username"]."</h4>"; futuro es validated

                        $row = $query->fetch();
                        $correct = true;
                    }
                    echo "</ul>";
                    if (!$correct) {
                        echo "<script>showNotification('info', 'Vaya, parece que no deberias estar aqui')</script>";
                        // log
                        escribirEnLog("[DASHBOARD] El user".$_SESSION['UserID']." no deberia estar aqui");
                    }
                } catch (PDOException $e){
                    echo $e->getMessage();
                    echo "<script>showNotification('error', 'Vaya, parece que algo ha salido mal')</script>";
                    escribirEnLog("[DASHBOARD] ".$e);
                }
                
            ?>
            </div>
            <div class="navDashboard">
                <div class="dashboardItem">
                    <a href="newPoll.php" id="createQuestion">
                            <i class="fa-solid fa-plus"></i><p>Crear encuesta </p>
                    </a>
                </div>
                <div class="dashboardItem">
                    <a href="list_polls.php" id="createQuestion">
                        <i class="fa-solid fa-list-ul"></i><p>Listar encuestas</p>
                    </a>
                </div>
                <div class="dashboardItem">
                    <a href="listVotes.php" id="createQuestion">
                        <i class="fa-solid fa-list-ul"></i><p>Listar Votos</p>
                    </a>
                </div>
            </div>
        </div>
    </section> 
    <?php include './components/banner.php'; ?>
    <?php include './components/footer.php'; ?>
</body>
</html>
<?php
    if ($_SESSION["login"] == "correcto") {
        echo "<script>showNotification('success', 'Login Correcto');</script>";
        //log
        escribirEnLog("[DASHBOARD] Login correcto del user".$_SESSION['UserID']." con username ".$_SESSION['Username']);
        unset($_SESSION["login"]);
    }
    if (isset($_SESSION["pollCreated"])) {
        echo "<script>showNotification('success', 'Encuesta creada correctamente.');</script>";
        //log
        escribirEnLog("[CREATE POLL] El usuario ".$_SESSION['UserID']." ha creado una encuesta");
        unset($_SESSION["login"]);
    }
}
?>