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
        <title>Employés</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="dashboard.css" rel="stylesheet">
        <link rel="stylesheet" href="jquery-ui-1.12.1/jquery-ui.css">
        <link href="jQuery-contextMenu-master/dist/jquery.contextMenu.css" rel="stylesheet">

    </head>
    <body>
        
      <?php 
          include('navbar.php');
      ?>
  <nav class="col-md-2 d-none d-md-block bg-light sidebar" style="margin-top: 40px">
  <div class="sidebar-sticky">
    <ul class="nav flex-column">
      

      <li class="nav-item">
        <a class="nav-link"  href="dashboard.php"><span data-feather="home"></span>Menu<span class="sr-only"></span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link active text-capitalize"  href="employe.php"><span data-feather="home"></span> Liste des employés<span class="sr-only"></span></a>
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
        
        
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])){
                ?> 
                
                <div class="alert alert-danger"><?php echo ($_SESSION['error']); ?> <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span></div>

            <?php
            unset($_SESSION['error']); } else if (isset($_SESSION['info']) && !empty($_SESSION['info'])){
                ?> 
                <div class="alert success"><?php echo ($_SESSION['info']); ?><span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span></div>
              
            <?php
            unset($_SESSION['info']); } ?>
      <div id="Français"> 
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center  pb-2 mb-3 border-bottom pt-3 px-4">
              <h1 class="h2 text-capitalize"><b>liste des employés</b></h1>
              <div class="btn-toolbar mb-2 mb-md-0">
                  <div class="btn-group mr-2">
                    <div class="btn-group">
                      <button class="btn btn-sm btn-outline-info Ar" role="button" onclick="toggler('Arabe');">عربي</button>
                      
                        <button class="btn btn-sm btn-outline-info TE" role="button" onclick="toggler('Echellon');" >Table des Echelons</button>
                      </div>
                  </div>
                      
                  <button class="btn btn-sm btn-info" role="button" data-toggle="modal" data-target="#insert-modal">
                    <span data-feather="plus-circle"></span>
                    Ajouter un nouvel employé
                  </button>

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
         <input class="form-control col-sm-3" type="text" id="myInput" onkeyup="myFunction()" placeholder="Chercher un nom d'employé..." style="margin-bottom: 10px; float: right;">
          <div  class="table-responsive" style="width: 100%;">
            
              <table id="ttable" class="table table-striped table-sm table-bordered table-ba table-hover" style=" margin-right: 2%">
                  <thead>
                      <tr>
                          <th style="display: none;">id</th>
                          <th onclick="sortTable(1)">Nom</th>
                          <th onclick="sortTable(2)">Prenom</th>
                          <th onclick="sortTable(3)">Date de Naissance</th>
                          <th onclick="sortTable(4)">LieuN</th>
                          <th onclick="sortTable(5)">Fonction</th>
                          <th onclick="sortTable(6)">Grade</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php 

                          $reponse = $bdd->query("SELECT idEmploye,NomFr,PrenomFr,DATE_FORMAT(DateN, '%d/%m/%Y') AS DateNFr,LieuNFR,FonctionFr,GradeFr,SitFam,sexe FROM Employe WHERE SitAdm = 1 or SitAdm = 2 or SitAdm = 3 or SitAdm = 4");
                  
                          while ($donnees = $reponse->fetch())
                          {
                      ?>

                       
                      <tr>
                          <td style="display: none;"><?php echo $donnees['idEmploye']; ?></td>
                          <td><?php
                          if (($donnees['SitFam']==2)&&($donnees['sexe']==2)) {
                            $reponse2 = $bdd->prepare("SELECT NomM FROM fmarie WHERE idEmploye = ?");
                            $reponse2->execute([$donnees['idEmploye']]);
                            $stmt = $reponse2->fetchColumn();
                            $nom = $donnees['NomFr'] . "<strong> ep </strong>". $stmt;
                          }else {
                            $nom = $donnees['NomFr'];
                          }

                           echo $nom; ?></td>
                          <td><?php echo $donnees['PrenomFr']; ?></td>
                          <td><?php echo $donnees['DateNFr']; ?></td>
                          <td><?php echo $donnees['LieuNFR']; ?></td>
                          <td><?php echo $donnees['FonctionFr']; ?></td>
                          <td><?php echo $donnees['GradeFr']; ?></td>

                      </tr>

                        <?php 
                            }
                            $reponse->closeCursor();
                        ?>
                  </tbody>
              </table>
          </div>
      </div>  




                        <!-- ******************************************-->
        <div id="Arabe" style="display: none;">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center  pb-2 mb-3 border-bottom pt-3 px-4" style="direction: rtl;">
                <h1 class="h2 text-capitalize"><b>قائمة الموظفين</b></h1>
                    
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <div class="btn-group">
                        <button class="btn btn-sm btn-outline-info Fr" role="button" onclick="toggler('Français');" >Français</button> 
                        
                          <button style="margin-left: 20px" class="btn btn-sm btn-outline-info TE" role="button" onclick="toggler('Echellon');" >Table des Echelons</button>
                        </div>
                    </div>

                    <button class="btn btn-sm btn-info" role="button" data-toggle="modal" data-target="#insert-modal">
                        <span data-feather="plus-circle"></span>
                        أضف موظفا جديدا
                     </button>
                </div>
            </div>
            <input class="form-control col-sm-3 arab" type="text" id="myInput1" onkeyup="myFunction1()" placeholder="ابحث عن لقب موظف..." style="margin-bottom: 10px; float: left;">
            <div  class="table-responsive ">
              <table id="ttableAr" class="table table-striped table-sm table-bordered table-ar table-ba table-hover"  >
                  <thead>
                      <tr>
                          <th style="display: none;">id</th>
                          <th onclick="sortTableAr(1)">اللقب</th>
                          <th onclick="sortTableAr(2)">الاسم</th>
                          <th onclick="sortTableAr(3)">تاريخ الميلاد</th>
                          <th onclick="sortTableAr(4)">المكان</th>
                          <th onclick="sortTableAr(5)">الوظيفة</th>
                          <th onclick="sortTableAr(6)">الرتبة</th>

                      </tr>
                  </thead>

                  <tbody>
                  <?php 

                    $reponse = $bdd->query("SELECT idEmploye,NomAr,PrenomAr,DATE_FORMAT(DateN, '%Y/%m/%d') AS DateNAr,LieuNAR,FonctionAr,GradeAr,SitFam,sexe FROM Employe WHERE SitAdm = 1 or SitAdm = 2 or SitAdm = 3 or SitAdm = 4");
              
                    while ($donnees = $reponse->fetch())
                      {
                  ?>

                       
                  <tr>
                      <td style="display: none;"><?php echo $donnees['idEmploye']; ?></td>
                      <td><?php
                      if (($donnees['SitFam']==2)&&($donnees['sexe']==2)) {
                        $reponse2 = $bdd->prepare("SELECT NomMA FROM fmarie WHERE idEmploye = ?");
                        $reponse2->execute([$donnees['idEmploye']]);
                        $stmt = $reponse2->fetchColumn();
                        $nom = $donnees['NomAr'] . "<strong> زوجة </strong>". $stmt;
                      }else {
                        $nom = $donnees['NomAr'];
                      }

                       echo $nom; ?></td>
                      <td><?php echo $donnees['PrenomAr']; ?></td>
                      <td><?php echo $donnees['DateNAr']; ?></td>
                      <td><?php echo $donnees['LieuNAR']; ?></td>
                      <td><?php echo $donnees['FonctionAr']; ?></td>
                      <td><?php echo $donnees['GradeAr']; ?></td>

                  </tr>

                    <?php 
                      }
                      $reponse->closeCursor();
                     ?>
                  </tbody>
                </table>
              </div>
            </div> 


              <!-- ******************************************-->


        <div id="Echellon" style="display: none;">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center  pb-2 mb-3 border-bottom pt-3 px-4" style="direction: rtl;">
                <h1 class="h2 text-capitalize"><b>قائمة الموظفين حسب الدرجات</b></h1>
                    
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <div class="btn-group">
                          <button class="btn btn-sm btn-outline-info Ar" role="button" onclick="toggler('Arabe');">عربي</button>
                          <button style="margin-left: 18px;" class="btn btn-sm btn-outline-info Fr" role="button" onclick="toggler('Français');" >Français</button> 
                        </div>
                    </div>

                    <button class="btn btn-sm btn-info" role="button" data-toggle="modal" data-target="#insert-modal">
                        <span data-feather="plus-circle"></span>
                        أضف موظفا جديدا
                     </button>

                </div>
            </div>
            <input class="form-control col-sm-3 arab" type="text" id="myInput2" onkeyup="myFunction2()" placeholder="ابحث عن لقب موظف..." style="margin-bottom: 10px; float: left;">
            <div  class="table-responsive ">
              <table id="tableE" class="table table-striped table-sm table-bordered table-ar table-ba table-hover"  >
                  <thead>
                      <tr>
                          <th style="display: none;">id</th>
                          <th onclick="sortTableE(1)">اللقب</th>
                          <th onclick="sortTableE(2)">الاسم</th>
                          <th onclick="sortTableE(3)">تاريخ الميلاد</th>
                          <th onclick="sortTableE(4)">المكان</th>
                          <th onclick="sortTableE(5)">الوضعية العائلية</th>
                          <th onclick="sortTableE(6)">الشهادة</th>
                          <th onclick="sortTableE(7)">الوظيفة</th>
                          <th onclick="sortTableE(8)">الرتبة</th>
                          <th onclick="sortTableE(9)">الدرجة</th>
                          <th onclick="sortTableE(10)">تاريخ آخر ترقية</th>

                      </tr>
                  </thead>

                  <tbody>
                  <?php 

                    $reponse = $bdd->query("SELECT idEmploye,NomAr,PrenomAr,DATE_FORMAT(DateN, '%Y/%m/%d') AS DateNAr,LieuNAR,sexe,FonctionAr,SitFam,GradeAr,Echellon,diplome, DateDE FROM Employe WHERE SitAdm = 1 or SitAdm = 2 or SitAdm = 3 or SitAdm = 4 ORDER BY DateDE");
              
                    while ($donnees = $reponse->fetch())
                      {

                        $nbr = date_diff(date_create_from_format('Y-m-d',$donnees["DateDE"]),date_create_from_format('Y-m-d',date("Y-m-d")));
                        $i=$nbr->format("%a");
                        $i=$i+1;
                  ?>

                       
                  <tr <?php if ($i > 912) echo ("style= \"background-color : #a3eaf7 !important;\""); ?>>
                      <td style="display: none;"><?php echo $donnees['idEmploye']; ?></td>
                      <td><?php
                      if (($donnees['SitFam']==2)&&($donnees['sexe']==2)) {
                        $reponse2 = $bdd->prepare("SELECT NomMA FROM fmarie WHERE idEmploye = ?");
                        $reponse2->execute([$donnees['idEmploye']]);
                        $stmt = $reponse2->fetchColumn();
                        $nom = $donnees['NomAr'] . "<strong> زوجة </strong>". $stmt;
                      }else {
                        $nom = $donnees['NomAr'];
                      }

                       echo $nom; ?></td>
                      <td><?php echo $donnees['PrenomAr']; ?></td>
                      <td><?php echo $donnees['DateNAr']; ?></td>
                      <td><?php echo $donnees['LieuNAR']; ?></td>
                      <td><?php if ($donnees['SitFam'] == 1 && $donnees['sexe'] == 1) echo "أعزب"; 
                      elseif ($donnees['SitFam'] == 2 && $donnees['sexe'] == 1) echo "متزوج"; 
                      elseif ($donnees['SitFam'] == 1 && $donnees['sexe'] == 2) echo "عزباء"; 
                      elseif ($donnees['SitFam'] == 2 && $donnees['sexe'] == 2) echo "متزوجة"; 
                       ?></td>
                      <td><?php echo $donnees['diplome']; ?></td>
                      <td><?php echo $donnees['FonctionAr']; ?></td>
                      <td><?php echo $donnees['GradeAr']; ?></td>
                      <td><?php echo $donnees['Echellon']; ?></td>
                      <td><?php echo date_format(date_create_from_format('Y-m-d', $donnees['DateDE']),"Y/m/d"); ?></td>

                  </tr>

                    <?php 
                      }
                      $reponse->closeCursor();
                     ?>
                  </tbody>
                </table>
              </div>
            </div> 





                        <!-- ******************************************-->



</main>

<?php 
  include('new.php');
?>
<div class="modal fade" id="tg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; vertical-align: middle; " >
  <div class="modal-dialog modal-sm " style="border-radius: 20px !important;">
    <div class="modal-content " style="border-style: solid; border-width: 5px; border-radius: 20px !important;">
      <div class="col-lg-12 well ins" style="border-radius: 20px !important;">
          <form id="tgf" method="post" action="Documents.php">
            <div class="col-sm-12">

              <div class="row">
                <div class="col-sm-12 form-group">
                  <label>Date du Debut:</label>
                  <input type="date" placeholder="" class="form-control" name="db">
                </div>
              </div>
              
              <div class="row">
                <div class="col-sm-12 form-group">
                  <label>Date du Fin</label>
                  <input type="date" placeholder="" class="form-control" name="df">
                </div>
              </div>

              <input type="submit" style="text-align: center;" class="btn btn-lg btn-info input-group col-sm-12" name="TG" value="Continuer">         
            
            </div>
          </form> 
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ps" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; vertical-align: middle !important; " >
  <div class="modal-dialog modal-sm " style="border-radius: 20px !important;">
    <div class="modal-content " style="border-style: solid; border-width: 5px; border-radius: 20px !important;">
      <div class="col-lg-12 well ins" style="border-radius: 20px !important;">
          <form id="psf" method="post" action="Documents.php">
            <div class="col-sm-12">

              <div class="row">
                <div class="col-sm-12 form-group">
                  <label>Année universitaire: </label>
                  <input type="text" placeholder="" class="form-control" name="au" required="">
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12 form-group">
                  <label>Date de debut:</label>
                  <input type="date" placeholder="" class="form-control" name="db">
                </div>
              </div>
              
              <input type="submit" style="text-align: center;" class="btn btn-lg btn-info input-group col-sm-12" name="PS" value="Continuer">         
            
            </div>
          </form> 
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="af" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; vertical-align: middle ; " >
  <div class="modal-dialog modal-sm " style="border-radius: 20px !important;">
    <div class="modal-content " style="border-style: solid; border-width: 5px; border-radius: 20px !important;">
      <div class="col-lg-12 well ins" style="border-radius: 20px !important;">
          <form id="aff" method="post" action="Documents.php">
            <div class="col-sm-12">

              <div class="row">
                <div class="col-sm-12 form-group">
                  <label>Année universitaire: </label>
                  <input type="text" placeholder="" class="form-control" name="au" required="">
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12 form-group">
                  <label>Date de debut:</label>
                  <input type="date" placeholder="" class="form-control" name="db">
                </div>
              </div>
              <br>
              <input type="submit" style="text-align: center;" class="btn btn-lg btn-info input-group col-sm-12" name="PS" value="Continuer">         
            
            </div>
          </form> 
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="md" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; vertical-align: middle; " >
  <div class="modal-dialog modal-sm " style="border-radius: 20px !important;">
    <div class="modal-content " style="border-style: solid; border-width: 5px; border-radius: 20px !important;">
      <div class="col-lg-12 well ins" style="border-radius: 20px !important;">
          <form id="mdf" method="post" action="Documents.php">
            <div class="col-sm-12">

              <div class="input-group mb-3 col-sm-12">
                <select class="custom-select form-control arab " name="ud" id="StF" required="">
                  <option value="01">1</option>
                  <option value="02">2</option>
                </select>
              </div>

              <div class="row">
                <div class="col-sm-12 form-group">
                  <label>Numero de reference:</label>
                  <input type="text" placeholder="" class="form-control" name="num">
                </div>
              </div>
              <br>
              <input type="submit" style="text-align: center;" class="btn btn-lg btn-info input-group col-sm-12" name="md" value="Continuer">         
            
            </div>
          </form> 
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="dmt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; vertical-align: middle ; " >
  <div class="modal-dialog modal-sm " style="border-radius: 20px !important; vertical-align: middle; ">
    <div class="modal-content " style=" border-style: solid; border-width: 5px; border-radius: 20px !important; vertical-align: middle; ">
      <div class="col-lg-12 well ins" style="border-radius: 20px !important; vertical-align: middle; ">

          <form id="dmtf" method="post" action="Documents.php">
            <div class="col-sm-12">

              <div class="row">
                <div class="col-sm-12 form-group">
                  <label>Date du certificat midical:</label>
                  <input type="date" placeholder="" class="form-control" name="dsm">
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12 form-group">
                  <label>Date du Debut:</label>
                  <input type="date" placeholder="" class="form-control" name="db">
                </div>
              </div>
              
              <div class="row">
                <div class="col-sm-12 form-group">
                  <label>Date du Fin</label>
                  <input type="date" placeholder="" class="form-control" name="df">
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12 form-group">
                  <label>Durée</label>
                  <input type="text" placeholder="En chiffres et lettres" class="form-control" name="dur">
                </div>
              </div>
              <hr>
              <input type="submit" style="text-align: center;" class="btn btn-lg btn-info input-group col-sm-12" name="dmt" value="Continuer">         
            
            </div>
          </form> 
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="dml" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; vertical-align: middle ; " >
  <div class="modal-dialog modal-sm " style="border-radius: 20px !important; vertical-align: middle; ">
    <div class="modal-content modal-dialog-centered" style=" border-style: solid; border-width: 5px; border-radius: 20px !important; vertical-align: middle; ">
      <div class="col-sm-12 well ins" style="border-radius: 20px !important; vertical-align: middle; ">

          <form id="dmlf" method="post" action="Documents.php">
            <div class="col-sm-12">

              <div class="row">
                <div class="col-sm-12 form-group">
                  <label>Date du certificat midical:</label>
                  <input type="date" placeholder="" class="form-control" name="dsm">
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12 form-group">
                  <label>Date du Debut:</label>
                  <input type="date" placeholder="" class="form-control" name="db">
                </div>
              </div>
              
              <div class="row">
                <div class="col-sm-12 form-group">
                  <label>Date du Fin</label>
                  <input type="date" placeholder="" class="form-control" name="df">
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12 form-group">
                  <label>Durée</label>
                  <input type="text" placeholder="En chiffres et lettres" class="form-control" name="dur">
                </div>
              </div>
              <hr>

              <input type="submit" style="text-align: center;" class="btn btn-lg btn-info input-group col-sm-12" name="dml" value="Continuer">         
            
            </div>
          </form> 

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="dr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; vertical-align: middle; " >
  <div class="modal-dialog modal-sm " style="border-radius: 20px !important;">
    <div class="modal-content " style="border-style: solid; border-width: 5px; border-radius: 20px !important;">
      <div class="col-lg-12 well ins" style="border-radius: 20px !important;">

          <form id="drf" method="post" action="Documents.php">
            <div class="col-sm-12">
              
              <div class="row">
                <div class="col-sm-12 form-group">
                  <label>Date du Debut:</label>
                  <input type="date" placeholder="" class="form-control" name="db">
                </div>
              </div>
              
              <div class="row">
                <div class="col-sm-12 form-group">
                  <label>Date du Fin</label>
                  <input type="date" placeholder="" class="form-control" name="df">
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12 form-group">
                  <label>Motifs</label>
                  <input type="text" placeholder="En Français" class="form-control" name="motif" required="">
                </div>
              </div>

              <input type="submit" style="text-align: center;" class="btn btn-lg btn-info input-group col-sm-12" name="dr" value="Continuer">         
            
            </div>
          </form> 

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="pvi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; vertical-align: middle; " >
  <div class="modal-dialog modal-sm " style="border-radius: 20px !important;">
    <div class="modal-content " style="border-style: solid; border-width: 5px; border-radius: 20px !important;">
      <div class="col-lg-12 well ins" style="border-radius: 20px !important;">
        
          <form id="pvif" method="post" action="Documents.php">
            <div class="col-sm-12">
              
              <div class="input-group col-sm-12">
                <select class="custom-select form-control arab " name="ud" id="StF" required="">
                  <option value="1">عطلة</option>
                  <option value="2">عطلة مرضية</option>
                  <option value="3">عطلة أمومة</option>
                  <option value="4">انتداب</option>
                  <option value="5">إحالة على الاستيداع</option>
                  <option value="6">الخدمة الوطنية</option>
                </select>
              </div>
              <br>
              <input type="submit" style="text-align: center;" class="btn btn-lg btn-info input-group col-sm-12" name="pvr" value="Continuer">         
            
            </div>
          </form> 
        
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="pvr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; vertical-align: middle; " >
  <div class="modal-dialog modal-sm " style="border-radius: 20px !important;">
    <div class="modal-content " style="border-style: solid; border-width: 5px; border-radius: 20px !important;">
      <div class="col-lg-12 well ins" style="border-radius: 20px !important;">
          <form id="pvrf" method="post" action="Documents.php">
            <div class="col-sm-12">
              
              <div class="input-group col-sm-12">
                <select class="custom-select form-control arab " name="ud" id="StF" required="">
                  <option value="1">عطلة</option>
                  <option value="2">عطلة مرضية</option>
                  <option value="3">عطلة أمومة</option>
                  <option value="4">انتداب</option>
                  <option value="5">إحالة على الاستيداع</option>
                  <option value="6">الخدمة الوطنية</option>
                </select>
              </div>
              <br>
              <input type="submit" style="text-align: center;" class="btn btn-lg btn-info input-group col-sm-12" name="pvre" value="Continuer">         
            
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
              
                $(".Ar").click(function(){
                    $("#Français").hide();
                    $("#Arabe").show();
                    $("#Echellon").hide();
                });
                $(".Fr").click(function(){
                    $("#Arabe").hide();
                    $("#Français").show();
                    $("#Echellon").hide();
                });
                $(".TE").click(function(){
                    $("#Français").hide();
                    $("#Arabe").hide();
                    $("#Echellon").show();
                });
            });

            $('#StF').on('change', function() {
              if ($(this).val()==1){
                $("#MM").hide();
                $("#FMMF").hide();
                $("#FMMA").hide();
              }else if(id = $(this).val()==2){
                if ($('#Sexe').val()==2){
                  $("#MM").show();
                  $("#FMMF").show();
                  $("#FMMA").show();
                }else {
                  $("#MM").show();
                  $("#FMMF").hide();
                $("#FMMA").hide();
                }
              }
            });

            $('#Sexe').on('change', function() {
              if ($(this).val()==1){
                if ($('#StF').val()==2){
                $("#MM").show();
                $("#FMMF").hide();
                $("#FMMA").hide();
              }else {
                $("#MM").hide();
                $("#FMMF").hide();
                $("#FMMA").hide();
              }
              }else if(id = $(this).val()==2){
                if ($('#StF').val()==2){
                  $("#MM").show();
                  $("#FMMF").show();
                  $("#FMMA").show();
                }else {
                  $("#MM").hide();
                  $("#FMMF").hide();
                $("#FMMA").hide();
                }
              }
            });

          $(function() {
            $.contextMenu({
              selector: 'tbody tr', 
              callback: function(key, options) {
              console.log(options.$trigger);
                if (key=="Afficher") {

                  var form = document.createElement("form");
                  form.setAttribute("method", "post");
                  form.setAttribute("action", "Global.php");

                  var hiddenField = document.createElement("input");
                  hiddenField.setAttribute("type", "hidden");
                  hiddenField.setAttribute("name", "id");
                  hiddenField.setAttribute("value", $(this).find("td:first").text());

                  form.appendChild(hiddenField);
      
                  document.body.appendChild(form);
                  form.submit();

                }else if (key=="fold1-key1") {

                  $('<input>').attr({
                      type: 'hidden',
                      name: 'id',
                      value: $(this).find("td:first").text(),
                  }).appendTo('#tgf');
                  jQuery.noConflict(); 
                  $('#tg').modal('show');

                }else if (key=="fold1-key2") {

                  $('<input>').attr({
                      type: 'hidden',
                      name: 'id',
                      value: $(this).find("td:first").text(),
                  }).appendTo('#psf');
                  jQuery.noConflict(); 
                  $('#ps').modal('show');

                }else if (key=="fold1-key3") {

                  var form = document.createElement("form");
                  form.setAttribute("method", "post");
                  form.setAttribute("action", "Documents.php");

                  var hiddenField = document.createElement("input");
                  hiddenField.setAttribute("type", "hidden");
                  hiddenField.setAttribute("name", "id");
                  hiddenField.setAttribute("value", $(this).find("td:first").text());

                  form.appendChild(hiddenField);
                  
                  var hiddenField2 = document.createElement("input");
                  hiddenField2.setAttribute("type", "hidden");
                  hiddenField2.setAttribute("name", "af");
                  hiddenField2.setAttribute("value", "af");

                  form.appendChild(hiddenField2);

                  document.body.appendChild(form);
                  form.submit();

                }else if (key=="fold1-key4") {

                  var form = document.createElement("form");
                  form.setAttribute("method", "post");
                  form.setAttribute("action", "Documents.php");

                  var hiddenField = document.createElement("input");
                  hiddenField.setAttribute("type", "hidden");
                  hiddenField.setAttribute("name", "id");
                  hiddenField.setAttribute("value", $(this).find("td:first").text());

                  form.appendChild(hiddenField);
                  
                  var hiddenField2 = document.createElement("input");
                  hiddenField2.setAttribute("type", "hidden");
                  hiddenField2.setAttribute("name", "fn");
                  hiddenField2.setAttribute("value", "fn");

                  form.appendChild(hiddenField2);

                  document.body.appendChild(form);
                  form.submit();

                }else if (key=="fold1-key5") {

                  $('<input>').attr({
                      type: 'hidden',
                      name: 'id',
                      value: $(this).find("td:first").text(),
                  }).appendTo('#mdf');
                  jQuery.noConflict(); 
                  $('#md').modal('show');

                }else if (key=="fold1-key6") {

                  var form = document.createElement("form");
                  form.setAttribute("method", "post");
                  form.setAttribute("action", "Documents.php");

                  var hiddenField = document.createElement("input");
                  hiddenField.setAttribute("type", "hidden");
                  hiddenField.setAttribute("name", "id");
                  hiddenField.setAttribute("value", $(this).find("td:first").text());

                  form.appendChild(hiddenField);
                  
                  var hiddenField2 = document.createElement("input");
                  hiddenField2.setAttribute("type", "hidden");
                  hiddenField2.setAttribute("name", "fs");
                  hiddenField2.setAttribute("value", "fs");

                  form.appendChild(hiddenField2);

                  document.body.appendChild(form);
                  form.submit();

                }else if (key=="fold1-key8") {

                  $('<input>').attr({
                      type: 'hidden',
                      name: 'id',
                      value: $(this).find("td:first").text(),
                  }).appendTo('#dmtf');
                  jQuery.noConflict(); 
                  $('#dmt').modal('show');

                }else if (key=="fold1-key7") {

                  $('<input>').attr({
                      type: 'hidden',
                      name: 'id',
                      value: $(this).find("td:first").text(),
                  }).appendTo('#dmlf');
                  jQuery.noConflict(); 
                  $('#dml').modal('show');

                }else if (key=="fold1-key9") {

                  $('<input>').attr({
                      type: 'hidden',
                      name: 'id',
                      value: $(this).find("td:first").text(),
                  }).appendTo('#drf');
                  jQuery.noConflict(); 
                  $('#dr').modal('show');

                }else if (key=="fold2-key1") {

                  var form = document.createElement("form");
                  form.setAttribute("method", "post");
                  form.setAttribute("action", "Documents.php");

                  var hiddenField = document.createElement("input");
                  hiddenField.setAttribute("type", "hidden");
                  hiddenField.setAttribute("name", "id");
                  hiddenField.setAttribute("value", $(this).find("td:first").text());

                  form.appendChild(hiddenField);
                  
                  var hiddenField2 = document.createElement("input");
                  hiddenField2.setAttribute("type", "hidden");
                  hiddenField2.setAttribute("name", "pvie");
                  hiddenField2.setAttribute("value", "pvie");

                  form.appendChild(hiddenField2);

                  document.body.appendChild(form);
                  form.submit();

                }else if (key=="fold2-key2") {

                  var form = document.createElement("form");
                  form.setAttribute("method", "post");
                  form.setAttribute("action", "Documents.php");

                  var hiddenField = document.createElement("input");
                  hiddenField.setAttribute("type", "hidden");
                  hiddenField.setAttribute("name", "id");
                  hiddenField.setAttribute("value", $(this).find("td:first").text());

                  form.appendChild(hiddenField);
                  
                  var hiddenField2 = document.createElement("input");
                  hiddenField2.setAttribute("type", "hidden");
                  hiddenField2.setAttribute("name", "pvi");
                  hiddenField2.setAttribute("value", "pvi");

                  form.appendChild(hiddenField2);

                  document.body.appendChild(form);
                  form.submit();

                }else if (key=="fold3-key1") {

                  $('<input>').attr({
                      type: 'hidden',
                      name: 'id',
                      value: $(this).find("td:first").text(),
                  }).appendTo('#pvrf');
                  jQuery.noConflict(); 
                  $('#pvr').modal('show');

                }else if (key=="fold3-key2") {

                  $('<input>').attr({
                      type: 'hidden',
                      name: 'id',
                      value: $(this).find("td:first").text(),
                  }).appendTo('#pvif');
                  jQuery.noConflict(); 
                  $('#pvi').modal('show');

                }
                },
                items: {

                    "Afficher" :{name: "Informations d'employé",icon: " fa-user "},                    
                   
                    "sep1": "---------",
                    "fold1": {
                        name: "Impression", 
                        items: {
                            "fold1-key1": {name: "Titre de Congé"},
                            "fold1-key2": {name: "PV de Sortie"},
                            "fold1-key3": {name: "Attestation de Fonction"},
                            "fold1-key4": {name: "Fiche de Notation"},
                            "fold1-key5": {name: "Mise en demeur"},
                            "fold1-key6": {name: "Fiche de fin de stage"},
                            "fold1-key7": {name: "Decision de maladie"},
                            "fold1-key8": {name: "Decision de maternité"},
                            "fold1-key9": {name: "Decision de suspension de rémunération"},
                            "fold2": {
                                "name": "PV d'Instalation", 
                                "items": {
                                    "fold2-key1": {"name": "Pour les enseignants"},
                                    "fold2-key2": {"name": "Pour les ATS"}
                                }
                            },
                            "fold3": {
                                "name": "PV de Reprise", 
                                "items": {
                                    "fold3-key1": {"name": "Pour les enseignants"},
                                    "fold3-key2": {"name": "Pour les ATS"}
                                }
                            }
                            
                        }
                   }

              }
            });

            $('tbody tr').on('click', function(e){
                console.log('clicked', 'rdkygfughipgvyhcfcftkcd');
            })    
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

function myFunction() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("ttable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}

function myFunction1() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput1");
  filter = input.value.toUpperCase();
  table = document.getElementById("ttableAr");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}

function myFunction2() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput2");
  filter = input.value.toUpperCase();
  table = document.getElementById("tableE");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
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

function sortTableC(n) {
var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
table = document.getElementById("tableC");
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

function sortTableA(n) {
var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
table = document.getElementById("tableA");
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

function sortTableE(n) {
var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
table = document.getElementById("tableE");
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
