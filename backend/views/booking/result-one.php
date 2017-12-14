<?php
use yii\helpers\Html;

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

<div class="col-md-12" >
<h2 align="center"> Select Trip </h2>
<h4 align="center"><?= date('d-m-Y',strtotime($departureList[0]->date)) ?></h4>
</div>

<br>
<?php if(!empty($departureList)): ?>
<?php foreach ($departureList as $key => $value): ?>
<?php
// $prices = round($value->adult_price/$currency->kurs*$totalPax,0,PHP_ROUND_HALF_UP);
$deptTime = date('H:i',strtotime($value->dept_time));
$durations = $value->id_est_time;
 ?>
<div class="col-md-6" >
<div times="<?= $deptTime ?>" duration="<?= $durations ?>">
<div class="panel panel-primary material-panel material-panel_primary">
  <div class="panel-body" itemprop="reviewBody">
    <span>
        <span class="nama-company"><?= $value->idBoat->idCompany->name ?></span>
        
    </span><br>
    <span class="text-muted row rute">
        <span class="col-md-12 col-sm-12">
          <?= $value->idRoute->departureHarbor->name ?>
          &nbsp
          <span class="glyphicon glyphicon-arrow-right"></span> 
          &nbsp
          <?=$value->idRoute->arrivalHarbor->name ?> 
          <span class="glyphicon glyphicon-align-justify"></span>
          <span class="glyphicon glyphicon-time"></span> 
          Dept Time: <?= $deptTime ?> WITA
          <span class="glyphicon glyphicon-menu-right"></span> 
          <?= $value->idEstTime->est_time ?> Duration
        </span>
      
    </span>
    <br>
     <span class="text-warning note">
       <?php if($value->description == null || $value->description == " "){

      }else{
        echo "Note: ".$value->description;
        } ?>
    </span> 
    <span class="bg-danger pull-right harga">Harga
    </span>
    <?= Html::beginForm(['/booking/booking-modify', 'id' =>$value->id], 'post') ?>
    <div class="funkyradio">
    <div class="funkyradio-warning">
    <?= Html::hiddenInput('id_booking', $id_booking, ['readonly' => true]); ?>
    <?= Html::checkbox('id_trip', $checked = false,[
          'id'=>$value->id,
          'value'=>$value->id,
          'class'=>'checkbox-modify',
          'onchange'=>'
          if ($(this).is(":checked")) {
            $(".checkbox-modify").prop("checked", false);
            $(this).prop("checked", true);
            $(".btn-modify").hide(100);
            $("#btn-'.$value->id.'").show(100);
          }else{
            $("#btn-'.$value->id.'").hide(100);
          }
          '
          ]); ?>
    <?= Html::label('Select', $value->id); ?>
    
    </div>
    </div>
    <?= Html::submitButton('Submit', [
            'class' => 'btn-modify btn btn-danger',
            'id'=>'btn-'.$value->id,
            'style'=>'display: none;',
            'data' => [
              'confirm' => 'Are You Sure To Modify This Trip ? <br> This  Action Cannot be Undone',
              ]
            ]); ?>
<?= Html::endForm() ?>              
  </div>
</div><!--/panel-->
</div>
</div>
<?php endforeach; ?>

<?php else: ?>
<center>
  <h2>Sorry</h2>
  <p>
    We Are Fully Booked
  </p>
  </center>
<?php endif;  ?>


 <?php 
// $this->registerJs("
// $('.checkbox-modify').on('change',function(){
//  var dept = $('input[name=id_trip]:radio:checked').val(); 
//  $('#btn-'+dept).show(100);
// });


//   ", \yii\web\View::POS_READY);
$customCss = <<< SCRIPT
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
.funkyradio input[type="checkbox"]:empty {
    display: none;
}
.funkyradio input[type="checkbox"]:empty ~ label {
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
.funkyradio input[type="checkbox"]:empty ~ label:before {
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
.funkyradio input[type="checkbox"]:hover:not(:checked) ~ label:before {
    content:'\2714';
    text-indent: .9em;
    color: #C2C2C2;
}
.funkyradio input[type="checkbox"]:hover:not(:checked) ~ label {
    color: #888;
}
.funkyradio input[type="checkbox"]:checked ~ label:before {
    content:'\2714';
    text-indent: .9em;
    color: #333;
    background-color: #ccc;
}
.funkyradio input[type="checkbox"]:checked ~ label {
    color: #777;
}
.funkyradio input[type="checkbox"]:focus ~ label:before {
    box-shadow: 0 0 0 3px #999;
}
.funkyradio-warning input[type="checkbox"]:checked ~ label:before {
    color: #fff;
    background-color: #f0ad4e;
}

</style>
