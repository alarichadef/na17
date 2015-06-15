<?php
include_once("conf.php");
include_once("dataprovider.php");

include('header.php'); 
include('header_info.php'); 
include('menu.php'); 

?>

<h1> Statistiques </h1>
<h2>Liste des projets avec la somme des depenses superieures a la moyenne</h2>
<table class="table table-bordered table-hover table-striped">
    <thead><tr><th>Id du projet</th><th>Moyenne des depenses</th></tr></thead>
                        <tbody>
    <?php 
		$db = dpconnexion();
		$query = 
			@"select projet, avg(montant) as moyenne from depense group by (projet) having avg(montant) > (select avg(montant) from depense)";

		$result = pg_query($query);
while($result = pg_fetch_array($requests)){
       echo "<tr><td>".$result['projet']."</td><td>".$result['montant']."</td><td>".$result['fin']."</td></tr>";

}
?>
                        </tbody>
                    </table>


<h2>Classements des membres affectes aux plus de projet</h2>
<table class="table table-bordered table-hover table-striped">
    <thead><tr><th>Mail</th><th>Nom</th><th>Nombre de projet</th></tr></thead>
                        <tbody>
    <?php 
		$db = dpconnexion();
		$query = 
			@"select membre_projet.mail, nom, count(projet) as nombre from membre_projet, personne where personne.mail = membre_projet.mail group by membre_projet.mail, nom order by nombre desc";

		$result = pg_query($query);
while($result = pg_fetch_array($requests)){
       echo "<tr><td>".$result['membre_projet.mail']."</td><td>".$result['nom']."</td><td>".$result['nombre']."</td></tr>";

}
?>
                        </tbody>
                    </table>




<h2>Classements des projets avec le plus de membres</h2>
<table class="table table-bordered table-hover table-striped">
    <thead><tr><th>Id projet</th><th>Description du projet</th><th>Nombre de membres</th></tr></thead>
                        <tbody>
    <?php 
		$db = dpconnexion();
		$query = 
			@" select count(mail) as nombre, membre_projet.projet as p, appel_a_projet.description as d from proposition_de_projet,appel_a_projet,projet,membre_projet where membre_projet.projet = projet.id and projet.proposition = proposition_de_projet.id and proposition_de_projet.appel_a_projet = appel_a_projet.id group by membre_projet.projet, appel_a_projet.description;";

		$result = pg_query($query);
while($result = pg_fetch_array($requests)){
       echo "<tr><td>".$result['membre_projet.projet']."</td><td>".$result['d']."</td><td>".$result['nombre']."</td></tr>";

}
?>
                        </tbody>
                    </table>


<?php
dpdisconnect();
include('footer.php');
?>
