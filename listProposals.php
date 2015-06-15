<?php
include_once("conf.php");
include_once("dataprovider.php");

include('header.php'); 
include('header_info.php'); 
include('menu.php'); 

// AFFICHAGE POUR EMPLOYE DE CONTACT
if($_SESSION['role'] == 'employe_de_contact')
{
        ?>
        <form class="form-inline" action="listProposals.php" method="GET">
        <p> Choisir l'appel à projet : 
            <select name="projectRequest" class="form-control">
            <?php
            $financer = getEmployeeFinancer($_SESSION['login']);
            $financer = pg_fetch_array($financer);
          $requests = getRequestsByFinancer($financer['nom']);
         while($result = pg_fetch_array($requests)){
            if (isset($_GET['projectRequest']) && ($_GET['projectRequest'] == $result['id'])){
                echo "<option value='".$result['id']."' selected>".$result['description']."</option>";
            } else {
                echo "<option value='".$result['id']."'>".$result['description']."</option>";                
            }
        }
        ?>
         </select> <input type="submit" class="btn btn-primary" value="Valider"></form>
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
        $proposals = getProposalsByRequest($idProjectRequest);
    while($result = pg_fetch_array($proposals)){
            $request = getRequestById($result['appel_a_projet']);
            $request = pg_fetch_assoc($request);
            echo "<tr><td>".$request['description']."</td><td>";
            if ($result['acceptation'] == null)
                    echo "En attente";
                    elseif ($result['acceptation'] == 't')
                        echo "Accept&eacute;";
                    else
                        echo "Refus&eacute;";
            echo "</td><td>".$result['reponse']."</td>";
    ?>
         <td>
            <input type="button" class="btn btn-info" onClick="javascript:document.location.href='viewProposal.php?proposalId=<?php echo $result['id']; ?>'" value="Voir">
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
            echo "<tr><td>".$result['description']."</td><td>";
            if ($result['acceptation'] == null)
                    echo "En attente";
                    elseif ($result['acceptation'] == 't')
                        echo "Accept&eacute;";
                    else
                        echo "Refus&eacute;";
            echo "</td><td>".$result['reponse']."</td>";
            ?>
            <td>
                <input type="button" class="btn btn-info" onClick="javascript:document.location.href='viewProposal.php?proposalId=<?php echo $result['id']; ?>'" value="Voir">
            </td>
        </tr>
        <?php
    }
    ?>
                    </tbody>
                </table>
<?php
}
dpdisconnect();
include('footer.php');
?>

