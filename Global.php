<?php

session_start();
 
 
if(!isset($_SESSION['login_user']) || empty($_SESSION['login_user'])){
  header("location: login.php");
  exit;
}

if($_SERVER["REQUEST_METHOD"] != "POST")
  {header("location: employe.php");}

?>



<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Gestion Globale</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="dashboard.css" rel="stylesheet">
        <link rel="stylesheet" href="jquery-ui-1.12.1/jquery-ui.css">
        <link href="jQuery-contextMenu-master/dist/jquery.contextMenu.css" rel="stylesheet">

    </head>
    <body>
        
      <?php 
        include('navbar.php');
      ?>
      <?php 
         include('side-nav.php');
      ?>

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


            $sql = "SELECT * FROM employe WHERE idEmploye = ?";
            $stmt = $bd->prepare($sql);
            $stmt->execute([$_POST['id']]);
            $result = $stmt->fetch();

            if ($result["SitFam"]==2) {
              $sql = "SELECT nbrEnf FROM marie WHERE idEmploye = ?";
              $stmt = $bd->prepare($sql);
              $stmt->execute([$_POST['id']]);
              $result2 = $stmt->fetch();

              if ($result["sexe"]==2) {
                $sql = "SELECT NomM,NomMA FROM fmarie WHERE idEmploye = ?";
                $stmt = $bd->prepare($sql);
                $stmt->execute([$_POST['id']]);
                $result3 = $stmt->fetch();
              }
            }

          ?>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <div id="Mod" style="display: none;">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center  pb-2 mb-3 border-bottom pt-3 px-4">
              <h1 class="h2"><b>Informations de <?php echo ($result['NomFr'] . " " . $result['PrenomFr']); ?></b></h1>
              <div class="btn-toolbar mb-2 mb-md-0">
                      
                  <button id="IN" class="btn btn-sm btn-info" role="button" onclick="toggler('info');">
                    Informations d'employ??
                  </button>

              </div>
          </div>
          <div class="card">
        <div class="header bg-blue" style="text-align: center;">
           <h5>Changer Les Informations d'employ??</h5>
        </div>
        <div class="body" style="background-color: #E5F2FF;">
        <div class="col-lg-12 well ins" style="background-color: #E5F2FF;">

          

              <div class="row">
                    <form style="width: 100%" method="post" action="Traitements.php">
                      <div class="col-sm-12">

                        <div class="row" style="display: none;">
                          <div class="col-sm-6 form-group">
                            <label>Nom:</label>
                            <input type="text" name="nomFex" placeholder="Nom" class="form-control" required="" value="<?php echo($result["NomFr"]); ?>">
                          </div>
                          <div class="col-sm-6 form-group col-xs-push-6">
                            <label>Prenom:</label>
                            <input type="text" name="prenomFex" placeholder="Prenom" class="form-control" required="" value="<?php echo($result["PrenomFr"]); ?>">
                          </div>
                          <div class="col-sm-6 form-group col-xs-push-6">
                            <label>Num??ro id Professionnel:</label>
                            <input type="text" name="idPex" placeholder="Num??ro id Professionnel..." class="form-control" required="" value="<?php echo($result["NumIdProf"]) ;?>">
                          </div>

                        </div>   



                        <div class="row">
                          <div class="col-sm-3 form-group">
                            <label>Nom:</label>
                            <input type="text" name="nomF" placeholder="Nom" class="form-control" required="" value="<?php echo($result["NomFr"]); ?>">
                          </div>
                          <div class="col-sm-3 form-group arab">
                            <label class="arabiclabel">??????????:</label>
                            <input type="text" name="nomA" placeholder="??????????" class="form-control" required="" value="<?php echo($result["NomAr"]); ?>">
                          </div>
                             
                    
                        
                          <div class="col-sm-3 form-group col-xs-push-6">
                            <label>Prenom:</label>
                            <input type="text" name="prenomF" placeholder="Prenom" class="form-control" required="" value="<?php echo($result["PrenomFr"]); ?>">
                          </div>
                          <div class="col-sm-3 form-group arab">
                            <label class="arabiclabel">??????????</label>
                            <input type="text" name="prenomA" placeholder="??????????" class="form-control" required="" value="<?php echo($result["PrenomAr"]); ?>">
                          </div>
                        </div>     


                       
                          <div class="form-group row ">
                          <div class="col-sm-4 form-group col-xs-push-3 ">
                            <label >Date de Naissance:</label>
                               <input  type="date" name="dateN" class="form-control" required="" value=<?php echo($result["DateN"]); ?>> 
                               
                          </div>  
                          <div class="col-sm-4 form-group col-xs-push-3">
                            <label>Lieu de Naissance:</label>
                            <input type="text" name="lieuF" placeholder="Lieu de Naissance" class="form-control" required="" value="<?php echo($result["LieuNFR"]); ?>">
                          </div>
                          <div class="col-sm-4 form-group arab">
                            <label class="arabiclabel">???????? ??????????????:</label>
                            <input type="text" name="lieuA" placeholder="???????? ??????????????" class="form-control" required="" value="<?php echo($result["LieuNAR"]); ?>">
                          </div>
                          
                         </div>    
                    
                         <div class="form-group row ">
                        <div class="col-sm-6 form-group">
                          <label>Adresse:</label>
                          <textarea placeholder="Entrer Voutre Adresse ici..." rows="3" name="adrF" class="form-control" required=""><?php echo($result["AdresseFR"]); ?></textarea>
                        </div>  

                        <div class="col-sm-6 form-group arab">
                          <label class="arabiclabel">??????????????:</label>
                          <textarea placeholder="???????? ?????????????? ??????..." rows="3" name="adrA" class="form-control" required=""><?php echo($result["AdresseAr"]); ?></textarea>
                        </div>  
                        </div>

                        <div class="row">
                          <div class="col-sm-3 form-group col-xs-push-6">
                            <label>Fonction</label>
                            <input type="text" name="fonctionF" placeholder="Fontion..." class="form-control" required="" value="<?php echo($result["FonctionFr"]); ?>">
                          </div>
                          <div class="col-sm-3 form-group arab">
                            <label class="arabiclabel">??????????????:</label>
                            <input type="text" name="fonctionA" placeholder="??????????????..." class="form-control" required="" value="<?php echo($result["FonctionAr"]); ?>">
                          </div>
                          

                        
                          <div class="col-sm-3 form-group col-xs-push-6">
                            <label>Grade:</label>
                            <input type="text" name="gradeF" placeholder="Grade..." class="form-control" required="" value=<?php echo($result["GradeFr"]); ?>>
                          </div>
                          <div class="col-sm-3 form-group arab">
                            <label class="arabiclabel">????????????:</label>
                            <input type="text" name="gradeA" placeholder="????????????..." class="form-control" required="" value=<?php echo($result["GradeAr"]); ?>>
                          </div>
                        </div>   

                        <div class="form-group row">
                            
                          <div class="col-sm-4 form-group col-xs-push-3">
                            <label>Echelon:</label>
                            <input type="text" name="ech" placeholder="Echellon..." class="form-control" required="" value=<?php echo($result["Echellon"]) ;?>>
                          </div>
                          <div class=" col-sm-4 form-group col-xs-push-3">
                            <label> Derni??re promossion d'echelon: </label>
                               <input  type="date" name="dateDE" id="" class="form-control " required="" value=<?php echo($result["DateDE"]) ;?>> 
                               
                          </div>
                          <div class="col-sm-4 form-group arab">
                            <label class="arabiclabel">??????????????:</label>
                            <input type="text" name="dip" placeholder="??????????????..." class="form-control" required="" value="<?php echo($result['diplome']) ;?>">
                          </div>
                          
                         </div> 

                        <div class="row">
                          <div class="col-sm-6 form-group col-xs-push-6">
                            <label>Num??ro id Professionnel:</label>
                            <input type="text" name="idP" placeholder="Num??ro id Professionnel..." class="form-control" required="" value=<?php echo($result["NumIdProf"]) ;?>>
                          </div>
                          <div class="col-sm-6 form-group arab">
                            <label class="arabiclabel">?????? ????????????:</label>
                            <input type="text" name="tel" placeholder="?????? ????????????..." class="form-control" required="" value=<?php echo($result["NumTel"]); ?>>
                          </div>
                        </div> 


                        <div class="row" style="margin-top: 10px">
                          <div class="input-group col-sm-4">
                          <select class="custom-select form-control" name="sexe" id="Sexe" required="" >
                            <option <?php if (!isset($result["sexe"]) || empty($result["sexe"])) {
                              echo("selected");
                            } ?>>Sexe...</option>
                            <option value="1" <?php if ($result["sexe"]==1) {
                              echo("selected");
                            } ?>>Homme</option>
                            <option value="2" <?php if ($result["sexe"]==2) {
                              echo("selected");
                            } ?>>Femme</option>
                          </select>
                          </div>
                        <div class="input-group mb-3 col-sm-4">
                          
                          <select class="custom-select form-control arab " name="stF" id="StF" required="">
                            <option <?php if (!isset($result["SitFam"]) || empty($result["SitFam"])) {
                              echo("selected");
                            } ?>>?????????????? ????????????????...</option>
                            <option value="1" <?php if ($result["SitFam"]==1) {
                              echo("selected");
                            } ?>>????????</option>
                            <option value="2" <?php if ($result["SitFam"]==2) {
                              echo("selected");
                            } ?>>??????????</option>
                          </select>
                        </div> 

                        <div class="input-group mb-3 col-sm-4">
                          
                          <select class="custom-select form-control arab"  name="stA" id="StA" required="">
                            <option <?php if (!isset($result["SitAdm"]) || empty($result["SitAdm"])) {
                              echo("selected");
                            } ?>>?????????????? ????????????????...</option>
                            <option value="1" <?php if ($result["SitAdm"]==1) {
                              echo("selected");
                            } ?>>??????????</option>
                            <option value="2" <?php if ($result["SitAdm"]==2) {
                              echo("selected");
                            } ?>>????????????</option>
                            <option value="3" <?php if ($result["SitAdm"]==3) {
                              echo("selected");
                            } ?>>????????</option>
                            <option value="4" <?php if ($result["SitAdm"]==4) {
                              echo("selected");
                            } ?>>????????</option>
                            <option value="5" <?php if ($result["SitAdm"]==5) {
                              echo("selected");
                            } ?>>??????????</option>
                            <option value="6" <?php if ($result["SitAdm"]==6) {
                              echo("selected");
                            } ?>>????????????</option>
                            <option value="7" <?php if ($result["SitAdm"]==7) {
                              echo("selected");
                            } ?>>????????????</option>
                          </select>
                        </div> 
                        
                        </div>
                          
                          <div class="row">
                          <div id="MM" class="col-sm-4 form-group col-xs-push-6" style="<?php if (!isset($result2["nbrEnf"]) || empty($result2["nbrEnf"])) { echo("display: none;");} else echo ""; ?>">
                            <label>Nombre d'enfants:</label>
                            <input type="text" name="nbE" placeholder="Nombre d'enfant..." class="form-control" value=<?php if (isset($result2["nbrEnf"]) || !empty($result2["nbrEnf"])) {
                              echo($result2["nbrEnf"]);
                            } ?>>
                          </div>
                          
                          <div class="col-sm-4 form-group" id="FMMF"  style="<?php if (!isset($result3["NomM"]) || empty($result3["NomM"])) { echo("display: none;");} else echo ""; ?>">
                            <label>Nom du femme mari??:</label>
                            <input type="text" name="nomFMF" placeholder="Nom du femme mari??..." class="form-control" value=<?php if (isset($result3["NomM"]) || !empty($result3["NomM"])) {
                              echo($result3["NomM"]);
                            } ?>>
                          </div>
                          <div class="col-sm-4 form-group arab" id="FMMA"  style="<?php if (!isset($result3["NomMA"]) || empty($result3["NomMA"])) { echo("display: none;");} else echo ""; ?>">
                            <label class="arabiclabel">?????? ???????????? ????????????????:</label>
                            <input type="text" name="nomFMA" placeholder="?????? ???????????? ????????????????..." class="form-control" value=<?php if (isset($result3["NomMA"]) || !empty($result3["NomMA"])) {
                              echo($result3["NomMA"]);
                            } ?>>
                          </div>
                          
                        </div> 


                        </div>



                        <hr><hr>
                        <div class="input-group mb-3 col-sm-12">
                      <input type="submit" name="submit" class="col-sm-12 btn btn-lg btn-info" value="Modifier">       </div> 
                      </div>
                    </form> 
                  </div>
              </div>
            </div>
          </div>
        </div>


    <div id="info">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center  pb-2 mb-3 border-bottom pt-3 px-4">
        <h1 class="h2"><b>Informations de <?php echo ($result['NomFr'] . " " . $result['PrenomFr']); ?></b></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
                
          <button id="MD" class="btn btn-sm btn-info" role="button" onclick="toggler('Mod');">
            Modifier les informations
          </button>

        </div>
      </div>
        <div id="AR" class="card">
        <div class="header bg-blue" style="text-align: center;">
           <h5>?????????????? ????????????</h5>
        </div>
        <div class="body" style="background-color: #E5F2FF;">
        <div  class="col-lg-12 well ins" style="background-color: #E5F2FF;">
        <div class="col-sm-12">
          <div class="row">
        

          <div class="col-lg-5">
            <p style="font-size: 18px; text-align: right;">
              ??????????
              <hr>
              <table class="table table-striped table-sm table-bordered table-ar table-ba table-hover">
                <thead>
                  <th>???? </th>
                  <th>??????</th>
                  <th>?????? ????????????</th>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT * FROM conge WHERE CodeE = ?";
                  $stmt = $bd->prepare($sql);
                  $stmt->execute([$_POST['id']]);
                  $i=0;
                  while ($res = $stmt->fetch()){
                  ?>
                  <tr>
                    <td> <?php echo date_format(date_create_from_format('Y-m-d', $res['dateDeb']),"Y/m/d"); ?></td>
                    <td> <?php echo date_format(date_create_from_format('Y-m-d', $res['dateFin']),"Y/m/d"); ?></td>
                    <td> <?php if ($res['TYPE'] == 1) echo "??????????"; else echo "??????????"; ?></td>
                  </tr>
                <?php
                 $nbr = date_diff(date_create_from_format('Y-m-d', $res['dateDeb']),date_create_from_format('Y-m-d', $res['dateFin']));
                $i= $i + $nbr->format("%a") + 1;
               }?>

                  <tr>
                    <td colspan="3"><?php echo "?????? ???????? ??????????" . ":&emsp; " . $i; ?></td>
                  </tr>
                </tbody>
              </table>  
              <br><br>
              <div style="font-size: 18px; text-align: right;">????????????????</div>
              <hr>
              <table class="table table-striped table-sm table-bordered table-ar table-ba table-hover">
                <thead>
                  <th>?????? ???????????? </th>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT * FROM abscence WHERE CodeE = ?";
                  $stmt = $bd->prepare($sql);
                  $stmt->execute([$_POST['id']]);
                  $i=0;
                  while ($res = $stmt->fetch()){
                    $begin = new DateTime($res['dateDAb']);
                    $end = new DateTime($res['dateFAb']);
                    $end = $end->modify( '+1 day' ); 
                    $interval = new DateInterval('P1D');
                    $daterange = new DatePeriod($begin, $interval ,$end);
                    foreach($daterange as $date){
                    
                  ?>
                  <tr>
                    <td> <?php echo $date->format("Y/m/d"); ?></td>
                  </tr>
                  <?php
                 
                $i= $i + 1;
                }
               }?>

                  <tr>
                    <td rowspan="3"><?php echo "?????? ???????? ???????????????? " . ":&emsp; " . $i; ?></td>
                  </tr>
                </tbody>
              </table>               
            </p>
          </div>

          <div class="col-lg-7 arab arabiclabel">
            <p style="font-size: 18px; text-align: right;">

              &emsp;
              <?php 
              if ($result['sexe'] = 1){
                echo "??????????: ";

              }else if($result['SitFam'] = 1) {
                echo "???????????? : ";

              }else echo "???????????? : "; 

              ?>
              <?php 
              echo (" " . $result["NomAr"] . " " .$result["PrenomAr"] . " "); 
              if (isset($result3)) echo ("???????? " . $result3['NomMA'] . " "); 
              ?> <br>

              &emsp;?????????? ??????????????: <?php echo (" " . date_format(date_create_from_format('Y-m-d', $result['DateN']),"Y/m/d") . " "); ?> <br>
              &emsp;???????? ??????????????:<?php echo (" " . $result["LieuNAR"] . " "); ?> <br>
              
              &emsp;??????????????: <?php echo (" " . $result["AdresseAr"] . " "); ?> <br>
              &emsp;?????? ????????????:<?php echo (" " . $result["NumTel"] . " "); ?> <br>
              &emsp;??????????????: <?php echo (" " . $result["FonctionAr"] . " "); ?> <br>
              &emsp;????????????: <?php echo (" " . $result["GradeAr"] . " "); ?> <br>
              &emsp;?????????? ??????????????: <?php echo (" " . date_format(date_create_from_format('Y-m-d', $result['DateIN']),"Y/m/d") . " "); ?> 
              
            </p>
          </div>
        </div>
          </div>
        </div>
</div>
</div>

<!-- ****************************** -->
        <div id="FR" class="card" style="display: none;">
        <div class="header bg-blue" style="text-align: center;">
           <h5>Informations d'employ??</h5>
        </div>
        <div class="body" style="background-color: #E5F2FF;">
        <div  class="col-lg-12 well ins" style="background-color: #E5F2FF; ">

        <div class="col-sm-12">
          <div class="row">
        

          <div class="col-lg-7">
            <p style="font-size: 18px;">

              &emsp;
              <?php
              if ($result['sexe'] = 1){
                echo "M. : ";

              }else if($result['SitFam'] = 1) {
                echo "Mlle : ";

              }else echo "Mme : "; 

              ?>
              <?php 
              echo (" " . $result["NomFr"] . " " .$result["PrenomFr"] . " "); 
              if (isset($result3)) echo ("Ep " . $result3['NomM'] . " "); 
              ?> <br>
              &emsp;Date de Naissance: <?php echo (" " . date_format(date_create_from_format('Y-m-d', $result['DateN']),"Y/m/d") . " "); ?> <br>
              &emsp;Lieu de Naissance:<?php echo (" " . $result["LieuNFR"] . " "); ?> <br>
              
              &emsp;Adresse: <?php echo (" " . $result["AdresseFR"] . " "); ?> <br>
              &emsp;Numero de telephone:<?php echo (" " . $result["NumTel"] . " "); ?> <br>
              &emsp;Fonction: <?php echo (" " . $result["FonctionFr"] . " "); ?> <br>
              &emsp;Grade: <?php echo (" " . $result["GradeFr"] . " "); ?> <br>
              &emsp;Date d'instalation: <?php echo (" " . date_format(date_create_from_format('Y-m-d', $result['DateIN']),"d/m/Y") . " "); ?> 
              
            </p>
          </div>



          <div class="col-lg-5">
            <p style="font-size: 18px;">

                 Les Cong??s:
              <hr>
              <table class="table table-striped table-sm table-bordered table-ba table-hover">
                <thead>
                  <th>De </th>
                  <th>Au</th>
                  <th>de Type</th>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT * FROM conge WHERE CodeE = ?";
                  $stmt = $bd->prepare($sql);
                  $stmt->execute([$_POST['id']]);
                  $i=0;
                  while ($res = $stmt->fetch()){
                  ?>
                  <tr>
                    <td> <?php echo date_format(date_create_from_format('Y-m-d', $res['dateDeb']),"Y/m/d"); ?></td>
                    <td> <?php echo date_format(date_create_from_format('Y-m-d', $res['dateFin']),"Y/m/d"); ?></td>
                    <td> <?php if ($res['TYPE'] == 1) echo "Maladie"; else echo "Maternit??"; ?></td>
                  </tr>
                <?php
                 $nbr = date_diff(date_create_from_format('Y-m-d', $res['dateDeb']),date_create_from_format('Y-m-d', $res['dateFin']));
                $i= $i + $nbr->format("%a") + 1;
               }?>

                  <tr>
                    <td colspan="3"><?php echo "Nombre de jours de Cong??s:" . ":&emsp; " . $i; ?></td>
                  </tr>
                </tbody>
              </table>  
              <br><br>
              <div style="font-size: 18px; text-align: left;">Les Abscences</div>
              <hr>
              <table class="table table-striped table-sm table-bordered table-ba table-hover">
                <thead>
                  <th>Date d'abscence</th>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT * FROM abscence WHERE CodeE = ?";
                  $stmt = $bd->prepare($sql);
                  $stmt->execute([$_POST['id']]);
                  $i=0;
                  while ($res = $stmt->fetch()){
                  $begin = new DateTime($res['dateDAb']);
                    $end = new DateTime($res['dateFAb']);
                    $end = $end->modify( '+1 day' ); 
                    $interval = new DateInterval('P1D');
                    $daterange = new DatePeriod($begin, $interval ,$end);
                    foreach($daterange as $date){                    
                  ?>
                  <tr>
                    <td> <?php echo $date->format("d/m/Y"); ?></td>
                  </tr>
                  <?php
                 
                $i= $i + 1;
                }
               }?>

                  <tr>
                    <td colspan="3"><?php echo "Nombre de jours d'abscence " . ":&emsp; " . $i; ?></td>
                  </tr>
                </tbody>
              </table>           
              
            </p>
          </div>
        </div>
          </div>
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
        <script> feather.replace() </script>
        
        <script>
          $(function() {
            $( "#datepicker" ).datepicker({
            altField: "#datepicker",
            closeText: 'Fermer',
            prevText: 'Pr??c??dent',
            nextText: 'Suivant',
            currentText: 'Aujourd\'hui',
            monthNames: ['Janvier', 'F??vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Ao??t', 'Septembre', 'Octobre', 'Novembre', 'D??cembre'],
            monthNamesShort: ['Janv.', 'F??vr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Ao??t', 'Sept.', 'Oct.', 'Nov.', 'D??c.'],
            dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
            dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
            weekHeader: 'Sem.',
            dateFormat: 'yy-mm-dd'
            });
          });
        </script>

        <script>
            $(document).ready(function(){

                $("#MD").click(function(){
                    $("#info").hide();
                    $("#Mod").show();
                });
                $("#IN").click(function(){
                    $("#Mod").hide();
                    $("#info").show();
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
                selector: '#AR', 
                callback: function(key, options) {
                 console.log(options.$trigger);
                  if (key=="FR") {
                    $("#FR").show();
                    $("#AR").hide();
                  }
                },
                items: {

                    "FR" :{name: "Informations en fran??ais",icon: " fa-user "}
              }
            });   
          });

          $(function() {
            $.contextMenu({
                selector: '#FR', 
                callback: function(key, options) {
                 console.log(options.$trigger);
                  if (key=="AR") {
                    $("#AR").show();
                    $("#FR").hide();
                  }
                },
                items: {

                    "AR" :{name: "?????????????????? ????????????????",icon: " fa-user "}
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
