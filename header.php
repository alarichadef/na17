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
                        
				<?php
				if (isset($_SESSION['role'])){
					if($_SESSION['role'] == 'membre_du_laboratoire'){
					?>
						<li><a href="listRequest.php">Liste des appels à projets</a></li>
						<li><a href="listProposals.php">Liste des propositions de projet</a></li> 
						<li><a href="financerDashboard.php">Liste des Financeurs</a></li>
						<li><a href="listProjects.php">Liste des Projets</a></li>
						<li><a href="listExpenses.php">Liste des dépenses</a></li>
						<li><a href="listStats.php">Liste des statistiques</a></li>
					<?php
					}
					if($_SESSION['role'] == 'webmaster'){
					?>
						<li><a href="listRequest.php">Liste des appels à projets</a></li>
						<li><a href="listProposals.php">Liste des propositions de projet</a></li> 
						<li><a href="financerDashboard.php">Liste des Financeurs</a></li>
						<li><a href="listProjects.php">Liste des Projets</a></li>
						<li><a href="listExpenses.php">Liste des dépenses</a></li>
						<li><a href="listStats.php">Liste des statistiques</a></li>
					<?php
					}
					if($_SESSION['role'] == 'employe_de_contact'){
					?>
<!-- 						<li><a href="listRequest.php">Liste des appels à projets</a></li>
 -->					<!-- <li><a href="contactEmployeDashboard.php#projets">Liste des propositions de projet</a></li>  -->
						<li><a href="contactEmployeDashboard.php#financeurs">Liste des Financeurs</a></li>
						<li><a href="contactEmployeDashboard.php#projets">Liste des Organismes de Projet</a></li>
						<li><a href="listExpenses.php">Liste des dépenses</a></li>
						<li><a href="listProposals.php">Liste des propositions de projet</a></li> 
					<?php
					}
				}
				?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="login.php">Deconnexion</a></li>
                    </ul>

                </nav>


            </div>
        </nav>
