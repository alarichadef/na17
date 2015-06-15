<?php
if (isset($_GET["etat"]) && isset($_GET["projetId"]) && isset($_GET["expenseId"]))
{
	$projetId = intval($_GET["projetId"]);
	$depenseId = intval($_GET["expenseId"]);

	if ($_GET['etat'] == "valide")
	{
		$depense = pg_fetch_row(getDepenseById($depenseId));
		if ($depense["etat"] == "En cours")
			if (validDepense($depense["financement"], $projetId))
				acceptDepense($_SESSION['login'], $depenseId);
	}

	else if ($_GET['etat'] == "refus")
	{
		$depense = pg_fetch_row(getDepenseById($depenseId));
		refuseDepense($_SESSION['login'], $depenseId);
	}
}
?>