<?php
if(isset($organisme)){
?>
<script>
function deleteRequest(id){
var choix = confirm('Êtes-vous sûr de vouloir supprimer cet appel à projet ?');
if(choix)document.location.href='projectOrganismDashboard.php?organisme=<?php echo $organisme; ?>&delete='+id;
}
</script>

<h2>Appels à Projets</h2>
<table class="table table-bordered table-hover table-striped">
    <thead><tr><th>Lancement</th><th>Durée</th><th>Thème</th><th>Description</th><th>Comité</th><th>Nombre de Propositions</th><th></th><th></th><th></th></tr></thead>
                        <tbody>
    <?php 
        $query = "SELECT * FROM appel_a_projet WHERE publieur='".$organisme."' ORDER BY lancement;";
        $query = pg_query($query);
    
while($result = pg_fetch_array($query)){
            $query2 = "SELECT COUNT(*) FROM proposition_de_projet WHERE appel_a_projet='".$result['id']."';";
            $query2 = pg_query($query2);
            $result2 = pg_fetch_array($query2);
    
            echo "<tr><td>".$result['lancement']."</td><td>".$result['duree']." mois</td><td>".$result['theme']."</td><td>".$result['description']."</td><td>".$result['comite']."</td><td>".$result2[0]."</td>";

    ?>
    <form action="createProposal.php?organisme=<?php echo $organisme; ?>" method="post">
        <input type="hidden" name="lancement" value="<?php echo $result['lancement']; ?>">
        <input type="hidden" name="theme" value="<?php echo $result['theme']; ?>">
        <input type="hidden" name="description" value="<?php echo $result['description']; ?>">
        <input type="hidden" name="duree" value="<?php echo $result['duree']; ?>">
        <input type="hidden" name="comite" value="<?php echo $result['comite']; ?>">
        <input type="hidden" name="lancement" value="<?php echo $result['lancement']; ?>">
        <input type="hidden" name="id" value="<?php echo $result['id']; ?>">

    <td><button class="btn btn-info" onClick="javascript:location.href='propositionDashboard.php?appel=<?php echo $result['id']; ?>'">Voir les Propositions</button></td>
        <td><input type="submit" class="btn btn-warning" value="Modifier"></td>
        </form>
                
        <td><input type="button" class="btn btn-danger" <?php if($result2[0] > 0) echo "disabled"; else{?>
                   
                   onClick="deleteRequest(<?php echo $result['id']; ?>)"
                   <?php }
                   ?> value="Supprimer"></td>

    </tr>
<?php
}
?>
                        </tbody>
                    </table>
        <input type="submit" class="btn btn-primary" OnClick="javascript:location.href='createProposal.php?action=new&organisme=<?php echo $organisme; ?>'" value="Créer un nouvel appel à projet">

<?php
}
?>