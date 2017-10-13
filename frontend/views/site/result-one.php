<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Choose FastBoats';

$customScript = 
$this->registerJs("
$('.radio-dept').on('change',function(){
 var dept = $('input[name=id_dept]:radio:checked').val();
 var ret = false; 
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
  
});

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
       
      </div>
    </div>
  </div>
</div>

<!--modal End -->
<div class="col-md-6 col-md-offset-3" >
<h2 align="center"> DEPARTURE </h2>
<h4 align="center"><?= date('D, d-M-Y',strtotime($formData['departureDate'])) ?></h4>
<?php if(!empty($departureList)): ?>
<?php foreach ($departureList as $key => $value): ?>
    <div class="col-sm-12">
          <div class="panel panel-primary">
          <div class="panel-heading">
            <span itemscope itemtype="http://schema.org/Review">
            <h3 class="panel-title" itemprop="name"><?= $value->idBoat->idCompany->name ?></h3>
          </div><!--/panel-heading-->
        <div class="panel-body" itemprop="reviewBody">
        <?= Html::img(['/site/logo','id'=>$value->idBoat->id_company], ['class' => 'img-responsive','width'=>'100px','height'=>'auto']); ?>
            <ul class="list-group">
              <li class="list-group-item"><?= date('H:i',strtotime($value->dept_time)) ?></li>
              <li class="list-group-item"><?= $value->idRoute->departureHarbor->name." -> ".$value->idRoute->arrivalHarbor->name ?></li>
               <li class="list-group-item"> <?= $currency->currency." ".round($value->adult_price/$currency->kurs*$totalPax,0,PHP_ROUND_HALF_UP) ?></li>
               <li class="list-group-item"> <?= $value->idEstTime->est_time ?></li>
            </ul>
            <div class="funkyradio col-md-1 col-md-offset-9">
              <div class="funkyradio-warning">
              <?= Html::radio('id_dept', $checked = false,['id'=>$value->id,'value'=>$value->id,'class'=>'radio-dept']); ?>
             <?= Html::label('Book!', $value->id); ?>
              </div>
              </div>
          </div>
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
 