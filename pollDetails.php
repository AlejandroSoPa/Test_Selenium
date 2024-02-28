<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="./img/vota-si.png" />
    <script src="https://kit.fontawesome.com/8946387bf5.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.0/dist/chart.umd.js"></script>
    <script src="functions.js"></script>
    <script src="pollDetails.js"></script>
    <title>Detalles de Encuesta | EJA</title>
</head>
<body>
     <div id="notificationContainer"></div>
    <?php 
    include("./components/header.php");
    include("config.php");
    include './components/log.php'; 

    session_start();
    $dsn = "mysql:host=localhost;dbname=project_vota";
    $pdo = new PDO($dsn, $dbUser, $dbPass); 
    if (!isset($_SESSION['UserID'])) {
        include("./errors/error403.php");
    } else {
        if (isset($_GET["id"])) {
            $validationPollFromCreator = $pdo->prepare("SELECT * FROM Polls WHERE ID = ? AND CreatorID = ?");
            $validationPollFromCreator->bindParam(1, $_GET["id"]);
            $validationPollFromCreator->bindParam(2, $_SESSION["UserID"]);
            $validationPollFromCreator->execute();
            $row = $validationPollFromCreator->fetch();

            if (!$row) {
                include("./errors/error403.php");
            }


    ?>
    <section class="pollDetails">
    <?php 
        try {  
            if (isset($_POST["QuestionVisibility"])) {
                
                $queryState = $pdo->prepare("SELECT State FROM Polls WHERE ID = ?");
                $queryState->bindParam(1, $_GET["id"]);
                $queryState->execute();
                $row = $queryState->fetch();
                $currentState = $row["State"];
                $newState = ($currentState == "blocked") ? "not_begun" : "blocked";


                $pdo->beginTransaction();
                $query = $pdo->prepare("UPDATE Polls SET QuestionVisibility = ?, ResultsVisibility = ?, State = ? WHERE ID = ?");
                $query->bindParam(1, $_POST["QuestionVisibility"]);
                $query->bindParam(2, $_POST["AnswerVisibility"]);

                $query->bindParam(3, $newState);

                $query->bindParam(4, $_GET["id"]);
                $query->execute();
                $pdo->commit();

		echo "<script>showNotification('success', 'Cambios guardados');</script>";
        //log
        escribirEnLog("[pollDetails] Cambios guardados del usuario ".$_SESSION["UserID"]." en la encuesta ".$_GET["id"]);
            }

            
            
            $query = $pdo->prepare("SELECT * FROM Polls WHERE ID = ?");
            $query->bindParam(1, $_GET["id"]);
            $query->execute();

            $row = $query->fetch();
            $correct = false;
            $questions = 0;
            if ($row) {
                echo "<div class='pollTextDetails'>";
                echo "<h2>Pregunta: ".$row["Question"]."</h2>";
                $creationDate = new DateTime($row["CreationDate"]);
                echo "<h4>Fecha de creación: ".$creationDate->format("d/m/Y h:i")."</h4>";
                $startDate = new DateTime($row["StartDate"]);
                echo "<h4>Fecha de inicio: ".$startDate->format("d/m/Y h:i")."</h4>";
                $endDate = new DateTime($row["EndDate"]);
                echo "<h4>Fecha de fin: ".$endDate->format("d/m/Y h:i")."</h4>";
                $state = "";
                echo "<h4>Estado: ".$state."</h4>";
                echo "<h4>Visibilidad de la pregunta:";
                echo "<select id='questionVisibility'>";
                echo "<option value='hidden' ".($row["QuestionVisibility"] == "hidden" ? "selected" : "").">Oculto</option>";
                echo "<option value='private' ".($row["QuestionVisibility"] == "private" ? "selected" : "").">Privado</option>";
                echo "<option value='public' ".($row["QuestionVisibility"] == "public" ? "selected" : "").">Público</option>";
                echo "</select></h4>";
                echo "<h4>Visibilidad de las respuestas:";
                echo "<select id='answerVisibility'>";
                if ($row["QuestionVisibility"] == "hidden") {
                    echo "<option id='AnswerVisibilityHiddenOption' value='hidden' ".($row["ResultsVisibility"] == "hidden" ? "selected" : "").">Oculto</option>";
                    echo "<option id='AnswerVisibilityPrivateOption' value='private' ".($row["ResultsVisibility"] == "private" ? "selected" : "")." disabled>Privado</option>";
                    echo "<option id='AnswerVisibilityPublicOption' value='public' ".($row["ResultsVisibility"] == "public" ? "selected" : "")." disabled>Público</option>";
                } else if ($row["QuestionVisibility"] == "private") {
                    echo "<option id='AnswerVisibilityHiddenOption' value='hidden' ".($row["ResultsVisibility"] == "hidden" ? "selected" : "").">Oculto</option>";
                    echo "<option id='AnswerVisibilityPrivateOption' value='private' ".($row["ResultsVisibility"] == "private" ? "selected" : "").">Privado</option>";
                    echo "<option id='AnswerVisibilityPublicOption' value='public' ".($row["ResultsVisibility"] == "public" ? "selected" : "")." disabled>Público</option>";
                } else {
                    echo "<option id='AnswerVisibilityHiddenOption' value='hidden' ".($row["ResultsVisibility"] == "hidden" ? "selected" : "").">Oculto</option>";
                    echo "<option id='AnswerVisibilityPrivateOption' value='private' ".($row["ResultsVisibility"] == "private" ? "selected" : "").">Privado</option>";
                    echo "<option id='AnswerVisibilityPublicOption' value='public' ".($row["ResultsVisibility"] == "public" ? "selected" : "").">Público</option>";
                }
                echo "</select></h4>";
                echo '<div class="switch-button">';
                echo '<label for="switch-label">Bloquear encuesta</label>';
                echo '<input type="checkbox" name="switch-button" id="switch-label" class="switch-button__checkbox "'.($row["State"] == "blocked" ? " checked " : "").'>';
                echo '<label for="switch-label" class="switch-button__label"></label>';
                echo '</div>';
                echo "<button id='saveChanges'>Guardar cambios</button>";
                echo "</div>";
                echo "
                <div id='pollGraphs'>
                    <div id='pollGraphButtons'>
                        <button id='barChartButton' disabled><h2>Barras</h2></button>
                        <button id='pieChartButton'><h2>Pastel</h2></button>
                    </div>
                    <div id='graphContainer'>
                        <canvas id='graph'>
                        </canvas>
                    </div>
                </div>
                ";
            }

            $query = $pdo->prepare("SELECT a.ID, a.Text, count(v.AnswerID) as counter FROM Answers a INNER JOIN Polls p on a.PollID = p.ID LEFT JOIN Votes v ON v.AnswerID = a.ID WHERE p.ID = ? GROUP BY a.ID;");
            $query->bindParam(1, $_GET["id"]);

            $query -> execute();
            $row = $query->fetch();
            echo "<script>\n";
            echo "getVotes([";
            
            while ($row) {
                echo "{answer:'".$row["Text"]."', count:".$row["counter"]."},";
                $row = $query->fetch();
            }
            echo "]);";
            echo "</script>";
        } catch (PDOException $e){
            echo $e->getMessage();
            echo "<script>showNotification('error', 'Vaya, parece que algo ha salido mal')</script>";
            escribirEnLog("[pollDetails] ".$e);
        }
    ?>
    <form id="hiddenForm" style="display: none" method="POST">
    </form>
    </section>
    <?php include './components/banner.php'; ?>
    <?php include("./components/footer.php");
            } else {
            include("./errors/error403.php");}}?>
</body>
</html>
