<div class="modal fade" id="insert-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" >
  <div class="modal-dialog modal-lg " style="border-radius: 20px !important;">
    <div class="modal-content " style=" border-style: solid; border-width: 5px; border-radius: 20px !important;">
      <div class="col-lg-12 well ins" style="border-radius: 20px !important;">
        <div class="row">
          <form method="post" action="Traitements.php">
            <h1 style="text-align: center;">Ajouter un Employé :</h1>
            <hr><hr>
            <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-3 form-group">
                  <label>Nom:</label>
                  <input type="text" name="nomF" placeholder="Nom" class="form-control" required="">
                </div>
                <div class="col-sm-3 form-group arab">
                  <label class="arabiclabel">اللقب:</label>
                  <input type="text" name="nomA" placeholder="اللقب" class="form-control" required="">
                </div>

                <div class="col-sm-3 form-group col-xs-push-6">
                  <label>Prenom:</label>
                  <input type="text" name="prenomF" placeholder="Prenom" class="form-control" required="">
                </div>
                <div class="col-sm-3 form-group arab">
                  <label class="arabiclabel">الاسم:</label>
                  <input type="text" name="prenomA" placeholder="الاسم" class="form-control" required="">
                </div>
              </div>     


             
                <div class="form-group row">
                  <div class=" col-sm-4 form-group col-xs-push-3">
                  <label> Date de Naissance: </label>
                     <input  type="date" name="dateN" id="" class="form-control " required=""> 
                     
                </div>
                <div class="col-sm-4 form-group col-xs-push-3">
                  <label>A:</label>
                  <input type="text" name="lieuF" placeholder="Lieu de Naissance" class="form-control" required="">
                </div>
                <div class="col-sm-4 form-group arab">
                  <label class="arabiclabel">ب:</label>
                  <input type="text" name="lieuA" placeholder="مكان الميلاد" class="form-control" required="">
                </div>
                
               </div>    
          
               <div class="form-group row ">
              <div class="col-sm-6 form-group">
                <label>Adresse:</label>
                <textarea placeholder="Entrer Voutre Adresse ici..." rows="2" name="adrF" class="form-control"></textarea>
              </div>  

              <div class="col-sm-6 form-group arab">
                <label class="arabiclabel">العنوان:</label>
                <textarea placeholder="أدخل العنوان هنا..." rows="2" name="adrA" class="form-control" required=""></textarea>
              </div>  
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3 form-group col-xs-push-6">
                  <label>Fonction</label>
                  <input type="text" name="fonctionF" placeholder="Fontion..." class="form-control" required="">
                </div>
                <div class="col-sm-3 form-group arab">
                  <label class="arabiclabel">الوظيفة:</label>
                  <input type="text" name="fonctionA" placeholder="الوظيفة..." class="form-control" required="">
                </div>
              
                <div class="col-sm-3 form-group col-xs-push-6">
                  <label>Grade:</label>
                  <input type="text" name="gradeF" placeholder="Grade..." class="form-control" required="">
                </div>
                <div class="col-sm-3 form-group arab">
                  <label class="arabiclabel">الرتبة:</label>
                  <input type="text" name="gradeA" placeholder="الرتبة..." class="form-control" required="">
                </div>
              </div>   



              <div class="form-group row">
                                         
                <div class=" col-sm-3 form-group col-xs-push-3">
                  <label> Dernière echellon: </label>
                     <input  type="date" name="dateDE" id="" class="form-control " required=""> 
                </div>
                <div class="col-sm-3 form-group arab">
                  <label class="arabiclabel">الدرجة:</label>
                  <input type="text" name="ech" placeholder="الدرجة..." class="form-control" required="">
                </div>  
                <div class=" col-sm-3 form-group col-xs-push-3">
                  <label>Date d'instalation: </label>
                     <input  type="date" name="dateIN" id="" class="form-control " required=""> 
                </div>
                <div class="col-sm-3 form-group arab">
                  <label class="arabiclabel">الشهادة:</label>
                  <input type="text" name="dip" placeholder="الشهادة..." class="form-control" required="">
                </div>
                
               </div>  
               <hr>
              <div class="row">
                <div class="col-sm-6 form-group col-xs-push-6">
                  <label>Numéro id Professionnel:</label>
                  <input type="text" name="idP" placeholder="Numéro id Professionnel..." class="form-control" required="">
                </div>
                <div class="col-sm-6 form-group arab">
                  <label class="arabiclabel">رقم الهاتف:</label>
                  <input type="text" name="tel" placeholder="رقم الهاتف..." class="form-control" required="">
                </div>
              </div> 

              
              <div class="row" style="margin-top: 10px">
                <div class="input-group col-sm-4">
                <select class="custom-select form-control" name="sexe" id="Sexe" required="">
                  <option selected>Sexe...</option>
                  <option value="1">Homme</option>
                  <option value="2">Femme</option>
                </select>
                </div>
              <div class="input-group mb-3 col-sm-4">
                
                <select class="custom-select form-control arab " name="stF" id="StF" required="">
                  <option selected>الوضعية العائلية...</option>
                  <option value="1">أعزب</option>
                  <option value="2">متزوج</option>
                </select>
              </div> 

              <div class="input-group mb-3 col-sm-4">
                
                <select class="custom-select form-control arab"  name="stA" id="StA" required="">
                  <option selected>الوضعية الإدارية...</option>
                  <option value="1">متربص</option>
                  <option value="2">متعاقد</option>
                  <option value="3">مرسم</option>
                  <option value="4">مؤقت</option>
                </select>
              </div> 
              
              </div>
                
                <div class="row">
                  <div id="MM" class="col-sm-4 form-group col-xs-push-6" style="display: none;">
                    <label>Nombre d'enfants:</label>
                    <input type="text" name="nbE" placeholder="Nombre d'enfant..." class="form-control">
                  </div>
                  
                  <div class="col-sm-4 form-group" id="FMMF"  style="display: none;">
                    <label>Nom du femme marié:</label>
                    <input type="text" name="nomFMF" placeholder="Nom du femme marié..." class="form-control">
                  </div>
                  <div class="col-sm-4 form-group arab" id="FMMA"  style="display: none;">
                    <label class="arabiclabel">لقب المرأة المتزوجة:</label>
                    <input type="text" name="nomFMA" placeholder="لقب المرأة المتزوجة..." class="form-control">
                  </div>
                </div> 


              </div>
              <hr>
              <input style="margin-right: 10px" type="submit" name="submit" class="btn btn-lg btn-info col-sm-12" value="Ajouter">     
          </form> 
        </div>
      </div>  
    </div>
  </div>
</div>