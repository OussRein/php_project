<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(isset($_SESSION['login_user']) && !empty($_SESSION['login_user'])){
  header("location: employe.php");
  exit;
}
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Connection</title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="sign-in.css" rel="stylesheet">
    </head>
    <body class="text-center" style="background-image: url('abcd.jpg');">
        <form class="form-signin bg-white text-capitalize font-weight-bold" method="post" action="Traitements.php">
            <img class="mb-4" src="1.png" alt="" width="200" height="200">
            <b><i><h1 class="h3 mb-3 font-weight-normal">Veuillez vous connecter</h1> </i></b>
            <label for="inputEmail" class="sr-only">Nom d'utilisateur</label>
            <input type="text" name="username" id="inputEmail" class="form-control" placeholder="Nom d'utilisateur" required="" autofocus="">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Mot De Passe" required="">
            <p><br></p>
            <input class="btn btn-lg btn-primary btn-block" name="submit" type="submit" value="Connexion">
            <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])){
                ?> 
                <div class="alert alert-danger"><?php echo ($_SESSION['error']); ?></div>
                <a href="Recuperation.php">J'ai oublier le mot de passe</a>

            <?php
            unset($_SESSION['error']); } ?>
        </form>
    </body>
</html>