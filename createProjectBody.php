<?php 
if(isset($_GET['action']) AND $_GET['action'] == "new"){
    
        $db = connexion();
        $check = "SELECT nom FROM financeur WHERE contact='".$_SESSION['login']."';";
        $check = pg_query($check);
        $ok = 0;
        while($result = pg_fetch_array($check)){
            if(isset($_GET[$result['nom']])) $ok=1;
                         }
    pg_close($db);
         if($ok == 0){
    ?>
    <script> alert("Veuillez sélectionner au moins un financeur !"); document.location.href='contactEmployeDashboard.php'; </script>
<?php
         }
    else{
    if(isset($_POST['send']) AND $_POST['nom'] != "" AND is_numeric($_POST['duree'])){
        $db = connexion();
        $nom = htmlspecialchars($_POST['nom']);
        $duree = htmlspecialchars($_POST['duree']);

        $check = "SELECT nom FROM financeur WHERE contact='".$_SESSION['login']."';";
        $check = pg_query($check);
        $ok = 0;
        while($result = pg_fetch_array($check)){
            if(isset($_GET[$result['nom']])) $ok=1;
                         }
         if($ok == 0){
    ?>
    <script> alert("Veuillez sélectionner au moins un financeur !"); document.location.href='contactEmployeDashboard.php'; </script>
<?php
         }
        else{        
        $query = "INSERT INTO organisme_de_projet VALUES ('".$nom."','".date('Y-m-d')."','".$duree."','actif');";
        $query = pg_query($query)or die(pg_last_error());
        foreach($_GET as $valeur){
            if($valeur != "new"){
            $query = "INSERT INTO assoc_financeur_organisme VALUES ('".$valeur."','".$nom."');";
            pg_query($query)or die(pg_last_error());
            }
        }
    echo '<script> alert("Organisme de Projet ajouté avec succès !"); </script>';
    ?>
    <meta http-equiv="refresh" content="0;URL='contactEmployeDashboard.php'">
<?php
}
    close($db);
    }
        elseif(isset($_POST['send'])){
?>    
   <script>alert('Informations renseignées erronées');</script>               
<?php
        }
    ?>
   <h2>Création d'un nouvel Organisme de Projet</h2>
<form class="form" role="form" action="" method="post">
 <div class="form-group">
 <label for="inputEmail1" class="col-lg-2 control-label">Nom </label>
 <div class="col-lg-10">
   <input type="text" class="form-control" value="<?php echo $_POST['nom']; ?>" name="nom" id="inputEmail1" placeholder="Nom de l'Organisme">
 </div>
 </div>
<div class="form-group">
 <label for="duree" class="col-lg-2 control-label">Durée </label>
  <div class="controls">
    <div class="col-lg-10">
      <input id="duree" name="duree" value="<?php echo $_POST['duree']; ?>" class="form-control" placeholder="Nombre de Mois" value="0" type="text">
    </div>
  </div>
</div>
<div class="form-group">
 <label for="duree" class="col-lg-2 control-label"> </label>
  <div class="controls">
    <div class="col-lg-10">
<input type="submit" class="btn btn-primary" name="send" value="Envoyer !">
      </div>
  </div>
</div>
</form>
  <?php  
}
}
?>

<h2>Liste de mes Financeurs</h2>
<form class="form" role="form" action="" method="get">
 <div class="form-group">
     <input type="hidden" name="action" value="new">
                    <table class="table table-bordered table-hover table-striped">
                        <thead><tr><th></th></th><th>Nom</th><th>Type</th><th>Debut d'Activité</th><th>Fin d'Activité</th></tr></thead>
                        <tbody>
    <?php 
        $db = connexion();
        $query = "SELECT * FROM vfinanceur WHERE contact='".$_SESSION['login']."';";
        $query = pg_query($query);
while($result = pg_fetch_array($query)){
            echo "<tr";
            if(isset($_GET[$result['nom']]))echo ' class="success"';
            echo "><td><input type='checkbox' ";
            if(isset($_GET[$result['nom']]))echo ' checked="checked"';
        
            echo "name='".$result['nom']."' value='".$result['nom']."'></td><td>".$result['nom']."</td><td>".$result['type']."</td><td>".$result['debut']."</td><td>".$result['fin']."</td></tr>";
    
}


        pg_close($db);
?>
                        </tbody>
                    </table>
<input type="submit" class="btn btn-primary" id="submit"value="Créer un nouvel Organisme de projet">
</div>
</form>
<h2>Organismes de Projets</h2>                    
<table class="table table-bordered table-hover table-striped">
    <thead><tr><th>Nom</th><th>Création</th><th>Durée</th><th>Etat</th><th>Financeurs</th><th></th></tr></thead>
                        <tbody>
    <?php 
        $db = connexion();
        $query = "SELECT DISTINCT O.nom, O.creation, O.duree, O.etat FROM assoc_financeur_organisme A JOIN organisme_de_projet O ON A.organisme = O.nom WHERE A.financeur IN (SELECT nom FROM vfinanceur WHERE contact='".$_SESSION['login']."');";
        $query = pg_query($query);

while($result = pg_fetch_array($query)){
            $query2 = "SELECT financeur FROM assoc_financeur_organisme WHERE organisme='".$result['nom']."';";
            $query2 = pg_query($query2);

            echo "<tr><td>".$result['nom']."</td><td>".$result['creation']."</td><td>".$result['duree']."</td><td>".$result['etat']."</td><td>";

    while($result2 = pg_fetch_array($query2)) echo $result2['financeur']." ";
    
    ?>
    </td><td><button class="btn btn-info" onClick="javascript:location.href='projectOrganismDashboard.php?organisme=<?php echo $result['nom']; ?>'">Gérer</button></td></tr>
<?php
}
        pg_close($db);
?>
                        </tbody>
                    </table>

