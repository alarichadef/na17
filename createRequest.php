<?php
include('conf.php');
include('header.php');
include('header_info.php');
include('menu.php');
if(isset($_GET['organisme']) AND $_GET['organisme'] != ""){
    
    $db = connexion();
    $organisme = htmlspecialchars($_GET['organisme']);
    $contact = htmlspecialchars($_SESSION['login']);
    $query = "SELECT COUNT(*) FROM financeur F JOIN assoc_financeur_organisme A ON F.nom = A.financeur WHERE A.organisme ='".$organisme."' AND F.contact = '".$contact."';";
    $query = pg_query($query)or die(pg_last_error());
    $result = pg_fetch_array($query);
    if($result[0] <= 0) //Acces non-autorisé 
     echo "<script> document.location.href='index.php';</script>";
 
if(isset($_POST['send']))//AJOUT
{
    if(validateDate($_POST['lancement']) AND is_numeric($_POST['duree']) AND $_POST['comite'] != ""){
        $lancement = htmlspecialchars($_POST['lancement']);
        $duree = htmlspecialchars($_POST['duree']);
        $description = htmlspecialchars($_POST['description']);
        $theme = htmlspecialchars($_POST['theme']);
        $comite = htmlspecialchars($_POST['comite']);
        $id = htmlspecialchars($_POST['id']);
        
        if($_POST['id'] == ""){
        $query = "INSERT INTO appel_a_projet (lancement, duree, description, theme, publieur, comite) VALUES
        ('".$lancement."',".$duree.",'".$description."','".$theme."','".$organisme."','".$comite."');";
        pg_query($query)or die(pg_last_error());
        ?>

<script>alert('Appel à projet ajouté avec succès !'); 
        location.href='projectOrganismDashboard.php?organisme=<?php echo $organisme; ?>';</script>

<?php    
    }
        else{
        $query = "UPDATE appel_a_projet SET lancement='".$lancement."',duree=".$duree.",description='".$description."',theme='".$theme."',publieur='".$organisme."',comite='".$comite."' WHERE id=".$id.";";
        pg_query($query)or die(pg_last_error());
        ?>

<script>alert('Appel à projet modifié avec succès !'); 
        location.href='projectOrganismDashboard.php?organisme=<?php echo $organisme; ?>';</script>

<?php       
        }
    }
    else{
     echo "<p class='lead'>Un ou plusieurs champs sont manquants/erronés !</p>";   
        
    }
}
?>
<h2>Création d'un Appel à Projet</h2>
<form class="form" role="form" action="" method="post">
 <div class="form-group">
 <label for="inputEmail1" class="col-md-3 control-label">Lancement </label>
 <div class="col-md-9">
   <input type="date" value="<?php if(isset($_POST['lancement'])) echo $_POST['lancement']; ?>" class="form-control" required="" name="lancement" id="inputEmail1" placeholder="Date de Lancement (AAAA-MM-DD)">
 </div>
 </div>
<div class="form-group">
 <label for="duree" class="col-md-3 control-label">Durée </label>
  <div class="controls">
    <div class="col-md-9">
      <input id="duree" value="<?php if(isset($_POST['duree'])) echo $_POST['duree']; ?>" name="duree" class="form-control" placeholder="Nombre de Mois"  type="text">
    </div>
  </div>
</div>
    <div class="form-group">
 <label for="description" class="col-md-3 control-label">Description </label>
  <div class="controls">
    <div class="col-md-9">
        <textarea class="form-control" id="description" name="description" class="form-control" placeholder="Description de l'appel" rows="3"><?php if(isset($_POST['description'])) echo $_POST['description']; ?></textarea>
    </div>
  </div>
</div>
<div class="form-group">
 <label for="theme" class="col-md-3 control-label">Thème </label>
  <div class="controls">
    <div class="col-md-9">
      <input id="theme" name="theme" class="form-control" value="<?php if(isset($_POST['theme'])) echo $_POST['theme']; ?>" placeholder="Thème de l'appel" type="text">
    </div>
  </div>
</div>
    <div class="form-group">
 <label for="comite" class="col-md-3 control-label">Comite </label>
  <div class="controls">
    <div class="col-md-9">
     <select id="comite" name="comite" class="form-control">
<?php 
    $query = "SELECT nom FROM comite";
    $query = pg_query($query);
    while($result = pg_fetch_array($query)){
         echo '<option value="'.$result['nom'].'"';
        if(isset($_POST['comite']) AND $_POST['comite'] == $result['nom'])echo " selected ";
         echo '>'.$result['nom'].'</option>';
    }
    ?>
     </select>
      </div>
  </div>
</div>

    <input type="hidden" name="id" value="<?php if(isset($_POST['id'])) echo $_POST['id']; ?>">
 
<div class="form-group">
  <div class="controls">
    <div class="col-md-12">
<input type="submit" name="send" class="btn btn-primary" value="Envoyer !">
      </div>
  </div>
</div>
</form>
<?php 
    pg_close($db);
}
else{
    ?>
<script>document.location.href='index.php';</script>
<?php } include('footer.php');?>