<?php
include_once("conf.php");
include_once("dataprovider.php");
include('header.php');
include('header_info.php');

include('menu.php'); 

if (isset($_POST["send"]) && isset($_POST["type"]) && isset($_POST["montant"]) && isset($_POST["date"])
    && isset($_POST["projet"]))
{
    $type = pg_escape_string($_POST["type"]);
    $montant = intval($_POST["montant"]);
    $date = pg_escape_string(($_POST["date"]));
    $projet = intval($_POST["projet"]);

    // Vérifier que ça ajoute bien ?
    ajouterDepense($_SESSION["login"], $type, $montant, $date, $projet);
    echo "<p>Dépense ajoutée, redirection...</p>";
    echo '<meta http-equiv="refresh" content="2;URL=viewProject.php?projectId=$projet">'; 
}
else if (isset($_GET["projectId"]))
{
?>
    <h2>Inscrire une dépense</h2>
    <hr>
    <form class="form" role="form" action="createExpense.php" method="post">
        <input type="hidden" name="projet" value="<?php echo $_GET['projectId'];?>">
        <div class="form-group">
            <label for="inputDate" class="col-lg-2 control-label">Date </label>
            <div class="col-lg-10">
                <input type="date" name="date" class="form-control input-sm" placeholder="MM-JJ-AAAA"> 
            </div>
        </div>
        <div class="form-group">
            <label for"inputMontant" class="col-lg-2 control-label">Montant </label>
            <div class="col-lg-10">
                <input type="text" name="montant" />
            </div>
        </div>
        <div class="form-group">
            <label for="type" class="col-lg-2 control-label">Type </label>
            <div class="col-lg-10">
             <select id="type" name="type" class="form-control">
                 <option value="fonctionnement">Fonctionnement</option>
                 <option value="materiel">Matériel</option>
             </select>
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
}
include('footer.php');
?>