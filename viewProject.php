<?php
include_once("conf.php");
include_once("dataprovider.php");

include('header.php'); 
include('header_info.php'); 
include('menu.php'); 

if (isset($_GET['projectId']))
{
	$projectId = intval($_GET['projectId']);
	$project = getProjectById($projectId);
	$project = pg_fetch_array($project);

	$depenses = getDepenses($projectId);
	$membres = getMembresProjet($projectId);

	if(isset($_GET['mail'])){
		foreach($_GET['mail'] as $newmembre)
			{
			  setMembresProjet($projectId,$newmembre);	  
			}
			echo '<meta http-equiv="refresh" content="0;URL=viewProject.php?projectId='.$_GET['projectId'].'">';
		} 
	?>

	<h2>Projet</h2>
	<h3>Caracteristiques</h3>
	<table class="table table-bordered table-hover table-striped">
	     <tr><td><b>ID du projet</b></td><td><?php echo $_GET['projectId']; ?></td></tr>
        <tr><td><b>Debut</b></td><td><?php echo $project['debut'] ?></td></tr>
        <tr><td><b>Fin</b></td><td><?php echo $project['fin'] ?></td></tr>
        <tr><td><b>Id de la proposition</b></td><td><?php echo $project['proposition'] ?></td></tr>
       <tr> <td>
        <form action="viewProposal.php">
            <input type="hidden" name="proposalId" value="<?php echo $project['proposition']; ?>">
            <button class="btn btn-info">Voir la proposition relative au projet</button>
        </form>
    </td></tr>
	
    </table>
    <h3>Membres du projet</h3>
    <table class="table table-bordered table-hover table-striped">
            <thead><tr><th>Nom</th><th>Mail</th><th>Fonction</th></tr></thead>
            <tbody>
		<?php
		while($result = pg_fetch_array($membres)){
			$fonction_mail = getNomsMails($result['mail']);
			$fonction_mail  = pg_fetch_array($fonction_mail);
            echo "<tr><td>".$fonction_mail['nom']."</td><td>".$result['mail']."</td><td>".$fonction_mail['fonction']."</td></tr>";
        }
        ?>
		<tr><th>Ajouter des membres au projet</th></tr>
		<tr><td> 
		<?php
			$nonMemres = getNonMembresProjet($projectId);
?>
			<form action="viewProject.php">
				<input type="hidden" name="projectId" value="<?php echo $projectId; ?>">
				<select name="mail[]" multiple="multiple" size="10">
						<?php	while($result = pg_fetch_array($nonMemres)){
			$fonction_mail = getNomsMails($result['mail']);
			$fonction_mail  = pg_fetch_array($fonction_mail);

		


					echo '<option value= '.$result['mail'].'>'.$fonction_mail['nom']." ".$result['mail']." ".$fonction_mail['fonction'].'</option> ';
				}
				?>
				</select>
				</td><td>
				<button class="btn btn-info">Ajouter les membres</button>
			</form>
		</td></tr>
            </tbody>
        </table>
 
	<?php
	if ($_SESSION['role'] == 'webmaster')
	{
		?>
		<h2>Actions</h2>
		<h3>Liste des dépenses</h3>
			<table class="table table-bordered table-hover table-striped">
            <thead><tr><th>id</th><th>projet</th><th>date</th><th>Montant</th><th></th><th>Demandeur</th><th>Valideur</th><th>Etat</th><th>Financement</th><th></th></tr></thead>
            <tbody>
		<?php
		while($result = pg_fetch_array($depenses)){
            echo "<tr><td>".$result['id']."</td><td>".$result['projet']."</td><td>".$result['date']."</td><td>".$result['montant']."</td><td>".$result['demandeur']."</td><td>".$result['validateur']."</td><td>".$result['etat']."</td><td>".$result['financement']."</td>";
			if($result['etat'] == 'En cours'){
			?>
				<td>
			<form action="decideExpense.php">
				<input type="hidden" name="projectId" value="<?php echo $projectId; ?>">
				<input type="hidden" name="etat" value="<?php echo 'valide'; ?>">
				<input type="hidden" name="expenseId" value="<?php echo $result['id']; ?>">
				<button class="btn btn-info">Valider la dépense</button>
			</form>
			</td><td>
			<form action="decideExpense.php">
				<input type="hidden" name="projectId" value="<?php echo $projectId; ?>">
				<input type="hidden" name="expenseId" value="<?php echo $result['id']; ?>">
				<input type="hidden" name="etat" value="<?php echo "refus"; ?>">
				<button class="btn btn-info">Refuser la dépense</button>
			</form>
			<?php	
			}
			echo "</td></tr>";
        }
        ?>
         </tbody>
        </table>
		<form action="createExpense.php">
				<input type="hidden" name="projectId" value="<?php echo $projectId; ?>">
            <button class="btn btn-info">Ajouter une dépense</button>
			</form>
		<?php
	}
}
else {
	echo "<p class='error'>Erreur, renseignez un projet</p>";
}
?>

<?php
dpdisconnect();
include('footer.php');
?>
