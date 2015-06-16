<?php
include_once("conf.php");
include_once("dataprovider.php");
include('header.php');
include('header_info.php');

include('menu.php');
$depenses = getDepensesForMyProjects($_SESSION['login']);
?>
<h2>Liste des dépenses associées à mes projets</h2>
<table class="table table-bordered table-hover table-striped">
    <thead>
    	<tr>
    		<th>Projet</th>
    		<th>Date</th>
    		<th>Montant</th>
    		<th>Financement</th>
    		<th>Etat de la dépense</th>
    	</tr>
    </thead>
    <tbody>
    <?php
   		while($depense = pg_fetch_array($depenses)) {
    ?>
		<tr>
			<td><?php echo $depense["projet"];?></td>
			<td><?php echo $depense["date"];?></td>
			<td><?php echo $depense["montant"];?></td>
			<td><?php echo $depense["financement"];?></td>
			<td><?php echo $depense["Etat"];?></td>
		</tr>
	<?php
		}
	?>
    </tbody>
</table>
<?php
include('footer.php');
?>