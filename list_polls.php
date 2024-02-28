<?php
    session_start();
    if (!isset($_SESSION['UserID'])) {
        include('./errors/error403.php');
    } else {
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
    <title>Lista de Encuestas | Vota EJA</title>
</head>
<body>
    <?php include './components/header.php'; ?>
    <div id="notificationContainer"></div>
    <div class="listPollDiv">
    <h1>Listado de tus encuestas creadas</h1>

    <?php
        include("config.php");
        try {
            $dsn = "mysql:host=localhost;dbname=project_vota";
            $pdo = new PDO($dsn, $dbUser, $dbPass);
            
            $query = $pdo->prepare("SELECT * FROM Polls WHERE CreatorID = ?");
            $query->bindParam(1, $_SESSION["UserID"]);
            $query->execute();
                        
            $row = $query->fetch();
            $correct = false;
            $questions = 0;
            echo "<ul>";
            while ($row) {
                $questions ++;
                echo "<li><div class='pollItem'>";
                $creationDate = new DateTime($row["CreationDate"]);
                echo "<span class='datePollItem'>".$creationDate->format("d/m/Y")."</span>";
                echo "<span class='nameQuestionPollItem'>".$row["Question"]."</span>";
                if ($row["QuestionVisibility"] == "hidden") {
                    echo "<span class='visibilityPollItem'>Oculto</span>";
                } else if ($row["QuestionVisibility"] == "public") {
		    echo "<span class='visibilityPollItem'>Público</span>";
		} else {
		    echo "<span class='visibilityPollItem'>Privado</span>";
		}
                echo "<a href='pollDetails.php?id=".$row["ID"]."'>Detalles</a>";
                echo "<a href='invite.php?pollID={$row['ID']}' class='inviteButton'>Invitar</a>";
                echo "</div></li>";
                $row = $query->fetch();
                $correct = true;
            }
            echo "</ul>";
            if (!$correct) {
                echo "<script>showNotification('info', 'Vaya, parece que no tienes encuestas')</script>";
                // log
                escribirEnLog("[DASHBOARD] El user ".$_SESSION["Username"]." no tiene encuestas");
            }
        } catch (PDOException $e){
            echo $e->getMessage();
            echo "<script>showNotification('error', 'Vaya, parece que algo ha salido mal')</script>";
            escribirEnLog("[list_pulls] ".$e);
        }
    ?>
        </div>
        <?php include './components/banner.php'; ?>

    <?php include './components/footer.php'; ?>
</body>
</html>
<?php
    }
?>
