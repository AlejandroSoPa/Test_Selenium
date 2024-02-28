<?php
    session_start();
    if (!isset($_SESSION['UserID'])) {
        include('./errors/error403.php');
    } else if (!isset($_SESSION['userPassword'])) {
        $_SESSION["redirectTo"] = "listVotes";
        header("Location:./login.php");
    } else {
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/8946387bf5.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="listVotes.js"></script>
    <link rel="stylesheet" href="styles.css">
    <title>Encuestas Votadas | Vota EJA</title>
</head>
<body>
<?php include './components/header.php'; ?>
    <div id="notificationContainer"></div>
    <div class="listPollDiv">
    <h1>Listado de tus votos</h1>

    <?php
        include("config.php");
        include './components/log.php';
        try {
            $dsn = "mysql:host=localhost;dbname=project_vota";
            $pdo = new PDO($dsn, $dbUser, $dbPass);
            
            //$query = $pdo->prepare("SELECT a.Text, p.Question FROM User_Vote uv INNER JOIN Answers a ON a.ID = uv.AnswerID INNER JOIN Polls p ON a.PollID = p.ID WHERE uv.UserID = ?;");
            $query = $pdo->prepare("SELECT * FROM User_Vote WHERE UserID = ?");
            $query->bindParam(1, $_SESSION["UserID"]);
            $query->execute();
            $row = $query->fetch();
            $correct = false;
            echo "<ul id='votesList'>";

            while ($row) {
                $hash = openssl_encrypt($row["Vote"], "AES-128-CBC", $_SESSION["userPassword"]);
                $query2 = $pdo->prepare("SELECT * FROM Votes v INNER JOIN Answers a ON a.ID = v.AnswerID WHERE VoteHash = ?");
                $query2->bindParam(1, $hash);
                $query2->execute();
                $row2 = $query2->fetch();
                if ($row2) {
                    $pollQuery = $pdo->prepare("SELECT * FROM Polls WHERE ID = ?");
                    $pollQuery->bindParam(1, $row2["PollID"]);
                    $pollQuery->execute();
                    $pollRow = $pollQuery->fetch();
                    echo "<li><div class='pollItem'>";
                    echo "<span>Pregunta: ".$pollRow["Question"]."</span>";
                    echo "<span class='nameQuestionPollItem'>Respuesta: <span class='showAnswer'><i class='fa-solid fa-eye' style='color: #ffffff;'></i></span><span class='answer' style='display: none'>".$row2["Text"]."</span></span>";
                    echo "</div></li>";
                    $row = $query->fetch();
                    $correct = true;
                }
                $row = $query->fetch();
            }
            echo "</ul>";
            if (!$correct) {
                echo "<script>showNotification('info', 'Vaya, parece que no tienes encuestas')</script>";
            }
            if (isset($_SESSION["userPassword"])) {
                unset($_SESSION["userPassword"]);
            }
            /*
            echo var_dump(openssl_decrypt($row["VoteHash"], "AES-128-CBC", $_SESSION["userPassword"]));
            $row = $query->fetch();
            $questions = 0;
            echo "<ul id='votesList'>";
            while ($row) {
                $questions ++;
                echo "<li><div class='pollItem'>";
                echo "<span>Pregunta: ".$row["Question"]."</span>";
                echo "<span class='nameQuestionPollItem'>Respuesta: <span class='showAnswer'><i class='fa-solid fa-eye' style='color: #ffffff;'></i></span><span class='answer' style='display: none'>".$row["Text"]."</span></span>";
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
            */
        } catch (PDOException $e){
            echo $e->getMessage();
            echo "<script>showNotification('error', 'Vaya, parece que algo ha salido mal')</script>";
            escribirEnLog("[listVotes] ".$e);
        }
    ?>
        </div>
        <?php include './components/banner.php'; ?>

    <?php include './components/footer.php'; ?>
</body>
</html>
<?php
}?>