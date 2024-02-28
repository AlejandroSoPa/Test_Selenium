<?php 
session_start();
if (!isset($_SESSION["UserID"])) {
    include("./errors/error403.php");
} else {
    include './components/log.php';
    include './components/header.php';
    include("config.php");
    
    function generarToken($length = 40) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $token .= $characters[$randomIndex];
        }
        return $token;
    }
    
    try {
        $hostname = "localhost";
        $dbname = "project_vota";
        $username = $dbUser;
        $pw = $dbPass;
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", "$username", "$pw");
    } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage();
        escribirEnLog("[invite] " . $e);
        exit;
    }
    $query = $pdo->prepare("SELECT * FROM Polls WHERE ID = ? AND CreatorID = ?");
    $query->bindParam(1, $_GET["pollID"]);
    $query->bindParam(2, $_SESSION["UserID"]);
    $query->execute();
    $row = $query->fetch();
    if ($row) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="functions.js"></script>
    <script src="log.php"></script>
    <link rel="icon" href="./img/vota-si.png" />
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/8946387bf5.js" crossorigin="anonymous"></script>
    <title>Invitar a usuarios | Vota EJA</title>
</head>
<body>
<div id="notificationContainer"></div>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['emails'])) {
        $emails = $_POST['emails'];
        try {
            $hostname = "localhost";
            $dbname = "project_vota";
            $username = $dbUser;
            $pw = $dbPass;
            $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", "$username", "$pw");
        } catch (PDOException $e) {
            echo "Failed to get DB handle: ". $e->getMessage();
            escribirEnLog("[invite] ".$e);
            exit;
        }

        // Obtener el pollID de la variable GET
        $pollID = isset($_GET['pollID']) ? $_GET['pollID'] : null;

        if (!$pollID) {
            echo "<script>showNotification('error', 'No se proporcionó el ID de la encuesta.');</script>";
            exit;
        }

        // Validar los correos electrónicos antes de almacenarlos en la base de datos
        $arrayEmails = preg_split('/[,\n]+/', $emails);
        $arrayEmails = array_map('trim', $arrayEmails);

        $emailRegex = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
        $correosIncorrectos = [];
        $correosCorrectos = [];

        foreach ($arrayEmails as $email) {
            if (preg_match($emailRegex, $email)) {
                $alreadySent = false;
                foreach ($correosCorrectos as $emailCheck) {
                    if ($email == $emailCheck) {
                        $alreadySent = true;
                    }
                }
                if (!$alreadySent) {
                    $query = $pdo->prepare("SELECT COUNT(*) as `counter`
                       FROM Poll_InvitedUsers pu
                       JOIN Users u ON pu.UserID = u.ID
                       WHERE u.Email = ? AND pu.PollID = ?");
                    $query->bindParam(1, $email);
                    $query->bindParam(2, $pollID);

                    $query->execute();
                    $row = $query->fetch();
                    if ($row && $row["counter"] > 0) {
                        echo "<script>showNotification('error', 'El usuario con la dirección de correo electrónico " . $email . " ya ha sido invitado a esta encuesta.');</script>";
                    } else {
                        $query = $pdo -> prepare("SELECT count(*) as `counter` FROM Users WHERE Email = ?");
                        $query->bindParam(1, $email);
                        $query->execute();
                        $row = $query->fetch();
                        if ($row && $row["counter"] > 0) {
    
                            $emailID = "";
    
                            $query = $pdo -> prepare("SELECT ID FROM Users WHERE Email = ?");
                            $query->bindParam(1, $email);
                            $query->execute();
                            $row = $query->fetch();
                            if ($row) {
                                $emailID = $row["ID"];
                            } 
                            $token = generarToken();
                            $pdo->beginTransaction();
                            $query = $pdo -> prepare("INSERT INTO Poll_InvitedUsers(UserID, PollID, tokenQuestion) VALUES (?, ?, ?)");
                            $query->bindParam(1, $emailID);
                            $query->bindParam(2, $_GET["pollID"]);
                            $query->bindParam(3, $token);
                            $query->execute();
                            $query = $pdo -> prepare("INSERT INTO email_queue(email, PollID) VALUES (?,?)");
                            $query->bindParam(1, $email);
                            $query->bindParam(2, $_GET["pollID"]);
                            $query->execute();
                            $pdo->commit();
                            $correosCorrectos[] = $email;
                        }else{

                            $pdo->beginTransaction();
                            $insertQuery = $pdo -> prepare("INSERT INTO Users(`email`) VALUES (?)");
                            $insertQuery ->bindParam(1, $email);
                            $insertQuery ->execute();
                            $pdo->commit();
    
                            $emailID = "";
    
                            $query = $pdo -> prepare("SELECT ID FROM Users WHERE Email = ?");
                            $query->bindParam(1, $email);
                            $query->execute();
                            $row = $query->fetch();
                            if ($row) {
                                $emailID = $row["ID"];
                            } 
                            $token = generarToken();
                            $pdo->beginTransaction();
                            $query = $pdo -> prepare("INSERT INTO Poll_InvitedUsers(UserID, PollID, tokenQuestion) VALUES (?, ?, ?)");
                            $query->bindParam(1, $emailID);
                            $query->bindParam(2, $_GET["pollID"]);
                            $query->bindParam(3, $token);
                            $query->execute();
                            $query = $pdo -> prepare("INSERT INTO email_queue(email, PollID) VALUES (?,?)");
                            $query->bindParam(1, $email);
                            $query->bindParam(2, $_GET["pollID"]);
                            $query->execute();
                            $pdo->commit();
                            $correosCorrectos[] = $email;
                        }
                    }
                }
            } else {
                $correosIncorrectos[] = $email;
            }
        }

        if (!empty($correosCorrectos)) {
            echo '<script>showNotification("success", "¡Correos electrónicos almacenados con éxito!");</script>';
        }

        if (!empty($correosIncorrectos)) {
            echo "<script>showNotification('info', 'Los siguientes correos electrónicos no son válidos: " . implode(', ', $correosIncorrectos) . "');</script>";
        }
    } else {
        echo "<script>showNotification('error', 'No se proporcionaron correos electrónicos.');</script>";
    }
}
?>

<!-- Añadir el título -->
<div class="paddingHeader"></div>
<div class="formInviteUsers" id="formInviteUsers">
    <h1>Invitar a usuarios</h1>
</div>
<script>
    $(document).ready(function () {
        var form = $('<form></form>', {
            'method': 'post',
            'action': '',
        });

        $('#formInviteUsers').append(form);

        // Crear el textarea dinámicamente
        var textarea = $('<textarea></textarea>', {
            'id': 'emailTextarea',
            'name': 'emails',
            'placeholder': 'Introduce correos electrónicos separados por comas o saltos de línea',
            'rows': '4',
            'cols': '50',
            'oninput': 'checkEmails()'
        });

        // Adjuntar el textarea al body
        $('form').append(textarea);

        // Crear el botón de enviar dinámicamente
        var enviarButton = $('<button></button>', {
            'id': 'enviarButton',
            'text': 'Enviar',
            'style': 'display:none', // Inicialmente oculto
            'click': function () {
                almacenarEnArray();
                validarEmails();
            }
        });

        $('form').append(enviarButton);
    });

    function checkEmails() {
        var emails = $('#emailTextarea').val();
        var enviarButton = $('#enviarButton');

        if (emails.trim() !== '') {
            enviarButton.show();
        } else {
            enviarButton.hide();
        }
    }
</script>

<?php 
include './components/banner.php';
include './components/footer.php';
?>

</body>

</html>
<?php
    } else {
        include("./errors/error403.php");
    }
}
?>