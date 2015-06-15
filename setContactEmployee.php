<?php 
    include('header.php'); 
    include('header_info.php'); 
    include('menu.php'); 
    include('conf.php');
?>

<?php if(isset($_GET['financeur'])){
    $db = connexion();
    $ajout_titre = 0;
    if(isset($_POST['send']) AND $_POST['contact'] != "" AND !isset($_GET['type']) AND !isset($_GET['debut']) AND !isset($_GET['fin'])){
    $contact = htmlspecialchars($_POST['contact']);
    $financeur = htmlspecialchars($_POST['financeur']);
    $query0 = "SELECT COUNT(*) FROM employe_de_contact WHERE mail='".$contact."';";
    $result = pg_fetch_array(pg_query($query0));
    if($result[0] == 1){
        $query0 = "UPDATE financeur SET contact='".$contact."' WHERE nom='".$financeur."';";
        pg_query($query0)or die(pg_last_error());
        echo "<script> alert('Contact modifié avec succès!'); document.location.href='financerDashboard.php'; 
 </script>";
    }
        elseif(isset($_POST['titre']) AND $_POST['titre'] != "" AND $_POST['tel'] != ""){
            $titre = htmlspecialchars($_POST['titre']);
            $tel = htmlspecialchars($_POST['tel']);
            $tel = str_replace(' ','',$tel);
            
            $query0 = "BEGIN;
                        INSERT INTO employe_de_contact VALUES ('".$contact."',".$tel.",'".$titre."');
                        UPDATE financeur SET mail='".$contact."' WHERE nom='".$financeur."';
                        COMMIT;";
            pg_query($query0) or die(pg_last_error());
         echo "<script> alert('Contact ajouté avec succès!'); document.location.href='financerDashboard.php'; 
 </script>";

        }
    else
        $ajout_titre = 1;
    
    }
    elseif(isset($_POST['send']) AND $_POST['contact'] != "" AND isset($_GET['type']) AND isset($_GET['debut']) AND isset($_GET['fin'])){
        
    $contact = htmlspecialchars($_POST['contact']);
    $financeur = htmlspecialchars($_POST['financeur']);
    $debut = htmlspecialchars($_GET['debut']);
    $fin = htmlspecialchars($_GET['fin']);
    $type = htmlspecialchars($_GET['type']);
    $query0 = "SELECT COUNT(*) FROM employe_de_contact WHERE mail='".$contact."';";
    $result = pg_fetch_array(pg_query($query0));
    if($result[0] == 1){
        $query1 = "BEGIN; 
                   INSERT INTO entite_juridique VALUES('".$financeur."','".$type."');
                   INSERT INTO financeur VALUES('".$financeur."','".$contact."','".$debut."','".$fin."');
                   COMMIT;";
        pg_query($query1) or die("<h2>Erreur: données erronées ou déjà existantes!</h2>".pg_last_error()."<meta http-equiv='refresh' content='2;URL='>");
        echo "<script> alert('Création de financeur et contact réalisés avec succès!'); document.location.href='financerDashboard.php'; 
 </script>";
    }
        elseif(isset($_POST['titre']) AND $_POST['titre'] != "" AND $_POST['tel'] != ""){
            $titre = htmlspecialchars($_POST['titre']);
            $tel = htmlspecialchars($_POST['tel']);
            $tel = str_replace(' ','',$tel);

        $query1 = "BEGIN; 
                   INSERT INTO employe_de_contact VALUES ('".$contact."',".$tel.",'".$titre."');
                   INSERT INTO entite_juridique VALUES('".$financeur."','".$type."');
                   INSERT INTO financeur VALUES('".$financeur."','".$contact."','".$debut."','".$fin."');
                   COMMIT;";
        pg_query($query1) or die("<h2>Erreur: données erronées ou déjà existantes!</h2>".pg_last_error()."<meta http-equiv='refresh' content='2;URL='>");
        echo "<script> alert('Création de financeur et contact réalisés avec succès!'); document.location.href='financerDashboard.php'; 
 </script>";

        }
    else
        $ajout_titre = 1;
    
        }
            
echo "<h2 id='modif'>Modifier votre contact</h2>";
$financeur = htmlspecialchars($_GET['financeur']);
$query = "SELECT P.mail, P.nom FROM personne P EXCEPT SELECT V.mail, V.nom FROM vmembre_du_projet V;";
//récupère les personnes qui ne sont pas membres de projet, et donc peuvent être contact !
$query = pg_query($query);
$query2 = "SELECT contact FROM financeur WHERE nom='".$financeur."';";
$query2 = pg_query($query2) or die(pg_last_error());
$retour = pg_fetch_array($query2);
?>
<form class="form" role="form" action="" method="post">
    
<div class="form-group">
<input type="hidden" name="financeur" value="<?php echo $_GET['financeur']; ?>"/>
 <label for="type">Contact </label>
     <select id="type" name="contact" class="form-control">
<?php
    while($result = pg_fetch_array($query)){
            echo "<option value='".$result['mail']."'";
        if(isset($_POST['contact']) AND $_POST['contact'] == $result['mail'])echo " selected";
            elseif($result['mail'] == $retour['contact']) echo " selected";
            echo ">".$result['nom']."</option>";
    }
    ?>
     </select>
 </div>
    <?php if($ajout_titre == 1){
    ?> 
<div class="form-group">
  <label for="tel">Numéro de Téléphone:</label>
  <input type="text"  name="tel" value="<?php echo $_POST['tel']; ?>" class="form-control" id="tel">
</div>
<div class="form-group">
  <label for="titre">Titre:</label>
  <input type="text" name="titre" value="<?php echo $_POST['titre']; ?>"class="form-control" id="titre">
</div>
    
    <?php
    }
    ?>
    <div class="form-group">
 <div class="col-lg-offset-2 col-lg-10">
   <button type="submit" name="send" class="btn btn-default">Envoyer</button>
 </div>
 </div>

</form>
<?php
    pg_close($db);
}
?>
<?php include('footer.php'); ?>