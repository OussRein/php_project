<?php

session_start();
 
 
if(!isset($_SESSION['login_user']) || empty($_SESSION['login_user'])){
  header("location: sign-in.php");
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
        <link rel="stylesheet" href="style.css">

    </head>
    <body>
        
      <?php 
        include('navbar.php');
      ?>
      <?php 
         include('side-nav.php');
      ?>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4" style="font-family: Times, 'Times New Roman', Georgia, serif !important;">
        
        <div class="mdiv col-lg-12 well ins" style="background-color: #fff;">

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

            // <!---    ******************** TITRE DE CONGE ****************         -->
            if (isset($_POST['TG'])){
              if (!isset($_POST['db']) || empty($_POST['db']) || !isset($_POST['df']) || empty($_POST['df'])) {
                $_SESSION['error'] = "Vous devez introduire une date de debut/fin" ;
                $_POST = array();
                header("location: employe.php");
              }
              if ($_POST['db'] > $_POST['df'])  {
                $_SESSION['error'] = "La date de d??but de cong?? ne peux pas etre supperieur a la date du fin" ;
                $_POST = array();
                header("location: employe.php");
              }
              $sql = "SELECT CodeU FROM users WHERE NomU = ? ";
              $stmt = $bd->prepare($sql);
              $stmt->execute([$_SESSION['login_user']]);
              $id2 = $stmt->fetchColumn();

              $sql = "INSERT INTO historique(CodeU, CodeE , Traitement, dateH) VALUES (?,?,?,?)";

              $stmt = $bd->prepare($sql);
              $Trt = "Etablissement d'un Titre de Cong??";
              $date = date("Y-m-d H:i:s");
              $stmt->execute([$id2,$_POST['id'],$Trt,$date]);
          ?>
            <div id="TG">
              <div style="display: block; text-align: center;" class="row">
                <img class="mb-4" src="Capture.PNG" alt="" width="1040" style="background-color: #fff;">
                
              </div>
              <p>&emsp; <br><br><br><br><br><br><br>
              <h1 style="text-align: center; margin-top: 10px; font-family: Times, 'Times New Roman', Georgia, serif !important;" ><u>TITRE DE CONGE</u></h1></p>
              <p style="font-size: 18px; font-family: Times, 'Times New Roman', Georgia, serif !important;"><h4 style="font-family: Times, 'Times New Roman', Georgia, serif !important;"><br><br><br><br>&emsp; &emsp;&emsp;&emsp;  &emsp;&emsp;&emsp;      Il sera Attribuer a <br><br><br><br>
              &emsp;&emsp;&emsp;
              <?php
              if ($result['sexe'] == 1){
                echo "Mr : ";

              }elseif($result['SitFam'] == 1) {
                echo "Mlle : ";

              }else echo "Mme : "; 

              ?><?php echo (" <b>" . $result["NomFr"] . " " .$result["PrenomFr"] . " "); if (isset($result3)) echo ("Ep " . $result3['NomM'] . " </b>"); ?> <br><br>
              &emsp;&emsp;&emsp;Grade: <?php echo (" <b>" . $result["GradeFr"] . " </b>"); ?> <br><br>
              &emsp;&emsp;&emsp;Fonction: <?php echo (" <b>" . $result["FonctionFr"] . " </b>"); ?> <br> <br>
              &emsp;&emsp;&emsp;Structure de rattachement: FACULTE D'ELECTRONIQUE ET D'INFORMATIQUE<br><br>
              &emsp;&emsp;&emsp;Du: <?php echo (" <b>" . date_format(date_create_from_format('Y-m-d', $_POST["db"]),"d/m/Y") . " </b>"); ?> &emsp;
              Au: <?php echo ("<b> " . date_format(date_create_from_format('Y-m-d', $_POST["df"]),"d/m/Y") . " </b>"); ?> <br></h4>
              <h4 style="text-align: right; font-family: Times, 'Times New Roman', Georgia, serif !important;"><br><br>Fait ??  Bab-Ezzouar Le <?php echo ("<b> " . date("d/m/Y") . "</b>"); ?>&emsp;&emsp;&emsp;</h4>
              <h2 style="text-align: right; font-family: Times, 'Times New Roman', Georgia, serif !important;"><br><br>P/Le Reteur&emsp;&emsp;&emsp;</h2>
            </p>
            </div>
            <?php $_POST = array(); ?>

            <!---    ******************** PV DE SORTIE ****************         -->

            <?php } elseif (isset($_POST['PS'])){
              if (!isset($_POST['db']) || empty($_POST['db'])) {
                $_SESSION['error'] = "Vous devez introduire une date de debut" ;
                $_POST = array();
                header("location: employe.php");
              }
              $sql = "SELECT CodeU FROM users WHERE NomU = ? ";
              $stmt = $bd->prepare($sql);
              $stmt->execute([$_SESSION['login_user']]);
              $id2 = $stmt->fetchColumn();

              $sql = "INSERT INTO historique(CodeU, CodeE , Traitement, dateH) VALUES (?,?,?,?)";

              $stmt = $bd->prepare($sql);
              $Trt = "Etablissement d'un PV de Sortie";
              $date = date("Y-m-d H:i:s");
              $stmt->execute([$id2,$_POST['id'],$Trt,$date]);
          ?>
            <div id="PS" style="direction: rtl;">
              <div style="display: block; text-align: center;" class="row">
                &emsp; <br><br>
                <img class="mb-4" src="Capture2.PNG" alt="" width="1040" style="background-color: #fff;">
                
              </div>
              <p>&emsp; <br><br><br><br>
              <h1 style="text-align: center; margin-top: 10px; font-family: Times, 'Times New Roman', Georgia, serif !important;" ><u>???????? ????????</u></h1></p>
              <p style="font-size: 18px;"><h4>&emsp; &emsp;&emsp;&emsp;  &emsp;&emsp;&emsp;      <br><br><br></h4></p><p ><h4 style="text-align: right !important; font-family: Times, 'Times New Roman', Georgia, serif !important;">
              &emsp;&emsp;&emsp;?????????? ????????????????: <?php echo (" <b>" . $_POST["au"] . " </b>"); ?> <br><br>  
              &emsp;&emsp;&emsp; ??????????:  <b><?php echo (" " . $result["NomAr"] . " &emsp;&emsp;"); if (isset($result3)) {echo ("</b> ?????????? ??????????????  <b>" . $result3['NomMA'] );} echo( "</b>&emsp;&emsp; ??????????:    <b>" . $result["PrenomAr"]); ?></b> <br><br>
              &emsp;&emsp;&emsp;?????????? ?????????? ????????????????: <?php echo (" <b>" . date_format(date_create_from_format('Y-m-d', $result["DateN"]),"Y/m/d") . "</b> &emsp;&emsp; ??:   <b>" . $result["LieuNAR"] ."</b>"); ?> <br><br>
              &emsp;&emsp;&emsp;????????????: <?php echo ("<b> " . $result["GradeAr"] . " </b>"); ?> <br><br>
              &emsp;&emsp;&emsp;??????????????: <?php echo ("<b> " . $result["FonctionAr"] . " </b>"); ?> <br> <br>
              &emsp;&emsp;&emsp;???? ?????? ????  ???????? ???????????? ????: <?php echo ("<b> " . date_format(date_create_from_format('Y-m-d', $_POST["db"]),"Y/m/d") . " </b>"); ?><br><br><br>&emsp;&emsp;&emsp;<b style="text-align: left !important;">?????????????????????????????? ????: <?php echo (" " . date("Y/m/d")); ?></b>&emsp;&emsp;&emsp;</h4>
              <h3 style="text-align: right; font-family: Times, 'Times New Roman', Georgia, serif !important;"><br><br>&emsp;&emsp;&emsp;???????????? ??????????????:&emsp;&emsp;&emsp; &emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp; &emsp;&emsp;&emsp; ????????????</h3>
            </p>
            </div>
            <?php $_POST = array(); ?>

            <!---    ******************** ATTESTATION DE FONCTION ****************         -->



            <?php } elseif (isset($_POST['af'])){
              $sql = "SELECT CodeU FROM users WHERE NomU = ? ";
              $stmt = $bd->prepare($sql);
              $stmt->execute([$_SESSION['login_user']]);
              $id2 = $stmt->fetchColumn();

              $sql = "INSERT INTO historique(CodeU, CodeE , Traitement, dateH) VALUES (?,?,?,?)";

              $stmt = $bd->prepare($sql);
              $Trt = "Etablissement d'une Attestation de Fonction";
              $date = date("Y-m-d H:i:s");
              $stmt->execute([$id2,$_POST['id'],$Trt,$date]);
          ?>
            <div id="AF">
              <div style="display: block; text-align: center;" class="row">
                <img class="mb-4" src="Capture2.PNG" alt="" width="1040" style="background-color: #fff;">
                
              </div>
              <p>&emsp; <br>
                <h4 style="text-align: right; font-family: Times, 'Times New Roman', Georgia, serif !important;"><br><br>USTHB Le <?php echo (" " . date("d/m/Y")); ?>&emsp;&emsp;&emsp;</h4>
                <br><br><br>

              <h1 style="text-align: center; margin-top: 10px; font-family: Times, 'Times New Roman', Georgia, serif !important;" ><u>ATTESTATION DE FONCTION</u></h1></p>
              <p style="font-size: 18px; font-family: Times, 'Times New Roman', Georgia, serif !important;"><h4 style="font-family: Times, 'Times New Roman', Georgia, serif !important;"><br><br><br><br>     
                &emsp;&emsp;&emsp;
              <?php
              if ($result['sexe'] == 1){
                echo "Mr : ";

              }elseif($result['SitFam'] == 1) {
                echo "Mlle : ";

              }else echo "Mme : "; 

              ?><?php echo (" " . $result["NomFr"] . " " .$result["PrenomFr"] . " "); if (isset($result3)) echo ("Ep " . $result3['NomM'] . " "); ?> <br><br>
              &emsp;&emsp;&emsp;N?? le: <?php echo (" " . date_format(date_create_from_format('Y-m-d', $result["DateN"]),"d/m/Y") . " &emsp; ?? : "  . $result["LieuNFR"]); ?> <br><br>
              &emsp;&emsp;&emsp;Grade: <?php echo (" " . $result["GradeFr"] . " "); ?> <br><br>
              &emsp;&emsp;&emsp;Fonction: <?php echo (" " . $result["FonctionFr"] . " "); ?> <br> <br>
              &emsp;&emsp;&emsp;Date d'installation: <?php echo (" " . date_format(date_create_from_format('Y-m-d', $result["DateIN"]),"d/m/Y")); ?><br><br>
              &emsp;&emsp;&emsp;Cette attestation est d??livr??e ?? l???int??ress?? (e) pour servir et faire valoir ce que de  droit.<br></h4><br><br><br><br>
              
              <h2 style="text-align: right; font-family: Times, 'Times New Roman', Georgia, serif !important;"><br><br>Le Secr??taire G??n??ral&emsp;&emsp;&emsp;</h2>

            </p>
            </div>
            <?php $_POST = array(); ?>

            <!---    ********************FICHE DE NOTATION****************         -->


          <?php } elseif (isset($_POST['fn'])){
            
              $sql = "SELECT CodeU FROM users WHERE NomU = ? ";
              $stmt = $bd->prepare($sql);
              $stmt->execute([$_SESSION['login_user']]);
              $id2 = $stmt->fetchColumn();

              $sql = "INSERT INTO historique(CodeU, CodeE , Traitement, dateH) VALUES (?,?,?,?)";

              $stmt = $bd->prepare($sql);
              $Trt = "Etablissement d'une Fiche de Notation";
              $date = date("Y-m-d H:i:s");
              $stmt->execute([$id2,$_POST['id'],$Trt,$date]);
          ?>
            <div id="FN" style="direction: rtl; font-size: 20px !important;" >
              <div style="display: block; text-align: center;" class="row">
                &emsp; <br><br>
                <img class="mb-4" src="Capture2.PNG" alt="" width="1040" style="background-color: #fff;">
                
              </div>
              <p>&emsp; <br><br><br><b>
                <h3 style="text-align: right; font-family: Times, 'Times New Roman', Georgia, serif !important;">&emsp;&emsp;?????????? ???????????? ?????????????? ???????????????? 
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;?????????? 2018/2017</h3></b>
                <br>
                <h3 style="text-align: right; font-family: Times, 'Times New Roman', Georgia, serif !important;">&emsp;&emsp;<b>?????????? ???????????????? ?????????????????? ?? ???????????????? </b></h3>
                <br>
              <h1 style="text-align: center; margin-top: 10px; font-family: Times, 'Times New Roman', Georgia, serif !important;"  ><b>?????????????? ??????????????</b></h1></p>
              <h4><br>
              <h4 style="text-align: right !important; font-family: Times, 'Times New Roman', Georgia, serif !important;">
                <table border="1" width="80%" style="margin-left: 10%; margin-right: 10%; font-size: 23px; font-family: Times, 'Times New Roman', Georgia, serif !important;">
                  <tr>
                    <td style="padding: 5px; border-width: 3px; text-align: right; " width="45%">
                      &emsp; ??????????<?php echo (" " .  $result["NomAr"] . " "); ?> <br><br>
                      &emsp; ?????????? ????????????<?php if (isset($result3)) echo (" " . $result3['NomM??A'] . " "); ?><br><br>
                      &emsp;??????????: <?php  echo (" " . $result['PrenomAr'] . " "); ?><br><br>
                      &emsp;??????????  ????????????????: <?php echo (" " . date_format(date_create_from_format('Y-m-d', $result["DateN"]),"Y/m/d") . "    ??:   " . $result["LieuNAR"]); ?> <br><br>
                      &emsp;?????????????? ????????????????: <?php 
                      
                      if (($result['sexe'] == 1) && ($result['SitFam'] == 1)){
                        echo "????????";

                      }

                      elseif (($result['sexe'] == 1) && ($result['SitFam'] == 2)) {
                          echo "??????????";

                      }

                      elseif (($result['sexe'] == 2) && ($result['SitFam'] == 1)) {
                          echo "??????????";

                      }else echo "????????????";  ?> <br><br>

                      &emsp;??????????????: <?php  echo (" " . $result['diplome'] . " "); ?><br><br>
                    </td>

                    <td style="padding: 5px; border-width: 3px; text-align: right; " width="55%">
                      &emsp; ????????????:<?php echo (" " .  $result["GradeAr"] . " "); ?> <br><br>
                      &emsp; ??????????????:<?php echo (" " . $result['FonctionAr'] . " "); ?><br><br>
                      &emsp;????????????: :<?php  echo (" " . $result['Echellon'] . " "); ?><br><br>
                      &emsp;?????????? ?????? ?????????? ???? ????????????: <?php echo (" " . date_format(date_create_from_format('Y-m-d', $result["DateDE"]),"Y/m/d")); ?> <br><br>
                    </td>

                  </tr>
                  <tr>
                    <td style="padding: 10px; border-width: 3px; text-align: right; " colspan="2">
                      &emsp;?????????????? : &emsp;/10
                    </td>
                  </tr> 
                  <tr>
                    <td style="padding: 10px; border-width: 3px; text-align: center; " >
                      <b>???????????? ???????????????? ???????????????? </b>
                    </td>
                    <td style="padding: 10px; border-width: 3px; text-align: center; " >
                      <b>?????????? ?????????? ???????????? ????????????</b>
                    </td>
                  </tr> 

                  <tr>
                    <td style="padding: 5px; border-width: 3px; text-align: right; vertical-align: top !important;">
                      <ul>
                        <li>???????? ?????????????? ??? ???? 0 ?????? 10 ???? ???????? ?????????????????? ?????? ???????????? ???????????? ?????????? ?????????? </li>
                        <br>
                        <li>?????????????? ?????????? ??????? ?????????? ??? ???? ???????? ???? ?????????????????? ?????? ?????? ?????????? ???????????? ???????????? ??????????</li>
                      </ul>
                    </td>
                    <td style="padding: 5px; border-width: 3px; text-align: right; ">
                      <ul>
                        <li>???????? ???????????? ???????????? ???? ???????? ?????????????? ???? ???? ???????? :
                          <ol>
                            <li>
                              ?????????????? ?????? ??????????????????.
                            </li>
                            <li>
                              ???????????????? ???????????????? ?????????????? ?? ???????????? ???????? ????????  ???????????? ?????????????? ?????? ?????????? ?????????? ??????.
                            </li>
                          </ol>
                          ............................................................... ............................................................... ...............................................................
                          <br><br>
                          ???????? ???????????? ???????????? ?????? ???????? ?????? ????????????
                             <div style="text-align: left;">?????????????? &emsp;&emsp;</div>
                        </li>
                        
                      </ul>
                    </td>
                  </tr> 
                </table>

                <br><br><br><br><br><br><br><br><br>
                &emsp;&emsp; ?????????????? ?????????? ???????????? ????????????????:
                &emsp;&emsp;..................................................................................................................................................................               
                &emsp;&emsp;......................................................
                <br><br>
                &emsp;&emsp; ??????????:
                <br>
                <ul style="padding-right: 100px;">
                  <li>
                    ?????? ?????????????? ?????? ?????? ???????? ???????????? ????????????  ?????????????? ?????????????? ??? ?????????? ?????????? ??? 
                  </li>
                  <li>
                    ???? ???? ???????? ??? ???????? ??? ?????? ?????????? ???????????? ???????????? ?????????????? ?????? ?????????????? ?????? ???????? ?????????????????? ???? ?????????? ???????? ????????
                  </li>
                </ul>
                <br>
                <div style="text-align: left;">?????? ?? ?????? ???????????? ?????? ???????? ???? ??????????????  &emsp;&emsp;</div>
                <br>
                <hr>
                <br>
                &emsp;&emsp; ?????? ???????????? ?????????????????? ??????????????:
                <br><br>
                <ul style="padding-right: 75px;">
                  <li>
                    ?????????? ???????????? ?????? ?????????????? ?? ?????????????? ?????????? ???? ???????????? ???????????????? ??????.................................
                  </li>
                  <li>
                    ???????? ???????????? ???? ???????????? ???????? ?????? ???????????? ?????????????? ?????????? ???????????? 33 ???? ?????????? ?????? 66-133???????????? ???? 1966/06/02 ?????????????? ???????????? ??????????????:
                  </li>
                </ul>
                &emsp;&emsp;..................................................................................................................................................................               
                &emsp;&emsp;......................................................
                <br>
                <br>
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;????????????  &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;????????????
                <br><br>
                <hr>
                <br><br>
                &emsp;&emsp; ???? ???????????? ???????? ?????? ?????????????? ?????????????? ???? ?????? ???????????? ?????? ???????????? ??????????????
                <br><br>
                &emsp;&emsp;..................................................................................................................................................................   
                &emsp;&emsp;..................................................................................................................................................................            
                &emsp;&emsp;......................................................
                <br><br><br>
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;??????????????
            </h4>
              
            </p>
            </div>
            <?php $_POST = array(); ?>

            <!---    ********************MISE EN DEMEUR****************         -->

            <?php } elseif (isset($_POST['md'])){
              if (!isset($_POST['num']) || empty($_POST['num']) || !isset($_POST['ud']) || empty($_POST['ud'])) {
                $_SESSION['error'] = "Vous devez introduire un numero de reference/ un numero du document" ;
                $_POST = array();
                header("location: employe.php");
              }
              $sql = "SELECT CodeU FROM users WHERE NomU = ? ";
              $stmt = $bd->prepare($sql);
              $stmt->execute([$_SESSION['login_user']]);
              $id2 = $stmt->fetchColumn();

              $sql = "INSERT INTO historique(CodeU, CodeE , Traitement, dateH) VALUES (?,?,?,?)";

              $stmt = $bd->prepare($sql);
              $Trt = "Etablissement d'une Mise en demeur";
              $date = date("Y-m-d H:i:s");
              $stmt->execute([$id2,$_POST['id'],$Trt,$date]);
          ?>
            <div id="MD" style="direction: rtl; font-family: Times, 'Times New Roman', Georgia, serif !important;">
              <div style="display: block; text-align: center;" class="row">
                &emsp; <br><br>
                <img class="mb-4" src="Capture2.PNG" alt="" width="1040" style="background-color: #fff;">
                
              </div>
              <p>&emsp; <br><br>
                <h5 style="text-align: right;">&emsp;&emsp;????????????:  <?php echo (" " . $_POST['num']); ?>
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;?????? ???????????? ????: <?php echo (" " . date("Y/m/d")); ?>&emsp;</h5>
                <br><br>
              <h1 style="text-align: center; margin-top: 10px;" ><?php echo ("???????????????????????????????????????????????????????????????????? " . $_POST['ud']); ?></h1></p>
              <p style="font-size: 18px;"><h4><br>&emsp; &emsp;&emsp;&emsp;  &emsp;&emsp;&emsp;      <br><br><br></h4></p><p ><h4 style="text-align: right !important; font-size: 30px;">
                &emsp;&emsp;
              <?php
              if ($result['sexe'] == 1){
                echo "?????? ?????????? : ";

              }elseif($result['SitFam'] == 1) {
                echo "?????? ???????????? : ";

              }

              ?><?php echo (" " . $result["NomAr"] . " " .$result["PrenomAr"] . " "); if (isset($result3)) echo ("????????  " . $result3['NomMA'] . " "); ?> <br><br>
              &emsp;&emsp;&emsp;&emsp; ???????????? ???? ???????? ???????? ???????????? ?????????????? ???????? 48 ???????? ???????? ???????????????? ???? ???????? ????????<br>&emsp;&emsp;&emsp;&emsp;?????? ???????? ???? ???????????? ???? ???????????? ?????????? ???????????????? ?????????? ??????????????.
              <br><br>
              <div style="text-align: left;">???????????? ?????? ???????? ???????????????? ???????????????? &emsp;&emsp;</div>
              </h4>
              <br><br><br><br>
              <h2 style="text-align: left;">????/ ???????? ?????????????? &emsp;&emsp;&emsp;</h2>
            </p>
            </div>

            <!---    ************FICHE DE FIN DE STAGE***********         -->


            <?php } elseif (isset($_POST['fs'])){

              $sql = "SELECT CodeU FROM users WHERE NomU = ? ";
              $stmt = $bd->prepare($sql);
              $stmt->execute([$_SESSION['login_user']]);
              $id2 = $stmt->fetchColumn();

              $sql = "INSERT INTO historique(CodeU, CodeE , Traitement, dateH) VALUES (?,?,?,?)";

              $stmt = $bd->prepare($sql);
              $Trt = "Etablissement d'une Fiche de fin de Stage";
              $date = date("Y-m-d H:i:s");
              $stmt->execute([$id2,$_POST['id'],$Trt,$date]);
          ?>
            <div id="FS" style="direction: rtl; font-family: Times, 'Times New Roman', Georgia, serif !important;">
              <div style="display: block; text-align: center;" class="row">
                &emsp; <br><br>
                
                
              </div>
              <p>
                <h3 style="text-align: right;">&emsp;&emsp;?????????? ?????????????? ???????????? ???????????? ????????????
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;???????????? ????????????????
                <br> <br>
                &emsp;?????????? ?????????? ???????????? ???????????? ????????????????????????
                <br><br><br><br>
              <h1 style="text-align: center; margin-top: 10px;" ><b><u>?????????????? ?????????? ????????????</u></b></h1></p>
              <p style="font-size: 16px;"><h4><br>&emsp; &emsp;&emsp;&emsp;  &emsp;&emsp;&emsp; <br></h4></p><p ><h4 style="text-align: right !important; font-size: 25px;">
              &emsp;&emsp;<?php echo ("??????????:&emsp; " . $result["NomAr"] . "&emsp;&emsp; ??????????:&emsp; " .$result["PrenomAr"] . " "); if (isset($result3)) echo ("&emsp;&emsp;????????  " . $result3['NomMA'] . " "); ?> <br><br>
              &emsp;&emsp;???????????? ????????????????: <?php if ($result['sexe'] == 1 && $result['SitFam'] == 1){ echo "&emsp; ????????";}elseif ($result['sexe'] == 1 && $result['SitFam'] == 2) {echo "&emsp; ??????????";}elseif ($result['sexe'] == 2 && $result['SitFam'] == 2) echo "&emsp; ???????????? "; else echo "&emsp; ?????????? ";?> <br><br>
              &emsp;&emsp;?????????? ??????????????: <?php echo date_format(date_create_from_format('Y-m-d', $result["DateIN"]),"Y/m/d");?> <br><br>
              &emsp;&emsp;???????? ????????????: <?php echo "?????? ?????????????? ??????????";?> <br><br>
              </h4>
              <br>
              <h4 style="text-align: center; font-size: 30px"><b><u>?????????? ???????????????? ?????????? ?????? ???????????? ?????????????? ???????? ???????????? ???????? ???????????? </u></b><br><br>

                ???? ..................... ?????? ....................... ???? .................. ????????<br>
                ???? ..................... ?????? ....................... ???? .................. ????????<br>
                ???? ..................... ?????? ....................... ???? .................. ????????<br>
                ???? ..................... ?????? ....................... ???? .................. ????????<br>
              </h4><br><br><br>

              <table border="1" width="86%" style="margin-left: 7%; margin-right: 7%; font-size: 23px; font-family: Times, 'Times New Roman', Georgia, serif !important;">
                    <tr>
                      <td style="padding: 5px; border-width: 0px; text-align: center; ">
                         
                      </td>

                      <td style="padding: 5px; border-width: 2px; text-align: center; ">
                         ??????
                      </td>
                      <td style="padding: 5px; border-width: 2px; text-align: center; ">
                         ?????? ??????????????
                      </td>
                      <td style="padding: 5px; border-width: 2px; text-align: center; ">
                         ??????????
                      </td>
                      <td style="padding: 5px; border-width: 2px; text-align: center; ">
                         ????????
                      </td>
                      <td style="padding: 5px; border-width: 2px; text-align: center; ">
                         ?????? ????????????
                      </td>
                      
                    </tr>
                      
                    <tr>
                      <td style="padding: 5px; border-width: 2px; text-align: right;">
                         ???????????? ?????? ???????????????? ????????????????????
                      </td>
                      <td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td>
                    </tr>
                    <tr>
                      <td style="padding: 5px; border-width: 2px; text-align: right;">
                         ????????????????
                      </td>
                      <td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td>
                    </tr>
                    <tr>
                      <td style="padding: 5px; border-width: 2px; text-align: right;">
                         ???????????? ????????????????????
                      </td>
                      <td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td>
                    </tr>
                    <tr>
                      <td style="padding: 5px; border-width: 2px; text-align: right;">
                         ?????????? ?????????????? ??????????????
                      </td>
                      <td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td>
                    </tr>
                    <tr>
                      <td style="padding: 5px; border-width: 2px; text-align: right;">
                         ?????????????? ??????????????
                      </td>
                      <td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td>
                    </tr>
                               
                  </table>
                  <br><br>
                  <h4 style="text-align: right !important; font-family: Times, 'Times New Roman', Georgia, serif !important; font-weight: bold;">
                  &emsp;&emsp;&emsp;???????????? ????????:  &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; ?????????????? ????  <?php echo (" " . date("Y/m/d")); ?> <br><br>
                  &emsp;&emsp;&emsp;?????????????? ????????????:<br><br>
                  &emsp;&emsp;&emsp;?????????????????? ???????????? ??????????????????: &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; ?????????????? ??????????????
                </h4>
            </p>
            </div>
            <?php $_POST = array(); ?>

            <!---    *********** DECISION DE MATERNITE ***********         -->


            <?php } elseif (isset($_POST['dmt'])){
              if ($result['sexe'] == 2) {
                
              
              if (!isset($_POST['db']) || empty($_POST['db']) || !isset($_POST['df']) || empty($_POST['df']) || !isset($_POST['dsm']) || empty($_POST['dsm'])) {
                $_SESSION['error'] = "Vous devez introduire une date de debut/fin/Certificat midical" ;
                $_POST = array();
                header("location: employe.php");
              }
              if ($_POST['dsm'] > date("Y-m-d")) {
                $_SESSION['error'] = "Date du Certificat midical Non valide" ;
                $_POST = array();
                header("location: employe.php");
              }
              if ($_POST['db'] > $_POST['df']) {
                $_SESSION['error'] = "La date de fin ne peux as etre inferieur a la date de debut!!!!" ;
                $_POST = array();
                header("location: employe.php");
              }
              if ($_POST['dsm'] > $_POST['db']) {
                $_SESSION['error'] = "La date du Certificat medical ne peux as etre inferieur a la date de debut!!!!" ;
                $_POST = array();
                header("location: employe.php");
              }

              $sql = "SELECT CodeU FROM users WHERE NomU = ? ";
              $stmt = $bd->prepare($sql);
              $stmt->execute([$_SESSION['login_user']]);
              $id2 = $stmt->fetchColumn();

              $sql = "INSERT INTO historique(CodeU, CodeE , Traitement, dateH) VALUES (?,?,?,?)";

              $stmt = $bd->prepare($sql);
              $Trt = "Etablissement d'une decision de Maternit??";
              $date = date("Y-m-d H:i:s");
              $stmt->execute([$id2,$_POST['id'],$Trt,$date]);


              $sql = "SELECT count(*) FROM conge WHERE CodeE = ? and dateDeb = ? and dateFin = ?";
              $stmt = $bd->prepare($sql);
              $stmt->execute([$_POST['id'],$_POST['db'],$_POST['df']]);
              $nb = $stmt->fetchColumn();

              if ( $nb == 0 ){
              $sql = "INSERT INTO conge(CodeE , dateDeb , dateFin , type) VALUES (?,?,?,?)";
              $stmt = $bd->prepare($sql);
              $stmt->execute([$_POST['id'],$_POST['db'],$_POST['df'],2]);

              $sql = "INSERT INTO historique(CodeU, CodeE , Traitement, dateH) VALUES (?,?,?,?)";

              $stmt = $bd->prepare($sql);
              $Trt = "Effecuation d'un Cong?? de maladie";
              $date = date("Y-m-d H:i:s");
              $stmt->execute([$id2,$_POST['id'],$Trt,$date]);

              }
          ?>
            <div id="DMT">
              <div style="display: block; text-align: center; font-family: Times, 'Times New Roman', Georgia, serif !important;" class="row">
                <img class="mb-4" src="Capture3.PNG" alt="" width="1040" style="background-color: #fff;">
                
              </div>
              <p>&emsp; <br>
                <h4 style="text-align: right; font-family: Times, 'Times New Roman', Georgia, serif !important;"><br><br>Bab Ezzouar Le <?php echo (" " . date("d/m/Y")); ?>&emsp;&emsp;&emsp;</h4><br>
              <h2 style="text-align: center; margin-top: 10px; font-family: Times, 'Times New Roman', Georgia, serif !important;" >-=oOo=-<u>DECISION</u>-=oOo=-</h2></p>
              <p style="font-size: 18px; font-family: Times, 'Times New Roman', Georgia, serif !important;"><h4 style="font-family: Times, 'Times New Roman', Georgia, serif !important;"><br><br>

                &emsp;&emsp;&emsp; La Doyenne de la facult?? d'Electronique et d'Informatique de l'Universit?? des Sciences<br>&emsp;&emsp;  et de la technolgie Houari Boumediene <br><br>

                &emsp;&emsp;&emsp; Vu la loi N?? 83 - 11 du 02 juillet 1983 relative aux assurances sociales notament ses <br>&emsp;&emsp;articles 14 et suivants<br><br>

                &emsp;&emsp;&emsp; Vu la loi N?? 83 - 27 du 11 02 1984 fixant les modalit??s d'application de la loi N?? 83 - 11 <br>&emsp;&emsp;du 02 juillet 1983 relative aux assurances sociales : <br><br>

                &emsp;&emsp;&emsp; Vu Le Certificat M??dical en date Du <b><?php echo (" " . date_format(date_create_from_format('Y-m-d', $_POST["dsm"]),"d/m/Y") . " "); ?> </b> Prescrivant un Arret de Travail d'une <br>&emsp;&emsp;durr??e de <b><?php echo (" " . $_POST["dur"] . " "); ?></b> Jours A <?php if ($result['sexe'] == 1){ echo "Mr : ";}elseif($result['SitFam'] == 1) {echo "Mlle : ";}else echo "Mme : ";?><b><?php echo (" " . $result["NomFr"] . " " .$result["PrenomFr"] . " "); if (isset($result3)) echo ("Ep " . $result3['NomM'] . " "); ?></b> Grade <b><?php echo (" " . $result["GradeFr"] . " "); ?></b> A la Facult?? d'Eletronique et d'Informatique<br><br>

                <h2 style="text-align: center; font-family: Times, 'Times New Roman', Georgia, serif !important;">-=oOo=-<u>DECIDE</u>-=oOo=-</h2>
                <h4 style="font-family: Times, 'Times New Roman', Georgia, serif !important;">
                &emsp;&emsp;&emsp;<b><u>Act 1:</u></b><br>

                &emsp;&emsp;&emsp; Un Cong?? de Maternit?? d'une durr??e de <b><?php echo (" " . $_POST["dur"] . " "); ?></b> Jours est octoy?? ?? <?php if ($result['sexe'] == 1){ echo "Mr : ";}elseif($result['SitFam'] == 1) {echo "Mlle : ";}else echo "Mme : ";?><b><?php echo (" " . $result["NomFr"] . " " .$result["PrenomFr"] . " "); if (isset($result3)) echo ("Ep " . $result3['NomM'] . " "); ?></b> Grade <b><?php echo (" " . $result["GradeFr"] . " "); ?></b> Durant la p??riode du <?php echo (" " . date_format(date_create_from_format('Y-m-d', $_POST["db"]),"d/m/Y") . " "); ?> &emsp;
                Au: <?php echo (" " . date_format(date_create_from_format('Y-m-d', $_POST["df"]),"d/m/Y") . " "); ?> Inclus<br><br>

                &emsp;&emsp;&emsp;<b><u>Act 2:</u></b><br>
                
                &emsp;&emsp;&emsp; Le salaire de poste de l'int??ress?? est suspendu pour la periode du <?php echo (" " . date_format(date_create_from_format('Y-m-d', $_POST["db"]),"d/m/Y") . " "); ?> &emsp;
                Au: <?php echo (" " . date_format(date_create_from_format('Y-m-d', $_POST["df"]),"d/m/Y") . " "); ?> Inclus, et sont pris en charge par la caisse de la s??curit?? sociale comp??tente conform??ment ?? la l??gistation et ?? la r??glementation en viqueur<br><br>

                &emsp;&emsp;&emsp;<b><u>Act 3:</u></b><br>
                
                &emsp;&emsp;&emsp; Le Directeur du Budget et le Directeur des Personnels dont charg??s chacun en ce le concerne ?? l'??x??cution de pr??sente d??cision <br><br><br><br></h4>

              <h3 style="text-align: center; font-family: Times, 'Times New Roman', Georgia, serif !important;"><b><u>SECRETAIRE GENERAL DE LA FACULTE</u></b></h3>
              <h3 style="text-align: center; font-family: Times, 'Times New Roman', Georgia, serif !important;"><b><u>ELECTRONIQUE ET INFORMATIQUE</u></b></h3>
            </p>
            </div>
            <?php 
          } else  
            $_SESSION['error'] = "Vous ne pouvez pas etablire une decision de maternit?? pour un homme!!!" ;
                $_POST = array();
                header("location: employe.php");

         $_POST = array(); ?>    

            <!---    *********** DECISION DE MALADIE ***********         -->


            <?php  }elseif (isset($_POST['dml'])){
               if (!isset($_POST['db']) || empty($_POST['db']) || !isset($_POST['df']) || empty($_POST['df']) || !isset($_POST['dsm']) || empty($_POST['dsm'])) {
                $_SESSION['error'] = "Vous devez introduire une date de debut/fin/Certificat midical" ;
                $_POST = array();
                header("location: employe.php");
              }
              if ($_POST['dsm'] > date("Y-m-d")) {
                $_SESSION['error'] = "Date du Certificat midical Non valide" ;
                $_POST = array();
                header("location: employe.php");
              }
              if ($_POST['db'] > $_POST['df']) {
                $_SESSION['error'] = "La date de fin ne peux as etre inferieur a la date de debut!!!!" ;
                $_POST = array();
                header("location: employe.php");
              }
              if ($_POST['dsm'] > $_POST['db']) {
                $_SESSION['error'] = "La date du Certificat medical ne peux as etre inferieur a la date de debut!!!!" ;
                $_POST = array();
                header("location: employe.php");
              }
              $sql = "SELECT CodeU FROM users WHERE NomU = ? ";
              $stmt = $bd->prepare($sql);
              $stmt->execute([$_SESSION['login_user']]);
              $id2 = $stmt->fetchColumn();

              $sql = "INSERT INTO historique(CodeU, CodeE , Traitement, dateH) VALUES (?,?,?,?)";

              $stmt = $bd->prepare($sql);
              $Trt = "Etablissement d'une decision de Maladie";
              $date = date("Y-m-d H:i:s");
              $stmt->execute([$id2,$_POST['id'],$Trt,$date]);

              $sql = "SELECT count(*) FROM conge WHERE CodeE = ? and dateDeb = ? and dateFin = ?";
              $stmt = $bd->prepare($sql);
              $stmt->execute([$_POST['id'],$_POST['db'],$_POST['df']]);
              $nb = $stmt->fetchColumn();

              if ( $nb == 0 ){

              $sql = "INSERT INTO conge(CodeE , dateDeb , dateFin , TYPE) VALUES (?,?,?,?)";
              $stmt = $bd->prepare($sql);
              $stmt->execute([$_POST['id'],$_POST['db'],$_POST['df'],1]);

              $sql = "INSERT INTO historique(CodeU, CodeE , Traitement, dateH) VALUES (?,?,?,?)";

              $stmt = $bd->prepare($sql);
              $Trt = "Effectuation d'un Cong?? de maladie";
              $date = date("Y-m-d H:i:s");
              $stmt->execute([$id2,$_POST['id'],$Trt,$date]);

              }
          ?>
            <div id="DML" style="background-color: #fff;">
              <div style="display: block; text-align: center; font-family: Times, 'Times New Roman', Georgia, serif !important; background-color: #fff;" class="row">
                <img class="mb-4" src="Capture3.PNG" alt="" width="1040" >
                
              </div>
              <p>&emsp; <br>
                <h4 style="text-align: right; font-family: Times, 'Times New Roman', Georgia, serif !important;"><br><br>Bab Ezzouar Le <?php echo (" " . date("d/m/Y")); ?>&emsp;&emsp;&emsp;</h4><br>
              <h2 style="text-align: center; margin-top: 10px; font-family: Times, 'Times New Roman', Georgia, serif !important;" >-=oOo=-<u>DECISION</u>-=oOo=-</h2></p>
              <p style="font-size: 18px;"><h4 style="font-family: Times, 'Times New Roman', Georgia, serif !important;"><br><br>

                &emsp;&emsp;&emsp; La Doyenne de la facult?? d'Electronique et d'Informatique de l'Universit?? des Sciences et de la<br>&emsp;&emsp;technolgie Houari Boumediene <br><br>

                &emsp;&emsp;&emsp; Vu la loi N?? 83 - 11 du 02 juillet 1983 relative aux assurances sociales notament ses articles 14 et <br>&emsp;&emsp;suivants<br><br>

                &emsp;&emsp;&emsp; Vu la loi N?? 83 - 27 du 11 02 1984 fixant les modalit??s d'application de la loi N?? 83 - 11 du <br>&emsp;&emsp;02 juillet 1983 relative aux assurances sociales : <br><br>

                &emsp;&emsp;&emsp; Vu Le Certificat M??dical en date Du <b><?php echo (" " . date_format(date_create_from_format('Y-m-d', $_POST["dsm"]),"d/m/Y") . " "); ?> </b> Prescrivant un Arret de Travail d'une durr??e <br>&emsp;&emsp;de  <b><?php echo (" " . $_POST["dur"] . " "); ?></b> Jours A <?php if ($result['sexe'] == 1){ echo "Mr : ";}elseif($result['SitFam'] == 1) {echo "Mlle : ";}else echo "Mme : ";?><b><?php echo (" " . $result["NomFr"] . " " .$result["PrenomFr"] . " "); if (isset($result3)) echo ("Ep " . $result3['NomM'] . " "); ?></b> Grade <b><?php echo (" " . $result["GradeFr"] . " "); ?></b> A la Facult?? d'Eletronique et <br>&emsp;&emsp; d'Informatique<br><br><br>

                <h2 style="text-align: center; font-family: Times, 'Times New Roman', Georgia, serif !important;" >-=oOo=-<u>DECIDE</u>-=oOo=-</h2>
                <h4 style="font-family: Times, 'Times New Roman', Georgia, serif !important;">
                &emsp;&emsp;&emsp;<b><u>Act 1:</u></b><br>

                &emsp;&emsp;&emsp; Un Cong?? de Maladie d'une durr??e de <b><?php echo (" " . $_POST["dur"] . " "); ?></b> Jours est octoy?? ?? <?php if ($result['sexe'] == 1){ echo "Mr : ";}elseif($result['SitFam'] == 1) {echo "Mlle : ";}else echo "Mme : ";?><b><?php echo (" " . $result["NomFr"] . " " .$result["PrenomFr"] . " "); if (isset($result3)) echo ("Ep " . $result3['NomM'] . " "); ?></b><br>&emsp;&emsp;Grade <b><?php echo (" " . $result["GradeFr"] . " "); ?></b> Durant la p??riode du <?php echo (" " . date_format(date_create_from_format('Y-m-d', $_POST["db"]),"d/m/Y") . " "); ?> &emsp;
                Au: <?php echo (" " . date_format(date_create_from_format('Y-m-d', $_POST["df"]),"d/m/Y") . " "); ?> Inclus<br><br>

                &emsp;&emsp;&emsp;<b><u>Act 2:</u></b><br>
                
                &emsp;&emsp;&emsp; Le salaire de poste de l'int??ress?? est suspendu pour la periode du <?php echo (" " . date_format(date_create_from_format('Y-m-d', $_POST["db"]),"d/m/Y") . " "); ?> &emsp;
                Au: <?php echo (" " . date_format(date_create_from_format('Y-m-d', $_POST["df"]),"d/m/Y") . " "); ?><br>&emsp;&emsp;Inclus, et sont pris en charge par la caisse de la s??curit?? sociale comp??tente conform??ment ?? la <br>&emsp;&emsp;l??gistation et ?? la r??glementation en viqueur<br><br>

                &emsp;&emsp;&emsp;<b><u>Act 3:</u></b><br>
                
                &emsp;&emsp;&emsp; Le Directeur du Budget et le Directeur des Personnels dont charg??s chacun en ce le concerne ?? &emsp;&emsp;l'??x??cution de pr??sente d??cision <br><br><br><br></h4>

              <h2 style="text-align: center; font-family: Times, 'Times New Roman', Georgia, serif !important;"><b><u>SECRETAIRE GENERAL DE LA FACULTE</u></b></h2>
              <h2 style="text-align: center; font-family: Times, 'Times New Roman', Georgia, serif !important;"><b><u>ELECTRONIQUE ET INFORMATIQUE</u></b></h2>
            </p>
            </div>
            <?php $_POST = array(); ?>                

            <!---    *********** DECISION DE SUSPENSION DE REMUNATION ***********         -->


            <?php } elseif (isset($_POST['dr'])){
              if (!isset($_POST['db']) || empty($_POST['db']) || !isset($_POST['df']) || empty($_POST['df'])) {
                $_SESSION['error'] = "Vous devez introduire une date de debut/fin/Certificat midical" ;
                $_POST = array();
                header("location: employe.php");
              }
              $sql = "SELECT CodeU FROM users WHERE NomU = ? ";
              $stmt = $bd->prepare($sql);
              $stmt->execute([$_SESSION['login_user']]);
              $id2 = $stmt->fetchColumn();

              $sql = "INSERT INTO historique(CodeU, CodeE , Traitement, dateH) VALUES (?,?,?,?)";

              $stmt = $bd->prepare($sql);
              $Trt = "Etablissement d'une Decision de suspension de r??mun??ration";
              $date = date("Y-m-d H:i:s");
              $stmt->execute([$id2,$_POST['id'],$Trt,$date]);

              $sql = "SELECT count(*) FROM abscence WHERE CodeE = ? and dateDAb = ? and dateFAb";
              $stmt = $bd->prepare($sql);
              $stmt->execute([$_POST['id'],$_POST['db'],$_POST['df']]);
              $nb = $stmt->fetchColumn();

              if ( $nb == 0 ){
              $sql = "INSERT INTO abscence(CodeE , dateDAb , dateFAb) VALUES (?,?,?)";
              $stmt = $bd->prepare($sql);
              $stmt->execute([$_POST['id'],$_POST['db'],$_POST['df']]);

              $sql = "INSERT INTO historique(CodeU, CodeE , Traitement, dateH) VALUES (?,?,?,?)";

              $stmt = $bd->prepare($sql);
              $Trt = "Effectuation d'une abscence de " .$_POST['db'] . " Jusqu'au " . $_POST['df'];
              $date = date("Y-m-d H:i:s");
              $stmt->execute([$id2,$_POST['id'],$Trt,$date]);

              }
          ?>
            <div id="DR" style="background-color: #fff;">
              <div style="display: block; text-align: center; font-family: Times, 'Times New Roman', Georgia, serif !important; background-color: #fff;" class="row">
                <img class="mb-4" src="Capture3.PNG" alt="" width="1040" >
                
              </div>
              <p>&emsp; <br>
                <h4 style="text-align: right; font-family: Times, 'Times New Roman', Georgia, serif !important;"><br><br>Bab Ezzouar Le <?php echo (" " . date("d/m/Y")); ?>&emsp;&emsp;&emsp;</h4><br>
              <h2 style="text-align: center; margin-top: 10px; font-family: Times, 'Times New Roman', Georgia, serif !important;" ><u>DECISION DESUSPENSION DE REMUNATION</u></h2></p>
              <p style="font-size: 18px;"><h4 style="font-family: Times, 'Times New Roman', Georgia, serif !important;"><br><br>

                &emsp;&emsp;&emsp; La Doyenne de la facult?? d'Electronique et d'Informatique de l'USTHB. <br>

                &emsp;&emsp;&emsp; Vu la loi N?? 78 - 12 du 06 Aout relative aux status g??n??ral des travailleurs<br><br>

                <h2 style="text-align: center; font-family: Times, 'Times New Roman', Georgia, serif !important;" ><u>DECIDE</u></h2><br>
                <h4 style="font-family: Times, 'Times New Roman', Georgia, serif !important;">
                &emsp;&emsp;&emsp;<b><u>Article 1:</u></b><br><br>

                &emsp;&emsp;&emsp; La r??mun??ration de <?php if ($result['sexe'] == 1){ echo "Mr : ";}elseif($result['SitFam'] == 1) {echo "Mlle : ";}else echo "Mme : ";?><b><?php echo (" " . $result["NomFr"] . " " .$result["PrenomFr"] . " "); if (isset($result3)) echo ("Ep " . $result3['NomM'] . " "); ?></b> <br>
                &emsp;&emsp;&emsp; Fonction: <b><?php echo (" " . $result["GradeFr"] . " "); ?></b> <br>
                &emsp;&emsp;&emsp; Est suspendu <?php if($_POST["db"] == $_POST["df"]){echo (" La Journ??e du " . date_format(date_create_from_format('Y-m-d', $_POST["db"]),"d/m/Y") . " "); }else echo ("du  " . date_format(date_create_from_format('Y-m-d', $_POST["db"]),"d/m/Y") . " Au " . date_format(date_create_from_format('Y-m-d', $_POST["df"]),"d/m/Y")); ?><br><br><br>
                <?php
                $nbr = date_diff(date_create_from_format('Y-m-d', $_POST["db"]),date_create_from_format('Y-m-d', $_POST["df"]));
                $i=$nbr->format("%a");
                $i=$i+1;
                ?>
                &emsp;&emsp;&emsp; Nombre de jours de suspension : <?php echo (" " . $i . " jours"); ?><br>
                &emsp;&emsp;&emsp; Pour motifs suivants : <?php echo (" " . $_POST['motif'] . " "); ?><br><br><br>
                &emsp;&emsp;&emsp;<b><u>Article 2:</u></b><br><br>
                
                &emsp;&emsp;&emsp; Le Directeur du Budget de fonctionnement et de l'agent comptable accr??dit?? aupr??s de l'USTHB <br>&emsp;&emsp;sont charg??s chacun en ce le concerne, de l'??x??cution de pr??sente d??cision <br><br><br><br></h4>

              <h3 style="text-align: center; font-family: Times, 'Times New Roman', Georgia, serif !important;"><b><u>SECRETAIRE GENERAL DE LA FACULTE</u></b></h3>
              <h3 style="text-align: center; font-family: Times, 'Times New Roman', Georgia, serif !important;"><b><u>ELECTRONIQUE ET INFORMATIQUE</u></b></h3>
            </p>
            </div>
                <?php $_POST = array(); ?>                    

            <!---    *********** PV D'INSTALLATION/REPRISE ***********         -->


            <?php } elseif (isset($_POST['pvi']) || isset($_POST['pvr'])){
              if (isset($_POST['pvr']) ) {
                if (!isset($_POST['ud']) || empty($_POST['ud'])) {
                $_SESSION['error'] = "Vous devez introduire une date de debut/fin/Certificat midical" ;
                $_POST = array();
                header("location: employe.php");
              }}
              $sql = "SELECT CodeU FROM users WHERE NomU = ? ";
              $stmt = $bd->prepare($sql);
              $stmt->execute([$_SESSION['login_user']]);
              $id2 = $stmt->fetchColumn();

              $sql = "INSERT INTO historique(CodeU, CodeE , Traitement, dateH) VALUES (?,?,?,?)";

              $stmt = $bd->prepare($sql);
              if (isset($_POST['pvi'])) {
                $Trt = "Etablissement d'un PV d'installation";
              }else $Trt = "Etablissement d'un PV de Reprise";
              
              $date = date("Y-m-d H:i:s");
              $stmt->execute([$id2,$_POST['id'],$Trt,$date]);

          ?>
            <div id="PVI" style="direction: rtl;">
              <div style="display: block; text-align: center;" class="row">
                &emsp; <br><br>
                <img class="mb-4" src="Capture2.PNG" alt="" width="1040" >
                
              </div>
              <p>&emsp; <br><br>

              <h1 style="text-align: center; margin-top: 10px; font-family: Times, 'Times New Roman', Georgia, serif !important;" ><u><?php if (isset($_POST['pvi'])) echo "???????? ???????????? ??????????"; else echo "???????? ?????????????? ??????????"; ?></u></h1></p>
              <p style="font-size: 18px;"><h4>&emsp; &emsp;&emsp;&emsp;  &emsp;&emsp;&emsp;     <br><br></h4></p>
              <p style="font-size: 18px;"><h4>&emsp; &emsp;&emsp;&emsp;  &emsp;&emsp;&emsp;     <br><br></h4></p><p ><h4 style="text-align: right !important; font-family: Times, 'Times New Roman', Georgia, serif !important;">

                <table border="0" width="95%" style="margin-left: 2%; margin-right: 5%; font-size: 23px; font-family: Times, 'Times New Roman', Georgia, serif !important;">
                  <tr>
                    <td style="padding: 5px; border-width: 0px; text-align: right; " width="50%">
                        &emsp;?????????? ????????????????: 2018/2017<br><br> <br>
                        &emsp;??????????:  <b><?php echo ("&emsp; " . $result["NomAr"] . " "); if (isset($result3)) {echo ("</b>&emsp;&emsp;&emsp; ?????????? ??????????????  &emsp;<b>" . $result3['NomMA'] );}  ?></b> <br><br> 
                        &emsp;?????????? ?????????? ????????????????: <b><?php echo ("&emsp; " . date_format(date_create_from_format('Y-m-d', $result["DateN"]),"Y/m/d")); ?></b> <br><br>
                        &emsp;????????????: <b><?php echo ("&emsp; " . $result["GradeAr"]); ?> </b><br><br>
                        &emsp;?????? ?????????????? ??????????????: <b><?php echo (" &emsp;" . $result["NumIdProf"]); ?></b> <br> <br>
                      </td>

                      <td>
                        &emsp;?? ????????????  : <?php  echo (date("Y/m/d")); ?><br><br><br>  
                        &emsp;<?php echo( "??????????:    &emsp;<b>" . $result["PrenomAr"]); ?></b> <br><br>
                        &emsp;<?php echo ("?? :&emsp;<b>" . $result["LieuNAR"]); ?></b> <br><br>
                        &emsp;??????????????: <b><?php echo (" &emsp;" . $result["FonctionAr"] . " "); ?></b> <br> <br>
                        &emsp;????????????:<b><?php echo (" &emsp;" . $result["NumTel"] . " "); ?></b> <br> <br>
                      </td>
                    </tr>
                  </table>
        
                &emsp;&emsp;&emsp; ?????????????? ???????????? :<b><?php echo (" &emsp; " . $result["AdresseAr"] . " "); ?></b><br><br>

                &emsp;&emsp;&emsp; <b><u>?????????????? ????????????????  :</u></b>  &emsp;<?php 
                  if ($result['SitAdm'] == 1) {
                    echo "??????????";;
                  }elseif ($result['SitAdm'] == 2) {
                    echo "????????????";
                  }elseif ($result['SitAdm'] == 3) {
                    echo "????????";
                  }elseif ($result['SitAdm'] == 4) {
                    echo "????????";
                  }

                 ?>

                 <br><br>
                 &emsp;&emsp;&emsp; <b><u>???????????????? ????????????????  : </u></b> &emsp;<?php 
                  if ($result['SitFam'] == 1) {
                    echo "????????";;
                  }else{
                    echo "??????????" . " " . "&emsp;&emsp;&emsp; ?????? ?????????????? : " . $result2['nbrEnf'];
                  }
                 ?>
                 <br><br>
                 &emsp;&emsp;&emsp; ???????? ???????? ?????????????? ?????????? ???????????????? ??????   
                  <?php 
                    if ($result['sexe'] == 1){
                      echo " ?????????? : ";

                    }elseif($result['SitFam'] == 1) {
                      echo " ???????????? : ";

                    }else echo " ???????????? : ";
                  
                  echo ("<b> " . $result["NomAr"] . " " . $result["PrenomAr"]); 
                  if (isset($result3)) {echo ("????????" . $result3['NomMA'] );}

                  ?></b><br>

                  &emsp;&emsp;&emsp; ???? <?php if (isset($_POST['pvi'])) echo ("???????? ?????????? ???????????? ????  &emsp;" . date("Y/m/d") . "&emsp;?????? ?????????? ????????"); 
                  else {

                    echo ("?? ???????????? ?????????? ???????????? ???? " . date("Y/m/d") . "&emsp;?????? &emsp;")  ;
                    if ($_POST['ud'] == 1) {
                      echo "????????";
                    }elseif ($_POST['ud'] == 2) {
                      echo "???????? ??????????";
                    }elseif ($_POST['ud'] == 3) {
                      echo "???????? ??????????";
                    }elseif ($_POST['ud'] == 4) {
                      echo "????????????";
                    }elseif ($_POST['ud'] == 5) {
                      echo "???????? ?? ?????? ??????????????????;";
                    }elseif ($_POST['ud'] == 6) {
                      echo "???????????? ??????????????;";
                    }

                  }

                   ?>

                  

              </h4>
                <h3 style="text-align: right;"><br><br><br><br>&emsp;&emsp;&emsp;<b><u>???????????? ??????????????</u></b>&emsp;&emsp;&emsp; &emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp; &emsp;&emsp;&emsp;<b><u> ????????????</u></b></h3>
            </p>
            </div>
                            <?php $_POST = array(); ?>                    

            <!---    *********** PV D'INSTALLATION/REPRISE ***********         -->


            <?php } elseif (isset($_POST['pvie']) || isset($_POST['pvre'])){
              if (isset($_POST['pvre']) ) {
                if (!isset($_POST['ud']) || empty($_POST['ud'])) {
                $_SESSION['error'] = "Vous devez introduire!!!!" ;
                $_POST = array();
                header("location: employe.php");
              }}
              $sql = "SELECT CodeU FROM users WHERE NomU = ? ";
              $stmt = $bd->prepare($sql);
              $stmt->execute([$_SESSION['login_user']]);
              $id2 = $stmt->fetchColumn();

              $sql = "INSERT INTO historique(CodeU, CodeE , Traitement, dateH) VALUES (?,?,?,?)";

              $stmt = $bd->prepare($sql);
              if (isset($_POST['pvie'])) {
                $Trt = "Etablissement d'un PV d'installation du personnel enseignat";
              }else $Trt = "Etablissement d'un PV de Reprise du personnel enseignat";
              
              $date = date("Y-m-d H:i:s");
              $stmt->execute([$id2,$_POST['id'],$Trt,$date]);

          ?>
            <div id="PVIE" style="direction: rtl;">
              <div style="display: block; text-align: center;" class="row">
                
                <img class="mb-4" src="Capture2.PNG" alt="" width="1040" >
                
              </div>
              <p>
              <h1 style="text-align: center; margin-top: 10px; font-family: Times, 'Times New Roman', Georgia, serif !important;" ><u><?php if (isset($_POST['pvie'])) echo "???????? ???????????? ?????????? ?????????? ?????????????????????? ????????????????"; else echo "???????? ?????????????? ?????????? ?????????? ?????????????????????? ????????????????"; ?></u></h1></p><br>
              <p ><h4 style="text-align: right !important; font-family: Times, 'Times New Roman', Georgia, serif !important;">

                <table border="0" width="95%" style="margin-left: 2%; margin-right: 5%; font-size: 23px; font-family: Times, 'Times New Roman', Georgia, serif !important;">
                  <tr>
                    <td style="padding: 5px; border-width: 0px; text-align: right; " width="50%">
                        &emsp;?????????? ????????????????: 2018/2017<br><br> <br>
                        &emsp;??????????:  <b><?php echo ("&emsp; " . $result["NomAr"] . " "); if (isset($result3)) {echo ("</b>&emsp;&emsp;&emsp; ?????????? ??????????????  &emsp;<b>" . $result3['NomMA'] );}  ?></b> <br><br> 
                        &emsp;?????????? ?????????? ????????????????: <b><?php echo ("&emsp; " . date_format(date_create_from_format('Y-m-d', $result["DateN"]),"Y/m/d")); ?></b> <br><br>
                        &emsp;????????????: <b><?php echo ("&emsp; " . $result["GradeAr"]); ?> </b><br><br>
                        &emsp;?????? ?????????????? ??????????????: <b><?php echo (" &emsp;" . $result["NumIdProf"]); ?></b> <br> <br>
                      </td>

                      <td>
                        &emsp;?? ????????????  : <?php  echo (date("Y/m/d")); ?><br><br><br>  
                        &emsp;<?php echo( "??????????:    &emsp;<b>" . $result["PrenomAr"]); ?></b> <br><br>
                        &emsp;<?php echo ("?? :&emsp;<b>" . $result["LieuNAR"]); ?></b> <br><br>
                        &emsp;??????????????: <b><?php echo (" &emsp;" . $result["FonctionAr"] . " "); ?></b> <br> <br>
                        &emsp;????????????:<b><?php echo (" &emsp;" . $result["NumTel"] . " "); ?></b> <br> <br>
                      </td>
                    </tr>
                  </table>
        
                &emsp;&emsp;&emsp; ?????????????? ???????????? :<b><?php echo (" &emsp; " . $result["AdresseAr"] . " "); ?></b><br><br>

                &emsp;&emsp;&emsp; <b><u>?????????????? ????????????????  :</u></b>  &emsp;<?php 
                  if ($result['SitAdm'] == 1) {
                    echo "??????????";;
                  }elseif ($result['SitAdm'] == 2) {
                    echo "????????????";
                  }elseif ($result['SitAdm'] == 3) {
                    echo "????????";
                  }elseif ($result['SitAdm'] == 4) {
                    echo "????????";
                  }

                 ?>

                 <br><br>
                 &emsp;&emsp;&emsp; <b><u>???????????????? ????????????????  : </u></b> &emsp;<?php 
                  if ($result['SitFam'] == 1) {
                    echo "????????";;
                  }else{
                    echo "??????????" . " " . "&emsp;&emsp;&emsp; ?????? ?????????????? : " . $result2['nbrEnf'];
                  }
                 ?>
                 <br><br>
                 &emsp;&emsp;&emsp; ???????? ???????? ?????????????? ?????????? ???????????????? ??????   
                  <?php 
                    if ($result['sexe'] == 1){
                      echo " ?????????? : ";

                    }elseif($result['SitFam'] == 1) {
                      echo " ???????????? : ";

                    }else echo " ???????????? : ";
                  
                  echo ("<b> " . $result["NomAr"] . " " . $result["PrenomAr"]); 
                  if (isset($result3)) {echo ("????????" . $result3['NomMA'] );}

                  ?></b><br>

                  &emsp;&emsp;&emsp; ???? <?php if (isset($_POST['pvie'])) echo ("???????? ?????????? ???????????? ????  &emsp;" . date("Y/m/d") . "&emsp;?????? ?????????? ????????"); 
                  else {

                    echo ("?? ???????????? ?????????? ???????????? ???? " . date("Y/m/d") . "&emsp;?????? &emsp;")  ;
                    if ($_POST['ud'] == 1) {
                      echo "????????";
                    }elseif ($_POST['ud'] == 2) {
                      echo "???????? ??????????";
                    }elseif ($_POST['ud'] == 3) {
                      echo "???????? ??????????";
                    }elseif ($_POST['ud'] == 4) {
                      echo "????????????";
                    }elseif ($_POST['ud'] == 5) {
                      echo "???????? ?? ?????? ??????????????????;";
                    }elseif ($_POST['ud'] == 6) {
                      echo "???????????? ??????????????;";
                    }

                  }

                   ?>
                   <br><br>
                   <table border="1" width="86%" style="margin-left: 7%; margin-right: 7%; font-size: 23px; font-family: Times, 'Times New Roman', Georgia, serif !important;">
                    <tr>
                      <td style="padding: 5px; border-width: 1px; text-align: right; " rowspan="2">
                         ??????
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right; " colspan="4">
                         ????????????
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right; " rowspan="2">
                         ??????????
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right; " rowspan="2">
                         ????????????
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right; " rowspan="2">
                         ????????????(2)
                      </td>
                      
                    </tr>
                      
                    <tr>
                      <td style="padding: 5px; border-width: 1px; text-align: right;">
                         ??????????????
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right;">
                         ??????(1)
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right;">
                         ??????????????
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right;">
                         ??????????????????
                      </td>
                    </tr>
                    <tr>
                      <td style="padding: 3px; border-width: 1px; text-align: right;">
                         1
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td>
                    </tr>
                    <tr>
                      <td style="padding: 3px; border-width: 1px; text-align: right;">
                         2
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td>
                    </tr>
                    <tr>
                      <td style="padding: 3px; border-width: 1px; text-align: right;">
                         3
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td>
                    </tr>
                    <tr>
                      <td style="padding: 3px; border-width: 1px; text-align: right;">
                         4
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td>
                    </tr>
                    <tr>
                      <td style="padding: 3px; border-width: 1px; text-align: right;">
                         5
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td>
                    </tr>
                    <tr>
                      <td style="padding: 3px; border-width: 1px; text-align: right;">
                         6
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td>
                    </tr>
                    <tr>
                      <td style="padding: 3px; border-width: 1px; text-align: right;">
                         7
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td>
                    </tr>
                    <tr>
                      <td style="padding: 3px; border-width: 1px; text-align: right;">
                         8
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td>
                    </tr>
                    <tr>
                      <td style="padding: 3px; border-width: 1px; text-align: right;">
                         9
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td>
                    </tr>
                    <tr>
                      <td style="padding: 3px; border-width: 1px; text-align: right;">
                         10
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td><td style="padding: 5px; border-width: 1px; text-align: right;"></td>
                    </tr>

                    
                  </table>
                  <div style="font-size: 16px"> &emsp;&emsp;&emsp; &emsp;(1 ) ???? ?????????? ???????? ???????????? ?????????????????? ( 2 ) ???????? ???? ?????? ???????????? </div>
              </h4>
                <h3 style="text-align: right;"><br><br>&emsp;&emsp;&emsp;<b><u>???????????? ??????????????</u></b>&emsp;&emsp;&emsp; &emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp; &emsp;&emsp;&emsp;<b><u> ????????????</u></b></h3>
            </p>
            </div>
            <?php $_POST = array(); ?>
            <?php }  ?>        


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
          $(function() {
            $.contextMenu({
              selector: 'main div #TG', 
              callback: function(key, options) {
              console.log(options.$trigger);
                if (key=="Imprimer") {
                  $('#TG').printThis();
                }
                },
                items: {
                    "Imprimer" :{name: "Imprimer",icon: " fa-user "}
              }
            });
          });

          $(function() {
            $.contextMenu({
              selector: 'main div #PS', 
              callback: function(key, options) {
              console.log(options.$trigger);
                if (key=="Imprimer") {
                  $('#PS').printThis();
                }
                },
                items: {
                    "Imprimer" :{name: "Imprimer",icon: " fa-user "}
              }
            });
          });

          $(function() {
            $.contextMenu({
              selector: 'main div #AF', 
              callback: function(key, options) {
              console.log(options.$trigger);
                if (key=="Imprimer") {
                  $('#AF').printThis();
                }
                },
                items: {
                    "Imprimer" :{name: "Imprimer",icon: " fa-user "}
              }
            });
          });

          $(function() {
            $.contextMenu({
              selector: 'main div #FN', 
              callback: function(key, options) {
              console.log(options.$trigger);
                if (key=="Imprimer") {
                  $('#FN').printThis();
                }
                },
                items: {
                    "Imprimer" :{name: "Imprimer",icon: " fa-user "}
              }
            });
          });

          $(function() {
            $.contextMenu({
              selector: 'main div #MD', 
              callback: function(key, options) {
              console.log(options.$trigger);
                if (key=="Imprimer") {
                  $('#MD').printThis();
                }
                },
                items: {
                    "Imprimer" :{name: "Imprimer",icon: " fa-user "}
              }
            });
          });

          $(function() {
            $.contextMenu({
              selector: 'main div #FS', 
              callback: function(key, options) {
              console.log(options.$trigger);
                if (key=="Imprimer") {
                  $('#FS').printThis();
                }
                },
                items: {
                    "Imprimer" :{name: "Imprimer",icon: " fa-user "}
              }
            });
          });

          $(function() {
            $.contextMenu({
              selector: 'main div #DMT', 
              callback: function(key, options) {
              console.log(options.$trigger);
                if (key=="Imprimer") {
                  $('#DMT').printThis();
                }
                },
                items: {
                    "Imprimer" :{name: "Imprimer",icon: " fa-user "}
              }
            });
          });

          $(function() {
            $.contextMenu({
              selector: 'main div #DML', 
              callback: function(key, options) {
              console.log(options.$trigger);
                if (key=="Imprimer") {
                  $('#DML').printThis();
                }
                },
                items: {
                    "Imprimer" :{name: "Imprimer",icon: " fa-user "}
              }
            });
          });

          $(function() {
            $.contextMenu({
              selector: 'main div #DR', 
              callback: function(key, options) {
              console.log(options.$trigger);
                if (key=="Imprimer") {
                  $('#DR').printThis();
                }
                },
                items: {
                    "Imprimer" :{name: "Imprimer",icon: " fa-user "}
              }
            });
          });

          $(function() {
            $.contextMenu({
              selector: 'main div #PVIE', 
              callback: function(key, options) {
              console.log(options.$trigger);
                if (key=="Imprimer") {
                  $('#PVIE').printThis();
                }
                },
                items: {
                    "Imprimer" :{name: "Imprimer",icon: " fa-user "}
              }
            });
          });

          $(function() {
            $.contextMenu({
              selector: 'main div #PVI', 
              callback: function(key, options) {
              console.log(options.$trigger);
                if (key=="Imprimer") {
                  $('#PVI').printThis();
                }
                },
                items: {
                    "Imprimer" :{name: "Imprimer",icon: " fa-user "}
              }
            });
          });


    </script>
  </body>
</html>
