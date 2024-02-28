<?php
    session_start();
    echo "
        <header>
            <span class='spanNavBar'>".(isset($_SESSION["username"]) ? $_SESSION["username"] : "")."<span>
            <div id='nav_menu' class='flex flex-row space-between items-center navbar'>
                <div class='logo'> 
                    <a href='index.php'><i class='fas fa-home'></i></a>
                    "; if (isset($_SESSION["UserID"])) {
                        echo "<h2>Hola, ".$_SESSION["Username"].".</h2>";
                    };echo "
                </div>
                <div class='userInterface'>
                ";
                if(isset($_SESSION["UserID"])){
                    echo "
                        <a href='dashboard.php' id='dashboardLink' name='dashboardLink'>Dashboard</a>
                        <a href='logout.php' id='logoutLink' name='logoutLink'>Cerrar Sesion</a>";
                } else{
                    echo "
                        <a href='login.php'>Inicia sesión</a>
                        <a href='register.php'>Regístrate</a>";
                }
                echo "    
                </div>
            </div>
        </header>
    ";
?>