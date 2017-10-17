<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Choose FastBoats';

$customScript = 
$this->registerJs("
$('.radio-dept, .radio-return').on('change',function(){
 var dept = $('input[name=id_dept]:radio:checked').val();
 var ret = $('input[name=id_return]:radio:checked').val();
  if(dept != undefined && ret != undefined){
    $.ajax({
      url: '". Url::to('/site/detail-modal')."',
      type: 'POST',
      data: {deptv: dept, retv: ret},
      success: function(data){
          $('#detail').html(data);
          $('#myModal').modal({
              backdrop: 'static',
              keyboard: false
          });
        }
    });
  }else if(dept != undefined && ret == undefined){
    $('html, body').animate({
          scrollTop: $('#div-return').offset().top
        }, 1000); 
        return false; 
  }
});

$('#myModal').on('hide.bs.modal',function(){
  $('input:radio').attr('checked', false);
})

  ", \yii\web\View::POS_READY);

?>
<!--modal Start -->
<div class="modal fade" id="myModal" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Book Detail</h4>
      </div>
      <div class="modal-body">
        <div id="detail" class="col-md-12">
          
        </div>
      </div>
      <div class="modal-footer">
      
        <?php //Html::button('Next', ['class' => 'btn material-btn material-btn_warning main-container__column material-btn_md ']); ?>
      </div>
    </div>
  </div>
</div>
<!--modal End -->
<div class="col-md-6" >
<h2 align="center"> DEPARTURE </h2>
<h4 align="center"><?= date('D, d-M-Y',strtotime($formData['departureDate'])) ?></h4>
<?php if(!empty($departureList)): ?>
<?php foreach ($departureList as $key => $valDept): ?>
          <div class="panel panel-primary material-panel material-panel_primary">
        <div class="panel-body" itemprop="reviewBody">
<span>
    <?= Html::img(['/site/logo','id'=>$valDept->idBoat->id_company], ['class'=>'boat-logo']); ?>
    <span class="nama-company"><?= $valDept->idBoat->idCompany->name ?></span>
    
</span><br>
<span class="text-muted row rute">
    <span class="col-md-12s col-sm-12">
    <?= $valDept->idRoute->departureHarbor->name ?>
    &nbsp
    <span class="glyphicon glyphicon-arrow-right"></span> 
    &nbsp
    <?=$valDept->idRoute->arrivalHarbor->name ?></span>
    
</span><br>
<span class="text-muted timer">
    <span class="col-md-12 col-sm-12">
      <span class="glyphicon glyphicon-time"></span> 
      Dept Time: <?= date('H:i',strtotime($valDept->dept_time)) ?> WITA
      <span class="glyphicon glyphicon-menu-right"></span> 
      <?= $valDept->idEstTime->est_time ?> Duration
    </span>
  
</span>
<br><br>
 <span class="text-warning note">
   <?php if($valDept->description == null || $valDept->description == " "){

  }else{
    echo "Note: ".$valDept->description;
    } ?>
 </span> 
<span  class="bg-danger pull-right harga"><?= $currency->currency." ".round($valDept->adult_price/$currency->kurs*$totalPax,0,PHP_ROUND_HALF_UP) ?></span>
              <div class="funkyradio">
              <div class="funkyradio-warning">
              <?= Html::radio('id_dept', $checked = false,['id'=>$valDept->id,'value'=>$valDept->id,'class'=>'radio-dept  ']); ?>
             <?= Html::label('Book!', $valDept->id); ?>
              </div>
              </div>
              
           
          </div>
        </div><!--/panel-->


<?php endforeach; ?>
<?php else: ?>
<center>
  <h2>Sorry</h2>
  <p>
    Boat is Unavaible for this time, or sheat is not enought
  </p>
  </center>
<?php endif;  ?>
</div>

<!--  RETURN CODE LIST -->
<div id="div-return" class="col-md-6" >
<h2 align="center"> RETURN </h2>
<h4 align="center"><?= date('D, d-M-Y',strtotime($formData['returnDate'])) ?></h4>
<?php if(!empty($returnList)): ?>
<?php foreach ($returnList as $key => $valRetr): ?>
    <div class="panel panel-primary material-panel material-panel_primary">
        <div class="panel-body" itemprop="reviewBody">
<span>
    <?= Html::img(['/site/logo','id'=>$valRetr->idBoat->id_company], ['class'=>'boat-logo']); ?>
    <span class="nama-company"><?= $valRetr->idBoat->idCompany->name ?></span>
    
</span><br>
<span class="text-muted row rute">
    <span class="col-md-12s col-sm-12">
    <?= $valRetr->idRoute->departureHarbor->name ?>
    &nbsp
    <span class="glyphicon glyphicon-arrow-right"></span> 
    &nbsp
    <?=$valRetr->idRoute->arrivalHarbor->name ?></span>
    
</span><br>
<span class="text-muted timer">
    <span class="col-md-12s col-sm-12">
      <span class="glyphicon glyphicon-time"></span> 
      Dept Time: <?= date('H:i',strtotime($valRetr->dept_time)) ?> WITA 
      <span class="glyphicon glyphicon-menu-right"></span>
      <?= $valRetr->idEstTime->est_time ?> Duration 
    </span>
  
</span>
<br><br>
 <span class="text-warning note">
   <?php if($valRetr->description == null || $valRetr->description == " "){

  }else{
    echo "Note: ".$valRetr->description;
    } ?>
 </span> 
<span  class="bg-danger pull-right harga"><?= $currency->currency." ".round($valRetr->adult_price/$currency->kurs*$totalPax,0,PHP_ROUND_HALF_UP) ?></span>
              <div class="funkyradio">
              <div class="funkyradio-warning">
              <?= Html::radio('id_return', $checked = false,['id'=>$valRetr->id,'value'=>$valRetr->id,'class'=>'radio-return  ']); ?>
             <?= Html::label('Book!', $valRetr->id); ?>
              </div>
              </div>
              
           
          </div>
        </div><!--/panel-->
<?php endforeach; ?>
<?php else: ?>
<center>
  <h2>Sorry</h2>
  <p>
    Boat is Unavaible for this time, or sheat is not enought
  </p>
  </center>
<?php endif;  ?>
</div>

<?php 
$customCss = <<< SCRIPT
.note{
  font-size: 10px;
}
.nama-company{
  font-weight: bold;
    font-size: 15px;
}
  .harga{
    font-weight: bold;
  }
  .harga-total{
    font-weight: bold;
    font-size: 25px;
  }
  

.div-ret{
  border-top: 1px solid #B0BEC5;
  padding-top: 2%;
  margin-top: 5%;
}
.boat-logo{
  width: auto;
  height:25px;
  max-height: 25px;
  max-width: 300px;
}
.boat-logo-modal{
  width: auto;
  height:30px;
  max-height: 30px;
  max-width: 75px;
}


SCRIPT;
$this->registerCss($customCss);
?>

<style type="text/css">
    .funkyradio label {
    /*min-width: 400px;*/
    width: 100%;
    border-radius: 3px;
    border: 1px solid #D1D3D4;
    font-weight: normal;
}
.funkyradio input[type="radio"]:empty {
    display: none;
}
.funkyradio input[type="radio"]:empty ~ label {
    position: relative;
    line-height: 2.5em;
    text-indent: 3.25em;
    margin-top: 2em;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
.funkyradio input[type="radio"]:empty ~ label:before {
    position: absolute;
    display: block;
    top: 0;
    bottom: 0;
    left: 0;
    content:'';
    width: 2.5em;
    background: #D1D3D4;
    border-radius: 3px 0 0 3px;
}
.funkyradio input[type="radio"]:hover:not(:checked) ~ label:before {
    content:'\2714';
    text-indent: .9em;
    color: #C2C2C2;
}
.funkyradio input[type="radio"]:hover:not(:checked) ~ label {
    color: #888;
}
.funkyradio input[type="radio"]:checked ~ label:before {
    content:'\2714';
    text-indent: .9em;
    color: #333;
    background-color: #ccc;
}
.funkyradio input[type="radio"]:checked ~ label {
    color: #777;
}
.funkyradio input[type="radio"]:focus ~ label:before {
    box-shadow: 0 0 0 3px #999;
}
.funkyradio-warning input[type="radio"]:checked ~ label:before {
    color: #fff;
    background-color: #f0ad4e;
}

</style>
