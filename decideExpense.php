<?php
include_once("conf.php");
include_once("dataprovider.php");
include('header.php');
include('header_info.php');

include('menu.php');
if (isset($_GET["etat"]) && isset($_GET["projectId"]) && isset($_GET["expenseId"]))
{
	$projetId = intval($_GET["projectId"]);
	$depenseId = intval($_GET["expenseId"]);

	if ($_GET["etat"] == "valide")
	{
		$depense = (pg_fetch_array(getDepenseById($depenseId)));
		if ($depense["etat"] == "En cours")
			if (validDepense($depense["financement"], $projetId))
			{
				acceptDepense($_SESSION['login'], $depenseId);
				echo "<p>Dépense validée, redirection...</p>";
				echo '<meta http-equiv="refresh" content="2;URL=viewProject.php?projectId=$projetId>';
			}
			else
			{
				echo "<p>Dépense refusée, pas assez de budget pour ce type de financement, redirection...</p>";
				echo '<meta http-equiv="refresh" content="2;URL=viewProject.php?projectId=$projetId">';	
			}
	}

	else if ($_GET["etat"] == "refus")
	{
		$depense = pg_fetch_array(getDepenseById($depenseId));
		refuseDepense($_SESSION['login'], $depenseId);
		echo "<p>Dépense refusée, redirection...</p>";
		echo '<meta http-equiv="refresh" content="2;URL=viewProject.php?projectId=$projetId">';	
	}
}
include('footer.php');
?>