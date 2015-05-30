<?php
include_once("conf.php");
include_once("dataprovider.php");

include('header.php'); 
include('header_info.php'); 
include('menu.php'); 

if (isset($_GET['proposalId']))
{
	$proposalId = intval($_GET['proposalId']);
	$proposal = getProposalById($proposalId);
	$budgetlines = getBudgetLines($proposalId);

	$proposal = pg_fetch_array($proposal);
	?>

	<h2>Proposition de projet</h2>
	<h3>Caract&eacute;ristiques</h3>
	<table class="table table-bordered table-hover table-striped">
        <tr><td><b>Projet</b></td><td><?php echo $proposal['description'] ?></td></tr>
        <tr><td><b>Th&egrave;me</b></td><td><?php echo $proposal['theme'] ?></td></tr>
        <tr><td><b>Dur&eacute;e</b></td><td><?php echo $proposal['duree'] ?></td></tr>
        <tr><td><b>Lancement</b></td><td><?php echo $proposal['lancement'] ?></td></tr>
        <tr><td><b>R&eacute;ponse</b></td><td>
        	<?php if ($proposal['acceptation'] == null)
        			echo "En attente";
        			elseif ($proposal['acceptation'] == 't')
        				echo "Accept&eacute;";
        			else
        				echo "Refus&eacute;";
        	 ?>
        </td></tr>
        <tr><td><b>Date r&eacute;ponse</b></td><td><?php echo $proposal['reponse'] ?></td></tr>
    </table>
    <h3>Budget</h3>
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
    <h3>Labels</h3>
    <p>
    	<?php
    	$labels = getLabels($proposalId);
    	$label = pg_fetch_assoc($labels);
    	if ($label != 0)
    		echo $label['label'];
    	while ($label = pg_fetch_assoc($labels)) {
    		$labelvalue = $label['label'];
    		echo ", $labelvalue";
    	}
    	?> 
    </p>
	<?php
	if ($_SESSION['role'] == 'employe_de_contact')
	{
		?>
		<h2>Actions</h2>
		<form class="form-inline" action="decideProposal.php" method="POST"> 
			<input type="hidden" name="proposalId" value="<?php echo $proposalId;?>">
			<div class="form-group">
			    <label for="label">Donner un label</label>
			    <input type="text" class="form-control" name="label">
			    <input type="submit" class="btn btn-link" name="labelSubmit" value="Ajouter">
			</div>
			<?php if($proposal['acceptation'] == null) { ?>
			<div class="form-group" style="display:block;margin-top:10px;">
			    <input type="submit" class="btn btn-success" name="acceptSubmit" value="Accepter la proposition">
			    <input type="submit" class="btn btn-warning" name="refuseSubmit" value="Refuser la proposition">
			</div>
			<?php } ?>
			</ul>
		</form>
		<?php
	}
}
else {
	echo "<p class='error'>Erreur, renseignez une proposition de projet</p>";
}
?>

<?php
dpdisconnect();
include('footer.php');
?>