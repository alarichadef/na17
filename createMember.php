<?
include('header.php');
include('header_info.php');
include('conf.php');
include('menu.php');

if (isset($_POST["send"]) && isset($_POST["nom"]) && isset($_POST["mail"]) && isset($_POST["fonction"])
&& isset($_POST["type"]), && isset($_POST["domaine"]) && isset($_POST["quotite"]) && isset($_POST["etablissement"])
&& isset($_POST["sujet"]) && isset($_POST["debut"]) {
  $nom = pg_escape_string($_POST["nom"]);
  $mail = pg_escape_string($_POST["mail"]);
  $fonction = pg_escape_string($_POST["fonction"]);
  $type = pg_escape_string($_POST["type"]);
  $domaine = pg_escape_string($_POST["domaine"]);
  $quotite = intval($_POST["quotite"]);
  $etablissement = pg_escape_string($_POST["etablissement"]);
  $sujet = pg_escape_string($_POST["sujet"]);
  $debut = pg_escape_string($_POST["debut"]);

  if (creerPersonne($mail, $nom))
  {
    creerMembreLaboratoire($mail, $nom, $fonction, $type, $domaine, $quotite, $etablissement, $sujet, $debut);
    echo 'Création réussie !';
  }
}
?>

<h2>Créer un membre</h2>
<hr>
<form class="form" role="form" action="" method="post">
    <div class="form-group">
        <label for="inputNom" class="col-lg-2 control-label">Nom </label>
        <div class="col-lg-10">
            <input type="text" name="nom"> 
        </div>
    </div>
    <div class="form-group">
        <label for"inputMail" class="col-lg-2 control-label">Mail </label>
        <div class="col-lg-10">
            <input type="text" name="mail" />
        </div>
    </div>
    <div class="form-group">
        <label for="type" class="col-lg-2 control-label">Fonction </label>
        <div class="col-lg-10">
          <input type="text" name="fonction" />
        </div>
    </div>
    <div class="form-group">
        <label for="type" class="col-lg-2 control-label">Type </label>
        <div class="col-lg-10">
          <select id="type" name="type" class="form-control">
           <option value="IR">Ingénieur de Recherche</option>
           <option value="EC">Enseignant chercheur</option>
           <option value="D">Doctorant</option>
           <option value="organisation">Organisation</option>
          </select>
        </div>
    </div>
    <div class="form-group">
        <label for="type" class="col-lg-2 control-label">Domaine: </label>
        <div class="col-lg-10">
          <input type="text" name="domaine" />
        </div>
    </div>
    <div class="form-group">
        <label for="type" class="col-lg-2 control-label">Quotite: </label>
        <div class="col-lg-10">
          <input type="text" name="domaine" />
        </div>
    </div>
    <div class="form-group">
        <label for="type" class="col-lg-2 control-label">Etablissement: </label>
        <div class="col-lg-10">
          <input type="text" name="etablissement" />
        </div>
    </div>
    <div class="form-group">
        <label for="type" class="col-lg-2 control-label">Sujet: </label>
        <div class="col-lg-10">
          <input type="text" name="sujet" />
        </div>
    </div>
    <div class="form-group">
        <label for="type" class="col-lg-2 control-label">Debut: </label>
        <div class="col-lg-10">
          <input type="date" name="debut" class="form-control input-sm" placeholder="MM-JJ-AAAA">
        </div>
    </div>
    <div class="form-group">
      <div class="controls">
        <div class="col-md-12">
            <input type="submit" name="send" class="btn btn-primary" value="Envoyer !">
        </div>
      </div>
    </div>
</form>
<?php
include('footer.php');
?>