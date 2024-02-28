<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="./img/vota-si.png" />
    <script src="https://kit.fontawesome.com/8946387bf5.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="functions.js"></script>
    <title>Cambiar contraseña | 2024</title>
</head>
<body>
    <?php include './components/header.php'; ?>
    <div id="notificationContainer"></div>

    <?php
    include("config.php");
    include './components/log.php';
    if (!isset($_SESSION['UserID'])) {
        include('./errors/error403.php');
    } else {
        ?>
    
    <div class="changePassword">
        <div class="changePasswordForm">
            <h2>Cambiar contraseña</h2>
            <form method="POST">
                <input type="password" name="currentPassword" id="currentPassword" placeholder="Contraseña actual" required>
                <input type="password" name="newPassword" id="newPassword" placeholder="Nueva contraseña" required>
                <input type="password" name="confirmNewPassword" id="confirmNewPassword" placeholder="Confirmar nueva contraseña" required>
                <input type="submit" value="Cambiar">
            </form>
        </div>
        <div class="changePasswordInfo">
            <h2>Información</h2>
            <p>Para cambiar tu contraseña, llena los campos de arriba con tu contraseña actual y la nueva contraseña que deseas usar. Asegúrate de que la nueva contraseña sea segura y que no la compartas con nadie.</p>
            <img src="./img/changePassword.svg" alt="">
        </div>
    </div>
    <?php include './components/banner.php'; ?>
    <?php include './components/footer.php' ?>
        <?php 
        echo var_dump($_SESSION["UserID"]);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['currentPassword']) && isset($_POST['newPassword']) && isset($_POST['confirmNewPassword'])) {
                $dsn = "mysql:host=localhost;dbname=project_vota";
                $pdo = new PDO($dsn, $dbUser, $dbPass);
                $passwordQuery = $pdo->prepare('SELECT Password FROM Users WHERE ID = :UserID');
                $passwordQuery->bindParam(':UserID', $_SESSION['UserID']);
                $passwordQuery->execute();
                $passwordRow = $passwordQuery->fetch();
                $currentPassword = $passwordRow['Password'];
                echo $currentPassword;
                if (hash('sha512', $_POST['currentPassword']) == $currentPassword) {
                    if ($_POST['newPassword'] == $_POST['confirmNewPassword']) {
                        $pdo->beginTransaction();
                        $updateQuery = $pdo->prepare('UPDATE Users SET Password = ? WHERE ID = ?');
                        $updateQuery->bindParam(1, hash('sha512', $_POST['newPassword']));
                        $updateQuery->bindParam(2, $_SESSION['UserID']);
                        $updateQuery->execute();
                        $UserVoteQuery = $pdo->prepare('SELECT * FROM User_Vote WHERE UserID = ?');
                        $UserVoteQuery->bindParam(1, $_SESSION['UserID']);
                        $UserVoteQuery->execute();
                        $UserVoteRow = $UserVoteQuery->fetch();
                        while ($UserVoteRow) {
                            $currentHash = openssl_encrypt($UserVoteRow["Vote"], 'AES-128-CBC', $_POST['currentPassword']);
                            $newHash = openssl_encrypt($UserVoteRow["Vote"], 'AES-128-CBC', $_POST['newPassword']);
                            $updateVotesQuery = $pdo->prepare("UPDATE Votes SET VoteHash = ? WHERE VoteHash = ?");
                            $updateVotesQuery->bindParam(2, $currentHash);
                            $updateVotesQuery->bindParam(1, $newHash);
                            $updateVotesQuery->execute();
                            $UserVoteRow = $UserVoteQuery->fetch();
                        }
                        $pdo->commit();
                        ?>
                        <script>
                            showNotification('success', 'Tu contraseña ha sido cambiada con éxito');
                            //log
                            <?php escribirEnLog("[PASSWORDCHANGE] El usuario ".$_SESSION['UserID']." ha cambiado su contraseña"); ?>
                        </script>
                        <?php
                    } else {
                        ?>
                        <script>
                            showNotification('error', 'Las contraseñas no coinciden');
                            //log
                            <?php escribirEnLog("[PASSWORDCHANGE] Intento de cambio de contraseña fallido, las nuevas contraseñas del usuario ".$_SESSION['UserID']." no coinciden"); ?>
                        </script>
                        <?php
                    }
                } else {
                    ?>
                    <script>
                        showNotification('error', 'La contraseña actual no es correcta');
                        //log
                        <?php escribirEnLog("[PASSWORDCHANGE] Intento de cambio de contraseña fallido, la contraseña actual del usuario ".$_SESSION['UserID']." no es correcta"); ?>
                    </script>
                    <?php
                }
            } else {
                ?>
                <script>
                    showNotification('error', 'Debes llenar todos los campos');
                    //log
                    <?php escribirEnLog("[PASSWORDCHANGE] Intento de cambio de contraseña fallido, el usuario ".$_SESSION['UserID']." no ha llenado todos los campos"); ?>
                </script>
                
                <?php
                
            }
        }
    }
    ?>
</body>
</html>