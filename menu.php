

				<?php 
				if (isset($_SESSION['role'])){
				?>
					<div class="col-md-3" id="leftCol">
                    <ul class="nav nav-stacked" id="sidebar">
  
				<?php
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
					<?php
					}
				}
				?>
			</div>
             <!--right-->
      <div class="col-md-9">
