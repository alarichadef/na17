<?php include('header.php'); 
        include('conf.php'); ?>
<?php if(isset($_POST['login'])){ 
       if($_POST['login'] == "admin"){
          $_SESSION['login'] = "admin";
          $_SESSION['nom'] = "Admin";
          $_SESSION['role'] = "webmaster";
         echo '<meta http-equiv="refresh" content="0;URL=financerDashboard.php">';
            }
            else{
    $mail = htmlspecialchars($_POST['login']);
    $db = connexion();
    $query = "SELECT COUNT(*), mail, nom, telephone, titre FROM vemploye_de_contact WHERE mail='".$mail."'GROUP BY mail, nom, telephone,titre;";
    $query = pg_query($query);
    $result = pg_fetch_array($query);
    if($result[0] > 0){
        $_SESSION['login'] = $mail;
        $_SESSION['nom'] = $result['nom'];
        $_SESSION['telephone'] = $result['telephone'];
        $_SESSION['titre'] = $result['titre'];
        $_SESSION['role'] = 'employe_de_contact';
        echo '<meta http-equiv="refresh" content="2;URL=contactEmployeDashboard.php">';
        echo '<div class="container" style="margin-top:50px;">
    <h1>Vous êtes connecté '.$result['nom'].' !</h1>
    <p class="lead"> Vous allez être redirigé dans quelques secondes..</p>
    </div>';
    }
    else{
    $query = "SELECT COUNT(*), mail, nom, fonction FROM vmembre_du_laboratoire WHERE mail='".$mail."'GROUP BY mail, nom, fonction;";
    $query = pg_query($query);
    $result = pg_fetch_array($query);
    if($result[0] > 0){
        $_SESSION['login'] = $mail;
        $_SESSION['nom'] = $result['nom'];
        $_SESSION['fonction'] = $result['fonction'];
        $_SESSION['role'] = 'membre_du_laboratoire';
        echo '<meta http-equiv="refresh" content="2;URL=laboratoryMemberDashboard.php">';
        echo '<div class="container" style="margin-top:50px;">
    <h1>Vous êtes connecté '.$result['nom'].' !</h1>
    <p class="lead"> Vous allez être redirigé dans quelques secondes..</p>
    </div>';
        
    }
    else{
        echo '<div class="container" style="margin-top:50px;">
    <h1>Erreur lors de la connexion !</h1>
    <p class="lead"> Vous allez être redirigé dans quelques secondes..</p>
    </div>';
        echo '<meta http-equiv="refresh" content="0;URL=login.php">';
    }
    }
    pg_close($db);
    
            }}
else{
?>
<div class="container" style="margin-top:50px;">
    <div class="row">
    <div class="col-lg-offset-4 col-lg-4 col-lg-offset4">
    <h1>Connexion</h1>
    <hr>
<form class="form" role="form" action="login.php" method="post">
<p class="lead" style="font-size:13px;">Tests possibles:<br>
    - Dashboard Membre de Contact: <b>antoine.jeannot@etu.utc.fr</b><br>
    - Dashboard Admin: <b>admin</b></p>
 <div class="form-group">
 <label for="inputEmail1" class="col-lg-2 control-label">Login </label>
 <div class="col-lg-10">
   <input type="text" class="form-control" name="login" id="inputEmail1" placeholder="Laboratoire">
 </div>
 </div>
<div class="form-group">
 <div class="col-lg-offset-2 col-lg-2 col-lg-offset-8">
   <button type="submit" class="btn btn-default">Sign in</button>
 </div>
 </div>
</form>
        </div>

<?php 
    }
include('footer.php'); ?>