<?php if(!isset($_SESSION['role']) AND !isset($_SESSION['login']))
    echo '<meta http-equiv="refresh" content="0;URL=login.php">';

?>

<div id="masthead">  
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <h1><?php echo $_SESSION['nom']; ?>
                            <p class="lead"><?php echo $_SESSION['role']; ?></p>

                        </h1>
                    </div>
                </div> 
            </div><!--/container-->
        </div><!--/masthead-->
        <div class="container">
            <div class="row">
