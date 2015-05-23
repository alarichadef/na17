<?php 
if(isset($_POST['send']) AND $_POST['nom'] != "" AND $_POST['debut'] != "" AND $_POST['fin']){
    $nom = htmlspecialchars($_POST['nom']);
    $debut = htmlspecialchars($_POST['debut']);
    $fin = htmlspecialchars($_POST['fin']);
    $type = htmlspecialchars($_POST['type']);
    $contact = htmlspecialchars($_POST['contact']);
//    if($contact != "new"){
//    $db = connexion();
//    $query1 = "INSERT INTO entite_juridique VALUES('".$nom."','".$type."')";
//    $query2 = "INSERT INTO financeur VALUES('".$nom."','".$contact."','".$debut."','".$fin."')";
//    pg_query($query1) or die("<h2>Erreur: données erronées ou déjà existantes!</h2>".pg_last_error()."<meta http-equiv='refresh' content='2;URL='>");
//    pg_query($query2) or die("<h2>Erreur: données erronées ou déjà existantes!</h2>".pg_last_error()."  <meta http-equiv='refresh' content='2;URL='>");
//    pg_close($db);
//?>
<!--
<script> alert('Financeur créé avec succès !'); </script>
<meta http-equiv='refresh' content='0;URL='>
-->
<?php
//    }
//    else{
    echo "<script> alert('Redirection vers la création de votre contact !'); 
    document.location.href='setContactEmployee.php?financeur=".$nom."&debut=".$debut."&fin=".$fin."&type=".$type."';
        </script>";   
// }
}
    ?>
    <h2>Inscrire un Financeur</h2>
    <hr>
<form class="form" role="form" action="" method="post">
 <div class="form-group">
 <label for="inputEmail1" class="col-lg-2 control-label">Nom </label>
 <div class="col-lg-10">
   <input type="text" class="form-control" required="" name="nom" id="inputEmail1" placeholder="Nom du Financeur">
 </div>
 </div>
<div class="form-group">
 <label for="type" class="col-lg-2 control-label">Type </label>
 <div class="col-lg-10">
     <select id="type" name="type" class="form-control">
         <option value="pays">Pays</option>
         <option value="region">Région</option>
         <option value="entreprise">Entreprise</option>
         <option value="organisation">Organisation</option>
     </select>
 </div>
 </div>
<div class="form-group">
    <label for="type" class="col-lg-2 control-label">Debut d'activité:  </label>
 <div class="col-lg-10">
     <input type="date" name="debut" class="form-control input-sm" placeholder="MM-JJ-AAAA">
 </div>
 </div>
    <div class="form-group">
 <label for="type" class="col-lg-2 control-label ">Fin d'activité: </label>
 <div class="col-lg-10">
     <input type="date" name="fin" class="form-control input-sm" placeholder="MM-JJ-AAAA">
 </div>
 </div>

<!--
    <div class="form-group">
 <label for="type" class="col-lg-2 control-label">Employé de contact </label>
 <div class="col-lg-10">
     <select id="type" name="contact" class="form-control">
        <option value="new">Nouveau Contact Employé</option>
<?php
    $db = connexion();
    $query = "SELECT mail, nom FROM vemploye_de_contact";
    $query = pg_query($query);
    while($result = pg_fetch_array($query))
        echo "<option value='".$result['mail']."'>".$result['nom']."</option>";
    pg_close($db);
?>
     </select>
 </div>
 </div>
-->



<div class="form-group">
 <div class="col-lg-offset-2 col-lg-10">
   <button type="submit" name="send" class="btn btn-default">Envoyer</button>
 </div>
 </div>
</form>
