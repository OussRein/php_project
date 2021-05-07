<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['login_user']) || empty($_SESSION['login_user'])){
  header("location: login.php");
  exit;
}
if($_SERVER["REQUEST_METHOD"] == "POST")
  {
  include('database.php');
    try
    {
        $bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $un, $pw);
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }

$sql = "INSERT INTO infos (dateI,info) VALUES (?,?) ON DUPLICATE KEY UPDATE info = ?";
$stmt = $bdd->prepare($sql);
$stmt->execute([$_POST['date'],$_POST['info'],$_POST['info']]);
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
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="dashboard.css" rel="stylesheet">
        <link rel="stylesheet" href="jquery-ui-1.12.1/jquery-ui.css">
    <link href="Calendario/css/calendar.css" rel="stylesheet">
    <link href="Calendario/css/custom_1.css" rel="stylesheet">

  </head>
  <body>
        
    <?php 
      include('navbar.php');
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

$sql = "SELECT * FROM infos ORDER BY dateI";
$stmt = $bd->prepare($sql);
$stmt->execute();
while ($donnees = $stmt->fetch()){
  echo ("<input type=\"hidden\" id=\"" . $donnees['dateI'] . "\" value=\"". $donnees['info'] . "\">");
}

?>      
      <div class="custom-calendar-wrap custom-calendar-full" style="margin-top: 10px;">
        <div class="custom-header clearfix">
            <h3 class="custom-month-year">
            <span id="custom-month" class="custom-month"></span>
            <span id="custom-year" class="custom-year"></span>
            <nav>

              <span id="custom-prev" class="custom-prev"></span>
              <span id="custom-next" class="custom-next"></span>
              <span id="custom-current" class="custom-current" title="Got to current date"></span>
            </nav>
          </h3>
        </div>
        <div id="calendar" class="fc-calendar-container"></div>
      </div>



<div class="modal fade" id="ii" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style=" border-style: solid; border-width: 5px; border-radius: 20px !important;">
      <div class="col-lg-12 well ins" style="border-radius: 20px !important;">
        <div class="row">
          <form id="ff" method="post" action="dashboard.php" style="width: 100% !important;">
            <h2 style="text-align: center;">Notes:</h2>
            <hr><hr>

            <div class="col-sm-12">
              
          
              <div class="row form-group">
                <div class="col-sm-12 form-group">
                  <textarea id="ta" rows="6" name="info" class="form-control"></textarea>
                </div>  
              </div>

              <hr>
              <hr>

              <input style="margin-right: 10px" type="submit" name="submit" class="btn btn-lg btn-info col-sm-12" value="Sauvgarder">     
            </div>     
                
          </form> 
        </div>
      </div>
    </div>
  </div>
</div> 


  
        <!-- Bootstrap core JavaScript



    ================================================== -->
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
    <script src="Calendario/js/modernizr.custom.63321.js"></script>
    <script src="Calendario/js/jquery.calendario.js"></script>
    <script src="Calendario/js/data.js"></script>
    
    <script> feather.replace() </script>
    <script type="text/javascript"> 
      var cal = $( '#calendar' ).calendario( {
            onDayClick : function( $el, $contentEl, dateProperties ) {

              for( var key in dateProperties ) {
                console.log( key + ' = ' + dateProperties[ key ] );
              }

            },
            caldata : codropsEvents
          } ) , d , dt;


      $(function() {
      
        
        var  $month = $( '#custom-month' ).html( cal.getMonthName() ),
          $year = $( '#custom-year' ).html( cal.getYear() );

        $( '#custom-next' ).on( 'click', function() {
          cal.gotoNextMonth( updateMonthYear );
        } );
        $( '#custom-prev' ).on( 'click', function() {
          cal.gotoPreviousMonth( updateMonthYear );
        } );
        $( '#custom-current' ).on( 'click', function() {
          cal.gotoNow( updateMonthYear );
        } );
        $(document).on('click','.thisday', function(){
          
          if (parseInt($(this).find(".fc-date").text()) >= 10 && parseInt(cal.getMonth())>=10) {
            d = cal.getYear()  + "-" + cal.getMonth() + "-" + $(this).find(".fc-date").text() ;
          }else if (parseInt(cal.getMonth()) >= 10) {
            d = cal.getYear()  + "-" + cal.getMonth() + "-0" + $(this).find(".fc-date").text() ;
          }else if (parseInt($(this).find(".fc-date").text()) >= 10) {
            d = cal.getYear()  + "-0" + cal.getMonth() + "-" + $(this).find(".fc-date").text() ;
          }else {
          d = cal.getYear()  + "-0" + cal.getMonth() + "-0" + $(this).find(".fc-date").text() ;
          }

          $('<input>').attr({
            type: 'hidden',
            name: 'date',
            value: d,
          }).appendTo('#ff');

          dt = "#" + d;
          $('#ta').val('');
          $('#ta').val($(dt).val());
          jQuery.noConflict(); 
          $('#ii').modal('show');
          jQuery.noConflict(); 
          $('#ii').modal('hide');
        });

        function updateMonthYear() {        
          $month.html( cal.getMonthName() );
          $year.html( cal.getYear() );
        }

      
      });

        


    </script>
    
        
  </body>
</html>
