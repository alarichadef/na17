 <?php
include_once("conf.php");
include_once("dataprovider.php");

include('header.php'); 
include('header_info.php'); 
include('menu.php'); 

if (isset($_GET['proposalId']))
{
	if((isset ($_GET['debut'])) && (isset ($_GET['fin'])))
			{ 
				echo "aaa = ".$_GET['debut'];
				createProject($_GET['debut'],$_GET['fin'],$_GET['proposalId']);
				$proposalId = intval($_GET['proposalId']);
				$projet = getProjectByProposition($proposalId);
				$projet = pg_fetch_array($projet);
				if(isset($_GET['mail'])){
					foreach($_GET['mail'] as $newmembre)
					{
					setMembresProjet($projet['id'],$newmembre);	  
					}
		echo '<meta http-equiv="refresh" content="0,2;URL=listProjects.php">';
		}			}
		else echo "Renseignez tout les champs";
?>

<h2>Creation du projet</h2>
	<h3>Caract&eacute;ristiques</h3>
	 <table class="table table-bordered table-hover table-striped">
            <thead><tr><th>Id proposition de projet</th><th>Date début</th><th>Date fin</th><th></th><<th>Creer le projet</th></tr></thead>
            <tbody>
			<form action="createProject.php">
			<input type="hidden" name="proposalId" value="<?php echo $_GET['proposalId']; ?>">
	<?php	
		echo "<tr><td>".$_GET['proposalId']."</td><td>";
	    echo '<input type="date" name="debut" class="form-control input-sm" placeholder="MM-JJ-AAAA"></td><td><input type="date" name="fin" class="form-control input-sm" placeholder="MM-JJ-AAAA"></td><td>';
		$nonMemres = getAllMembres();
		?>
		
		<select name="mail[]" multiple="multiple" size="10">
				<?php
				while($result = pg_fetch_array($nonMemres)){
						$fonction_mail = getNomsMails($result['mail']);
						$fonction_mail  = pg_fetch_array($fonction_mail);
						echo '<option value= '.$result['mail'].'>'.$fonction_mail['nom']." ".$result['mail']." ".$fonction_mail['fonction'].'</option> ';
				}
				?>
				</select>
	
		<?php
		echo "</td>";
		//id propos projet, date début, date fin


		?>
				<td><button class="btn btn-info">Création</button></td></tr>
			</form>
            </tbody>
        </table>






<?php

}
else {
	echo "<p class='error'>Erreur, renseignez une proposition de projet</p>";
}
?>

<?php
dpdisconnect();
include('footer.php');
?>
