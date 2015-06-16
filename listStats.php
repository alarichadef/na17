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

		$results = pg_query($query);
while($result = pg_fetch_array($results)){
       echo "<tr><td>".$result['projet']."</td><td>".$result['moyenne']."</td></tr>";

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
			@"select membre_projet.mail as m, nom, count(projet) as nombre from membre_projet, personne where personne.mail = membre_projet.mail group by membre_projet.mail, nom order by nombre desc";

		$results = pg_query($query);
while($result = pg_fetch_array($results)){
       echo "<tr><td>".$result['m']."</td><td>".$result['nom']."</td><td>".$result['nombre']."</td></tr>";

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

		$results = pg_query($query);
while($result = pg_fetch_array($results)){
       echo "<tr><td>".$result['p']."</td><td>".$result['d']."</td><td>".$result['nombre']."</td></tr>";

}
?>
                        </tbody>
                    </table>

<h2>Nombre de projets, de propositions de projets et d'appels a projets</h2>
<table class="table table-bordered table-hover table-striped">
    <thead><tr><th>Nombre de projets</th><th>Nombre de propositions</th><th>Nombre d'appels a projet</th></tr></thead>
                        <tbody>
    <?php 
		$db = dpconnexion();
		$query = 
			@" select count(id) as c from projet";

		$results = pg_query($query);
		$result = pg_fetch_array($results);
		$query = 
			@" select count(id) as c from proposition_de_projet";
		$results1 = pg_query($query);
		$result1 = pg_fetch_array($results1);
		$query = 
			@" select count(id) as c from appel_a_projet";
		$results2 = pg_query($query);
		$result2 = pg_fetch_array($results1);


       echo "<tr><td>".$result['c']."</td><td>".$result1['c']."</td><td>".$result2['c']."</td></tr>";

?>
                        </tbody>
                    </table>



<h2>Budget moyen de toutes les propositions de projets</h2>
<table class="table table-bordered table-hover table-striped">
    <thead><tr><th>Moyenne</th></tr></thead>
                        <tbody>
    <?php 
		$db = dpconnexion();
		$query = 
			@"SELECT AVG (psum) as m
					FROM
					(
					    SELECT projet,sum(montant) AS psum FROM
					    ligne_budgetaire
					    GROUP BY projet
					) as t,proposition_de_projet";

		$results = pg_query($query);
while($result = pg_fetch_array($results)){
       echo "<tr><td>".$result['m']."</td></tr>";

}
?>
                        </tbody>
                    </table>

<h2>Moyenne des depenses de tout les projets </h2>
<table class="table table-bordered table-hover table-striped">
    <thead><tr><th>Moyenne</th></tr></thead>
                        <tbody>
    <?php 
		$db = dpconnexion();
		$query = 
			@"SELECT AVG (montant) as m
					FROM
					depense
";

		$results = pg_query($query);
while($result = pg_fetch_array($results)){
       echo "<tr><td>".$result['m']."</td></tr>";

}
?>
                        </tbody>
                    </table>




<h2>Pourcentage des propositions de projets acceptes </h2>
<table class="table table-bordered table-hover table-striped">
    <thead><tr><th>Pourcentage</th></tr></thead>
                        <tbody>
    <?php 
		$db = dpconnexion();
		$query = 
			@"SELECT  cast(pa as decimal(4,2))/cast(pp as decimal(4,2))*100 as p
					FROM
					(
					    SELECT count(*) as pa from proposition_de_projet where acceptation = true
					) as t,(
					    SELECT count(*) as pp from proposition_de_projet
					) as t1


";

		$results = pg_query($query);
while($result = pg_fetch_array($results)){
       echo "<tr><td>".$result['p']."</td></tr>";

}
?>
                        </tbody>
                    </table>


<?php
dpdisconnect();
include('footer.php');
?>
