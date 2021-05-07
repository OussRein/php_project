<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['login_user']) || empty($_SESSION['login_user'])){
  header("location: login.php");
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
        <a class="nav-link" href="Profile.php"> <span data-feather="shopping-cart"></span> Gerer mon Compte </a>
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
        <a class="nav-link active text-capitalize" href="Historique.php"> <span data-feather="bar-chart-2"></span> Historique </a>
      </li>
    </ul>
  </div>
</nav>
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
      <div id="Français"> 
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center  pb-2 mb-3 border-bottom pt-3 px-4">
              <h1 class="h2 text-capitalize"><b>Historique</b></h1>
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
          <div  class="table-responsive" style="width: 100%;">
            
              <table id="ttable" class="table table-striped table-sm table-bordered table-ba table-hover" style=" margin-right: 2%">
                  <thead>
                      <tr>
                          <th style="display: none;">id</th>
                          <th onclick="sortTable(1)">Traitement</th>
                          <th onclick="sortTable(2)">Fait Par</th>
                          <th onclick="sortTable(3)">Pour</th>
                          <th onclick="sortTable(4)">Le</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php 

                          $reponse = $bd->query("SELECT * FROM Historique ORDER BY CodeH desc LIMIT 100;" );
                  
                          while ($donnees = $reponse->fetch())
                          {
                      ?>

                       
                      <tr>
                          <td style="display: none;"><?php echo $donnees['CodeH']; ?></td>
                          <td><?php echo $donnees['Traitement']; ?></td>
                          <td>
                            <?php 
                            $sql = "SELECT NomU FROM users WHERE CodeU = ? ";
                            $stmt = $bd->prepare($sql);
                            $stmt->execute([$donnees['CodeU']]);
                            $nomu = $stmt->fetchColumn();
                            echo ($nomu);
                             ?>
                               
                          </td>
                          <td>
                            <?php 
                            $sql = "SELECT NomFr,PrenomFr FROM employe WHERE idEmploye = ? ";
                            $stmt = $bd->prepare($sql);
                            $stmt->execute([$donnees['CodeE']]);
                            $emp = $stmt->fetch();
                            echo ($emp['NomFr'] . " " . $emp['PrenomFr']);
                             ?>
                               
                          </td>
                          <td>
                            <?php 
                            
                            echo (date_format(date_create_from_format('Y-m-d H:i:s', $donnees['dateH']),"d/m/Y H:i:s"));
                             ?>
                               
                          </td>
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
