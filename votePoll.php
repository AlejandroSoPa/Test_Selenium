<?php
    session_start();
    include './components/log.php';
    include("config.php");
    if (isset($_SESSION['UserID']) || isset($_SESSION['tokenQuestion']) || isset($_GET['tokenQuestion'])) {
        if (isset($_GET["tokenQuestion"])) {
            $tokenQuestion = "";
            if (isset($_SESSION["tokenQuestion"])) {
                $tokenQuestion = $_SESSION["tokenQuestion"];
            } else {
                $tokenQuestion = $_GET["tokenQuestion"];
            }

            try {
                $dsn = "mysql:host=localhost;dbname=project_vota";
                $pdo = new PDO($dsn, $dbUser, $dbPass);
            } catch (PDOException $e){
                echo $e->getMessage();
                escribirEnLog("[votePoll] ".$e);
                echo "<script>showNotification('error', 'Vaya, parece que algo ha salido mal')</script>";
            }

            $validationQuery = $pdo->prepare('SELECT * FROM Poll_InvitedUsers WHERE tokenQuestion = :Token');

            $validationQuery->bindParam(':Token', $tokenQuestion);
            $validationQuery->execute();
            $userRow = $validationQuery->fetch();

            if ($userRow) {
                $isBlockedQuery = $pdo->prepare("SELECT p.State FROM Poll_InvitedUsers piu JOIN Polls p ON piu.PollID = p.ID WHERE tokenQuestion = :Token");
                $isBlockedQuery->bindParam(":Token", $_SESSION["tokenQuestion"]);
                $isBlockedQuery->execute();
                $isBlockedRow = $isBlockedQuery->fetch();
                if ($isBlockedRow) {
                    if ($isBlockedRow["State"] == "blocked") {
                        $_SESSION["pollBlocked"] = true;
                        header("Location:./index.php");
                    } else {
                        $_SESSION["tokenQuestion"] = $userRow["tokenQuestion"];
                        $query = $pdo->prepare("SELECT * FROM Users WHERE ID = ?");
                        $query->bindParam(1, $userRow["UserID"]);
                        $query->execute();
                        $row = $query->fetch();
                        if ($row["Password"] != "") {
                            $_SESSION["redirectTo"] = "login";
                            header("Location:./login.php");
                        } else {
                            header("Location:./votePoll.php"); 
                        }
                    }
                }
            } else {
                echo "<script>showNotification('error', 'Token de validación inválido');</script>";
                escribirEnLog("[DASHBOARD] Token de validación inválido");
            }
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
    <title>Votar  | Vota EJA</title>
</head>
<body>
    <div id="notificationContainer"></div>
    <?php include './components/header.php'; ?>

    <div class="questionDiv">
        <div class="question">

    <?php
        include("config.php");
        function getRandomString($length = 40) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $token = '';
            for ($i = 0; $i < $length; $i++) {
                $randomIndex = rand(0, strlen($characters) - 1);
                $token .= $characters[$randomIndex];
            }
            return $token;
        }
        
        try {
            $dsn = "mysql:host=localhost;dbname=project_vota";
            $pdo = new PDO($dsn, $dbUser, $dbPass);
            
            $query = $pdo->prepare("SELECT UserID, AnswerID FROM User_Vote WHERE UserID = :UserID");

            $query = $pdo->prepare("SELECT * FROM Poll_InvitedUsers piu JOIN Polls p ON piu.PollID = p.ID WHERE tokenQuestion = :Token");
            $query->bindParam(':Token', $_SESSION['tokenQuestion']);
            $query->execute();
            $row = $query->fetch();
            $question = $row['Question'];
            if ($row["ImagePath"] != "") {
                echo "<img src='".$row["ImagePath"]."' alt='Imagen de la pregunta'>";
            }
            echo "<h1>".$question."</h1>";
            echo '<div class="answers">';
            $query = $pdo->prepare("SELECT UserID, PollID from Poll_InvitedUsers WHERE tokenQuestion = :Token");
            //$query = $pdo->prepare("SELECT ans.ID, ans.Text, ans.PollID, ans.ImagePath, piu.UserID FROM Answers AS ans JOIN Poll_InvitedUsers AS piu ON ans.PollID = piu.PollID JOIN Polls AS p ON piu.PollID = p.ID where piu.tokenQuestion = :Token");
            $query->bindParam(':Token', $_SESSION['tokenQuestion']);
            $query->execute();
            $row = $query->fetch();
            $userID = $row['UserID'];
            $pollID = $row['PollID'];

            $query2 = $pdo->prepare("SELECT * FROM User_Vote WHERE UserID = :UserID and PollID = :PollID");
            $query2->bindParam(':UserID', $userID);
            $query2->bindParam(':PollID', $pollID);
            $query2->execute();
            $row2 = $query2->fetch();
            if ($row2) {
                header("Location:./index.php");
                $_SESSION['alreadyVoted'] = true;
            } else {
                $query = $pdo->prepare("SELECT * FROM Answers WHERE PollID = ?");
                $query->bindParam(1, $pollID);
                $query->execute();
                $row = $query->fetch();
                $correct = false;
                $answers = 0;
                if ($row) {
                    echo '<form action="./votePoll.php" method="POST">';
                    while ($row) {
                        $answers ++;
                        echo "<div class='answer'>";
        

                        echo "<input type='radio' name='answer' id='answer".$answers."' value='".$row["ID"]."' required>";
                        echo "<label for='answer".$answers."'>".$row["Text"]."</label>";
                        if ($row["ImagePath"] != "") {
                            echo "<img src='".$row["ImagePath"]."' alt='Imagen de la respuesta'>";
                        }
                        echo "</div>";
                        $row = $query->fetch();
                        $correct = true;
                    }
                    echo '<input type="submit" value="Tramitar voto">';
                    echo '</form>';
                }
                
                echo "</div>";
                if (!$correct) {
                    echo "<script>showNotification('info', 'Vaya, parece que no tienes respuestas')</script>";
                    // log
                    escribirEnLog("[DASHBOARD] Vaya, parece que no tienes respuestas, user: ".$_SESSION["Username"]);
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['answer'])) {
                        $selectedAnswerId = $_POST['answer'];

                        try {
                            $pdo->beginTransaction();
                            $randomString = getRandomString();
                            $updateQuery = $pdo->prepare("INSERT INTO `User_Vote`(`UserID`, `Vote`, `PollID`) VALUES (?,?, ?)");
                            $updateQuery->bindParam(1, $userID);
                            $updateQuery->bindParam(2, $randomString);
                            $updateQuery->bindParam(3, $pollID);
                            $updateQuery->execute();

                            $updateQuery = $pdo->prepare("INSERT INTO Votes(VoteHash, AnswerID) VALUES (?, ?)");
                            $password = "Password1234!";
                            if (isset($_SESSION["userPassword"])) {
                                $password = $_SESSION["userPassword"];
                            }
                            $hash = openssl_encrypt($randomString, 'AES-128-CBC', $password);
                            $updateQuery->bindParam(1, $hash);
                            $updateQuery->bindParam(2, $selectedAnswerId);
                            $updateQuery->execute();
                            $pdo->commit();

                            $_SESSION['justVoted'] = true;
                            if (isset($_SESSION["userPassword"])) {
                                unset( $_SESSION["userPassword"] );
                            }
                            unset($_SESSION['tokenQuestion']);
                            header("Location:./index.php");
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                            escribirEnLog("[votePoll] ".$e);
                            echo "<script>showNotification('error', 'Vaya, parece que algo ha salido mal')</script>";

                        }
                    } else {
                        echo "<script>showNotification('error', 'Vaya, parece que algo ha salido mal')</script>";
                        // log
                        escribirEnLog("[votePoll] Vaya, parece que algo ha salido mal, user: ".$_SESSION["Username"]);
                    }
                }
            }

        } catch (PDOException $e){
            echo $e->getMessage();
            escribirEnLog("[votePoll] ".$e);
            echo "<script>showNotification('error', 'Vaya, parece que algo ha salido mal')</script>";
        }

    ?>
        </div>
    </div>
    <?php include './components/banner.php'; ?>
    <?php include './components/footer.php'; ?>
</body>
</html>
<?php
    }} else {
        include('./errors/error403.php');
    }
?>