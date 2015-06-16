<?php
include_once("conf.php");
include_once("dataprovider.php");

include('header.php'); 
include('header_info.php'); 
include('menu.php'); 

?>

<h2>Liste des projets</h2>
<table class="table table-bordered table-hover table-striped">
    <thead><tr><th>Id</th><th>Début</th><th>Fin</th><th>Id de la proposition du projet</th><th>Description</th><th>Etat</th><th>Infos projet</th></tr></thead>
                        <tbody>
    <?php 
        $requests = GetProjects();
while($result = pg_fetch_array($requests)){
        $etat = getEtatProjet($result['i']);
       echo "<tr><td>".$result['i']."</td><td>".$result['d']."</td><td>".$result['f']."</td><td>"."<center>".$result['p']."</center></td><td>".$result['de']."</td><td>".$etat."</td>";
     
  ?>
       <td> <form action="viewProject.php">
            <input type="hidden" name="projectId" value="<?php echo $result['i']; ?>">
            <button class="btn btn-info">Voir les infos sur le projet</button>
        </form>
    </td>
        <form action="createProject.php" method="post">
            <input type="hidden" name="Début" value="<?php echo $result['debut']; ?>">
            <input type="hidden" name="Fin" value="<?php echo $result['fin']; ?>">
            <input type="hidden" name="Id de la proposition du projet" value="<?php echo $result['p']; ?>">
            <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
        </form>
  
    </tr>
<?php
}
?>
                        </tbody>
                    </table>

