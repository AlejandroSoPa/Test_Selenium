<?php
session_start();
include("config.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';


function getTokenFromEmail($email, $pollID) {
    include("config.php");
    try {
        $dsn = "mysql:host=localhost;dbname=project_vota";
        $pdo = new PDO($dsn, $dbUser, $dbPass);

        $stmt = $pdo->prepare("SELECT PIU.tokenQuestion 
                              FROM email_queue EQ
                              JOIN Users U ON EQ.email = U.Email
                              JOIN Poll_InvitedUsers PIU ON U.ID = PIU.UserID AND EQ.PollID = PIU.PollID
                              WHERE U.Email = ? AND EQ.PollID = ?");
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $pollID);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result !== false) {
            return $result['tokenQuestion'];
        } else {
            return null;
        }
            
    } catch (PDOException $e) {
        echo $e->getMessage();
        escribirEnLog("[ENVIAR] " . $e->getMessage());
    }
}

function enviarCorreo($pdo, $destinatario, $username, $pollID) {
    
    $token = getTokenFromEmail($destinatario);
    $title = "Has sido invitado para votar, " . $username . "!";
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
  <td align="center" style="padding:0;Margin:0;padding-bottom:10px"><h1 style="Margin:0;font-family, helvetica, arial, sans-serif;mso-line-height-rule:exactly;letter-spacing:0;font-size:30px;font-style:normal;font-weight:bold;line-height:36px;color:#212121">¡Has sido invitado a votar a una encuesta!</h1> </td></tr><tr><td align="center" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px"><p style="Margin:0;mso-line-height-rule:exactly;font-family, helvetica, arial, sans-serif;line-height:24px;letter-spacing:0;color:#131313;font-size:16px">¡Hola! Has sido invitado a votar en una encuesta de nuestro portal de votaciones VOTA EJA.&nbsp;</p></td></tr></table></td></tr></table></td></tr> <tr>
    <td class="es-m-p15t es-m-p0b es-m-p0r es-m-p0l" align="left" style="padding:0;Margin:0;padding-top:15px"><table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" valign="top" style="padding:0;Margin:0;width:600px"><table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" style="padding:0;Margin:0;font-size:0px"><img class="adapt-img" src="https://ffifbrp.stripocdn.email/content/guids/CABINET_1ce849b9d6fc2f13978e163ad3c663df/images/3991592481152831.png" alt="" style="display:block;font-size:16px;border:0;outline:none;text-decoration:none" width="600"></td></tr></table></td></tr></table></td></tr></table></td></tr> </table>
     <table cellpadding="0" cellspacing="0" class="es-content" align="center" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important"><tr><td align="center" bgcolor="#071f4f" style="padding:0;Margin:0;background-color:#071f4f;background-image:url(https://ffifbrp.stripocdn.email/content/guids/CABINET_1ce849b9d6fc2f13978e163ad3c663df/images/10801592857268437.png);background-repeat:no-repeat;background-position:center top" background="https://ffifbrp.stripocdn.email/content/guids/CABINET_1ce849b9d6fc2f13978e163ad3c663df/images/10801592857268437.png"><table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px"><tr>
    <td align="left" style="Margin:0;padding-right:30px;padding-left:30px;padding-top:40px;padding-bottom:40px"><table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" valign="top" style="padding:0;Margin:0;width:540px"><table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" height="20" style="padding:0;Margin:0"></td> </tr><tr>
    <td align="left" style="padding:0;Margin:0;padding-bottom:10px"><h1 style="Margin:0;mso-line-height-rule:exactly;letter-spacing:0;font-size:30px;font-style:normal;font-weight:bold;line-height:36px;color:#fff;text-align:center">Accede a este enlace para poder votar en esta encuesta</h1></td></tr><tr><td align="center" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px"><p style="Margin:0;mso-line-height-rule:exactly;font-family, helvetica, arial, sans-serif;line-height:24px;letter-spacing:0;color:#ffffff;font-size:16px"><a class="btn" style="font-size:30px;color:#fff" href="https://aws25.ieti.site/Proyecto_Vota/votePoll.php?tokenQuestion='.$token.'">Votar</a></p></td></tr></table></td></tr></table></td></tr></table></td></tr></table>
     <table cellpadding="0" cellspacing="0" class="es-content" align="center" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important"><tr><td align="center" bgcolor="#f8f9fd" style="padding:0;Margin:0;background-color:#f8f9fd;background-image:url(https://ffifbrp.stripocdn.email/content/guids/CABINET_1ce849b9d6fc2f13978e163ad3c663df/images/83191592482092483.png);background-repeat:no-repeat;background-position:center center" background="https://ffifbrp.stripocdn.email/content/guids/CABINET_1ce849b9d6fc2f13978e163ad3c663df/images/83191592482092483.png"><table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px"><tr>
    <td align="left" style="Margin:0;padding-bottom:15px;padding-right:20px;padding-left:20px;padding-top:40px"><table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" valign="top" style="padding:0;Margin:0;width:281px"><table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="left" style="padding:0;Margin:0"><h1 style="Margin:0;font-family, helvetica, arial, sans-serif;mso-line-height-rule:exactly;letter-spacing:0;font-size:30px;font-style:normal;font-weight:bold;line-height:36px;color:#212121;text-align:center">Atentamente, el equipo de VOTA EJA</h1> </td></tr></table></td></tr></table></td></tr><tr>
    <td class="es-m-p15t es-m-p20b es-m-p15r es-m-p15l" align="left" style="padding:0;Margin:0;padding-top:15px;padding-bottom:20px"><table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" valign="top" style="padding:0;Margin:0;width:600px"><table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" style="padding:0;Margin:0;display:none"></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></div></body></html>';

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Mailer = "smtp";

    $mail->SMTPDebug  = 2;
    $mail->SMTPAuth   = TRUE;
    $mail->SMTPSecure = "tls";
    $mail->Port       = 587;
    $mail->Host       = "smtp.gmail.com";
    $mail->Username   = "jbernabeucaballero.cf@iesesteveterradas.cat"; 
    $mail->Password   = "KekHut93"; 

    $mail->IsHTML(true);
    $mail->AddAddress($destinatario);
    $mail->SetFrom("jbernabeucaballero.cf@iesesteveterradas.cat", "Vota EJA");

    $mail->Subject = $title;
    $mail->MsgHTML($content);

    if ($mail->Send()) {
        return true; 
    } else {
        return false; 
    }
}

try {
    $dsn = "mysql:host=localhost;dbname=project_vota";
    $pdo = new PDO($dsn, $dbUser, $dbPass);

   
    $userID = $_SESSION['UserID'];

} catch (PDOException $e) {
    echo $e->getMessage();
    escribirEnLog("[ENVIAR] " . $e->getMessage());
}


try {
    $mysqli = new mysqli("localhost", $dbUser, $dbPass, "project_vota");

    if ($mysqli->connect_error) {
        die("Error de conexión a la base de datos: " . $mysqli->connect_error);
    }
    $result = $mysqli->query("SELECT email, PollID FROM email_queue LIMIT 5");

    if ($result->num_rows > 0) {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Mailer = "smtp";
        $mail->SMTPDebug  = 2;
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port       = 587;
        $mail->Host       = "smtp.gmail.com";
        $mail->Username   = "jbernabeucaballero.cf@iesesteveterradas.cat";
        $mail->Password   = "KekHut93"; // Password de la cuenta de correo

        while ($row = $result->fetch_assoc()) {
            $email = $row['email'];
            $pollID = $row['PollID'];
        
            $token = getTokenFromEmail($email, $pollID);
        
            if ($token) {
                if (enviarCorreo($pdo, $email, "Nombre de Usuario", $pollID)) {
                    echo "Correo enviado a: $email<br>";
                } else {
                    // hacer echo del error:
                    $error = $mail->ErrorInfo;
                    echo "Error al enviar correo a: $email. Detalles del error: $error<br>";
                }
            } else {
                echo "No se encontró token para el correo: $email<br>";
            }
        }

        $mysqli->query("DELETE FROM email_queue LIMIT 5");

        $mysqli->close();
    } else {
        echo "No hay correos electrónicos en la cola.";
    }
} catch (Exception $e) {
    escribirEnLog("[ENVIAR]" . $e->getMessage());
}

?>
