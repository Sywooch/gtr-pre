<?php
use yii\helpers\Html;
$totalPax = $paxAdult+$paxChild;
?>
<?php 
$aD = $tripDeparture->adult_price/$currency->kurs*$paxAdult;
$cD = $tripDeparture->child_price/$currency->kurs*$paxChild;
$totalD = $aD+$cD;
$aR = $tripReturn->adult_price/$currency->kurs*$paxAdult;
$cR = $tripReturn->child_price/$currency->kurs*$paxChild;
$totalR = $aR+$cR;
//echo $totalD."<br>".$totalR."<br>";
 ?>
<div class="panel panel-info">
    <div class="panel-heading">
      <h5 class="panel-title" itemprop="name" align="center">Round Trip Details</h5>
      </div><!--/panel-heading-->
        <div class="panel-body" itemprop="reviewBody">
            <div class="col-md-12">
            <div class="col-md-2">
            <b>Departure</b>
              <br>
              <?= date('D, d-M-Y',strtotime($tripDeparture->date)) ?>
            </div>
            <div class="col-md-2">
            <b>Boat</b><br>
              <?= $tripDeparture->idBoat->idCompany->name ?>       
            </div>
            <div class="col-md-2">
            <b>Dept Time</b><br>
            <?= date('H:i',strtotime($tripDeparture->dept_time)) ?>
              
            </div>
            <div class="col-md-4">
            <b>Route</b><br>
            <?= $tripDeparture->idRoute->departureHarbor->name." -> ".$tripDeparture->idRoute->arrivalHarbor->name ?><br>
            (<?= $tripDeparture->idEstTime->est_time ?>)
              </div>
            
           <div class="col-md-2">
            
           <b class="text-strong"><?php $currency->currency." ".round($totalD,0,PHP_ROUND_HALF_UP) ?></b>
           <?= Html::img(['/site/logo','id'=>$tripDeparture->idBoat->id_company], ['class'=>'boat-logo-modal']) ?>
           </div>
</div>
           <br><br>
<div class="col-md-12">
           <!-- RETURN  -->
           <div class="col-md-2 div-ret">
            <b>Return</b>
              <br>
              <?= date('D, d-M-Y',strtotime($tripReturn->date)) ?>
            </div>
            <div class="col-md-2 div-ret">
            <b>Boat</b><br>
              <?= $tripReturn->idBoat->idCompany->name ?>       
            </div>
            <div class="col-md-2 div-ret">
            <b>Dept Time</b><br>
            <?= date('H:i',strtotime($tripReturn->dept_time)) ?>
              
            </div>
            <div class="col-md-4 div-ret">
            <b>Route</b><br>
            <?= $tripReturn->idRoute->departureHarbor->name." -> ".$tripReturn->idRoute->arrivalHarbor->name ?><br>
            (<?= $tripReturn->idEstTime->est_time ?>)
              </div>
            
           <div class="col-md-2 div-ret">
            
           <b class="text-strong"><?php $currency->currency." ".round($totalR,0,PHP_ROUND_HALF_UP) ?></b>
           <?= Html::img(['/site/logo','id'=>$tripReturn->idBoat->id_company], ['class'=>'boat-logo-modal']) ?>
           </div>
</div>
        </div>

</div>

<span class="pull-right"><b class="harga-total"><?= $currency->currency." ".round($totalD+$totalR,0,PHP_ROUND_HALF_UP); ?></b>&nbsp
<?= Html::a('Book', ['/book/add-to-cart', 'tripDeparture' => $tripDeparture->id,'tripReturn' => $tripReturn->id], [
            'class' => 'btn material-btn material-btn_warning main-container__column material-btn_lg',
            'data' => [
                'method' => 'post',
            ],
          ]) ?></span>