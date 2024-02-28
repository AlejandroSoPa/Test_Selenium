<?php
include("config.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

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
    escribirEnLog("[RECOVER_PASSWORD] " . $e);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_GET['validToken'])) {
    $destinatario = $_POST['userEmail'];

    // Verificar si el correo está registrado
    $emailCheckQuery = $pdo->prepare("SELECT * FROM Users WHERE Email = ?");
    $emailCheckQuery->execute([$destinatario]);
    $userData = $emailCheckQuery->fetch(PDO::FETCH_ASSOC);

    if ($userData) {
        // Verificar si ya existe una solicitud en la tabla password_recovery_requests
        $checkExistingQuery = $pdo->prepare("SELECT * FROM password_recovery_requests WHERE email = ?");
        $checkExistingQuery->execute([$destinatario]);
        $existingData = $checkExistingQuery->fetch(PDO::FETCH_ASSOC);

        if ($existingData) {
            // Tomar el token existente
            $token = $existingData['token'];
        } else {
            // Generar un nuevo token
            $token = generarToken();

            // Insertar en la tabla password_recovery_requests
            $insertTokenQuery = $pdo->prepare("INSERT INTO password_recovery_requests (email, token) VALUES (?, ?)");
            $insertTokenQuery->execute([$destinatario, $token]);
        }

        // Enviar el correo con el token
        $title = "Recuperación de Contraseña | Vota EJA";
        $content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html dir="ltr" lang="es"><head><meta charset="UTF-8"><meta content="width=device-width, initial-scale=1" name="viewport"><meta name="x-apple-disable-message-reformatting"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta content="telephone=no" name="format-detection"><title>New Template</title> <!--[if (mso 16)]><style type="text/css">     a {text-decoration: none;}     </style><![endif]--> <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--> <!--[if gte mso 9]><xml> <o:OfficeDocumentSettings> <o:AllowPNG></o:AllowPNG> <o:PixelsPerInch>96</o:PixelsPerInch> </o:OfficeDocumentSettings> </xml>
        <![endif]--> <!--[if !mso]><!-- --><link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,700,700i" rel="stylesheet"> <!--<![endif]--><style type="text/css">.rollover:hover .rollover-first { max-height:0px!important; display:none!important; } .rollover:hover .rollover-second { max-height:none!important; display:block!important; } .rollover span { font-size:0px; } u + .body img ~ div div { display:none; } #outlook a { padding:0; } span.MsoHyperlink,span.MsoHyperlinkFollowed { color:inherit; mso-style-priority:99; } a.es-button { mso-style-priority:100!important; text-decoration:none!important; } a[x-apple-data-detectors] { color:inherit!important; text-decoration:none!important; font-size:inherit!important; font-family:inherit!important; font-weight:inherit!important; line-height:inherit!important; } .es-desk-hidden { display:none; float:left; overflow:hidden; width:0; max-height:0; line-height:0; mso-hide:all; }
         .es-button-border:hover { border-color:#42d159 #42d159 #42d159 #42d159!important; background:#0b317e!important; } .es-button-border:hover a.es-button,.es-button-border:hover button.es-button { background:#0b317e!important; color:#ffffff!important; }@media only screen and (max-width:600px) {.es-m-p15t { padding-top:15px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0b { padding-bottom:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p15r { padding-right:15px!important } .es-m-p20b { padding-bottom:20px!important } .es-m-p15l { padding-left:15px!important } *[class="gmail-fix"] { display:none!important } p, a { line-height:150%!important } h1, h1 a { line-height:120%!important } h2, h2 a { line-height:120%!important } h3, h3 a { line-height:120%!important } h4, h4 a { line-height:120%!important } h5, h5 a { line-height:120%!important } h6, h6 a { line-height:120%!important }
         h1 { font-size:30px!important; text-align:center } h2 { font-size:26px!important; text-align:center } h3 { font-size:20px!important; text-align:center } h4 { font-size:24px!important; text-align:left } h5 { font-size:20px!important; text-align:left } h6 { font-size:16px!important; text-align:left } .es-header-body h1 a, .es-content-body h1 a, .es-footer-body h1 a { font-size:30px!important } .es-header-body h2 a, .es-content-body h2 a, .es-footer-body h2 a { font-size:26px!important } .es-header-body h3 a, .es-content-body h3 a, .es-footer-body h3 a { font-size:20px!important } .es-header-body h4 a, .es-content-body h4 a, .es-footer-body h4 a { font-size:24px!important } .es-header-body h5 a, .es-content-body h5 a, .es-footer-body h5 a { font-size:20px!important } .es-header-body h6 a, .es-content-body h6 a, .es-footer-body h6 a { font-size:16px!important } .es-menu td a { font-size:14px!important }
         .es-header-body p, .es-header-body a { font-size:16px!important } .es-content-body p, .es-content-body a { font-size:16px!important } .es-footer-body p, .es-footer-body a { font-size:14px!important } .es-infoblock p, .es-infoblock a { font-size:12px!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3, .es-m-txt-c h4, .es-m-txt-c h5, .es-m-txt-c h6 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3, .es-m-txt-r h4, .es-m-txt-r h5, .es-m-txt-r h6 { text-align:right!important } .es-m-txt-j, .es-m-txt-j h1, .es-m-txt-j h2, .es-m-txt-j h3, .es-m-txt-j h4, .es-m-txt-j h5, .es-m-txt-j h6 { text-align:justify!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3, .es-m-txt-l h4, .es-m-txt-l h5, .es-m-txt-l h6 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important }
         .es-m-txt-r .rollover:hover .rollover-second, .es-m-txt-c .rollover:hover .rollover-second, .es-m-txt-l .rollover:hover .rollover-second { display:inline!important } .es-m-txt-r .rollover span, .es-m-txt-c .rollover span, .es-m-txt-l .rollover span { line-height:0!important; font-size:0!important } .es-spacer { display:inline-table } a.es-button, button.es-button { font-size:16px!important; line-height:120%!important } a.es-button, button.es-button, .es-button-border { display:block!important } .es-m-fw, .es-m-fw.es-fw, .es-m-fw .es-button { display:block!important } .es-m-il, .es-m-il .es-button, .es-social, .es-social td, .es-menu { display:inline-block!important } .es-adaptive table, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .adapt-img { width:100%!important; height:auto!important }
         .es-mobile-hidden, .es-hidden { display:none!important } .es-desk-hidden { width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } tr.es-desk-hidden { display:table-row!important } table.es-desk-hidden { display:table!important } td.es-desk-menu-hidden { display:table-cell!important } .es-menu td { width:1%!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } .es-social td { padding-bottom:10px } .h-auto { height:auto!important } .st-br { padding-left:10px!important; padding-right:10px!important } h1 a { text-align:center } h2 a { text-align:center } h3 a { text-align:center } }@media screen and (max-width:384px) {.mail-message-content { width:414px!important } }</style>
         </head> <body data-new-gr-c-s-check-loaded="14.1021.0" data-gr-ext-installed="" class="body" style="width:100%;height:100%;padding:0;Margin:0"><div dir="ltr" class="es-wrapper-color" lang="es" style="background-color:#F8F9FD"> <!--[if gte mso 9]><v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t"> <v:fill type="tile" color="#f8f9fd"></v:fill> </v:background><![endif]--><table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;background-color:#F8F9FD"><tr>
        <td valign="top" style="padding:0;Margin:0"><table cellpadding="0" cellspacing="0" class="es-header" align="center" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important;background-color:transparent;background-repeat:repeat;background-position:center top"><tr><td align="center" style="padding:0;Margin:0"><table bgcolor="#ffffff" class="es-header-body" align="center" cellpadding="0" cellspacing="0" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px"><tr><td align="left" style="Margin:0;padding-top:10px;padding-right:30px;padding-bottom:15px;padding-left:30px"><table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr>
        <td align="center" valign="top" style="padding:0;Margin:0;width:540px"><table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" style="padding:0;Margin:0;font-size:0px"><img src="https://ffifbrp.stripocdn.email/content/guids/CABINET_30920521403ecf2502fca84f71fbcad8c7bb04b1688435b443188acbac3693e5/images/votacion.png" alt="" style="display:block;font-size:16px;border:0;outline:none;text-decoration:none" width="130" class="adapt-img"></td> </tr></table></td></tr></table></td></tr></table></td></tr></table> <table cellpadding="0" cellspacing="0" class="es-content" align="center" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important"><tr>
        <td align="center" bgcolor="#f8f9fd" style="padding:0;Margin:0;background-color:#f8f9fd"><table bgcolor="transparent" class="es-content-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" role="none"><tr><td align="left" style="Margin:0;padding-top:20px;padding-right:20px;padding-bottom:10px;padding-left:20px"><table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" valign="top" style="padding:0;Margin:0;width:560px"><table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr>
      <td align="center" style="padding:0;Margin:0;padding-bottom:10px"><h1 style="Margin:0;font-family, helvetica, arial, sans-serif;mso-line-height-rule:exactly;letter-spacing:0;font-size:30px;font-style:normal;font-weight:bold;line-height:36px;color:#212121">¡Recupera tu contraseña!</h1> </td></tr><tr><td align="center" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px"><p style="Margin:0;mso-line-height-rule:exactly;font-family, helvetica, arial, sans-serif;line-height:24px;letter-spacing:0;color:#131313;font-size:16px">Recupera tu contraseña accediendo a este enlace.&nbsp;</p></td></tr></table></td></tr></table></td></tr> <tr>
        <td class="es-m-p15t es-m-p0b es-m-p0r es-m-p0l" align="left" style="padding:0;Margin:0;padding-top:15px"><table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" valign="top" style="padding:0;Margin:0;width:600px"><table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" style="padding:0;Margin:0;font-size:0px"><img class="adapt-img" src="https://ffifbrp.stripocdn.email/content/guids/CABINET_1ce849b9d6fc2f13978e163ad3c663df/images/3991592481152831.png" alt="" style="display:block;font-size:16px;border:0;outline:none;text-decoration:none" width="600"></td></tr></table></td></tr></table></td></tr></table></td></tr> </table>
         <table cellpadding="0" cellspacing="0" class="es-content" align="center" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important"><tr><td align="center" bgcolor="#071f4f" style="padding:0;Margin:0;background-color:#071f4f;background-image:url(https://ffifbrp.stripocdn.email/content/guids/CABINET_1ce849b9d6fc2f13978e163ad3c663df/images/10801592857268437.png);background-repeat:no-repeat;background-position:center top" background="https://ffifbrp.stripocdn.email/content/guids/CABINET_1ce849b9d6fc2f13978e163ad3c663df/images/10801592857268437.png"><table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px"><tr>
        <td align="left" style="Margin:0;padding-right:30px;padding-left:30px;padding-top:40px;padding-bottom:40px"><table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" valign="top" style="padding:0;Margin:0;width:540px"><table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" height="20" style="padding:0;Margin:0"></td> </tr><tr>
        <td align="left" style="padding:0;Margin:0;padding-bottom:10px"><h1 style="Margin:0;mso-line-height-rule:exactly;letter-spacing:0;font-size:30px;font-style:normal;font-weight:bold;line-height:36px;color:#fff;text-align:center">Accede a este enlace para poder recuperar tu contraseña</h1></td></tr><tr><td align="center" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px"><p style="Margin:0;mso-line-height-rule:exactly;font-family, helvetica, arial, sans-serif;line-height:24px;letter-spacing:0;color:#ffffff;font-size:16px"><a class="btn" style="font-size:30px;color:#fff" href="https://aws25.ieti.site/Proyecto_Vota/forgot_password.php?validToken=' . $token . '">Votar</a></p></td></tr></table></td></tr></table></td></tr></table></td></tr></table>
         <table cellpadding="0" cellspacing="0" class="es-content" align="center" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important"><tr><td align="center" bgcolor="#f8f9fd" style="padding:0;Margin:0;background-color:#f8f9fd;background-image:url(https://ffifbrp.stripocdn.email/content/guids/CABINET_1ce849b9d6fc2f13978e163ad3c663df/images/83191592482092483.png);background-repeat:no-repeat;background-position:center center" background="https://ffifbrp.stripocdn.email/content/guids/CABINET_1ce849b9d6fc2f13978e163ad3c663df/images/83191592482092483.png"><table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px"><tr>
        <td align="left" style="Margin:0;padding-bottom:15px;padding-right:20px;padding-left:20px;padding-top:40px"><table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" valign="top" style="padding:0;Margin:0;width:281px"><table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="left" style="padding:0;Margin:0"><h1 style="Margin:0;font-family, helvetica, arial, sans-serif;mso-line-height-rule:exactly;letter-spacing:0;font-size:30px;font-style:normal;font-weight:bold;line-height:36px;color:#212121;text-align:center">Atentamente, el equipo de VOTA EJA</h1> </td></tr></table></td></tr></table></td></tr><tr>
        <td class="es-m-p15t es-m-p20b es-m-p15r es-m-p15l" align="left" style="padding:0;Margin:0;padding-top:15px;padding-bottom:20px"><table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" valign="top" style="padding:0;Margin:0;width:600px"><table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" style="padding:0;Margin:0;display:none"></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></div></body></html>';
        
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Mailer = "smtp";

        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port       = 587;
        $mail->Host       = "smtp.gmail.com";
        $mail->Username   = "jbernabeucaballero.cf@iesesteveterradas.cat"; // Email de la cuenta de correo desde la que se enviarán los correos
        $mail->Password   = "KekHut93"; // Password de la cuenta de correo

        $mail->IsHTML(true);
        $mail->AddAddress($destinatario);
        $mail->SetFrom("jbernabeucaballero.cf@iesesteveterradas.cat", "Vota EJA");

        $mail->Subject = $title;
        $mail->MsgHTML($content);

        if ($mail->Send()) {
            echo '<script>showNotification("success", "Se ha enviado un correo de prueba.");</script>';
            header("Location: forgot_password.php");
            exit;
        } else {
            // Manejar error de envío de correo
        }
    } else {
        echo '<script>showNotification("error", "El correo electrónico no está registrado.");</script>';
    }
} elseif (isset($_GET['validToken'])) {
    // Si se proporciona un token en la URL, procesar el cambio de contraseña
    $validToken = $_GET['validToken'];

    // Buscar el token en la tabla password_recovery_requests
    $checkTokenQuery = $pdo->prepare("SELECT * FROM password_recovery_requests WHERE token = ?");
    $checkTokenQuery->execute([$validToken]);
    $tokenData = $checkTokenQuery->fetch(PDO::FETCH_ASSOC);

    if ($tokenData) {
        // Mostrar el formulario de cambio de contraseña
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtener la nueva contraseña del formulario
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];

            // Verificar que las contraseñas coincidan
            if ($newPassword !== $confirmPassword) {
                // Contraseñas no coinciden, mostrar mensaje de error
                echo '<script>showNotification("error", "Las contraseñas no coinciden.");</script>';
            } else {
                // Cifrar la contraseña con hash sha512
                $hashedPassword = hash('sha512', $newPassword);

                // Actualizar la contraseña en la base de datos
                $updatePasswordQuery = $pdo->prepare("UPDATE Users SET Password = ? WHERE Email = ?");
                $updatePasswordQuery->execute([$hashedPassword, $tokenData['email']]);

                // Eliminar la entrada en la tabla password_recovery_requests
                $deleteTokenQuery = $pdo->prepare("DELETE FROM password_recovery_requests WHERE token = ?");
                $deleteTokenQuery->execute([$validToken]);

                // Enviar un correo de confirmación u otro mensaje si es necesario
                echo '<script>showNotification("success", "Contraseña cambiada exitosamente.");</script>';
                header("Location: forgot_password.php");
            }
        } else {
            // Mostrar el formulario de cambio de contraseña
            ?>
            <!DOCTYPE html>
            <html lang="es">
            <head>
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<link rel="stylesheet" href="styles.css">
				<script src="functions.js"></script>
				<link rel="icon" href="./img/vota-si.png" />
				<script src="https://kit.fontawesome.com/8946387bf5.js" crossorigin="anonymous"></script>
				<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
				<title>Cambiar Contraseña | Vota EJA</title>
				<script>
					function validatePassword() {
						var newPassword = document.getElementById("newPassword").value;
						var confirmPassword = document.getElementById("confirmPassword").value;

						// Agrega tus propias reglas de validación aquí
						var passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

						if (!passwordRegex.test(newPassword)) {
							showNotification('error', 'La contraseña debe contener al menos una mayúscula, un número y un carácter especial, y tener al menos 8 caracteres.');
							return false;
						}

						if (newPassword !== confirmPassword) {
							showNotification('error', 'Las contraseñas no coinciden.');
							return false;
						}

						return true;
					}
				</script>
			</head>
				<body>
                <?php include './components/header.php'; ?>
                <?php include './components/log.php'; ?>
                <div id="notificationContainer"></div>
                <section class="loginSection">
                    <h1>Cambiar Contraseña</h1>
                    <div class="loginForm">
                        <div class="circleLoginForm">
                            <h3>Ingresa tu nueva contraseña</h3>
                            <form method="POST" action="" onsubmit="return validatePassword()">
                                <input type="password" name="newPassword" id="newPassword" placeholder="Nueva Contraseña" required>
                                <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirmar Contraseña" required>
                                <input type="hidden" name="token" value="<?= $validToken ?>">
                                <button type="submit" class="btnForm">Cambiar Contraseña</button>
                            </form>
                        </div>
                    </div>
                    <div class="loginImg">
                        <!-- Puedes personalizar esta parte según tus necesidades -->
                        <img src="./img/forgotPassword.svg">
                    </div>
                </section>
                <?php include './components/footer.php'; ?>
            </body>
            </html>
            <?php
        }
    } else {
        // Redirigir a la página normal o mostrar un mensaje
        header("Location: forgot_password.php");
        
        exit;
    }
} else {
    // Código restante para el caso normal (sin token en la URL)
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <script src="functions.js"></script>
        <link rel="icon" href="./img/vota-si.png" />
        <script src="https://kit.fontawesome.com/8946387bf5.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <title>Recuperar Contraseña | Vota EJA</title>
        <script>
             function validatePassword() {
                var newPassword = document.getElementById("newPassword").value;
                var confirmPassword = document.getElementById("confirmPassword").value;
                var passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
                if (!passwordRegex.test(newPassword)) {
                    showNotification('error', 'La contraseña debe contener al menos una mayúscula, un número y un carácter especial, y tener al menos 8 caracteres.');
                    return false;
                }
                if (newPassword !== confirmPassword) {
                    showNotification('error', 'Las contraseñas no coinciden.');
                    return false;
                }
                return true;
            }
        </script>
    </head>
    <body>
        <?php include './components/header.php'; ?>
        <?php include './components/log.php'; ?>
        <div id="notificationContainer"></div>
        <section class="loginSection">
            <h1>Recuperar Contraseña</h1>
            <div class="loginForm">
                <div class="circleLoginForm">
                    <h3>Ingresa tu correo electrónico</h3>
                    <form method="POST" action="" onsubmit="return validatePassword()">
                        <input type="email" name="userEmail" placeholder="Correo Electrónico" required>
                        <button type="submit" class="btnForm">Enviar email</button>
                    </form>
                </div>
            </div>
            <div class="loginImg">
                <img src="./img/forgotPassword.svg">
            </div>
        </section>
        <?php include './components/footer.php'; ?>
    </body>
    </html>
    <?php
}
?>
