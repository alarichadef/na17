<?php
include_once("conf.php");
include_once("dataprovider.php");
include('header.php');
include('header_info.php');

include('menu.php');
if ($_SESSION['role'] != 'membre_du_laboratoire')
{
?>
<h2>Liste de vos projets</h2>
<table class="table table-bordered table-hover table-striped">
    <thead><tr><th>Id</th><th>Début</th><th>Fin</th><th>Id de la proposition du projet</th><th></th></tr></thead>
                        <tbody>
    <?php 
        $requests = getMyProjects($_SESSION['login']);
while($result = pg_fetch_array($requests)){
       echo "<tr><td>".$result['id']."</td><td>".$result['debut']."</td><td>".$result['fin']."</td>"."<td><center>".$result['proposition']."</center></td>";
     
  ?>
       <td> <form action="viewProject.php">
            <input type="hidden" name="projectId" value="<?php echo $result['id']; ?>">
            <button class="btn btn-info">Voir les infos sur le projet</button>
        </form>
    </td>
<?php
}
?>
</tbody>
</table>
<?php
}
include('footer.php');
?>