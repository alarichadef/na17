<?php

include_once('conf.php');
$db = "";

function dpconnexion(){
	global $host, $port, $user, $password, $dbname, $db;
	$connexion = "host=localhost port=$port user=$user password=$password dbname=$dbname";
	if(!pg_ping($db))
	{
		$db = pg_connect($connexion)or die ("Oula ça craint.." . pg_last_error($db));
	}
	return $db;
}

function dpdisconnect(){
	global $db;
	if($db != "")
		pg_close($db);
}


function getProposals()
{
	$db = dpconnexion();
	$query = "SELECT p.*, a.description FROM proposition_de_projet p JOIN appel_a_projet a ON p.appel_a_projet = a.id ORDER BY a.description";
    $qresults = pg_query($query);
	//pg_close($db);

	return $qresults;
}

function getEmployeeFinancer( $mail )
{
	$db = dpconnexion();
	$query = "SELECT * FROM financeur f WHERE f.contact = '$mail'";
    $qresult = pg_query($query);
	//pg_close($db);

	return $qresult;
}

function getRequestsByEmployee( $mail )
{
	$db = dpconnexion();
	$query = 
		@"SELECT * FROM 
			appel_a_projet a
			WHERE a.publieur IN (SELECT organisme FROM assoc_financeur_organisme 
				WHERE financeur IN (SELECT nom FROM financeur f WHERE f.contact = '$mail'));";
    $qresult = pg_query($query);
	//pg_close($db);

	return $qresult;
}

function getRequestsByFinancer( $financerName)
{
	$db = dpconnexion();
	$query = 
		@"SELECT * FROM 
			appel_a_projet a
			WHERE a.publieur IN (SELECT organisme FROM assoc_financeur_organisme WHERE financeur = '$financerName');";

    $qresults = pg_query($query);
	//pg_close($db);

	return $qresults;
}

function getProposalsByRequest( $requestId)
{
	$db = dpconnexion();
	$query = 
		@"SELECT * FROM 
			proposition_de_projet p
			WHERE p.appel_a_projet = $requestId;";

    $qresults = pg_query($query);
	//pg_close($db);

	return $qresults;
}

function getProposalById ($proposalId)
{
	$db = dpconnexion();
	$query = "SELECT * FROM proposition_de_projet p JOIN appel_a_projet a ON p.appel_a_projet = a.id WHERE p.id = $proposalId";


    $qresult = pg_query($query);
	//pg_close($db);

	return $qresult;
}

function getRequestById( $requestId )
{
	$db = dpconnexion();
	$query = 
		@"SELECT * FROM 
			appel_a_projet a
			WHERE a.id = $requestId;";

    $qresults = pg_query($query);
	//pg_close($db);

	return $qresults;
}

function createProposal( $resquestId )
{
	$db = dpconnexion();
	$query = "INSERT INTO proposition_de_projet (reponse, acceptation, appel_a_projet) VALUES (NULL, NULL, $resquestId);";
    $qresults = pg_query($query);

    $query = "SELECT * FROM proposition_de_projet ORDER BY id DESC LIMIT 1";
    $qresult = pg_query($query);
    $idProposal = pg_fetch_result($qresult, 0, 0);
	//pg_close($db);

	return $idProposal;
}

function refuseProposal($proposalId)
{
	$db = dpconnexion();
	$query = "UPDATE proposition_de_projet SET acceptation=FALSE, reponse=current_date WHERE id = $proposalId;";
    $qresult = pg_query($query);
}

function acceptProposal($proposalId)
{
	$db = dpconnexion();
	$query = "SELECT appel_a_projet FROM proposition_de_projet WHERE id = $proposalId;";
	$qresult = pg_query($query);
	$requestId = pg_fetch_result($qresult, 0, 0);
	$query = "UPDATE proposition_de_projet SET acceptation=TRUE, reponse=current_date WHERE id = $proposalId;";
    $qresult = pg_query($query);
    $query = "UPDATE proposition_de_projet SET acceptation=FALSE, reponse=current_date WHERE appel_a_projet = $requestId AND id != $proposalId AND acceptation IS NULL;";
    $qresult = pg_query($query);
}

function createBudgetLine($proposalId, $montant, $objet, $financeType)
{
	$db = dpconnexion();
	$query = "INSERT INTO ligne_budgetaire (projet, montant, objet_global, financement) VALUES ($proposalId, $montant, '$objet', '$financeType');";

    $qresults = pg_query($query);
}

function getBudgetLines($proposalId)
{
	$db = dpconnexion();
	$query = 
		@"SELECT * FROM 
			ligne_budgetaire
			WHERE projet = $proposalId;";

    $qresults = pg_query($query);
	//pg_close($db);

	return $qresults;
}

function insertLabel($mail, $proposalId, $label) {
	$db = dpconnexion();

	// Retrieve the rigth "entite juridique"
	$financer = getEmployeeFinancer($mail);
	$financer = pg_fetch_assoc($financer);
	$entite = $financer['nom'];

	// Insert label	
	$query = 
		@"INSERT INTO donne_label(
            entite_juridique, proposition_de_projet, label)
    	  VALUES ('$entite', $proposalId, '$label');";
    $qresult = pg_query($query);

    return $qresult;
}

function getLabels($proposalId)
{
	$db = dpconnexion();
	$query = 
		@"SELECT label FROM 
			donne_label
			WHERE proposition_de_projet = $proposalId;";

    $qresults = pg_query($query);
	//pg_close($db);

	return $qresults;
}

function getProjects()
{
	$db = dpconnexion();
	$query =
		@"select projet.id as i, projet.debut as d, projet.fin as f, description as de from projet,proposition_de_projet, appel_a_projet where projet.proposition = proposition_de_projet.id and proposition_de_projet.appel_a_projet = appel_a_projet.id";
	$qresults = pg_query($db, $query) or die(pg_last_error());

	return $qresults;
}

function getDepenseById($depenseId) {
	$db = dpconnexion();
	$query = 
	@"SELECT * FROM
			depense WHERE id =".$depenseId.";";

	$qresult = pg_query($db, $query) or die(pg_last_error());

	return $qresult;
}

function validDepense($type_depense, $projetId) {
	$db = dpconnexion();
	$query = "SELECT SUM(d.montant) - lb.montant AS final FROM depense d, ligne_Budgetaire lb, projet p 
	WHERE d.financement = '".$type_depense."' AND p.Id = $projetId AND lb.projet = p.proposition AND lb.financement = '$type_depense'
	GROUP BY lb.montant;";
	$qresult = pg_query($db, $query) or die(pg_last_error());
	$result = pg_fetch_row($qresult);
	$montant = $result[0];
	var_dump($montant);
	return $montant > 0;
}

function ajouterDepense($personne, $type, $montant, $date, $projet)
{
	$db = dpconnexion();
	$query = "INSERT INTO depense (projet, date, montant, Demandeur, Etat, financement) VALUES (".$projet.", '".$date."', ".$montant.", '".$personne."', 'En cours', '".$type."');";

	pg_query($db, $query) or die(pg_last_error());
}

function acceptDepense($personne, $depenseId) {
	$db = dpconnexion();
	$query = "UPDATE depense SET validateur = '".$personne."' AND etat = 'Valide'
				WHERE id =".$depenseId.";";

	$qresult = pg_query($db, $query) or die(pg_last_error());
}

function refuseDepense($personne, $depenseId) {
	$db = dpconnexion();
	$query = "UPDATE depense SET validateur = '".$personne."' AND etat = 'Refuse'
				WHERE id =".$depenseId.";";
	pg_query($db, $query) or die(pg_last_error());
}

function creerPersonne($mail, $nom) {
	$db = dpconnexion();
	$query = "INSERT INTO Personne (mail, nom) VALUES ('".$mail."', '".$nom."');";
	pg_query($db, $query);
	return true;
}

function getDepensesForMyProjects($mail) {
	$db = dpconnexion();
	$query = "SELECT d.id, d.projet, d.date, d.montant, d.Validateur, d.Demandeur, d.Etat, d.financement
	FROM Depense d, Projet p, Membre_projet mp WHERE mp.projet = p.id AND mp.mail = '$mail' ORDER BY d.projet;";
	$qresult = pg_query($db, $query) or die(pg_last_error());
	return $qresult;
}

function creerMembreLaboratoire($mail, $nom, $fonction, $type, $domaine, $quotite, $etablissement, $sujet, $debut) {
	$db = dpconnexion();
	$query = "INSERT INTO Membre_du_projet VALUES ('".$mail."', '".$nom."');";
	pg_query($db, $query);
	$query = "INSERT INTO Membre_du_laboratoire VALUES ('".$mail."', '".$type."', '".$domaine."', '".$quotite."', 
		'".$etablissement."', '".$sujet."', '".$debut."';";
	pg_query($db, $query);
}

function getDepenses($projectId)
{
	$db = dpconnexion();
		$query = 
			@"SELECT * FROM 
				Depense
				WHERE projet = $projectId";

		$qresults = pg_query($query);
		//pg_close($db);

		return $qresults;
}

function getBudgetTotal($projectId)
{
	$db = dpconnexion();
	$query = "SELECT SUM(montant) FROM ligne_Budgetaire lb WHERE lb.projet = $projectId;";
	$qresult = pg_query($db, $query);
	return $qresult;
}

function getBudgetTotalByType($projectId, $type)
{
	$db = dpconnexion();
	$query = "SELECT SUM(montant) FROM ligne_Budgetaire lb WHERE lb.projet = $projectId AND lb.financement = '$type';";
	$qresult = pg_query($db, $query);
	return $qresult;
}

function getTotalDepenses($projectId)
{
	$db = dpconnexion();
	$query = "SELECT SUM(montant) FROM depense d WHERE d.projet = $projectId;";
	$qresult = pg_query($db, $query);
	return $qresult;
}

function getTotalDepensesByType($projectId, $type)
{
	$db = dpconnexion();
	$query = "SELECT SUM(montant) FROM depense d WHERE d.projet = $projectId AND d.financement = $type;";
	$qresult = pg_query($db, $query);
	return $qresult;	
}

function getBudgetRestant($projectId)
{
	$db = dpconnexion();
	return pg_fetch_row(getBudgetTotal($projectId)) - pg_fetch_row(getTotalDepenses($projectId));
}

function getBudgetRestantByType($projectId, $type)
{
	$db = dpconnexion();
	return pg_fetch_row(getBudgetTotalByType($projectId, $type))
	- pg_fetch_row($getTotalDepensesByType($projectId, $type));
}

function getMembresProjet($projectId)
{
	$db = dpconnexion();
		$query = 
			@"SELECT mail FROM 
				Membre_projet
				WHERE projet = $projectId";

		$qresults = pg_query($query);
		//pg_close($db);

		return $qresults;
}

function getNonMembresProjet($projectId)
{
	$db = dpconnexion();
		$query = 
			@"SELECT DISTINCT mail FROM 
				Membre_du_projet
				WHERE mail not in (select mail from membre_projet where projet = $projectId)";

		$qresults = pg_query($query);
		//pg_close($db);

		return $qresults;
}


function getNomsMails($mail)
{
	$db = dpconnexion();
		$query = 
			@"SELECT fonction,nom FROM 
				Membre_du_projet, Personne
				WHERE Membre_du_projet.mail = '$mail' and Personne.mail = '$mail'";

		$qresults = pg_query($query);
		//pg_close($db);

		return $qresults;
}

function getProjectById($project)
{
	$db = dpconnexion();
		$query = 
			@"SELECT * FROM 
				Projet
				WHERE id = $project";

		$qresults = pg_query($query);
		//pg_close($db);

		return $qresults;
}


function setMembresProjet($project,$mail)
{
	$db = dpconnexion();
		$query = 
			@"Insert into Membre_projet VALUES ($project,'$mail')";

		$qresults = pg_query($query);
		//pg_close($db);
}


function getAllMembres()
{
	$db = dpconnexion();
		$query = 
			@"Select * from membre_du_projet";

		$qresults = pg_query($query);
		//pg_close($db);
		return $qresults;

}

function getProjectByProposition($proposition)
{
	$db = dpconnexion();
		$query = 
			@"Select * from projet where proposition = $proposition";

		$qresults = pg_query($query);
		//pg_close($db);
		return $qresults;

}

function getMyProjects($login)
{
	$db = dpconnexion();
	$query = "SELECT * FROM projet p, Membre_projet mp WHERE p.id = mp.projet AND mp.mail = '$login';";
	$qresults = pg_query($db, $query);
	return $qresults;
}

function createProject($debut,$fin,$proposition)
{
	$db = dpconnexion();
		$query = 
			@"Insert into Projet(debut,fin,proposition) VALUES ('$debut','$fin',$proposition)";

		$qresults = pg_query($query);
		//pg_close($db);
		return $qresults;
}

?>
