<?php
include_once("conf.php");
include_once("dataprovider.php");

include('header.php'); 
include('header_info.php'); 
include('menu.php'); 

if(isset($_POST['proposalSubmit']))
{
	echo "<p>Proposition enregistrée, redirection...</p>";
	echo '<meta http-equiv="refresh" content="2;URL=listProposals.php">';
}

if($_SESSION['role'] == 'membre_du_laboratoire')
{	
	if (isset($_GET['requestId']))
	{
		$resquestId = intval($_GET['requestId']);
		if( !isset($_GET['proposalId'])) // insertion proposition de projet
		{
			$proposalId = createProposal($resquestId);
		}
		else if (isset($_POST['budgetLine'])) // insertion ligne budgetaire
		{
			$proposalId = intval($_POST['proposalId']);
			$montant = doubleval($_POST['montant']);
			$objet = htmlspecialchars($_POST['objet']);
			$financeType =  htmlspecialchars($_POST['financeType']);
			createBudgetLine($proposalId, $montant, $objet, $financeType);
		}

?>
	<h3>Lignes budgetaires :</h3>
<?php
	// Affichage des lignes
	if (isset($_GET['proposalId']) )
	{
		$proposalId = intval($_GET['proposalId']);
		$budgetlines = getBudgetLines($proposalId);
		?>
		<table class="table table-bordered table-hover table-striped">
            <thead><tr><th>Objet</th><th>Montant</th><th>Type financement</th><th></th></tr></thead>
            <tbody>
		<?php
		while($result = pg_fetch_array($budgetlines)){
            echo "<tr><td>".$result['objet_global']."</td><td>".$result['montant']."</td><td>".$result['financement']."</td><td></td></tr>";
        }
        ?>
            </tbody>
        </table>
        <?php
	}
	
?>
	<h3>Ajouter une ligne :</h3>
	<form class="form-vertical" action="createProposal.php?requestId=<?php echo $resquestId; ?>&proposalId=<?php echo $proposalId; ?>" method="POST">
		<input type="hidden" name="proposalId" value="<?php echo $proposalId; ?>">
		<div class="form-group">
		    <label for="montant">Montant</label>
		    <input type="text" class="form-control" name="montant">
		</div>
		<div class="form-group">
		    <label for="objet">Objet</label>
		    <input type="text" class="form-control" name="objet">
		</div>
		<div class="form-group">
			<label>Type financement : </label>
			<div class="radio">
			  <label>
			    <input type="radio" name="financeType" value="materiel">
			    Materiel
			  </label>
			</div>
			<div class="radio">
			  <label>
			    <input type="radio" name="financeType" value="fonctionnement">
			    Fonctionnement
			  </label>
			</div>
		</div>
		<input name="budgetLine" type="submit" class="btn btn-default" value="Ajouter">
	</form>

	<h3>Validation</h3>
	<form action="createProposal.php" method="POST">
		<input name="proposalSubmit" type="submit" class="btn btn-primary" value="Terminer la proposition">
	</form>

<?php
	}
}
else
{
	echo "<p>Acces refuse</p>";
}
dpdisconnect();
include('footer.php');
?>