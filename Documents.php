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
                $_SESSION['error'] = "La date de début de congé ne peux pas etre supperieur a la date du fin" ;
                $_POST = array();
                header("location: employe.php");
              }
              $sql = "SELECT CodeU FROM users WHERE NomU = ? ";
              $stmt = $bd->prepare($sql);
              $stmt->execute([$_SESSION['login_user']]);
              $id2 = $stmt->fetchColumn();

              $sql = "INSERT INTO historique(CodeU, CodeE , Traitement, dateH) VALUES (?,?,?,?)";

              $stmt = $bd->prepare($sql);
              $Trt = "Etablissement d'un Titre de Congé";
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
              <h4 style="text-align: right; font-family: Times, 'Times New Roman', Georgia, serif !important;"><br><br>Fait à  Bab-Ezzouar Le <?php echo ("<b> " . date("d/m/Y") . "</b>"); ?>&emsp;&emsp;&emsp;</h4>
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
              <h1 style="text-align: center; margin-top: 10px; font-family: Times, 'Times New Roman', Georgia, serif !important;" ><u>محضر خروج</u></h1></p>
              <p style="font-size: 18px;"><h4>&emsp; &emsp;&emsp;&emsp;  &emsp;&emsp;&emsp;      <br><br><br></h4></p><p ><h4 style="text-align: right !important; font-family: Times, 'Times New Roman', Georgia, serif !important;">
              &emsp;&emsp;&emsp;السنة الجامعية: <?php echo (" <b>" . $_POST["au"] . " </b>"); ?> <br><br>  
              &emsp;&emsp;&emsp; اللقب:  <b><?php echo (" " . $result["NomAr"] . " &emsp;&emsp;"); if (isset($result3)) {echo ("</b> اللقب الأصليز  <b>" . $result3['NomMA'] );} echo( "</b>&emsp;&emsp; الاسم:    <b>" . $result["PrenomAr"]); ?></b> <br><br>
              &emsp;&emsp;&emsp;تاريخ ومكان الازدياد: <?php echo (" <b>" . date_format(date_create_from_format('Y-m-d', $result["DateN"]),"Y/m/d") . "</b> &emsp;&emsp; ب:   <b>" . $result["LieuNAR"] ."</b>"); ?> <br><br>
              &emsp;&emsp;&emsp;الرتبة: <?php echo ("<b> " . $result["GradeAr"] . " </b>"); ?> <br><br>
              &emsp;&emsp;&emsp;الوظيفة: <?php echo ("<b> " . $result["FonctionAr"] . " </b>"); ?> <br> <br>
              &emsp;&emsp;&emsp;قد خرج في  عطلة ابتداء من: <?php echo ("<b> " . date_format(date_create_from_format('Y-m-d', $_POST["db"]),"Y/m/d") . " </b>"); ?><br><br><br>&emsp;&emsp;&emsp;<b style="text-align: left !important;">الجـــــزائـــر في: <?php echo (" " . date("Y/m/d")); ?></b>&emsp;&emsp;&emsp;</h4>
              <h3 style="text-align: right; font-family: Times, 'Times New Roman', Georgia, serif !important;"><br><br>&emsp;&emsp;&emsp;السلطة السلمية:&emsp;&emsp;&emsp; &emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp; &emsp;&emsp;&emsp; الموظف</h3>
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
              &emsp;&emsp;&emsp;Né le: <?php echo (" " . date_format(date_create_from_format('Y-m-d', $result["DateN"]),"d/m/Y") . " &emsp; à : "  . $result["LieuNFR"]); ?> <br><br>
              &emsp;&emsp;&emsp;Grade: <?php echo (" " . $result["GradeFr"] . " "); ?> <br><br>
              &emsp;&emsp;&emsp;Fonction: <?php echo (" " . $result["FonctionFr"] . " "); ?> <br> <br>
              &emsp;&emsp;&emsp;Date d'installation: <?php echo (" " . date_format(date_create_from_format('Y-m-d', $result["DateIN"]),"d/m/Y")); ?><br><br>
              &emsp;&emsp;&emsp;Cette attestation est délivrée à l’intéressé (e) pour servir et faire valoir ce que de  droit.<br></h4><br><br><br><br>
              
              <h2 style="text-align: right; font-family: Times, 'Times New Roman', Georgia, serif !important;"><br><br>Le Secrétaire Général&emsp;&emsp;&emsp;</h2>

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
                <h3 style="text-align: right; font-family: Times, 'Times New Roman', Georgia, serif !important;">&emsp;&emsp;نيابة مديرية التوظيف والتكوين 
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;السنة 2018/2017</h3></b>
                <br>
                <h3 style="text-align: right; font-family: Times, 'Times New Roman', Georgia, serif !important;">&emsp;&emsp;<b>مصلحة الموظفين الإداريين و التقنيين </b></h3>
                <br>
              <h1 style="text-align: center; margin-top: 10px; font-family: Times, 'Times New Roman', Georgia, serif !important;"  ><b>استمارة التنقيط</b></h1></p>
              <h4><br>
              <h4 style="text-align: right !important; font-family: Times, 'Times New Roman', Georgia, serif !important;">
                <table border="1" width="80%" style="margin-left: 10%; margin-right: 10%; font-size: 23px; font-family: Times, 'Times New Roman', Georgia, serif !important;">
                  <tr>
                    <td style="padding: 5px; border-width: 3px; text-align: right; " width="45%">
                      &emsp; اللقب<?php echo (" " .  $result["NomAr"] . " "); ?> <br><br>
                      &emsp; اللقب الأصلي<?php if (isset($result3)) echo (" " . $result3['NomMَA'] . " "); ?><br><br>
                      &emsp;الاسم: <?php  echo (" " . $result['PrenomAr'] . " "); ?><br><br>
                      &emsp;تاريخ  الازدياد: <?php echo (" " . date_format(date_create_from_format('Y-m-d', $result["DateN"]),"Y/m/d") . "    ب:   " . $result["LieuNAR"]); ?> <br><br>
                      &emsp;الوضعية العائلية: <?php 
                      
                      if (($result['sexe'] == 1) && ($result['SitFam'] == 1)){
                        echo "أعزب";

                      }

                      elseif (($result['sexe'] == 1) && ($result['SitFam'] == 2)) {
                          echo "متزوج";

                      }

                      elseif (($result['sexe'] == 2) && ($result['SitFam'] == 1)) {
                          echo "عزباء";

                      }else echo "متزوجة";  ?> <br><br>

                      &emsp;الشهادة: <?php  echo (" " . $result['diplome'] . " "); ?><br><br>
                    </td>

                    <td style="padding: 5px; border-width: 3px; text-align: right; " width="55%">
                      &emsp; الرتبة:<?php echo (" " .  $result["GradeAr"] . " "); ?> <br><br>
                      &emsp; الوظيفة:<?php echo (" " . $result['FonctionAr'] . " "); ?><br><br>
                      &emsp;الدرجة: :<?php  echo (" " . $result['Echellon'] . " "); ?><br><br>
                      &emsp;تاريخ آخر ترقية في الدرجة: <?php echo (" " . date_format(date_create_from_format('Y-m-d', $result["DateDE"]),"Y/m/d")); ?> <br><br>
                    </td>

                  </tr>
                  <tr>
                    <td style="padding: 10px; border-width: 3px; text-align: right; " colspan="2">
                      &emsp;العلامة : &emsp;/10
                    </td>
                  </tr> 
                  <tr>
                    <td style="padding: 10px; border-width: 3px; text-align: center; " >
                      <b>بيانات للقائمين بالتنقيط </b>
                    </td>
                    <td style="padding: 10px; border-width: 3px; text-align: center; " >
                      <b>مساحة مخصصة للمعني بالأمر</b>
                    </td>
                  </tr> 

                  <tr>
                    <td style="padding: 5px; border-width: 3px; text-align: right; vertical-align: top !important;">
                      <ul>
                        <li>توضع العلامة – من 0 الى 10 تم تقدم الاستمارة الى المعني بالأمر ليطلع عليها </li>
                        <br>
                        <li>التقدير العام –في الخلف – لا يدرج في الاستمارة إلا بعد إطلاع المعني بالأمر عليها</li>
                      </ul>
                    </td>
                    <td style="padding: 5px; border-width: 3px; text-align: right; ">
                      <ul>
                        <li>يجوز للمعني بالأمر أن يبدي ملاحظته أو ان يطلب :
                          <ol>
                            <li>
                              توضيحات حول الاستمارة.
                            </li>
                            <li>
                              البيانات المتعلقة بوضعيته و المهام التي أكتر  ملائمة لكفاءته إذا اقتضى الأمر ذلك.
                            </li>
                          </ol>
                          ............................................................... ............................................................... ...............................................................
                          <br><br>
                          يصرح المعني بالأمر أنه اطلع على علامته
                             <div style="text-align: left;">التوقيع &emsp;&emsp;</div>
                        </li>
                        
                      </ul>
                    </td>
                  </tr> 
                </table>

                <br><br><br><br><br><br><br><br><br>
                &emsp;&emsp; التقدير العام للقائم بالتنقيط:
                &emsp;&emsp;..................................................................................................................................................................               
                &emsp;&emsp;......................................................
                <br><br>
                &emsp;&emsp; تنبيه:
                <br>
                <ul style="padding-right: 100px;">
                  <li>
                    هذا التقدير يجب الا يكون مخالفا لتقدير  العلامة السابقة – الوجه الأول – 
                  </li>
                  <li>
                    جب ان يعبر – خاصة – على كفاءة المعني بالأمر لممارسة بعض الوظائف ذات طابع المسؤولية او يناسب رتبة أعلى
                  </li>
                </ul>
                <br>
                <div style="text-align: left;">اسم و صفة السلطة ذات الحق في التنقيط  &emsp;&emsp;</div>
                <br>
                <hr>
                <br>
                &emsp;&emsp; رأي اللجنة المتساوية الأعضاء:
                <br><br>
                <ul style="padding-right: 75px;">
                  <li>
                    اطلعت اللجنة على العلامة و التقدير العام في جلستها المنعقدة يوم.................................
                  </li>
                  <li>
                    تطلب اللجنة من السلطة التي لها صلاحية التنقيط بموجب المادة 33 من الأمر رقم 66-133المؤرخ في 1966/06/02 بمراجعة النقاط التالية:
                  </li>
                </ul>
                &emsp;&emsp;..................................................................................................................................................................               
                &emsp;&emsp;......................................................
                <br>
                <br>
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;الرئيس  &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;الكاتب
                <br><br>
                <hr>
                <br><br>
                &emsp;&emsp; رد السلطة التي لها صلاحيات التنقيط عن طلب الداعي إلي مراجعة التنقيط
                <br><br>
                &emsp;&emsp;..................................................................................................................................................................   
                &emsp;&emsp;..................................................................................................................................................................            
                &emsp;&emsp;......................................................
                <br><br><br>
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;التوقيع
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
                <h5 style="text-align: right;">&emsp;&emsp;المرجع:  <?php echo (" " . $_POST['num']); ?>
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;باب الزوار في: <?php echo (" " . date("Y/m/d")); ?>&emsp;</h5>
                <br><br>
              <h1 style="text-align: center; margin-top: 10px;" ><?php echo ("إعـــــــــــــــــــــــــــــذار " . $_POST['ud']); ?></h1></p>
              <p style="font-size: 18px;"><h4><br>&emsp; &emsp;&emsp;&emsp;  &emsp;&emsp;&emsp;      <br><br><br></h4></p><p ><h4 style="text-align: right !important; font-size: 30px;">
                &emsp;&emsp;
              <?php
              if ($result['sexe'] == 1){
                echo "إلى السيد : ";

              }elseif($result['SitFam'] == 1) {
                echo "إلى السيدة : ";

              }

              ?><?php echo (" " . $result["NomAr"] . " " .$result["PrenomAr"] . " "); if (isset($result3)) echo ("زوجة  " . $result3['NomMA'] . " "); ?> <br><br>
              &emsp;&emsp;&emsp;&emsp; يشرفني أن أطلب منكم مزاولة وظيفتكم خلال 48 ساعة وإلا ستعتبرون في حالة غياب<br>&emsp;&emsp;&emsp;&emsp;غير شرعي عن المنصب مع إحتمال تطبيق القوانين سارية المفعول.
              <br><br>
              <div style="text-align: left;">تقبلوا مني فائق الاحترام والتقدير &emsp;&emsp;</div>
              </h4>
              <br><br><br><br>
              <h2 style="text-align: left;">عن/ عميد الجامعة &emsp;&emsp;&emsp;</h2>
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
                <h3 style="text-align: right;">&emsp;&emsp;وزارة التعليم العالي والبحث العلمي
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;مديرية الموظفين
                <br> <br>
                &emsp;جامعة هواري بومدين للعلوم والتكنولوجيا
                <br><br><br><br>
              <h1 style="text-align: center; margin-top: 10px;" ><b><u>استمارة نهاية التربص</u></b></h1></p>
              <p style="font-size: 16px;"><h4><br>&emsp; &emsp;&emsp;&emsp;  &emsp;&emsp;&emsp; <br></h4></p><p ><h4 style="text-align: right !important; font-size: 25px;">
              &emsp;&emsp;<?php echo ("اللقب:&emsp; " . $result["NomAr"] . "&emsp;&emsp; الاسم:&emsp; " .$result["PrenomAr"] . " "); if (isset($result3)) echo ("&emsp;&emsp;زوجة  " . $result3['NomMA'] . " "); ?> <br><br>
              &emsp;&emsp;الحالة العائلية: <?php if ($result['sexe'] == 1 && $result['SitFam'] == 1){ echo "&emsp; أعزب";}elseif ($result['sexe'] == 1 && $result['SitFam'] == 2) {echo "&emsp; متزوج";}elseif ($result['sexe'] == 2 && $result['SitFam'] == 2) echo "&emsp; متزوجة "; else echo "&emsp; عزباء ";?> <br><br>
              &emsp;&emsp;تاريخ التعيين: <?php echo date_format(date_create_from_format('Y-m-d', $result["DateIN"]),"Y/m/d");?> <br><br>
              &emsp;&emsp;مكان التيين: <?php echo "قسم الإعلام الآلي";?> <br><br>
              </h4>
              <br>
              <h4 style="text-align: center; font-size: 30px"><b><u>العطل المأجورة إضافة إلى العطلة السنوية التي استفاد منها المعني </u></b><br><br>

                من ..................... إلى ....................... أي .................. أيام<br>
                من ..................... إلى ....................... أي .................. أيام<br>
                من ..................... إلى ....................... أي .................. أيام<br>
                من ..................... إلى ....................... أي .................. أيام<br>
              </h4><br><br><br>

              <table border="1" width="86%" style="margin-left: 7%; margin-right: 7%; font-size: 23px; font-family: Times, 'Times New Roman', Georgia, serif !important;">
                    <tr>
                      <td style="padding: 5px; border-width: 0px; text-align: center; ">
                         
                      </td>

                      <td style="padding: 5px; border-width: 2px; text-align: center; ">
                         جيد
                      </td>
                      <td style="padding: 5px; border-width: 2px; text-align: center; ">
                         فوق المتوسط
                      </td>
                      <td style="padding: 5px; border-width: 2px; text-align: center; ">
                         متوسط
                      </td>
                      <td style="padding: 5px; border-width: 2px; text-align: center; ">
                         عادي
                      </td>
                      <td style="padding: 5px; border-width: 2px; text-align: center; ">
                         دون العادي
                      </td>
                      
                    </tr>
                      
                    <tr>
                      <td style="padding: 5px; border-width: 2px; text-align: right;">
                         القدرة على الانسجام والإستيعاب
                      </td>
                      <td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td>
                    </tr>
                    <tr>
                      <td style="padding: 5px; border-width: 2px; text-align: right;">
                         المبادرة
                      </td>
                      <td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td>
                    </tr>
                    <tr>
                      <td style="padding: 5px; border-width: 2px; text-align: right;">
                         النشاط والمردودية
                      </td>
                      <td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td>
                    </tr>
                    <tr>
                      <td style="padding: 5px; border-width: 2px; text-align: right;">
                         إعطاء الأهمية لوظائفه
                      </td>
                      <td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td>
                    </tr>
                    <tr>
                      <td style="padding: 5px; border-width: 2px; text-align: right;">
                         الكفاءة المهنية
                      </td>
                      <td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td><td style="padding: 5px; border-width: 2px; text-align: right;"></td>
                    </tr>
                               
                  </table>
                  <br><br>
                  <h4 style="text-align: right !important; font-family: Times, 'Times New Roman', Georgia, serif !important; font-weight: bold;">
                  &emsp;&emsp;&emsp;كفاءات خاصة:  &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; الجزائر في  <?php echo (" " . date("Y/m/d")); ?> <br><br>
                  &emsp;&emsp;&emsp;معلومات إضافية:<br><br>
                  &emsp;&emsp;&emsp;التقديرات العامة والإقتراح: &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; المسؤول المباشر
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
              $Trt = "Etablissement d'une decision de Maternité";
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
              $Trt = "Effecuation d'un Congé de maladie";
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

                &emsp;&emsp;&emsp; La Doyenne de la faculté d'Electronique et d'Informatique de l'Université des Sciences<br>&emsp;&emsp;  et de la technolgie Houari Boumediene <br><br>

                &emsp;&emsp;&emsp; Vu la loi N° 83 - 11 du 02 juillet 1983 relative aux assurances sociales notament ses <br>&emsp;&emsp;articles 14 et suivants<br><br>

                &emsp;&emsp;&emsp; Vu la loi N° 83 - 27 du 11 02 1984 fixant les modalités d'application de la loi N° 83 - 11 <br>&emsp;&emsp;du 02 juillet 1983 relative aux assurances sociales : <br><br>

                &emsp;&emsp;&emsp; Vu Le Certificat Médical en date Du <b><?php echo (" " . date_format(date_create_from_format('Y-m-d', $_POST["dsm"]),"d/m/Y") . " "); ?> </b> Prescrivant un Arret de Travail d'une <br>&emsp;&emsp;durrée de <b><?php echo (" " . $_POST["dur"] . " "); ?></b> Jours A <?php if ($result['sexe'] == 1){ echo "Mr : ";}elseif($result['SitFam'] == 1) {echo "Mlle : ";}else echo "Mme : ";?><b><?php echo (" " . $result["NomFr"] . " " .$result["PrenomFr"] . " "); if (isset($result3)) echo ("Ep " . $result3['NomM'] . " "); ?></b> Grade <b><?php echo (" " . $result["GradeFr"] . " "); ?></b> A la Faculté d'Eletronique et d'Informatique<br><br>

                <h2 style="text-align: center; font-family: Times, 'Times New Roman', Georgia, serif !important;">-=oOo=-<u>DECIDE</u>-=oOo=-</h2>
                <h4 style="font-family: Times, 'Times New Roman', Georgia, serif !important;">
                &emsp;&emsp;&emsp;<b><u>Act 1:</u></b><br>

                &emsp;&emsp;&emsp; Un Congé de Maternité d'une durrée de <b><?php echo (" " . $_POST["dur"] . " "); ?></b> Jours est octoyé à <?php if ($result['sexe'] == 1){ echo "Mr : ";}elseif($result['SitFam'] == 1) {echo "Mlle : ";}else echo "Mme : ";?><b><?php echo (" " . $result["NomFr"] . " " .$result["PrenomFr"] . " "); if (isset($result3)) echo ("Ep " . $result3['NomM'] . " "); ?></b> Grade <b><?php echo (" " . $result["GradeFr"] . " "); ?></b> Durant la période du <?php echo (" " . date_format(date_create_from_format('Y-m-d', $_POST["db"]),"d/m/Y") . " "); ?> &emsp;
                Au: <?php echo (" " . date_format(date_create_from_format('Y-m-d', $_POST["df"]),"d/m/Y") . " "); ?> Inclus<br><br>

                &emsp;&emsp;&emsp;<b><u>Act 2:</u></b><br>
                
                &emsp;&emsp;&emsp; Le salaire de poste de l'intéressé est suspendu pour la periode du <?php echo (" " . date_format(date_create_from_format('Y-m-d', $_POST["db"]),"d/m/Y") . " "); ?> &emsp;
                Au: <?php echo (" " . date_format(date_create_from_format('Y-m-d', $_POST["df"]),"d/m/Y") . " "); ?> Inclus, et sont pris en charge par la caisse de la sécurité sociale compétente conformément à la légistation et à la règlementation en viqueur<br><br>

                &emsp;&emsp;&emsp;<b><u>Act 3:</u></b><br>
                
                &emsp;&emsp;&emsp; Le Directeur du Budget et le Directeur des Personnels dont chargés chacun en ce le concerne à l'éxécution de présente décision <br><br><br><br></h4>

              <h3 style="text-align: center; font-family: Times, 'Times New Roman', Georgia, serif !important;"><b><u>SECRETAIRE GENERAL DE LA FACULTE</u></b></h3>
              <h3 style="text-align: center; font-family: Times, 'Times New Roman', Georgia, serif !important;"><b><u>ELECTRONIQUE ET INFORMATIQUE</u></b></h3>
            </p>
            </div>
            <?php 
          } else  
            $_SESSION['error'] = "Vous ne pouvez pas etablire une decision de maternité pour un homme!!!" ;
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
              $Trt = "Effectuation d'un Congé de maladie";
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

                &emsp;&emsp;&emsp; La Doyenne de la faculté d'Electronique et d'Informatique de l'Université des Sciences et de la<br>&emsp;&emsp;technolgie Houari Boumediene <br><br>

                &emsp;&emsp;&emsp; Vu la loi N° 83 - 11 du 02 juillet 1983 relative aux assurances sociales notament ses articles 14 et <br>&emsp;&emsp;suivants<br><br>

                &emsp;&emsp;&emsp; Vu la loi N° 83 - 27 du 11 02 1984 fixant les modalités d'application de la loi N° 83 - 11 du <br>&emsp;&emsp;02 juillet 1983 relative aux assurances sociales : <br><br>

                &emsp;&emsp;&emsp; Vu Le Certificat Médical en date Du <b><?php echo (" " . date_format(date_create_from_format('Y-m-d', $_POST["dsm"]),"d/m/Y") . " "); ?> </b> Prescrivant un Arret de Travail d'une durrée <br>&emsp;&emsp;de  <b><?php echo (" " . $_POST["dur"] . " "); ?></b> Jours A <?php if ($result['sexe'] == 1){ echo "Mr : ";}elseif($result['SitFam'] == 1) {echo "Mlle : ";}else echo "Mme : ";?><b><?php echo (" " . $result["NomFr"] . " " .$result["PrenomFr"] . " "); if (isset($result3)) echo ("Ep " . $result3['NomM'] . " "); ?></b> Grade <b><?php echo (" " . $result["GradeFr"] . " "); ?></b> A la Faculté d'Eletronique et <br>&emsp;&emsp; d'Informatique<br><br><br>

                <h2 style="text-align: center; font-family: Times, 'Times New Roman', Georgia, serif !important;" >-=oOo=-<u>DECIDE</u>-=oOo=-</h2>
                <h4 style="font-family: Times, 'Times New Roman', Georgia, serif !important;">
                &emsp;&emsp;&emsp;<b><u>Act 1:</u></b><br>

                &emsp;&emsp;&emsp; Un Congé de Maladie d'une durrée de <b><?php echo (" " . $_POST["dur"] . " "); ?></b> Jours est octoyé à <?php if ($result['sexe'] == 1){ echo "Mr : ";}elseif($result['SitFam'] == 1) {echo "Mlle : ";}else echo "Mme : ";?><b><?php echo (" " . $result["NomFr"] . " " .$result["PrenomFr"] . " "); if (isset($result3)) echo ("Ep " . $result3['NomM'] . " "); ?></b><br>&emsp;&emsp;Grade <b><?php echo (" " . $result["GradeFr"] . " "); ?></b> Durant la période du <?php echo (" " . date_format(date_create_from_format('Y-m-d', $_POST["db"]),"d/m/Y") . " "); ?> &emsp;
                Au: <?php echo (" " . date_format(date_create_from_format('Y-m-d', $_POST["df"]),"d/m/Y") . " "); ?> Inclus<br><br>

                &emsp;&emsp;&emsp;<b><u>Act 2:</u></b><br>
                
                &emsp;&emsp;&emsp; Le salaire de poste de l'intéressé est suspendu pour la periode du <?php echo (" " . date_format(date_create_from_format('Y-m-d', $_POST["db"]),"d/m/Y") . " "); ?> &emsp;
                Au: <?php echo (" " . date_format(date_create_from_format('Y-m-d', $_POST["df"]),"d/m/Y") . " "); ?><br>&emsp;&emsp;Inclus, et sont pris en charge par la caisse de la sécurité sociale compétente conformément à la <br>&emsp;&emsp;légistation et à la règlementation en viqueur<br><br>

                &emsp;&emsp;&emsp;<b><u>Act 3:</u></b><br>
                
                &emsp;&emsp;&emsp; Le Directeur du Budget et le Directeur des Personnels dont chargés chacun en ce le concerne à &emsp;&emsp;l'éxécution de présente décision <br><br><br><br></h4>

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
              $Trt = "Etablissement d'une Decision de suspension de rémunération";
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

                &emsp;&emsp;&emsp; La Doyenne de la faculté d'Electronique et d'Informatique de l'USTHB. <br>

                &emsp;&emsp;&emsp; Vu la loi N° 78 - 12 du 06 Aout relative aux status général des travailleurs<br><br>

                <h2 style="text-align: center; font-family: Times, 'Times New Roman', Georgia, serif !important;" ><u>DECIDE</u></h2><br>
                <h4 style="font-family: Times, 'Times New Roman', Georgia, serif !important;">
                &emsp;&emsp;&emsp;<b><u>Article 1:</u></b><br><br>

                &emsp;&emsp;&emsp; La rémunération de <?php if ($result['sexe'] == 1){ echo "Mr : ";}elseif($result['SitFam'] == 1) {echo "Mlle : ";}else echo "Mme : ";?><b><?php echo (" " . $result["NomFr"] . " " .$result["PrenomFr"] . " "); if (isset($result3)) echo ("Ep " . $result3['NomM'] . " "); ?></b> <br>
                &emsp;&emsp;&emsp; Fonction: <b><?php echo (" " . $result["GradeFr"] . " "); ?></b> <br>
                &emsp;&emsp;&emsp; Est suspendu <?php if($_POST["db"] == $_POST["df"]){echo (" La Journée du " . date_format(date_create_from_format('Y-m-d', $_POST["db"]),"d/m/Y") . " "); }else echo ("du  " . date_format(date_create_from_format('Y-m-d', $_POST["db"]),"d/m/Y") . " Au " . date_format(date_create_from_format('Y-m-d', $_POST["df"]),"d/m/Y")); ?><br><br><br>
                <?php
                $nbr = date_diff(date_create_from_format('Y-m-d', $_POST["db"]),date_create_from_format('Y-m-d', $_POST["df"]));
                $i=$nbr->format("%a");
                $i=$i+1;
                ?>
                &emsp;&emsp;&emsp; Nombre de jours de suspension : <?php echo (" " . $i . " jours"); ?><br>
                &emsp;&emsp;&emsp; Pour motifs suivants : <?php echo (" " . $_POST['motif'] . " "); ?><br><br><br>
                &emsp;&emsp;&emsp;<b><u>Article 2:</u></b><br><br>
                
                &emsp;&emsp;&emsp; Le Directeur du Budget de fonctionnement et de l'agent comptable accrédité auprès de l'USTHB <br>&emsp;&emsp;sont chargés chacun en ce le concerne, de l'éxécution de présente décision <br><br><br><br></h4>

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

              <h1 style="text-align: center; margin-top: 10px; font-family: Times, 'Times New Roman', Georgia, serif !important;" ><u><?php if (isset($_POST['pvi'])) echo "محضر مباشرة العمل"; else echo "محضر استئناف العمل"; ?></u></h1></p>
              <p style="font-size: 18px;"><h4>&emsp; &emsp;&emsp;&emsp;  &emsp;&emsp;&emsp;     <br><br></h4></p>
              <p style="font-size: 18px;"><h4>&emsp; &emsp;&emsp;&emsp;  &emsp;&emsp;&emsp;     <br><br></h4></p><p ><h4 style="text-align: right !important; font-family: Times, 'Times New Roman', Georgia, serif !important;">

                <table border="0" width="95%" style="margin-left: 2%; margin-right: 5%; font-size: 23px; font-family: Times, 'Times New Roman', Georgia, serif !important;">
                  <tr>
                    <td style="padding: 5px; border-width: 0px; text-align: right; " width="50%">
                        &emsp;السنة الجامعية: 2018/2017<br><br> <br>
                        &emsp;اللقب:  <b><?php echo ("&emsp; " . $result["NomAr"] . " "); if (isset($result3)) {echo ("</b>&emsp;&emsp;&emsp; اللقب الأصليز  &emsp;<b>" . $result3['NomMA'] );}  ?></b> <br><br> 
                        &emsp;تاريخ ومكان الازدياد: <b><?php echo ("&emsp; " . date_format(date_create_from_format('Y-m-d', $result["DateN"]),"Y/m/d")); ?></b> <br><br>
                        &emsp;الرتبة: <b><?php echo ("&emsp; " . $result["GradeAr"]); ?> </b><br><br>
                        &emsp;رقم البطاقة المهنية: <b><?php echo (" &emsp;" . $result["NumIdProf"]); ?></b> <br> <br>
                      </td>

                      <td>
                        &emsp;و بتاريخ  : <?php  echo (date("Y/m/d")); ?><br><br><br>  
                        &emsp;<?php echo( "الاسم:    &emsp;<b>" . $result["PrenomAr"]); ?></b> <br><br>
                        &emsp;<?php echo ("ب :&emsp;<b>" . $result["LieuNAR"]); ?></b> <br><br>
                        &emsp;الوظيفة: <b><?php echo (" &emsp;" . $result["FonctionAr"] . " "); ?></b> <br> <br>
                        &emsp;الهاتف:<b><?php echo (" &emsp;" . $result["NumTel"] . " "); ?></b> <br> <br>
                      </td>
                    </tr>
                  </table>
        
                &emsp;&emsp;&emsp; العنوان الشخصي :<b><?php echo (" &emsp; " . $result["AdresseAr"] . " "); ?></b><br><br>

                &emsp;&emsp;&emsp; <b><u>الوضعية الإدارية  :</u></b>  &emsp;<?php 
                  if ($result['SitAdm'] == 1) {
                    echo "متربص";;
                  }elseif ($result['SitAdm'] == 2) {
                    echo "متعاقد";
                  }elseif ($result['SitAdm'] == 3) {
                    echo "مرسم";
                  }elseif ($result['SitAdm'] == 4) {
                    echo "مؤقت";
                  }

                 ?>

                 <br><br>
                 &emsp;&emsp;&emsp; <b><u>االوضعية العائلية  : </u></b> &emsp;<?php 
                  if ($result['SitFam'] == 1) {
                    echo "أعزب";;
                  }else{
                    echo "متزوج" . " " . "&emsp;&emsp;&emsp; عدد الأطفال : " . $result2['nbrEnf'];
                  }
                 ?>
                 <br><br>
                 &emsp;&emsp;&emsp; يشهد عميد الكلية، مسؤول المصلحة، بأن   
                  <?php 
                    if ($result['sexe'] == 1){
                      echo " السيد : ";

                    }elseif($result['SitFam'] == 1) {
                      echo " السيدة : ";

                    }else echo " الآنسة : ";
                  
                  echo ("<b> " . $result["NomAr"] . " " . $result["PrenomAr"]); 
                  if (isset($result3)) {echo ("زوجة" . $result3['NomMA'] );}

                  ?></b><br>

                  &emsp;&emsp;&emsp; قد <?php if (isset($_POST['pvi'])) echo ("باشر العمل ابتداء من  &emsp;" . date("Y/m/d") . "&emsp;بعد توظيف جديد"); 
                  else {

                    echo ("د استئنف العمل ابتداء من " . date("Y/m/d") . "&emsp;بعد &emsp;")  ;
                    if ($_POST['ud'] == 1) {
                      echo "عطلة";
                    }elseif ($_POST['ud'] == 2) {
                      echo "عطلة مرضية";
                    }elseif ($_POST['ud'] == 3) {
                      echo "عطلة أمومة";
                    }elseif ($_POST['ud'] == 4) {
                      echo "انتداب";
                    }elseif ($_POST['ud'] == 5) {
                      echo "إحال ة على الاستيداع;";
                    }elseif ($_POST['ud'] == 6) {
                      echo "الخمدة الوطنية;";
                    }

                  }

                   ?>

                  

              </h4>
                <h3 style="text-align: right;"><br><br><br><br>&emsp;&emsp;&emsp;<b><u>السلطة السلمية</u></b>&emsp;&emsp;&emsp; &emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp; &emsp;&emsp;&emsp;<b><u> الموظف</u></b></h3>
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
              <h1 style="text-align: center; margin-top: 10px; font-family: Times, 'Times New Roman', Georgia, serif !important;" ><u><?php if (isset($_POST['pvie'])) echo "محضر مباشرة العمل الخاص بالمستخدمين المدرسين"; else echo "محضر استئناف العمل الخاص بالمستخدمين المدرسين"; ?></u></h1></p><br>
              <p ><h4 style="text-align: right !important; font-family: Times, 'Times New Roman', Georgia, serif !important;">

                <table border="0" width="95%" style="margin-left: 2%; margin-right: 5%; font-size: 23px; font-family: Times, 'Times New Roman', Georgia, serif !important;">
                  <tr>
                    <td style="padding: 5px; border-width: 0px; text-align: right; " width="50%">
                        &emsp;السنة الجامعية: 2018/2017<br><br> <br>
                        &emsp;اللقب:  <b><?php echo ("&emsp; " . $result["NomAr"] . " "); if (isset($result3)) {echo ("</b>&emsp;&emsp;&emsp; اللقب الأصليز  &emsp;<b>" . $result3['NomMA'] );}  ?></b> <br><br> 
                        &emsp;تاريخ ومكان الازدياد: <b><?php echo ("&emsp; " . date_format(date_create_from_format('Y-m-d', $result["DateN"]),"Y/m/d")); ?></b> <br><br>
                        &emsp;الرتبة: <b><?php echo ("&emsp; " . $result["GradeAr"]); ?> </b><br><br>
                        &emsp;رقم البطاقة المهنية: <b><?php echo (" &emsp;" . $result["NumIdProf"]); ?></b> <br> <br>
                      </td>

                      <td>
                        &emsp;و بتاريخ  : <?php  echo (date("Y/m/d")); ?><br><br><br>  
                        &emsp;<?php echo( "الاسم:    &emsp;<b>" . $result["PrenomAr"]); ?></b> <br><br>
                        &emsp;<?php echo ("ب :&emsp;<b>" . $result["LieuNAR"]); ?></b> <br><br>
                        &emsp;الوظيفة: <b><?php echo (" &emsp;" . $result["FonctionAr"] . " "); ?></b> <br> <br>
                        &emsp;الهاتف:<b><?php echo (" &emsp;" . $result["NumTel"] . " "); ?></b> <br> <br>
                      </td>
                    </tr>
                  </table>
        
                &emsp;&emsp;&emsp; العنوان الشخصي :<b><?php echo (" &emsp; " . $result["AdresseAr"] . " "); ?></b><br><br>

                &emsp;&emsp;&emsp; <b><u>الوضعية الإدارية  :</u></b>  &emsp;<?php 
                  if ($result['SitAdm'] == 1) {
                    echo "متربص";;
                  }elseif ($result['SitAdm'] == 2) {
                    echo "متعاقد";
                  }elseif ($result['SitAdm'] == 3) {
                    echo "مرسم";
                  }elseif ($result['SitAdm'] == 4) {
                    echo "مؤقت";
                  }

                 ?>

                 <br><br>
                 &emsp;&emsp;&emsp; <b><u>االوضعية العائلية  : </u></b> &emsp;<?php 
                  if ($result['SitFam'] == 1) {
                    echo "أعزب";;
                  }else{
                    echo "متزوج" . " " . "&emsp;&emsp;&emsp; عدد الأطفال : " . $result2['nbrEnf'];
                  }
                 ?>
                 <br><br>
                 &emsp;&emsp;&emsp; يشهد عميد الكلية، مسؤول المصلحة، بأن   
                  <?php 
                    if ($result['sexe'] == 1){
                      echo " السيد : ";

                    }elseif($result['SitFam'] == 1) {
                      echo " السيدة : ";

                    }else echo " الآنسة : ";
                  
                  echo ("<b> " . $result["NomAr"] . " " . $result["PrenomAr"]); 
                  if (isset($result3)) {echo ("زوجة" . $result3['NomMA'] );}

                  ?></b><br>

                  &emsp;&emsp;&emsp; قد <?php if (isset($_POST['pvie'])) echo ("باشر العمل ابتداء من  &emsp;" . date("Y/m/d") . "&emsp;بعد توظيف جديد"); 
                  else {

                    echo ("د استئنف العمل ابتداء من " . date("Y/m/d") . "&emsp;بعد &emsp;")  ;
                    if ($_POST['ud'] == 1) {
                      echo "عطلة";
                    }elseif ($_POST['ud'] == 2) {
                      echo "عطلة مرضية";
                    }elseif ($_POST['ud'] == 3) {
                      echo "عطلة أمومة";
                    }elseif ($_POST['ud'] == 4) {
                      echo "انتداب";
                    }elseif ($_POST['ud'] == 5) {
                      echo "إحال ة على الاستيداع;";
                    }elseif ($_POST['ud'] == 6) {
                      echo "الخمدة الوطنية;";
                    }

                  }

                   ?>
                   <br><br>
                   <table border="1" width="86%" style="margin-left: 7%; margin-right: 7%; font-size: 23px; font-family: Times, 'Times New Roman', Georgia, serif !important;">
                    <tr>
                      <td style="padding: 5px; border-width: 1px; text-align: right; " rowspan="2">
                         حصة
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right; " colspan="4">
                         المقرر
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right; " rowspan="2">
                         اليوم
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right; " rowspan="2">
                         الساعة
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right; " rowspan="2">
                         القاعة(2)
                      </td>
                      
                    </tr>
                      
                    <tr>
                      <td style="padding: 5px; border-width: 1px; text-align: right;">
                         العنوان
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right;">
                         درس(1)
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right;">
                         الموجهة
                      </td>
                      <td style="padding: 5px; border-width: 1px; text-align: right;">
                         التطبيقية
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
                  <div style="font-size: 16px"> &emsp;&emsp;&emsp; &emsp;(1 ) ضع علامة أمام الخانة المناسبة، ( 2 ) تحدد من طرف المعهد </div>
              </h4>
                <h3 style="text-align: right;"><br><br>&emsp;&emsp;&emsp;<b><u>السلطة السلمية</u></b>&emsp;&emsp;&emsp; &emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp; &emsp;&emsp;&emsp;<b><u> الموظف</u></b></h3>
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
