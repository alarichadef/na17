<?php

include_once('conf.php');
$db = "";

function dpconnexion(){
	global $host, $port, $user, $password, $dbname, $db;
	$connexion = "host=localhost port=$port user=$user password=$password dbname=$dbname";
	$db = pg_connect($connexion)or die ("Oula ça craint.." . pg_last_error($db));
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
	$query = "SELECT * FROM proposition_de_projet p JOIN appel_a_projet a ON p.appel_a_projet = a.id ORDER BY a.description";
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

?>