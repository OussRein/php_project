<?php
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['login_user']) || empty($_SESSION['login_user'])){
  header("location: login.php");
  exit;
}

  include('database.php');
    try
    {
        $bd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $un, $pw);
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }

    if (isset($_POST['ModUN'])) {

        $getuser = $bd->prepare('SELECT `MotDePasse` FROM `users` WHERE `NomU` = ?');
        $getuser->execute([$_SESSION['login_user']]);
        $row = $getuser->fetch();

        if (password_verify($_POST['current_password'], $row['MotDePasse'])) {
            $sql = "UPDATE users SET NomU = ? WHERE NomU = ?";
            $stmt = $bd->prepare($sql);
            $stmt->execute([$_POST['user'],$_SESSION['login_user']]);
            $_SESSION['info'] = "votre Nom d'utilisateur a été changer!!";
            $_POST = array();
            header("location: logout.php");
        } else {
            $_SESSION['error'] = "Le mot De Passe est faux";
            $_POST = array();
        }
        

    }else if (isset($_POST['ModEM'])) {

        $getuser = $bd->prepare('SELECT `MotDePasse` FROM `users` WHERE `NomU` = ?');
        $getuser->execute([$_SESSION['login_user']]);
        $row = $getuser->fetch();

        if (password_verify($_POST['current_password'], $row['MotDePasse'])) {
            $sql = "UPDATE users SET email = ? WHERE NomU = ?";
            $stmt = $bd->prepare($sql);
            $stmt->execute([$_POST['email'],$_SESSION['login_user']]);
            $_SESSION['info'] = "votre Nom d'utilisateur a été changer!!";
            $_POST = array();
            header("location: logout.php");
        } else {
            $_SESSION['error'] = "Le mot De Passe est faux";
            $_POST = array();
        }


    }else if (isset($_POST['ModPW'])) {
        if ($_POST['password_confirmation'] !== $_POST['password']){
            $_POST = array();
            $_SESSION['error'] = "Vous avez entrer 2 mots de passe non identiques.";
        }else {

          $getuser = $bd->prepare('SELECT `MotDePasse` FROM `users` WHERE `NomU` = ?');
          $getuser->execute([$_SESSION['login_user']]);
          $row = $getuser->fetch();

          if (!password_verify($_POST['current_password'], $row['MotDePasse'])) {
              $sql = "UPDATE users SET MotDePasse = ? WHERE NomU = ?";
              $stmt = $bd->prepare($sql);
              $stmt->execute([password_hash($_POST['password_confirmation'], PASSWORD_DEFAULT),$_SESSION['login_user']]);
              $_SESSION['info'] = "votre Nom d'utilisateur a été changer!!";
              $_POST = array();
              header("location: logout.php");
          } else {
              $_SESSION['error'] = "Le mot De Passe est faux";
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
  <title>Historique</title>
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="dashboard.css" rel="stylesheet">
  <link rel="stylesheet" href="jquery-ui-1.12.1/jquery-ui.css">
  <link href="jQuery-contextMenu-master/dist/jquery.contextMenu.css" rel="stylesheet">

</head>
<body>

  <?php 
  include('navbar.php');
  ?>
  <nav class="col-md-2 d-none d-md-block bg-light sidebar" style="margin-top: 50px">
    <div class="sidebar-sticky">
      <ul class="nav flex-column">


        <li class="nav-item">
          <a class="nav-link"  href="dashboard.php"><span data-feather="home"></span>Menu<span class="sr-only"></span></a>
        </li>


        <li class="nav-item">
          <a class="nav-link"  href="employe.php"><span data-feather="home"></span> Liste des employés<span class="sr-only"></span></a>
        </li>

        <li class="nav-item">
          <a class="nav-link  active text-capitalize" href="Profile.php"> <span data-feather="shopping-cart"></span> Gerer mon Compte </a>
        </li>


        <?php 
        if ($_SESSION['Permission']==1) {
         ?>

         <li class="nav-item">
          <a class="nav-link" href="Users.php"> <span data-feather="users"></span> Gerer les Utilisateurs </a>
        </li>

        <?php 
      }
      ?>

      <li class="nav-item">
        <a class="nav-link" href="Historique.php"> <span data-feather="bar-chart-2"></span> Historique </a>
      </li>
    </ul>
  </div>
</nav>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
  <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])){
  ?> 
  <div class="alert alert-danger alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <?php echo ($_SESSION['error']); ?>
  </div>
  <?php
    unset($_SESSION['error']); } else if (isset($_SESSION['info']) && !empty($_SESSION['info'])){
  ?> 
  <div class="alert alert-info alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <?php echo ($_SESSION['info']); ?>
  </div>
  <?php
    unset($_SESSION['info']); } ?>
  <div id="Français"> 
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center  pb-2 mb-3 border-bottom pt-3 px-4">
      <h1 class="h2 text-capitalize"><b>Changer Vos Informations:</b></h1>
    </div>




    <?php  
    include('database.php');
    try
    {
        $bd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $un, $pw);
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }
    ?>
    <div class="container">

      <div class="card">
        <div class="header bg-blue">
          <h5>Changer Votre Nom d'utilisateur</h5>
        </div>
        <div class="body">
          <form method="post" action="Profile.php">
            <div class="form-group form-float">

              <label>Votre Mot de Passe : </label>
              <input type="password" name="current_password" class="form-control">
                                                  
            </div>
            <div class="form-group form-float">
              <div class="form-line">
                <label>Votre Nouveau Nom d'utilisateur : </label>
                <input type="email" name="email" class="form-control" value="">
              </div>
            </div>
            
            <input style="float: right;" type="submit" name="ModEM" class="btn btn-lg btn-info" value="Modifier" onclick="conf()">
          </form>
        </div>
      </div>
      
      <div class="card">
        <div class="header bg-blue">
          <h5>Changer Votre e-mail</h5>
        </div>
        <div class="body">
          <form method="post" action="Profile.php">
            <div class="form-group form-float">

              <label for="current_password" class="form-label">Votre Mot de Passe : </label>
              <input type="password" id="current_password" name="current_password" class="form-control">
                                                  
            </div>
            <div class="form-group form-float">
              <div class="form-line">
                <label for="email" class="form-label">Votre Nouveau E-mail : </label>
                <input type="email" id="email" name="email" class="form-control" value="">
              </div>
            </div>
            
            <input style="float: right;" type="submit" name="ModEM" class="btn btn-lg btn-info" value="Modifier" onclick="conf()">
          </form>
        </div>
      </div>


      <div class="card">
        <div class="header bg-blue">
          <h5>Changer Votre Mot de Passe</h5>
        </div>
        <div class="body">
          <form method="post" action="Profile.php">
            <div class="form-group form-float">
                <div class="form-line">
                    <label for="current_password" class="form-label">Votre Mot de Passe :</label>
                    <input type="password" id="current_password" name="current_password" class="form-control">
                    
                </div>
            </div>
          <div class="form-group form-float">
              <div class="form-line">
                  <label for="password" class="form-label">Nouveau mot de passe : </label>
                  <input type="password" id="password" name="password" class="form-control">
                  
              </div>
          </div>
          <div class="form-group form-float">
              <div class="form-line">
                  <label for="password_confirmation" class="form-label">confirmer le nouveau mot de passe : </label>
                  <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                  
              </div>
          </div>
          <input style="float: right;" type="submit" name="ModPW" class="btn btn-lg btn-info" value="Modifier" onclick="conf()">
        </form>
        </div>
      </div>
    </div>
  </div>  




</main>



        <!-- Bootstrap core JavaScript
          ================================================== -->
          <!-- Placed at the end of the document so the pages load faster -->
          <script src="assets/js/jquery.min.js"></script>
          <script src="assets/js/popper.js"></script>
          <script src="bootstrap/js/bootstrap.min.js"></script>
          <script src="bootstrap/js/bootstrap.js"></script>
          <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
          <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
          <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
          <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>
          <script src="js/Chart.min.js"></script>
          <script src="vendor/jquery/jquery.js"></script>
          <script src="jquery-ui-1.12.1/jquery-ui.js"></script>
          <script src="bootstrap-table-1.12.1/src/bootstrap-table.js"></script>
          <script src="bootstrap-table-contextmenu.js"></script>
          <script src="jQuery-contextMenu-master/dist/jquery.contextMenu.js"></script>
          <script src="jQuery-contextMenu-master/dist/jquery.ui.position.min.js"></script>
          <script src="printThis/printThis.js"></script>
          <script> feather.replace() </script>


          <script>

           function sortTable(n) {

            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("ttable");
            switching = true;
        // Set the sorting direction to ascending:
        dir = "asc"; 
        /* Make a loop that will continue until
        no switching has been done: */
        while (switching) {
          // Start by saying: no switching is done:
          switching = false;
          rows = table.getElementsByTagName("TR");
          /* Loop through all table rows (except the
          first, which contains table headers): */
          for (i = 1; i < (rows.length - 1); i++) {
            // Start by saying there should be no switching:
            shouldSwitch = false;
            /* Get the two elements you want to compare,
            one from current row and one from the next: */
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            /* Check if the two rows should switch place,
            based on the direction, asc or desc: */
            if (dir == "asc") {
              if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                // If so, mark as a switch and break the loop:
                shouldSwitch= true;
                break;
              }
            } else if (dir == "desc") {
              if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                // If so, mark as a switch and break the loop:
                shouldSwitch= true;
                break;
              }
            }
          }
          if (shouldSwitch) {
            /* If a switch has been marked, make the switch
            and mark that a switch has been done: */
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            // Each time a switch is done, increase this count by 1:
            switchcount ++; 
          } else {
            /* If no switching has been done AND the direction is "asc",
            set the direction to "desc" and run the while loop again. */
            if (switchcount == 0 && dir == "asc") {
              dir = "desc";
              switching = true;
            }
          }
        }
      } 

      function sortTableAr(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("ttableAr");
        switching = true;
  // Set the sorting direction to ascending:
  dir = "asc"; 
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.getElementsByTagName("TR");
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++; 
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
} 


</script>
</body>
</html>
