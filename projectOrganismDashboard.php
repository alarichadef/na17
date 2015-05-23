<?php include('header.php');
    include('header_info.php');
    include('conf.php');
    include('menu.php');
if(isset($_GET['organisme'])){
    
    $db = connexion();
    $organisme = htmlspecialchars($_GET['organisme']);
    $contact = htmlspecialchars($_SESSION['login']);
    $query = "SELECT COUNT(*) FROM financeur F JOIN assoc_financeur_organisme A ON F.nom = A.financeur WHERE A.organisme ='".$organisme."' AND F.contact = '".$contact."';";
    $query = pg_query($query)or die(pg_last_error());
    $result = pg_fetch_array($query);
    if($result[0] <= 0) //Acces non-autorisé
     echo "<script> document.location.href='index.php';</script>";
    
    /////////////////// ACCES AUTORISE
    //// DELETE FINANCER

    if(isset($_GET['delete']) AND isset($_GET['financeur'])){
     
        $financeur = htmlspecialchars($_GET['financeur']);
        $query = "DELETE FROM assoc_financeur_organisme WHERE financeur='".$financeur."' AND organisme='".$organisme."';";
        pg_query($query)or die(pg_last_error());
        ?>
<script>
alert('Financeur retiré avec succès !');
document.location.href='projectOrganismDashboard.php?organisme=<?php echo $organisme; ?>';
</script>
<?php
    } ////// DESACTIVER/ACTIVER ORGANISME
    
    if(isset($_GET['desactivate'])){
        $query = "UPDATE organisme_de_projet SET etat='disparu' WHERE nom='".$organisme."';";
        pg_query($query)or die(pg_last_error());
        ?>
<script>
alert('Organisme de projet désactivé avec succès !');
document.location.href='projectOrganismDashboard.php?organisme=<?php echo $organisme; ?>';
</script>
<?php
    }
    if(isset($_GET['activate'])){
        $query = "UPDATE organisme_de_projet SET etat='actif' WHERE nom='".$organisme."';";
        pg_query($query)or die(pg_last_error());
        ?>
<script>
alert('Organisme de projet activé avec succès !');
document.location.href='projectOrganismDashboard.php?organisme=<?php echo $organisme; ?>';
</script>
<?php
    }
    //// ADD FINANCER
    if(isset($_POST['addFinancer'])){
     
        $financeur = htmlspecialchars($_POST['addFinancer']);
        $query = "INSERT INTO assoc_financeur_organisme VALUES ('".$financeur."','".$organisme."');";
        $query = pg_query($query)or die(pg_last_error());
        ?>
<script>
alert('Financeur ajouté avec succès !');
document.location.href='projectOrganismDashboard.php?organisme=<?php echo $organisme; ?>';
</script>
<?php
    }
    if(isset($_GET['delete'])){
    $id = htmlspecialchars($_GET['delete']);
     $query = "SELECT COUNT(*) FROM appel_a_projet WHERE id=".$id." AND publieur='".$organisme."';";
     $query2 = "SELECT COUNT(*) FROM proposition_de_projet WHERE appel_a_projet='".$id."';";
     $query2 = pg_query($query2) or die(pg_last_error());
     $query = pg_query($query) or die(pg_last_error());
     $result2 = pg_fetch_array($query2);
     $result = pg_fetch_array($query);
        if($result[0] > 0 AND $result2[0] == 0){
            $query = "DELETE FROM appel_a_projet WHERE id=".$id.";";
            pg_query($query)or die(pg_last_error());
        }
    }


    $query = "SELECT * FROM organisme_de_projet WHERE nom ='".$organisme."';";
    $query = pg_query($query);
    $result = pg_fetch_array($query);
    echo "<h2>Organisme ".$result['nom']."</h2><ul class='list-group'>
        <li class='list-group-item'><b>Date de création</b>\t".$result['creation']."</li>
        <li class='list-group-item'><b>Durée</b> ".$result['duree']." mois</li>
        <li class='list-group-item'><b>Etat</b> ".$result['etat']."</li>";
?>
        <li class='list-group-item'><input type="button" class="btn btn-danger" 
  <?php if($result['etat'] == 'actif')
        echo 'onClick="desactivateOrganism()" value="Desactiver"'; 
        else echo 'onClick="activateOrganism()" value="Activer"'; 
            ?>
</li>
</ul>

<script>
function desactivateOrganism(){
var choix = confirm('Êtes-vous sûr de vouloir desactiver cette organisme de projet ?');
if(choix)document.location.href='projectOrganismDashboard.php?organisme=<?php echo $organisme; ?>&desactivate';
}
function activateOrganism(){
var choix = confirm('Êtes-vous sûr de vouloir activer cette organisme de projet ?');
if(choix)document.location.href='projectOrganismDashboard.php?organisme=<?php echo $organisme; ?>&activate';
}

</script>

<h2>Financeurs de <?php echo $organisme; ?></h2>
<table class="table table-bordered table-hover table-striped">
                        <thead><tr><th>Nom</th><th>Type</th><th>Debut d'Activité</th><th>Fin d'Activité</th><th></th></tr></thead>
                        <tbody>
    <?php 
        $query = "SELECT * FROM vfinanceur F JOIN assoc_financeur_organisme A ON F.nom = A.financeur WHERE A.organisme='".$organisme."' ORDER BY type, nom;";
        $query2 = "SELECT COUNT(*) FROM vfinanceur F JOIN assoc_financeur_organisme A ON F.nom = A.financeur WHERE A.organisme='".$organisme."';";

        $query = pg_query($query);
        $query2 = pg_query($query2);
    $result2 = pg_fetch_array($query2);
    
    while($result = pg_fetch_array($query)){
            echo "<tr><td>".$result['nom']."</td><td>".$result['type']."</td><td>".$result['debut']."</td><td>".$result['fin']."</td><td>"; ?>
                            <?php if($result2[0] > 1){?>
                            <button class="btn btn-warning" onClick="javascript:location.href='?delete&organisme=<?php echo $organisme; ?>&financeur=<?php echo $result['nom']; ?>'">Retirer</button>
                            
<?php
     }
            echo "</td></tr>";
    }
?>
                        </tbody>
                    </table>
<form class="form" role="form" action="" method="post">
<div class="form-group row">
 <label for="type" class="col-md-2 control-label">Ajouter un Financeur </label>
 <div class="col-md-8">
     <select id="type" name="addFinancer" class="form-control">
<?php 
    $query = "SELECT nom FROM financeur WHERE contact='".$contact."' EXCEPT
              SELECT financeur FROM assoc_financeur_organisme WHERE organisme='".$organisme."';";
    $query = pg_query($query);
    while($result = pg_fetch_array($query))
         echo '<option value="'.$result['nom'].'">'.$result['nom'].'</option>';
    ?>
     </select>
 </div>
<div class="col-md-2">
        <input type="submit" class="btn btn-primary " value="Ajouter">
</div>
 </div>
</form>



<?php
    include('listRequest.php');
    pg_close($db);
}
    include('footer.php'); 
?>