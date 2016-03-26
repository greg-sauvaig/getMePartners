<?php
require_once '../core/psl-config.php';
require_once '../core/Db.php';
require_once '../model/User.php';
$bdd = Db::dbConnect();
$user = new User($_COOKIE["getMePartners"],$bdd);
if(isset($_POST['upload'])){// si formulaire soumis
    $content_dir = '../image/avatar/'; // dossier où sera déplacé le fichier
    $tmp_file = $_FILES['fichier']['tmp_name'];
    if(!is_uploaded_file($tmp_file)){
        exit("Le fichier est introuvable");
    }
    // on vérifie l'extension
    $type_file = $_FILES['fichier']['type'];
    if(!strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') && !strstr($type_file, 'png')){
        exit("Le fichier n'est pas une image");
    }
    $at = $user;
    // on copie le fichier dans le dossier de destination
    $name_file = $_FILES['fichier']['name'];
    if(!move_uploaded_file($tmp_file, $content_dir . $at->getUsername() . "-" . $name_file))
    {
        exit("Impossible de copier le fichier dans $content_dir");
    }
    try {
        $id = $at->getId();
        var_dump("a");
        $req = "UPDATE `user` set `profil_pic` = '".'/image/avatar/' .  $at->getUsername() . "-" . $name_file."' WHERE ID = $id ;";
        var_dump("aa");
        $data = $bdd->prepare($req);
        $data->execute();
        if($data->rowCount() == 1){
            var_dump("aaa");
            echo "Le fichier a bien été uploadé";
            header("location: ../index.php?setting=account_setting");
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

?>