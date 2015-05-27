<?php
include_once("conf.php");
include_once("dataprovider.php");
session_start();

// AFFICHAGE POUR EMPLOYE DE CONTACT
if($_SESSION['role'] == 'employe_de_contact')
{
        ?>
        <form action="/listProposals.php" method="GET">
        <p> Choisir l'appel à projet : 
            <select name="projectRequest">
            <?php
            $financer = getEmployeeFinancer($_SESSION['login']);
            $financer = pg_fetch_array($financer);
          $requests = getRequestsByFinancer($financer['nom']);
         while($result = pg_fetch_array($requests)){
            echo "<option value='".$result['id']."'>".$result['description']."</option>";
        }
        ?>
         </select>
        <br><input type="submit" value="valider"></form>
        <?php
    

    if (isset($_GET['projectRequest']))
    {
    ?>
<h2>Liste des propositions de projets recues</h2>
                    <table class="table table-bordered table-hover table-striped">
                        <thead><tr><th>Nom du projet</th><th>Statut</th><th>Date</th><th></th></tr></thead>
                        <tbody>
    <?php
        $idProjectRequest = intval(htmlspecialchars($_GET['projectRequest']));
        $requests = getProposalsByRequest($idProjectRequest);
    while($result = pg_fetch_array($requests)){
            $request = getRequestById($result['appel_a_projet']);
            $reqdesc = pg_fetch_result($request, 0, 4);
            echo "<tr><td>".$reqdesc."</td><td>".$result['acceptation']."</td><td>".$result['reponse']."</td>";
    ?>
         <td>
            <input type="button" class="btn btn-info" onClick="javascript:document.location.href='TODO'" value="Gerer labels">
            <input type="button" class="btn btn-info" onClick="javascript:document.location.href='TODO'" value="Accepter">
            <input type="button" class="btn btn-info" onClick="javascript:document.location.href='TODO'" value="Refuser">
         </td>
     </tr>
    <?php
    }
?>
                        </tbody>
                    </table>
<?php
    }
}
else {
    // AFFICHAGE POUR LABORATOIRE
    ?>
    <h2>Liste de toutes les propositions de projets</h2>
                    <table class="table table-bordered table-hover table-striped">
                        <thead><tr><th>Nom du projet</th><th>Statut</th><th>Date</th><th></th></tr></thead>
                        <tbody>
                            <?php
     $proposals = getProposals();
    while($result = pg_fetch_array($proposals)){
            echo "<tr><td>".$result['description']."</td><td>".$result['acceptation']."</td><td>".$result['reponse']."</td>";
            echo "<td><button>Voir</button></td></tr>";
    }
    ?>
                    </tbody>
                </table>
<?php
}
dpdisconnect();
?>

