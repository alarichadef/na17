<?php
if (isset($_GET["projet"]))
{
	$projetId = intval($_GET["projet"]);
	$depenses = getDepensesByProjet($projetId);
?>
<h2>Liste des dépenses</h2>
<table class="table table-bordered table-hover table-striped">
    <thead>
    	<tr>
    		<th>Date</th>
    		<th>Montant</th>
    		<th>Financement</th>
    		<th>Actions</th>
    	</tr>
    </thead>
    <tbody>
    <?php
   		while($depense = pg_fetch_array($depenses)) {
    ?>
		<tr>
			<td><?php echo $depense["date"];?></td>
			<td><?php echo $depense["montant"];?></td>
			<td><?php echo $depense["financement"];?></td>
			<td>
				<input type="button" class="btn btn-info" onclick="window.location.href='TODO'" value="Accepter">
				<input type="button" class="btn btn-info" onclick="window.location.href='TODO'" value="Refuser">
			</td>
		</tr>
	<?php
		}
	?>
    </tbody>
</table>
<?php
}
?>