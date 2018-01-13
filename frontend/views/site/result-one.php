<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Choose FastBoats';

$customScript = 
$this->registerJs("
$('.radio-dept').on('change',function(){
 var dept = $('input[name=id_dept]:radio:checked').val();
 var ret = false; 
 $('#myModal').modal({
              backdrop: 'static',
              keyboard: false
          });
    $('#detail').html('<i class=\"fa fa-spinner fa-spin\"></i>');
    $.ajax({
      url: '". Url::to(['/site/detail-modal'])."',
      type: 'POST',
      data: {deptv: dept, retv: ret},
      success: function(data){
          $('#detail').html(data);
          
        }
    });
  
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

<div class="modal material-modal material-modal_primary fade" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content material-modal__content">
      <div class="modal-header material-modal__header">
        <button class="close material-modal__close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title material-modal__title">Round Trip Detail</h4>
      </div>
      <div class="modal-body material-modal__body">
        <div id="detail" class="col-md-12">
            <center>Please Wait...</center>
        </div>
      <div class="modal-footer material-modal__footer">
      </div>
    </div>
  </div>
</div>
</div>
<!--modal End -->

<div id="div-dept" class="col-md-12" ><br><br>
  <h2 align="center"> DEPARTURE </h2>
  <h4 align="center"><?= date('D, d-M-Y',strtotime($formData['departureDate'])) ?></h4>
  <?php if(!empty($departureList)): ?>
    <?= $this->render('_filter-result',[
        'col'       => "col-md-4 col-sm-4 col-xs-12",
        'parent'    => "departure",
        'listRoute' => $listRoute,
  ]) ?>
 <center id="loading-departure"></center>
  <div id="result-departure">
  <?php foreach ($departureList as $key => $valDept): ?>
    <?php
    $priceDept = round($valDept['adult_price']/$currency['kurs']*$totalPax,0,PHP_ROUND_HALF_UP);
    $timeDept = date('H:i',strtotime($valDept['dept_time']));
    $durDept = $valDept['id_est_time'];
     ?>
    <div class="list-departure" price="<?= $priceDept ?>" times="<?= $timeDept ?>" departure="<?= $valDept['idRoute']['departureHarbor']['id_island'] == 1 ? $valDept['idRoute']['departure'] : $valDept['idRoute']['arrival'] ?>">
      <div class="panel panel-primary material-panel material-panel_primary">
        <div class="panel-body" itemprop="reviewBody">
        <span>
          <?= Html::img(['/site/logo','id'=>$valDept['idBoat']['id_company']], ['class'=>'boat-logo']); ?>
          <span class="nama-company"><?= $valDept['idBoat']['idCompany']['name'] ?></span>
        </span>
        <br>

        <span class="text-muted row rute">
            <span class="col-md-12s col-sm-12">
            <?= $valDept['idRoute']['departureHarbor']['name'] ?>
            &nbsp
            <span class="glyphicon glyphicon-arrow-right"></span> 
            &nbsp
            <?=$valDept['idRoute']['arrivalHarbor']['name'] ?></span>
            
        </span>
        <br>

        <span class="text-muted timer">
            <span class="col-md-12 col-sm-12">
              <span class="glyphicon glyphicon-time"></span> 
              Dept Time: <?= $timeDept ?>
              <span class="glyphicon glyphicon-menu-right"></span> 
              <?= $valDept['idEstTime']['est_time'] ?> Duration
            </span>
          
        </span>
        <br><br>

        <span class="text-warning note">
          <?php if($valDept['description'] == null || $valDept['description'] == " "){
          }else{
            echo "Note: ".$valDept['description'];
          } ?>
        </span> 

        <span  class="bg-danger pull-right harga"><?= $currency['currency']." ".$priceDept ?></span>
        <div class="funkyradio">
          <div class="funkyradio-warning">
            <?= Html::radio('id_dept', $checked = false,['id'=>'radio-dept'.$valDept['id'],'value'=>$valDept['id'],'class'=>'radio-dept']); ?>
            <?= Html::label('Select', 'radio-dept'.$valDept['id']); ?>
          </div>
        </div>
                      
                   
        </div>
      </div><!--/panel-->
    </div>
  <?php endforeach; ?>
  </div>
<?php else: ?>
<center>
  <h2>Sorry</h2>
  <p>
    We Are Fully Booked
  </p>
  </center>
<?php endif;  ?>
</div>
 <?php 
$customCss = <<< SCRIPT
.is-hidden {
display:none;
}
.img-loading{
  width: 100px;
  height: 100px;
}
#loading-departure, loading-arrival{
  display: none;
}
.note{
  font-size: 12px;
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
    border: 2px solid #f2a12e;
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
    background: #ECEFF1;
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
