<?php 
session_start();
      

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

        switch ($_POST['submit']) {

            case 'Connexion':

                $getuser = $bd->prepare('SELECT * FROM users WHERE NomU = ?');
                $getuser->execute([$_POST['username']]);
                $row = $getuser->fetch();
                if (password_verify($_POST['password'], $row['MotDePasse'])) {
                    $_SESSION['login_user'] = $_POST['username'];
                    $_SESSION['Permission'] = $row['Permission'];
                    $_POST = array();
                    header("location: employe.php");
                    echo 'Success.';
                    exit();
                } else {
                    $_SESSION['error'] = "Vorte Nom d'utilisateur ou mot De Passe est faux";
                    $_POST = array();
                    header("location: login.php");
                }
                break;


            case 'Ajouter':

                if(!isset($_SESSION['login_user']) || empty($_SESSION['login_user'])){

                    header("location: login.php");
                    exit;
                }

                if (empty($_POST['dateN'])){

                    $_SESSION['error'] = "Vous devez introduire une date de naissance valable";
                    $_POST = array();
                    header("location: employe.php");
                }

                $time1 = date('Y-m-d',strtotime($_POST['dateN']));
                $time2 = date('Y-m-d',strtotime('-18 year'));

                if ($time1 > $time2)  {

                    $_SESSION['error'] = "L'employé doit avoir plus de 18 ans!!!";
                    $_POST = array();
                    header("location: employe.php");
                    exit();
                }

                if (empty($_POST['dateIN'])) {

                    $_SESSION['error'] = "Vous devez introduire une date d'instalation au poste";
                    $_POST = array();
                    header("location: employe.php");
                    exit();
                }

                $time1 = date('Y-m-d',strtotime($_POST['dateIN']));
                $time2 = date('Y-m-d',strtotime("now"));

                if ($time1 > $time2)  {

                    $_SESSION['error'] = "Date d'instalation non valide!!!";
                    $_POST = array();
                    header("location: employe.php");
                    exit();
                }

                $sql = "SELECT count(*) FROM employe WHERE NomFr = ? and PrenomFr =  ? and NumIdProf =  ?";
                $stmt = $bd->prepare($sql);
                $stmt->execute([$_POST['nomF'],$_POST['prenomF'],$_POST['idP']]);
                $result = $stmt->fetchColumn();

                if ($result == 0) {
                    
                    $sql = "INSERT INTO employe(NomFr, NomAr, PrenomFr, PrenomAr, DateN, LieuNFR, LieuNAR,FonctionFr, FonctionAr, GradeFr, GradeAr, AdresseFR, AdresseAr, NumIdProf, NumTel,SitFam,sexe,SitAdm,Echellon,DateDE,Diplome,DateIN) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

                    $stmt = $bd->prepare($sql);

                    $stmt->execute([$_POST['nomF'],$_POST['nomA'],$_POST['prenomF'], $_POST['prenomA'], $_POST['dateN'], $_POST['lieuF'], $_POST['lieuA'], $_POST['fonctionF'], $_POST['fonctionA'], $_POST['gradeF'], $_POST['gradeA'], $_POST['adrF'], $_POST['adrA'], $_POST['idP'], $_POST['tel'], $_POST['stF'],$_POST['sexe'],$_POST['stA'], $_POST['ech'],$_POST['dateDE'],$_POST['dip'],$_POST['dateIN']]);

                    $sql = "SELECT idEmploye FROM employe WHERE NomFr = ? and PrenomFr =  ? and NumIdProf =  ?";
                    $stmt = $bd->prepare($sql);
                    $stmt->execute([$_POST['nomF'],$_POST['prenomF'],$_POST['idP']]);
                    $id = $stmt->fetchColumn();

                    $sql = "SELECT CodeU FROM users WHERE NomU = ? ";
                    $stmt = $bd->prepare($sql);
                    $stmt->execute([$_SESSION['login_user']]);
                    $id2 = $stmt->fetchColumn();

                    $sql = "INSERT INTO historique(CodeU, CodeE , Traitement, dateH) VALUES (?,?,?)";

                    $stmt = $bd->prepare($sql);
                    $Trt = "Ajouter L'employé a la base de données";
                    $date = date("Y-m-d H:i:s", strtotime("+1 hours"));
                    $stmt->execute([$id2,$id,$Trt,$date]);



                    if ($_POST['stF'] == 2){
                      
                      $stmt = $bd->prepare("INSERT INTO marie VALUES (?,?)");
                      $stmt->execute([$id,$_POST['nbE']]);

                      if ($_POST['sexe'] == 2) {

                        $stmt = $bd->prepare("INSERT INTO fmarie VALUES (?,?,?,?)");
                        $stmt->execute([$id,$_POST['nomFMF'],$_POST['nomFMA']]);

                      }
                    }

                    $_SESSION['info'] = "L'employé a été Ajouter Avec Succes";
#                    unset($_SESSION['error']);
               
                }else {
                    $_SESSION['error'] = "Ce Employé Existe Deja";
                    unset($_SESSION['info']);
                }
          
                $_POST = array();
                header("location: employe.php");
                exit();
                break;



            case 'Modifier':
            
                if(!isset($_SESSION['login_user']) || empty($_SESSION['login_user'])){

                header("location: login.php");
                exit;
                }

                $sql = "SELECT * FROM employe WHERE NomFr = ? and PrenomFr =  ? and NumIdProf =  ?";
                $stmt = $bd->prepare($sql);
                $stmt->execute([$_POST['nomFex'],$_POST['prenomFex'],$_POST['idPex']]);
                $id = $stmt->fetch();
                if ($id != null) {
                
                    $sql = "UPDATE  employe SET NomFr = ?, NomAr = ?, PrenomFr = ?, PrenomAr = ?, DateN = ?, LieuNFR = ?, LieuNAR = ?,FonctionFr = ?, FonctionAr = ?, GradeFr = ?, GradeAr = ?, AdresseFR = ?, AdresseAr = ?, NumIdProf = ?, NumTel = ?,SitFam = ?,sexe = ?, SitAdm = ? ,Echellon = ? ,DateDE = ?, diplome = ? WHERE idEmploye = ?";

                    $stmt = $bd->prepare($sql);

                    $stmt->execute([$_POST['nomF'],$_POST['nomA'],$_POST['prenomF'], $_POST['prenomA'], $_POST['dateN'], $_POST['lieuF'], $_POST['lieuA'], $_POST['fonctionF'], $_POST['fonctionA'], $_POST['gradeF'], $_POST['gradeA'], $_POST['adrF'], $_POST['adrA'], $_POST['idP'], $_POST['tel'], $_POST['stF'],$_POST['sexe'],$_POST['stA'],$_POST['ech'],$_POST['dateDE'],$_POST['dip'],$id['idEmploye']]);

                    $sql = "SELECT CodeU FROM users WHERE NomU = ? ";
                    $stmt = $bd->prepare($sql);
                    $stmt->execute([$_SESSION['login_user']]);
                    $id2 = $stmt->fetchColumn();

                    $sql = "INSERT INTO historique(CodeU, CodeE , Traitement, dateH) VALUES (?,?,?,?)";
                    $date = date("Y-m-d H:i:s");
                    $stmt = $bd->prepare($sql);

                    if ($_POST['nomF'] !== $id['NomFr']){
                        $Trt = "Modification du nom d'employé de " . $id['NomFr'] ." à " .$_POST['nomF'];
                        $stmt->execute([$id2,$id['idEmploye'],$Trt,$date]);
                    }

                    if ($_POST['nomA'] !== $id['NomAr']){
                        $Trt = "Modification du nom d'employé de " . $id['NomAr'] ." à " .$_POST['nomA'];
                        $stmt->execute([$id2,$id['idEmploye'],$Trt,$date]);
                    }
                    if ($_POST['prenomF'] !== $id['PrenomFr']){
                        $Trt = "Modification du prenom d'employé de " . $id['PrenomFr'] ." à " .$_POST['prenomF'];
                        $stmt->execute([$id2,$id['idEmploye'],$Trt,$date]);
                    }
                    if ($_POST['prenomA'] !== $id['PrenomAr']){
                        $Trt = "Modification du prenom d'employé de " . $id['PrenomAr'] ." à " .$_POST['prenomA'];
                        $stmt->execute([$id2,$id['idEmploye'],$Trt,$date]);
                    }
                    if ($_POST['dateN'] !== $id['DateN']){
                        $Trt = "Modification de la date de naissance d'employé de " . $id['DateN'] ." à " .$_POST['dateN'];
                        $stmt->execute([$id2,$id['idEmploye'],$Trt,$date]);
                    }
                    if ($_POST['lieuF'] !== $id['LieuNFR']){
                        $Trt = "Modification du lieu de naissance d'employé de " . $id['LieuNFR'] ." à " .$_POST['lieuF'];
                        $stmt->execute([$id2,$id['idEmploye'],$Trt,$date]);
                    }
                    if ($_POST['lieuA'] !== $id['LieuNAR']){
                        $Trt = "Modification du lieu de naissance d'employé de " . $id['LieuNAR'] ." à " .$_POST['lieuA'];
                        $stmt->execute([$id2,$id['idEmploye'],$Trt,$date]);
                    }
                    if ($_POST['gradeF'] !== $id['GradeFr']){
                        $Trt = "Modification du grade d'employé de " . $id['GradeFr'] ." à " .$_POST['gradeF'];
                        $stmt->execute([$id2,$id['idEmploye'],$Trt,$date]);
                    }
                    if ($_POST['gradeA'] !== $id['GradeAr']){
                        $Trt = "Modification du grade d'employé de " . $id['GradeAr'] ." à " .$_POST['gradeA'];
                        $stmt->execute([$id2,$id['idEmploye'],$Trt,$date]);
                    }
                    if ($_POST['fonctionF'] !== $id['FonctionFr']){
                        $Trt = "Modification du grade d'employé de " . $id['FonctionFr'] ." à " .$_POST['fonctionF'];
                        $stmt->execute([$id2,$id['idEmploye'],$Trt,$date]);
                    }
                    if ($_POST['fonctionA'] !== $id['FonctionAr']){
                        $Trt = "Modification du grade d'employé de " . $id['FonctionFr'] ." à " .$_POST['fonctionA'];
                        $stmt->execute([$id2,$id['idEmploye'],$Trt,$date]);
                    }
                    if ($_POST['adrF'] !== $id['AdresseFR']){
                        $Trt = "Modification d'addresse d'employé de " . $id['AdresseFR'] ." à " .$_POST['adrF'];
                        $stmt->execute([$id2,$id['idEmploye'],$Trt,$date]);
                    }
                    if ($_POST['adrA'] !== $id['AdresseAr']){
                        $Trt = "Modification d'addresse d'employé de " . $id['AdresseAr'] ." à " .$_POST['adrA'];
                        $stmt->execute([$id2,$id['idEmploye'],$Trt,$date]);
                    }
                    if ($_POST['idP'] !== $id['NumIdProf']){
                        $Trt = "Modification du N° d'identification professionnel d'employé de " . $id['NumIdProf'] ." à " .$_POST['idP'];
                        $stmt->execute([$id2,$id['idEmploye'],$Trt,$date]);
                    }
                    if ($_POST['tel'] !== $id['NumTel']){
                        $Trt = "Modification du N° de téléphone d'employé de " . $id['NumTel'] ." à " .$_POST['tel'];
                        $stmt->execute([$id2,$id['idEmploye'],$Trt,$date]);
                    }
                    if ($_POST['ech'] !== $id['Echellon']){
                        $Trt = "Modification d'échelon d'employé de " . $id['Echellon'] ." à " .$_POST['ech'];
                        $stmt->execute([$id2,$id['idEmploye'],$Trt,$date]);
                    }
                    if ($_POST['dateDE'] !== $id['DateDE']){
                        $Trt = "Modification de la date du dernier échelon d'employé de " . $id['DateDE'] ." à " .$_POST['dateDE'];
                        $stmt->execute([$id2,$id['idEmploye'],$Trt,$date]);
                    }
                    if ($_POST['dip'] !== $id['diplome']){
                        $Trt = "Modification du diplome d'employé de " . $id['diplome'] ." à " .$_POST['dip'];
                        $stmt->execute([$id2,$id['idEmploye'],$Trt,$date]);
                    }

                    if ($_POST['stF'] !== $id['SitFam']){
                        if ($_POST['stF'] == 1) {
                            $Trt = "Modification de la situation familiale d'employé de marié à selibataire ";
                        }else $Trt = "Modification de la situation familiale d'employé de selibataire à marié  ";

                        $stmt->execute([$id2,$id['idEmploye'],$Trt,$date]);  
                    }

                    if ($_POST['stA'] !== $id['SitAdm']){
                        if ($_POST['stA'] == 1) $ch = "متربص";
                        elseif ($_POST['stA'] == 2) $ch = "متعاقد";
                        elseif ($_POST['stA'] == 3) $ch = "مرسم";
                        elseif ($_POST['stA'] == 4) $ch = "مؤقت";
                        elseif ($_POST['stA'] == 5) $ch = "مطرود";
                        elseif ($_POST['stA'] == 6) $ch = "متقاعد";
                        elseif ($_POST['stA'] == 7) $ch = "مستقيل";
                            
                        if ($id['SitAdm'] == 1) $sh = "متربص";
                        elseif ($id['SitAdm'] == 2) $sh = "متعاقد";
                        elseif ($id['SitAdm'] == 3) $sh = "مرسم";
                        elseif ($id['SitAdm'] == 4) $sh = "مؤقت";

                        $Trt = "Modification de la situation administrative d'employé de " . $sh . " à " . $ch;

                        $stmt->execute([$id2,$id['idEmploye'],$Trt,$date]);  
                    }



                    if ($_POST['stF'] == 2){

                        $stmt4 = $bd->prepare("SELECT nbrEnf FROM marie WHERE idEmploye = ?");
                        $stmt4->execute([$id['idEmploye']]);
                        $nb = $stmt4->fetchColumn();

                        $stmt4 = $bd->prepare("INSERT INTO marie(idEmploye,nbrEnf) VALUES (?,?) ON DUPLICATE KEY UPDATE nbrEnf = ?");
                        $stmt4->execute([$id['idEmploye'],$_POST['nbE'],$_POST['nbE']]);

                        if ($nb == null ){
                            $Trt = "Ajouter " . $_POST['nbE'] . "pour l'employé";
                            $stmt->execute([$id2,$id['idEmploye'],$Trt,$date]);
                        }
                        elseif ($_POST['nbE'] !== $nb){
                            $Trt = "Modification du nombre d'enfants de " . $nb ." à " .$_POST['nbE'];
                            $stmt->execute([$id2,$id['idEmploye'],$Trt,$date]);
                        }

                        if ($_POST['sexe'] == 2) {

                            $stmt4 = $bd->prepare("INSERT INTO fmarie(idEmploye,NomM,NomMA) VALUES (?,?,?) ON DUPLICATE KEY UPDATE NomM = ?, NomMA = ?");
                            $stmt4->execute([$id,$_POST['nomFMF'],$_POST['nomFMA'],$_POST['nomFMF'],$_POST['nomFMA']]);
                        }

                    }
                $_SESSION['info'] = "L'employé a été Modifier Avec Succes";
                unset($_SESSION['error']);
                }else {
                    $_SESSION['error'] = "Ce Employé n'Existe pas";
                    unset($_SESSION['info']);
                    
                }
                $_POST = array();
                header("location: employe.php");
                

                break;    
            

            default:
                $_POST = array();
                header("location: sign-in.php");
                break;
        }    
       
    }

}else echo "Erreur";

?>
