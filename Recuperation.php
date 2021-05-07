<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(isset($_SESSION['login_user']) && !empty($_SESSION['login_user'])){
  header("location: employe.php");
  exit;
}


if($_SERVER["REQUEST_METHOD"] == "POST"){
  include('database.php');
    try
    {
        $bd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $un, $pw);
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }

    if (isset($_POST['submit'])) {
      # code...
    

    $sql = "SELECT count(*) FROM users WHERE Email = ?";
    $stmt = $bd->prepare($sql);
    $stmt->execute([$_POST['mail']]);
    $result = $stmt->fetchColumn();

      if ($result == 1) {
        $username = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1).substr(md5(time()),1);
        $pass = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1).substr(md5(time()),1);

        $sql = "INSERT INTO users(NomU,MotDePasse,Permission,Email) VALUES (?,?,?,?)";
        $stmt2 = $bd->prepare($sql);
        $stmt2->execute([$username,password_hash($pass, PASSWORD_DEFAULT),2,$_POST['mail']]);

        $message = "Bonjours \r Votre Nom d'utilisateur : " . $username . " \r et Votre mot de passe : " . $pass;
        $headers = "From: Service_Perso@usthb.dz"; 
        $_SESSION['info'] = "l'utilisateur a été Ajouter Avec succès!";
        $_POST = array();
        
      }else {
        $_SESSION['error'] = "Ce Email n'éxiste pas!!!";
        $_POST = array();
      }
      
  }
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
        <title>Recuperation</title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="sign-in.css" rel="stylesheet">
    </head>
    <body class="text-center" style="background-image: url('abcd.jpg');">
        <form class="form-signin bg-white text-capitalize font-weight-bold" method="post" action="Recuperation.php">
            <img class="mb-4" src="1.png" alt="" width="200" height="200">
            <b><i><h1 class="h3 mb-3 font-weight-normal">Recuperer votre Compte</h1> </i></b>
            <label for="inputEmail" class="sr-only">E-mail</label>
            <input type="email" name="mail" id="inputEmail" class="form-control" placeholder="E-mail" required="" autofocus="">
            <p><br></p>
            <input class="btn btn-lg btn-primary btn-block" name="submit" type="submit" value="Recuperer">
            
                <div class="alert alert-danger">Attention votre nom d'utilisateur et mot de passe seront initialiser!!!</div>
        </form>
    </body>
</html>