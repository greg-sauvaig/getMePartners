<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="lib/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/deco.css" rel="stylesheet" type="text/css"/>
        <script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script src="./lib/geocomplete/jquery.geocomplete.js" type='text/javascript' ></script>
        <script src="./lib/moment/moment.js" type='text/javascript'></script>
        <script src="./lib/combodate/combodate.js" type='text/javascript'></script>
        <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBY2_9mOiVb_bKdrck5FMzVrJwAJPbefvk&libraries=places&amp"></script>
        <title>Get Me Partners</title>
    </head>
    <body class="no-js">
        <script type="text/javascript">$(document).ready(function(){ $('.no-js').removeClass( "no-js" ).addClass( "js" );});</script>
        <nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./index.php">Get Me Partners</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                    <?php if($valid){ ?>
                        <li class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" id="drop-header-btn" type="button" data-toggle="dropdown">EVENT
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="./index.php?page=create">Create Event</a></li>
                                <li><a href="./index.php?page=search">Search Event</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form action="./view/deco.php" method="post"><input type="submit"  id="deco" value="X deconnexion"></form>
                    <?php } ?>
                </div>
            </div>
        </nav>
        <div id="mainContainer"> <!-- Balise fermée dans le fichier footer.php -->