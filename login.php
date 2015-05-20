<?php include('header.php'); ?>
<?php if(isset($_POST['login'])){ 
    $_SESSION['login'] = htmlspecialchars($_POST['login']);
    $_SESSION['role'] = 'financeur';
?>
<meta http-equiv="refresh" content="2;URL=index.php">
<div class="container" style="margin-top:50px;">
    <h1>Vous êtes connecté !</h1>
    <p class="lead"> Vous allez être redirigé dans quelques secondes..</p>

</div>
<?php
}
elseif(isset($_SESSION['login']) AND isset($_SESSION['role'])){
    echo '<meta http-equiv="refresh" content="0;URL=index.php">';
}
else{
?>
<div class="container" style="margin-top:50px; max-width:30%;">
    <h1>Connexion</h1>
    <hr>
<form class="form" role="form" action="login.php" method="post">
 <div class="form-group">
 <label for="inputEmail1" class="col-lg-2 control-label">Login </label>
 <div class="col-lg-10">
   <input type="email" class="form-control" name="login" id="inputEmail1" placeholder="Laboratoire">
 </div>
 </div>
<div class="form-group">
 <div class="col-lg-offset-2 col-lg-10">
   <button type="submit" class="btn btn-default">Sign in</button>
 </div>
 </div>
</form>
<?php 
    }
include('footer.php'); ?>