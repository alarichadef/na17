<?php
include_once("dataprovider.php");
if(!isset($_GET['organisme']))
{
    ?>
<h2>Liste des Financeurs</h2>
                    <table class="table table-bordered table-hover table-striped">
                        <thead><tr><th>Nom</th><th>Type</th><th>Contact</th><th>Debut d'Activité</th><th>Fin d'Activité</th><th></th></tr></thead>
                        <tbody>
    <?php 
        $db = dpconnexion();
        $query = "SELECT * FROM vfinanceur ORDER BY type,nom";
        $query = pg_query($query);
    while($result = pg_fetch_array($query)){
            echo "<tr><td>".$result['nom']."</td><td>".$result['type']."</td><td>".$result['contact']."</td><td>".$result['debut']."</td><td>".$result['fin']."</td>";
    ?>
         <td><input type="button" class="btn btn-info" onClick="javascript:document.location.href='setContactEmployee.php?financeur=<?php echo $result['nom']; ?>'" value="Changer de Contact"></td></tr>
    <?php
    }
        pg_close($db);
?>
                        </tbody>
                    </table>
<?php
}
else{
    $db = dpconnexion();
    $organisme = htmlspecialchars($_GET['organisme']);
    $contact = htmlspecialchars($_SESSION['login']);
    $query = "SELECT COUNT(*) FROM financeur F JOIN assoc_financeur_organisme A ON F.nom = A.financeur WHERE A.organisme ='".$organisme."' AND F.contact = '".$contact."';";
    
    $query = pg_query($query)or die(pg_last_error());
    $result = pg_fetch_array($query);
    if($result[0] <= 0) //Acces non-autorisé
     echo "<script> document.location.href='index.php';</script>";
    
?>
<h2>Financeurs de <?php echo $organisme; ?></h2>
                    <table class="table table-bordered table-hover table-striped">
                        <thead><tr><th>Nom</th><th>Type</th><th>Debut d'Activité</th><th>Fin d'Activité</th></tr></thead>
                        <tbody>
    <?php 
        $query = "SELECT * FROM vfinanceur F JOIN assoc_financeur_organisme A ON F.nom = A.financeur WHERE A.organisme='".$organisme."';";
        $query = pg_query($query);
        while($result = pg_fetch_array($query))
            echo "<tr><td>".$result['nom']."</td><td>".$result['type']."</td><td>".$result['debut']."</td><td>".$result['fin']."</td></tr>";
        pg_close($db);
?>
                        </tbody>
                    </table>
<?php
}
include('footer.php');
?>