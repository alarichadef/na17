<?php if(!isset($_SESSION['role']) AND !isset($_SESSION['login']))
 echo '<meta http-equiv="refresh" content="0;URL=login.php">';
elseif($_SESSION['role'] != 'financeur')
echo '<meta http-equiv="refresh" content="0;URL=index.php">';
?>

<div id="masthead">  
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <h1>Région de Picardie <?php echo "lol"; ?>
                            <p class="lead">Financeur</p>
                            <p class="lead" style="font-size:13pt; margin-bottom:10px;">Début d'activité: 18 Mai 2015</p>
                            <p class="lead" style="font-size:13pt; margin:0;">Fin d'activité: 21 Juin 2015</p>

                        </h1>
                    </div>
                </div> 
            </div><!--/container-->
        </div><!--/masthead-->
        <div class="container">
            <div class="row">
