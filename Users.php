<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['login_user']) || empty($_SESSION['login_user'])){
  header("location: login.php");
  exit;
}
if (!isset($_SESSION['Permission']) || empty($_SESSION['Permission']) || ($_SESSION['Permission']) != 1) {
  header("location: employe.php");
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
    if (isset($_POST['user'])) {

    $sql = "SELECT count(*) FROM users WHERE Email = ?";
    $stmt = $bd->prepare($sql);
    $stmt->execute([$_POST['email']]);
    $result = $stmt->fetchColumn();

      if ($result == 0) {
        $username = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1).substr(md5(time()),1);
        $pass = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1).substr(md5(time()),1);

        $sql = "INSERT INTO users(NomU,MotDePasse,Permission,Email) VALUES (?,?,?,?)";
        $stmt2 = $bd->prepare($sql);
        $stmt2->execute([$username,password_hash($pass, PASSWORD_DEFAULT),2,$_POST['email']]);

        $message = "Bonjours \r Votre Nom d'utilisateur : " . $username . " \r et Votre mot de passe : " . $pass;
        $headers = "From: Service_Perso@usthb.dz"; 
        $_SESSION['info'] = "l'utilisateur a été Ajouter Avec succès!";
        $_POST = array();
        
      }else {
        $_SESSION['error'] = "Ce Email Existe Déja!!!!";
        $_POST = array();
      }
      
  }elseif (isset($_POST['admin'])) {

    $sql = "SELECT CodeU,Permission FROM users WHERE CodeU = ?";
    $stmt = $bd->prepare($sql);
    $stmt->execute([$_POST['id']]);
    $id = $stmt->fetch();

      if (($id['CodeU'] != null) && ($id['Permission'] == 2)) {
        $sql = "SELECT CodeU,Permission FROM users WHERE NomU = ?";
        $stmt = $bd->prepare($sql);
        $stmt->execute([$_SESSION['login_user']]);
        $id2 = $stmt->fetch();

        if (($id2['CodeU'] != null) && ($id2['Permission'] == 1)) {

        $sql = "UPDATE users SET Permission = 1 WHERE CodeU = ?";
        $stmt2 = $bd->prepare($sql);
        $stmt2->execute([$id['CodeU']]);
        $sql = "UPDATE users SET Permission = 2 WHERE CodeU = ?";
        $stmt2 = $bd->prepare($sql);
        $stmt2->execute([$id2['CodeU']]);
        $_SESSION['info'] = "l'Administration a été passer Avec succès!";
        $_POST = array();        
        }else {
          $_SESSION['error'] = "vous n'etes pas l'administrateur!!!!";
        $_POST = array();
        }
      }else {
        $_SESSION['error'] = "vous ne pouvez pas passer l'administration a un utilisateur bloqué!!!!";
        $_POST = array();
      }
      
  }elseif (isset($_POST['block'])) {
    $sql = "SELECT CodeU,Permission FROM users WHERE CodeU = ?";
    $stmt = $bd->prepare($sql);
    $stmt->execute([$_POST['id']]);
    $id = $stmt->fetch();
      if (($id['CodeU'] != null) && ($id['Permission'] == 2)) {

        $sql = "SELECT CodeU,Permission FROM users WHERE NomU = ?";
        $stmt = $bd->prepare($sql);
        $stmt->execute([$_SESSION['login_user']]);
        $id2 = $stmt->fetch();

        if (isset($id2['CodeU']) && ($id2['Permission'] == 1)) {
        $sql = "UPDATE users SET Permission = 3 WHERE CodeU = ?";
        $stmt2 = $bd->prepare($sql);
        $stmt2->execute([$id['CodeU']]);
        $_SESSION['info'] = "l'utilisateur a été bloqué Avec succès!";
        $_POST = array();        
        }else {
          $_SESSION['error'] = "vous n'etes pas l'administrateur!!!!";
        $_POST = array();
        }
      }else {
        $_SESSION['error'] = "vous ne pouvez pas bloqué l'administrateur!!!!";
        $_POST = array();
      }
      
  }
  $_POST = array();

?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Utilisateurs</title>
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
        <a class="nav-link" href="Profile.php"> <span data-feather="shopping-cart"></span> Gerer mon Compte </a>
      </li>

      
      <?php 
        if ($_SESSION['Permission']==1) {
       ?>

      <li class="nav-item">
        <a class="nav-link active text-capitalize" href="Users.php"> <span data-feather="users"></span> Gerer les Utilisateurs </a>
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
      <div id="Français"> 
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center  pb-2 mb-3 border-bottom pt-3 px-4">
              <h1 class="h2 text-capitalize"><b>liste des utilisateurs</b></h1>
              <div class="btn-toolbar mb-2 mb-md-0">
                                        
                  <a class="btn btn-sm btn-outline-secondary" role="button" data-toggle="modal" data-target="#ii">
                    <span data-feather="plus-circle"></span>
                    Ajouter un utilisateur
                  </a>

              </div>
          </div>




         <?php  
  include('database.php');
    try
    {
        $bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $un, $pw);
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }
         ?>
          <div  class="table-responsive" style="width: 100%;">
            <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])){
                ?> 
                <div class="alert alert-danger"><?php echo ($_SESSION['error']); ?> <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span></div>

            <?php
            unset($_SESSION['error']); } else if (isset($_SESSION['info']) && !empty($_SESSION['info'])){
                ?> 
                <div class="alert success"><?php echo ($_SESSION['info']); ?><span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span></div>

            <?php
            unset($_SESSION['info']); } ?>
              <table id="ttable" class="table table-striped table-sm table-bordered table-ba table-hover" style=" margin-right: 2%">
                  <thead>
                      <tr>
                          <th style="display: none;">id</th>
                          <th onclick="sortTable(1)">Nom d'utilisateur</th>
                          <th onclick="sortTable(2)">Email</th>
                          <th onclick="sortTable(3)">Etat</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php 

                          $reponse = $bdd->query("SELECT CodeU,NomU,email,Permission FROM users WHERE Permission != 3 ORDER BY Permission");
                  
                          while ($donnees = $reponse->fetch())
                          {
                      ?>

                       
                      <tr>
                          <td style="display: none;"><?php echo $donnees['CodeU']; ?></td>
                          <td><?php echo $donnees['NomU']; ?></td>
                          <td><?php echo $donnees['email']; ?></td>
                          <td><?php if ($donnees['Permission'] == 1) {
                            echo "ADMIN"; 
                          }elseif ($donnees['Permission'] == 2) {
                            echo "USER";
                          }else echo "Ancient"; ?></td>
                      </tr>

                        <?php 
                            }
                            $reponse->closeCursor();
                         ?>
                  </tbody>
              </table>
          </div>
      </div>  




</main>

        

<div class="modal fade" id="ii" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" >
        <div class="modal-dialog modal-sm " style="border-radius: 20px !important; vertical-align: middle; ">
            <div class="modal-content " style=" border-style: solid; border-width: 5px; border-radius: 20px !important; vertical-align: middle; ">
         <div class="col-lg-12 well ins" style="border-radius: 20px !important; vertical-align: middle; ">

                    <form  method="post" action="Users.php">
                      <div class="col-sm-12">

                        <div class="row">
                          <div class="col-sm-12 form-group">
                            <label>Email du nouveau utilisateur:</label>
                            <input type="email" placeholder="" class="form-control" name="email">
                          </div>
                          
                        </div>
                        
                      <input type="submit" style="text-align: center;" class="btn btn-lg btn-info input-group col-sm-12" name="user" value="Ajouter">         
                      
                      </div>
                    </form> 
              </div>
            </div>
        </div>
    </div>

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
            $(document).ready(function(){
              
                $("#Ar").click(function(){
                    $("#Français").hide();
                    $("#Arabe").show();
                });
                $("#Fr").click(function(){
                    $("#Arabe").hide();
                    $("#Français").show();
                });
            });



          $(function() {
            $.contextMenu({
              selector: 'tbody tr', 
              callback: function(key, options) {
              console.log(options.$trigger);
                if (key=="admin") {
         
                  if (confirm("Voulez-vous passer l'administration?")) {
                                
                    var form = document.createElement("form");
                    form.setAttribute("method", "post");
                    form.setAttribute("action", "Users.php");

                    var hiddenField = document.createElement("input");
                    hiddenField.setAttribute("type", "hidden");
                    hiddenField.setAttribute("name", "id");
                    hiddenField.setAttribute("value", $(this).find("td:first").text());

                    form.appendChild(hiddenField);

                    var hiddenField2 = document.createElement("input");
                    hiddenField2.setAttribute("type", "hidden");
                    hiddenField2.setAttribute("name", "admin");
                    hiddenField2.setAttribute("value", "admin");

                    form.appendChild(hiddenField2);
        
                    document.body.appendChild(form);
                    form.submit();
                  }
                }else if (key=="block") {
                 
                  if (confirm("Voulez-vous bloqué ce utilisateur?")) {
                        
                    var form = document.createElement("form");
                    form.setAttribute("method", "post");
                    form.setAttribute("action", "Users.php");

                    var hiddenField = document.createElement("input");
                    hiddenField.setAttribute("type", "hidden");
                    hiddenField.setAttribute("name", "id");
                    hiddenField.setAttribute("value", $(this).find("td:first").text());

                    form.appendChild(hiddenField);

                    var hiddenField2 = document.createElement("input");
                    hiddenField2.setAttribute("type", "hidden");
                    hiddenField2.setAttribute("name", "block");
                    hiddenField2.setAttribute("value", "block");

                    form.appendChild(hiddenField2);

                    document.body.appendChild(form);
                    form.submit();
                  }
                }
                },
                items: {

                    "admin" :{name: "Passe l'administration"},                    
                   
                    "sep1": "---------",
                    "block" :{name: "arreter l'utilisateur"}

              }
            });
 
          });


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
