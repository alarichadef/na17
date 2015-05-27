<?php session_start();?>
    
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Gestionnaire de Projets</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/styles.css" />
    </head>
    <body >
        <nav class="navbar navbar-inverse navbar-fixed-top" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="index.php" class="navbar-brand">Gestionnaire de Recherche</a>
                </div>
                <nav class="collapse navbar-collapse" role="navigation">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="#sec">Projets </a>
                        </li>
                        <li>
                            <a href="#sec">Statistiques</a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#">Paramètres</a></li>
                        <li><a href="#">Profil</a></li>
                        <li><a href="#">Deconnexion</a></li>
                    </ul>

                </nav>


            </div>
        </nav>
