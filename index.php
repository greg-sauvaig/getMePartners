<?php 
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
    
    //core
    require_once './core/psl-config.php';
    require_once './core/Db.php';
    //model
    require_once './model/User.php';
    require_once './model/Logs.php';
    require_once './model/Event.php';
    //controller
    require_once './controller/Session.php';

    $bdd = Db::dbConnect();
    $valid = Logs::sessionIsValid($bdd);

    //header
    include_once './view/header.php';

    //Views
    if (isset($_COOKIE['getMePartners']) && $_COOKIE['getMePartners'] != null && $valid)
    {
        $user = new User($_COOKIE['getMePartners'], $bdd);
        if(isset($_GET["setting"]) && $_GET["setting"] != null && $_GET["setting"] === "account_setting"){
            include_once './view/account_setting.php';
        }
        else if(isset($_GET['page']) && $_GET['page']!= null){
            if ($_GET['page'] == 'create'){
                include_once './view/left-container-profil.php';
                include_once './view/create_event.php';
            }else if ($_GET['page'] == 'search'){
                include_once './view/left-container-profil.php';
                include_once './view/search.php';
            }
        }
        else if(isset($_POST['upload']) && $_POST["upload"] != null){
            $user->uploadAvatar($user, $bdd);
        }
        else{
            include_once './view/left-container-profil.php';
            include_once './view/main_page.php';
        }
        if (isset($_POST['create_event'])){
            $user->createEvent($bdd);
        }
    }else{
        include_once './view/login_register.php';
    }

    if(isset( $_POST['login'], $_POST['email'], $_POST['pass']) && $_POST['email'] != null && $_POST['pass'] != null){
        Logs::login($_POST['email'], $_POST['pass'], $bdd);
    }   
    if(isset($_POST['register'],$_POST['username'], $_POST['mail'], $_POST['pass'], $_POST['pass2']) && $_POST['username']!= null && $_POST['mail'] != null && $_POST['pass'] != null && $_POST['pass2'] != null){
        Logs::register($_POST['username'], $_POST['mail'], $_POST['pass'], $_POST['pass2'], $bdd);
    }
    
    echo '</div>';

    //footer
    include_once 'view/footer.php'; 
?>