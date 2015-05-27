<?php
include_once("conf.php");
include_once("dataprovider.php");

// AFFICHAGE POUR EMPLOYE DE CONTACT
if($_SESSION['role'] == 'employe_de_contact')
{
        ?>
        <form action="/" method="GET">
        <p> Choisir l'appel à projet : 
            <select name="projectRequest">
            <?
            $financer = getEmployeeFinancer($_SESSION['login']);
            $financer = pg_fetch_array($financer);
          $requests = getRequestsByFinancer($financer['nom']);
         while($result = pg_fetch_array($requests)){
            echo "<option value='".$result['id']."'>".$result['description']."</option>";
        }
        ?>
        <br><input type="submit" value="valider"></form>
        <?
    

    if (isset($_GET['projectRequest']))
    {
    ?>
<h2>Liste des propositions de projets</h2>
                    <table class="table table-bordered table-hover table-striped">
                        <thead><tr><th>Nom du projet</th><th>Statut</th><th>Date</th><th></th></tr></thead>
                        <tbody>
    <? 
        $idProjectRequest = intval(htmlspecialchars($_GET['projectRequest']));
        $requests = getProposalsByRequest($idProjectRequest);
    while($result = pg_fetch_array($requests)){
            echo "<tr><td>".$result['description']."</td><td>".$result['acceptation']."</td><td>".$result['reponse']."</td>";
    ?>
         <td>
            <input type="button" class="btn btn-info" onClick="javascript:document.location.href='TODO'" value="Gérer labels">
            <input type="button" class="btn btn-info" onClick="javascript:document.location.href='TODO'" value="Accepter">
            <input type="button" class="btn btn-info" onClick="javascript:document.location.href='TODO'" value="Refuser">
         </td>
     </tr>
    <?
    }
?>
                        </tbody>
                    </table>
<?
    }
}
else {
    // AFFICHAGE POUR LABORATOIRE
    ?>
    <h2>Liste des propositions de projets</h2>
                    <table class="table table-bordered table-hover table-striped">
                        <thead><tr><th>Nom du projet</th><th>Statut</th><th>Date</th></tr></thead>
                        <tbody>
                            <?
     $proposals = getProposals();
    while($result = pg_fetch_array($proposals)){
            echo "<tr><td>".$result['description']."</td><td>".$result['acceptation']."</td><td>".$result['reponse']."</td></tr>";
    }
    ?>
                    </tbody>
                </table>
<?
}
disconnect($db);
include('footer.php');
?>

