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
        <a class="nav-link" href="Historique.php"> <span data-feather="bar-chart-2"></span> Historique </a>
      </li>
    </ul>
  </div>
</nav>