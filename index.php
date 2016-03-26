<?php 
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
    
    //core
    require_once './core/psl-config.php';
    require_once './core/Db.php';
    //model
    require_once './model/User.php';
    require_once './model/Logs.php';
    //controller
    require_once './controller/Session.php';

    $bdd = Db::dbConnect();
    $valid = Logs::sessionIsValid();

    //header
    include_once './view/header.php';

    //Views
    if (isset($_COOKIE['getMePartners']) && $_COOKIE['getMePartners'] != null && $valid){
        $user = new User($_COOKIE['getMePartners'], $bdd);
        if(isset($_GET["setting"]) ){
            if($_GET["setting"] === "account_setting"){
                include_once './view/account_setting.php';
            }
        }
        else
            include_once './view/main_page.php';
    }else{
        include_once './view/login_register.php';
    }

    if(isset($_POST['login'])){
        Logs::login($_POST['email'], $_POST['pass']);
    }   
    if(isset($_POST['register'])){
        Logs::register($_POST['username'], $_POST['mail'], $_POST['pass'], $_POST['pass2']);
    }
    
    echo '</div>';

    //footer
    include_once 'view/footer.php'; 
?>