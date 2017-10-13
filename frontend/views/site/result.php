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
  }
});

$('#myModal').on('hide.bs.modal',function(){
  $('input:radio').attr('checked', false);
})

  ", \yii\web\View::POS_READY);
$customCss = <<< SCRIPT
  .harga{
    font-weight: bold;
  }
  .harga-total{
    font-weight: bold;
    font-size: 25px;
  }
SCRIPT;
$this->registerCss($customCss);
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
      <!--  <button id="btn-close-modal" type="button" class="btn material-btn material-btn_danger main-container__column material-btn_md" data-dismiss="modal">Cancel</button> -->
        <?php //Html::button('Next', ['class' => 'btn material-btn material-btn_warning main-container__column material-btn_md ']); ?>
      </div>
    </div>
  </div>
</div>
<!--modal End -->
<div class="col-md-6 <?= $formData['type'] == '1' ? 'col-md-offset-3' : '' ?>" >
<h2 align="center"> DEPARTURE </h2>
<h4 align="center"><?= date('D, d-M-Y',strtotime($formData['departureDate'])) ?></h4>
<?php if(!empty($departureList)): ?>
<?php foreach ($departureList as $key => $valDept): ?>
    <div class="col-sm-12">
          <div class="panel panel-info">
          <div class="panel-heading">
            <span itemscope itemtype="http://schema.org/Review">
            <h3 class="panel-title" itemprop="name"><?= $valDept->idBoat->idCompany->name ?></h3>
          </div><!--/panel-heading-->
        <div class="panel-body" itemprop="reviewBody">
<?= Html::img(['/site/logo','id'=>$valDept->idBoat->id_company], ['class'=>'boat-logo']); ?><span class=" bg-danger pull-right harga"> <?= $currency->currency." ".round($valDept->adult_price/$currency->kurs*$totalPax,0,PHP_ROUND_HALF_UP) ?> </span>
            <ul class="list-group">
              <li class="list-group-item">Date <?= date('m, d-Y',strtotime($valDept->date)) ?></li>
              <li class="list-group-item"><?= date('H:i',strtotime($valDept->dept_time)) ?></li>
              <li class="list-group-item"><?= $valDept->idRoute->departureHarbor->name." -> ".$valDept->idRoute->arrivalHarbor->name ?></li>
               <li class="list-group-item"> <?= $valDept->idEstTime->est_time ?></li>
            </ul>

              <div class="funkyradio col-md-1 col-md-offset-9">
              <div class="funkyradio-warning">
              <?= Html::radio('id_dept', $checked = false,['id'=>$valDept->id,'value'=>$valDept->id,'class'=>'radio-return  ']); ?>
             <?= Html::label('Book!', $valDept->id); ?>
              </div>
              </div>
              
           
          </div><!--/panel-body -
          <div class="panel-footer clearfix">
              <div class="col-sm-1"><i class="fa fa-facebook-official fa-2x"></i></div>
              <div class="col-sm-1"><i class="fa fa-twitter-square fa-2x"></i></div>
              <div class="col-sm-1"><i class="fa fa-google-plus fa-2x"></i></div>
          </div><!-/panel-footer-->
        </div><!--/panel-->

    </div><!--/col-sm-6-->
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
<div class="col-md-6" >
<h2 align="center"> RETURN </h2>
<h4 align="center"><?= date('D, d-M-Y',strtotime($formData['returnDate'])) ?></h4>
<?php if(!empty($returnList)): ?>
<?php foreach ($returnList as $key => $valRetr): ?>
    <div class="col-sm-12">
          <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title" itemprop="name"><?= $valRetr->idBoat->idCompany->name ?></h3>
          </div><!--/panel-heading-->
        <div class="panel-body" itemprop="reviewBody">
        <?= Html::img(['/site/logo','id'=>$valRetr->idBoat->id_company], ['class'=>'boat-logo']); ?>
        <span class="bg-danger pull-right harga"> <?= $currency->currency." ".round($valRetr->adult_price/$currency->kurs*$totalPax,0,PHP_ROUND_HALF_UP) ?> </span>
            <ul class="list-group">
              <li class="list-group-item">Date <?= date('m, d-Y',strtotime($valRetr->date)) ?></li>
              <li class="list-group-item">Time <?= date('H:i',strtotime($valRetr->dept_time)) ?></li>
              <li class="list-group-item"><b>Port</b> <?= $valRetr->idRoute->departureHarbor->name." -> ".$valRetr->idRoute->arrivalHarbor->name ?></li>
              <li class="list-group-item"><?= $valRetr->idEstTime->est_time ?></li>
            </ul>

             <div class="funkyradio col-md-1">
              <div class="funkyradio-warning">
              <?= Html::radio('id_return', $checked = false,['id'=>$valRetr->id,'value'=>$valRetr->id,'class'=>'radio-return']); ?>
             <?= Html::label('Book!', $valRetr->id); ?>
              </div>
              </div>
          </div><!--/panel-body -->
        
        </div><!-- /panel -->

    </div><!--/col-sm-6-->
<?php 

endforeach; ?>
<?php else: ?>
<center>
  <h2>Sorry</h2>
  <p>
    Boat is Unavaible for this time, or sheat is not enought
  </p>
  </center>
<?php endif;  ?>
</div>




