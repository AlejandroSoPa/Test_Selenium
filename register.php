<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="./img/vota-si.png" />
    <script src="https://kit.fontawesome.com/8946387bf5.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="functions.js"></script>
    <script src="register.js"></script>
    <title>Registro | Vota EJA</title>
</head>
<body>
    <div id="notificationContainer"></div>

    <?php include("./components/log.php")?>
    <?php include './components/header.php'; ?>

    <section class="loginSection regSection">
        <h1>Bienvenido a Vota EJA!</h1>
        <div class="registerForm">
            <div class="circleRegisterForm">
                <div class="textReg">
                    <h3>Regístrate</h3>
                    <p>Completa todos los campos</p>
                </div>
                <form method="POST">
                    
                </form>
                <div class=""></div>
            </div>
        </div>

        <div class="loginImg">
            <img src="./img/register.svg">
        </div>
    </section>
    <?php include './components/banner.php'; ?>
    <?php include("./components/footer.php")?>

    <?php 
                
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    include("config.php");
    try {
        $hostname = "localhost";
        $dbname = "project_vota";
        $username = $dbUser;
        $pw = $dbPass;
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", "$username", "$pw");
    } catch (PDOException $e) {
        echo "Failed to get DB handle: ". $e->getMessage();
        escribirEnLog("[REGISTER] ".$e);
        exit;
    }
    

    if (isset($_POST["username"])) {
        $errorShown = false;
        echo "<script>";
        $username = $_POST["username"];
        $password = $_POST["password"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $country = $_POST["country"];
        $city = $_POST["city"];
        $postalCode = $_POST["postalCode"];
        $userIsGuest = false;
        if (strlen($username) == 0) {
            echo "showNotification('error', 'Inserte un nombre de usuario');\n";
            //log
            escribirEnLog("[REGISTER] Nombre de usuario inválido");
            if (!$errorShown) {
                echo "showStep(0);\n";
                $errorShown = true;
            }
        } else if (str_contains($username,';') or str_contains($username,'--') or str_contains($username,'/*') or str_contains($username, "*/")) {
            echo "showNotification('error', 'El nombre de usuario contiene carácteres no permitidos');\n";
            //log
            escribirEnLog("[REGISTER] Nombre de usuario inválido (caracteres no permitidos)");
            if (!$errorShown) {
                echo "showStep(0);\n";
                $errorShown = true;
            }
        }
        if (strlen($password) < 8) {
            echo "showNotification('error', 'La contraseña debe tener un mínimo de 8 carácteres');\n";
            //log
            escribirEnLog("[REGISTER] Contraseña inválida (menos de 8 caracteres)");
            if (!$errorShown) {
                echo "showStep(0);\n";
                $errorShown = true;
            }
        } else if (str_contains($password,';') or str_contains($password,'--') or str_contains($password,'/*') or str_contains($password, "*/")) {
            echo "showNotification('error', 'La contraseña contiene carácteres no permitidos');\n";
            //log
            escribirEnLog("[REGISTER] Contraseña inválida (caracteres no permitidos)");
            if (!$errorShown) {
                echo "showStep(0);\n";
                $errorShown = true;
            }
        } else if (!preg_match('/\d/', $password)) {
            echo "showNotification('error', 'La contraseña debe contener al menos un carácter numérico');\n";
            //log
            escribirEnLog("[REGISTER] Contraseña inválida (sin carácter numérico)");
            if (!$errorShown) {
                echo "showStep(0);\n";
                $errorShown = true;
            }
        } else if (!preg_match('/[A-Z]/', $password)) {
            echo "showNotification('error', 'La contraseña debe contener al menos una mayúscula');\n";
            //log
            escribirEnLog("[REGISTER] Contraseña inválida (sin mayúscula)");
            if (!$errorShown) {
                echo "showStep(0);\n";
                $errorShown = true;
            }
        } else if (!preg_match('/[a-z]/', $password)) {
            echo "showNotification('error', 'La contraseña debe contener al menos una minúscula');\n";
            //log
            escribirEnLog("[REGISTER] Contraseña inválida (sin minúscula)");
            if (!$errorShown) {
                echo "showStep(0);\n";
                $errorShown = true;
            }
        } else if (!preg_match('/[ `!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?~]/', $password)) {
            echo "showNotification('error', 'La contraseña debe contener al menos un carácter especial');\n";
            //log
            escribirEnLog("[REGISTER] Contraseña inválida (sin carácter especial)");
            if (!$errorShown) {
                echo "showStep(0);\n";
                $errorShown = true;
            }
        }

        if (!preg_match('/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email)) {
            echo "showNotification('error', 'La dirección de correo electrónico no es válida');\n";
            //log
            escribirEnLog("[REGISTER] Email inválido");
            if (!$errorShown) {
                echo "showStep(0);\n";
                $errorShown = true;
            }
        } else if (str_contains($email,';') or str_contains($email,'--') or str_contains($email,'/*') or str_contains($email, "*/")) {
            echo "showNotification('error', 'La dirección de correo electrónico contiene carácteres no permitidos');\n";
            //log
            escribirEnLog("[REGISTER] Email inválido (caracteres no permitidos)");
            if (!$errorShown) {
                echo "showStep(0);\n";
                $errorShown = true;
            }
        } else {
            $query = $pdo -> prepare("SELECT * FROM Users WHERE `Email` = ?");
            $query->bindParam(1, $email);
            $query -> execute();
            $row = $query -> fetch();
            if ($row) {
                if ($row["Password"] == "") {
                    $userIsGuest = true;
                } else {
                    echo "showNotification('error', 'La dirección de correo electrónico ya está enlazada a una cuenta');\n";
                    //log
                    escribirEnLog("[REGISTER] Email inválido (ya enlazado a una cuenta)");
                    if (!$errorShown) {
                        $errorShown = true;
                    }
                }
            }
        }

        if (!preg_match("/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im", $phone)) {
            echo "showNotification('error', 'Su número de teléfono debe de tener 9 dígitos y un prefijo');\n";
            //log
            escribirEnLog("[REGISTER] Número de teléfono inválido");
            if (!$errorShown) {
                echo "showStep(0);\n";
                $errorShown = true;
            }
        } else {
            $numWithoutPrefix = substr($phone, 0 -9);
            $prefix = str_replace($numWithoutPrefix, "", $phone);
            $query = $pdo -> prepare("SELECT * FROM Countries WHERE PhoneCode = ? AND CountryName = ?;");
            $query->bindParam(1, $prefix);
            $query->bindParam(2, $country);
            $query -> execute();
            $row = $query -> fetch();
            if (!$row) {
                echo "showNotification('error', 'El prefijo del número de teléfono insertado no es válido');\n";
                //log
                escribirEnLog("[REGISTER] Prefijo de número de teléfono inválido");
                if (!$errorShown) {
                    echo "showStep(0);\n";
                    $errorShown = true;
                }
            }
        }

        if (strlen($country) == 0) {
            echo "showNotification('error', 'Inserte un país');\n";
            //log
            escribirEnLog("[REGISTER] País inválido");
            if (!$errorShown) {
                echo "showStep(0);\n";
                $errorShown = true;
            }
        } else if (str_contains($country,';') or str_contains($country,'--') or str_contains($country,'/*') or str_contains($country, "*/")) {
            echo "showNotification('error', 'El país insertado contiene carácteres no permitidos');\n";
            //log
            escribirEnLog("[REGISTER] País inválido (caracteres no permitidos)");
            if (!$errorShown) {
                echo "showStep(0);\n";
                $errorShown = true;
            }
        } else {
            $query = $pdo -> prepare("SELECT * FROM Countries WHERE CountryName = ?");
            $query->bindParam(1, $country);
            $query -> execute();
            $row = $query -> fetch();
            if (!$row) {
                echo "showNotification('error', 'El país insertado no existe');\n";
                //log
                escribirEnLog("[REGISTER] País inválido (no existe)");
                if (!$errorShown) {
                    echo "showStep(0);\n";
                    $errorShown = true;
                }
            }
        }

        if (strlen($city) == 0) {
            echo "showNotification('error', 'Inserte una ciudad');\n";
            //log
            escribirEnLog("[REGISTER] Ciudad inválida");
            if (!$errorShown) {
                echo "showStep(0);\n";
                $errorShown = true;
            }
        }

        if (strlen($postalCode) == 0) {
            echo "showNotification('error', 'Inserte un código postal');\n"; 
            //log
            escribirEnLog("[REGISTER] Código postal inválido");
            if (!$errorShown) {
                echo "showStep(0);\n";
                $errorShown = true;
            }
        }
        echo '</script>';

        if (!$errorShown) {

            $tokenLength = 40;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $token = '';
            for ($i = 0; $i < $tokenLength; $i++) {
                $randomIndex = rand(0, strlen($characters) - 1);
                $token .= $characters[$randomIndex];
            }
            
            $pdo->beginTransaction();
            if ($userIsGuest) {
                $query = $pdo -> prepare("UPDATE Users SET `Username` = ?, `Password` = SHA2(?, 512), `Phone` = ?, `Country` = ?, `City` = ?, `PostalCode` = ?, `ValidationToken` = ? WHERE email = ?");
                $query->bindParam(1, $username);
                $query->bindParam(2, $password);
                $query->bindParam(3, $phone);
                $query->bindParam(4, $country);
                $query->bindParam(5, $city);
                $query->bindParam(6, $postalCode);
                $query->bindParam(7, $token);
                $query->bindParam(8, $email);
                $userIDQuery = $pdo->prepare('SELECT * FROM Users WHERE email = ?');
                $userIDQuery->bindParam(1, $email);
                $userIDQuery->execute();
                $userIDrow = $userIDQuery->fetch();
                if ($userIDrow) {
                    $userVoteQuery = $pdo->prepare('SELECT * FROM User_Vote WHERE UserID = ?');
                    $userVoteQuery->bindParam(1, $userIDrow['ID']);
                    $userVoteQuery->execute();
                    $userVoteRow = $userVoteQuery->fetch();
                    while ($userVoteRow) {
                        $currentHash = openssl_encrypt($userVoteRow["Vote"], 'AES-128-CBC', "Password1234!");
                        $newHash = openssl_encrypt($userVoteRow["Vote"], 'AES-128-CBC', $password);
                        $updateVotesQuery = $pdo->prepare("UPDATE Votes SET VoteHash = ? WHERE VoteHash = ?");
                        $updateVotesQuery->bindParam(2, $currentHash);
                        $updateVotesQuery->bindParam(1, $newHash);
                        $updateVotesQuery->execute();
                        $userVoteRow = $userVoteQuery->fetch();
                    }
                }
            } else {
            $query = $pdo -> prepare("INSERT INTO Users(`Username`, `Password`, `Phone`, `Email`, `Country`, `City`, `PostalCode`, `ValidationToken`) VALUES (?, SHA2(?, 512), ?, ?, ?, ?, ?, ?)");
            $query->bindParam(1, $username);
            $query->bindParam(2, $password);
            $query->bindParam(3, $phone);
            $query->bindParam(4, $email);
            $query->bindParam(5, $country);
            $query->bindParam(6, $city);
            $query->bindParam(7, $postalCode);
            $query->bindParam(8, $token);
           }
            
            $query -> execute();
            session_start();
            $query = $pdo -> prepare("SELECT * FROM Users WHERE `Email` = ?");
            $query->bindParam(1, $email);
            $query -> execute();
            $row = $query->fetch();

            $pdo->commit();



            require 'PHPMailer-master/src/Exception.php';
            require 'PHPMailer-master/src/PHPMailer.php';
            require 'PHPMailer-master/src/SMTP.php';

            $destinatary = $email;

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $destinatario = $destinatary;
                $title = "Bienvenido, " . $username . "!";
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
<td align="center" style="padding:0;Margin:0;padding-bottom:10px"><h1 style="Margin:0;font-family, helvetica, arial, sans-serif;mso-line-height-rule:exactly;letter-spacing:0;font-size:30px;font-style:normal;font-weight:bold;line-height:36px;color:#212121">¡Bienvenido a VOTA EJA!</h1> </td></tr><tr><td align="center" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px"><p style="Margin:0;mso-line-height-rule:exactly;font-family, helvetica, arial, sans-serif;line-height:24px;letter-spacing:0;color:#131313;font-size:16px">Bienvenido, ' . $username . '! Nos complace que&nbsp;</p></td></tr></table></td></tr></table></td></tr> <tr>
<td class="es-m-p15t es-m-p0b es-m-p0r es-m-p0l" align="left" style="padding:0;Margin:0;padding-top:15px"><table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" valign="top" style="padding:0;Margin:0;width:600px"><table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" style="padding:0;Margin:0;font-size:0px"><img class="adapt-img" src="https://ffifbrp.stripocdn.email/content/guids/CABINET_1ce849b9d6fc2f13978e163ad3c663df/images/3991592481152831.png" alt="" style="display:block;font-size:16px;border:0;outline:none;text-decoration:none" width="600"></td></tr></table></td></tr></table></td></tr></table></td></tr> </table>
 <table cellpadding="0" cellspacing="0" class="es-content" align="center" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important"><tr><td align="center" bgcolor="#071f4f" style="padding:0;Margin:0;background-color:#071f4f;background-image:url(https://ffifbrp.stripocdn.email/content/guids/CABINET_1ce849b9d6fc2f13978e163ad3c663df/images/10801592857268437.png);background-repeat:no-repeat;background-position:center top" background="https://ffifbrp.stripocdn.email/content/guids/CABINET_1ce849b9d6fc2f13978e163ad3c663df/images/10801592857268437.png"><table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px"><tr>
<td align="left" style="Margin:0;padding-right:30px;padding-left:30px;padding-top:40px;padding-bottom:40px"><table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" valign="top" style="padding:0;Margin:0;width:540px"><table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px"><tr><td align="center" height="20" style="padding:0;Margin:0"></td> </tr><tr>
<td align="left" style="padding:0;Margin:0;padding-bottom:10px"><h1 style="Margin:0;mso-line-height-rule:exactly;letter-spacing:0;font-size:30px;font-style:normal;font-weight:bold;line-height:36px;color:#fff;text-align:center">Accede a este enlace para validar tu cuenta y poder acceder al portal.</h1></td></tr><tr><td align="center" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px"><p style="Margin:0;mso-line-height-rule:exactly;font-family, helvetica, arial, sans-serif;line-height:24px;letter-spacing:0;color:#ffffff;font-size:16px"><a class="btn" style="font-size:30px;color:#fff" href="https://aws25.ieti.site/Proyecto_Vota/dashboard.php?validToken=' . $token . '">Validar cuenta</a></p></td></tr></table></td></tr></table></td></tr></table></td></tr></table>
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
                $mail->Username   = "jbernabeucaballero.cf@iesesteveterradas.cat"; // Email de la cuenta de correo desde la que se enviaran los correos
                $mail->Password   = "KekHut93"; // Password de la cuenta de correo
    
                $mail->IsHTML(true);
                $mail->AddAddress($destinatario);
                $mail->SetFrom("jbernabeucaballero.cf@iesesteveterradas.cat", "Vota EJA");
    
                $mail->Subject = $title;
                $mail->MsgHTML($content);

                if ($mail->Send()) {
                    echo '<script>showNotification("success", "¡Registro completado!");</script>';
                    //log
                    escribirEnLog("[REGISTER] Registro completado correctamente del user " . $username . " con email " . $email);
                } else {
                    echo '<script>showNotification("error", "Vaya, parece que no se ha enviado el correo. ' . $mail->ErrorInfo . '");</script>';
                    //log
                    escribirEnLog("[REGISTER] Error al enviar el correo de validación: " . $mail->ErrorInfo);
                }
            }

            if ($row) {
                header("Location:./index.php");
            }

        }
    }
    $query =  $pdo ->prepare("SELECT * FROM Countries");
    $query -> execute();
    $row = $query -> fetch();
    echo "<script>getCountryData({";
    while ($row) {
        echo "'".$row["CountryName"]."':'".$row["PhoneCode"]."',";
        $row = $query -> fetch();
    }
    echo "});</script>";
    ?>
</body>
</html>
